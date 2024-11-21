<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\Expinsumos; 
use App\Models\Auxi; 
use App\Models\Catalogo; 
use App\Models\Grupos; 
use App\Models\Materiales; 
use App\Models\Presu; 
use App\Models\ConceptosMateriales; 
use App\Models\ConceptosManoObras; 
use App\Models\ConceptosEquipos; 
use App\Models\ConceptosAuxiliares; 
use App\Models\ConceptosCuadrillas; 
//cantidad explosion insmumos = sumatoria de (cantidad catalogo conceptos * cantidad conceptos materiales)
class ExpinsumoController extends Controller 
{
  /**      * Display a listing of the resource.      */
  public function index(Request $request): View
  {
      $insumos = collect();
      $materiales = collect();
      $categorias = collect();
      $equipos = collect();
      $idPresup = 0;

      if ($request->has('presup')) { 
          $idPresup = $request->input('presup');       
          $idTarjetas = Catalogo::where('id_presup', $idPresup)->pluck('id_tarjeta');
        
          if ($idTarjetas->isNotEmpty()) {
              $insumosAgrupados = $this->processInsumos($idTarjetas);    
              // dd($insumosAgrupados);  
              $this->saveGroupedInsumos($idPresup, $insumosAgrupados);
          }

          // Obtener todos los registros de Expinsumos para el presupuesto dado
          $insumos = Expinsumos::where('id_presup', $idPresup)->get();

          // Filtrar registros por grupo
          $materiales = Expinsumos::where('id_presup', $idPresup)
                                  ->where('id_grupo', 1) // Solo registros donde id_grupo = 1
                                  ->get();

          $categorias = Expinsumos::where('id_presup', $idPresup)
                                  ->where('id_grupo', 2) // Solo registros donde id_grupo = 2
                                  ->get();

          $equipos = Expinsumos::where('id_presup', $idPresup)
                              ->where('id_grupo', 3) // Solo registros donde id_grupo = 3
                              ->get();
      }

      return view('tabs/expinsumos', [
          'insumos' => $insumos,
          'materiales' => $materiales,
          'categorias' => $categorias,
          'equipos' => $equipos,
          'idPresup' => $idPresup,
      ]);
  }

  /**      * Procesa y agrupa los materiales y auxiliares.      */
  private function processInsumos($idTarjetas)
  {
      $registrosCatalogo = Catalogo::whereIn('id_tarjeta', $idTarjetas)->get()->keyBy('id_tarjeta');
  
      $registroMateriales = ConceptosMateriales::whereIn('id_tarjeta', $idTarjetas)->get();
      $registroCategorias = ConceptosManoObras::whereIn('id_tarjeta', $idTarjetas)->get();    
      $registroEquipos = ConceptosEquipos::whereIn('id_tarjeta', $idTarjetas)->get();
  
      $materialesDirectos = $registroMateriales->where('id_auxiliar', 0);
      $categoriasDirectos = $registroCategorias->where('id_cuadrilla', 0);
  
      $materialesDeAuxiliares = $this->createMaterialFromAuxiliar(
          $registroMateriales->where('id_material', 0)
      );
      $allMateriales = $materialesDirectos->concat($materialesDeAuxiliares);
  
      $categoriasDeCuadrillas = $this->createCategoriaFromCuadrilla(
          $registroCategorias->where('id_categoria', 0)
      );
      $allCategorias = $categoriasDirectos->concat($categoriasDeCuadrillas);
  
      // Aplicar cantidades del catálogo a materiales y categorías
      $updatedMateriales = $this->applyCatalogQuantities($allMateriales, $registrosCatalogo);
      $updatedCategorias = $this->applyCatalogQuantities($allCategorias, $registrosCatalogo);
      $updatedEquipos = $this->applyCatalogQuantities($registroEquipos, $registrosCatalogo);
  
      return [
          'materiales' => $updatedMateriales->groupBy(fn($item) => $item->id_material . '-' . $item->concepto),          
          'categorias' => $updatedCategorias->groupBy(fn($item) => $item->id_categoria . '-' . $item->concepto),
          'equipos' => $updatedEquipos->groupBy(fn($item) => $item->id_equipo . '-' . $item->concepto),
      ];
  } 

  /**      * Genera materiales virtuales a partir de auxiliares.      */
  private function createMaterialFromAuxiliar($materialesAux)
  {
    $materialDeAuxiliar = collect();
    
    foreach ($materialesAux as $materialAux) {
      $conceptosAuxiliares = ConceptosAuxiliares::where('id_auxiliar', $materialAux->id_auxiliar)->get();

      foreach ($conceptosAuxiliares as $conceptoAux) {
        $nuevoMaterial = clone $materialAux;
        $nuevoMaterial->id_material = $conceptoAux->id_material;
        $nuevoMaterial->cantidad = $conceptoAux->cantidad * $materialAux->cantidad;
        $materialDeAuxiliar->push($nuevoMaterial);
      }
    }
    return $materialDeAuxiliar;
  }

  /** Genera categorias virtuales a partir de cuadrillas */
  private function createCategoriaFromCuadrilla($categoriasCuadri)
  {
    $categoriaDeCuadrilla = collect();

    foreach ($categoriasCuadri as $categoriaCuadri) {
      $conceptosCuadrillas = ConceptosCuadrillas::where('id_cuadrilla', $categoriaCuadri->id_cuadrilla)->get();

      foreach ($conceptosCuadrillas as $conceptoCuadri) {
        $nuevaCategoria = clone $categoriaCuadri;
        $nuevaCategoria->id_categoria = $conceptoCuadri->id_categoria;
        $nuevaCategoria->cantidad = $conceptoCuadri->cantidad * $categoriaCuadri->cantidad;
        $categoriaDeCuadrilla->push($nuevaCategoria);
      }
    }
    return  $categoriaDeCuadrilla;
  }

  /**      * Aplica las cantidades de catálogo a los materiales.      */
  private function applyCatalogQuantities($items, $registrosCatalogo)
  {
      return $items->map(function ($item) use ($registrosCatalogo) {
          $registroCatalogo = $registrosCatalogo->get($item->id_tarjeta);
          if ($registroCatalogo) {
              $item->cantidad *= $registroCatalogo->cantidad; // Multiplica la cantidad según el catálogo
          }
          return $item; // Retorna el item actualizado
      });
  }

  /** Guarda los insumos agrupados en la base de datos */
  private function saveGroupedInsumos($idPresup, $insumosAgrupados)
  {
      foreach (['materiales', 'categorias', 'equipos'] as $tipo) {
          if (!isset($insumosAgrupados[$tipo])) {
              continue;
          }

          foreach ($insumosAgrupados[$tipo] as $grupoInsumo) {
              $primerRegistro = $grupoInsumo->first(function ($registro) {
                  return isset($registro->id_tarjeta) && $registro->id_tarjeta !== null;
              });

              if (!$primerRegistro) {
                  continue;
              }

              // Determinar valores según el tipo de insumo
              $idGrupo = match ($tipo) {
                  'materiales' => 1,
                  'categorias' => 2,
                  'equipos' => 3,
              };

              $idTarjeta = $primerRegistro->id_tarjeta ?? null;
              $idMaterial = $primerRegistro->id_material ?? 0;
              $idCategoria = $primerRegistro->id_categoria ?? 0;
              $idEquipo = $primerRegistro->id_equipo ?? 0;

              $cantidadTotal = $grupoInsumo->sum('cantidad');

              // Determinar monto
              $precioUnitario = match ($tipo) {
                  'materiales' => $primerRegistro->material->precio_unitario ?? 0,
                  'categorias' => $primerRegistro->categoria->salario_real ?? 0,
                  'equipos' => $primerRegistro->equipo->precio_unitario ?? 0,
              };
              $monto = $cantidadTotal * $precioUnitario;

              // Guardar o actualizar el registro
              Expinsumos::updateOrCreate(
                  [
                      'id_grupo' => $idGrupo,
                      'id_presup' => $idPresup,
                      'id_tarjeta' => $idTarjeta,
                      'id_material' => $idMaterial,
                      'id_categoria' => $idCategoria,
                      'id_equipo' => $idEquipo,
                  ],
                  [
                      'cantidad' => $cantidadTotal,
                      'monto' => $monto,
                  ]
              );
          }
      }
  }




}


