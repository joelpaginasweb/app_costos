<?php

namespace App\Http\Controllers;

//modifica el metodo saveGroupedInsumos para que pueda guardar todos los registros de las colecciones "materiales" "categorias" y "equipos"  con las indicaciones para cada variable que le corresponde a cada atributo indicado en los comments
class ExpinsumoController extends Controller 
{
  /**      * Display a listing of the resource.      */
  public function index(Request $request): View
  {
    $insumos = collect();
    $idPresup = 0;

    if ($request->has('presup')) {

        $idPresup = $request->input('presup');       
        $idTarjetas = Catalogo::where('id_presup', $idPresup)->pluck('id_tarjeta');
       
        if ($idTarjetas->isNotEmpty()) {

          $insumosAgrupados = $this->processInsumos($idTarjetas);      
          $this->saveGroupedInsumos($idPresup, $insumosAgrupados);
        }

      $insumos = Expinsumos::where('id_presup', $idPresup)->get();
    }
    return view('tabs/expinsumos', ['insumos' => $insumos, 'idPresup' => $idPresup]);
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

  /**      * Guarda los materiales agrupados en la base de datos.  */
  private function saveGroupedInsumos($idPresup, $insumosAgrupados)
  {   
      foreach ($insumosAgrupados as $grupoInsumo) { 

          $primerRegistro = $grupoInsumo->first(function ($registro) {            
            return isset($registro->id_tarjeta) && $registro->id_tarjeta !== null;
          });
          
          if (!$primerRegistro) {
              continue;
          }

          $idGrupo = // si registro tiene atributo id_material = 1 /si registro tiene atributo id_categoria = 2 / si registro  tiene atributo id_equipo entonces = 3 ; 
          $idPresup = // parametro $idPresup recibido, debera ser el mismo valor para todos los registros
          $idTarjeta = $primerRegistro->id_tarjeta;
          $idMaterial = $primerRegistro->id_material; //si registro no tiene atributo id_material entonces = 0;
          $idCategoria = //si Registro tiene atributo id_categoria = id_categoria / si registro no tiene atributo id_categoria entonces = 0;
          $idEquipo = 0; //si registro tiene atributo id_equipo = id_equipo / si registro no tiene atributo id_equipo entonces = 0;
          $cantidadTotal = $grupoInsumo->sum('cantidad');
  
          $monto = $cantidadTotal * $primerRegistro->material->precio_unitario;
  
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
                  'monto' => $monto
              ]
          );
      }
  }

}
