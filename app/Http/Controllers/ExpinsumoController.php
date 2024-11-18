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
    $idPresup = 0;

    if ($request->has('presup')) {

        $idPresup = $request->input('presup');       
        $idTarjetas = Catalogo::where('id_presup', $idPresup)->pluck('id_tarjeta');
       
        if ($idTarjetas->isNotEmpty()) {

          $materialesAgrupados = $this->processInsumos($idTarjetas);

          $this->saveGroupedMateriales($idPresup, $materialesAgrupados);
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

    $materialesDeAuxiliares = $this->generateMaterialesFromAuxiliares(
      $registroMateriales->where('id_material', 0)
    );

    $todosLosMateriales = $materialesDirectos->concat($materialesDeAuxiliares);

    return $this->applyCatalogQuantities($todosLosMateriales, $registrosCatalogo)
        ->groupBy(fn($item) => $item->id_material . '-' . $item->concepto);
  }


  /**      * Genera materiales virtuales a partir de auxiliares.      */
  private function generateMaterialesFromAuxiliares($materialesAux)
  {
    $materialDeAuxiliar = collect();
    
    foreach ($materialesAux as $materialAux) {
      $conceptosAuxiliares = ConceptosAuxiliares::where('id_auxiliar', $materialAux->id_auxiliar)->get();

      foreach ($conceptosAuxiliares as $conceptoAux) {
        $nuevoMaterial = clone $materialAux;
        $nuevoMaterial->id_material = $conceptoAux->id_material;
        $nuevoMaterial->concepto = $conceptoAux->concepto;
        $nuevoMaterial->cantidad = $conceptoAux->cantidad * $materialAux->cantidad;
        $materialDeAuxiliar->push($nuevoMaterial);
      }
    }
    return $materialDeAuxiliar;
  }

  /**      * Aplica las cantidades de catálogo a los materiales.      */
  private function applyCatalogQuantities($materiales, $registrosCatalogo)
  {
    return $materiales->map(function ($material) use ($registrosCatalogo) {
      $registroCatalogo = $registrosCatalogo->get($material->id_tarjeta);
      if ($registroCatalogo) {
        $material->cantidad *= $registroCatalogo->cantidad;
      }
      return $material;
    });
  }

  /**      * Guarda los materiales agrupados en la base de datos.      */
  private function saveGroupedMateriales($idPresup, $materialesAgrupados)
{   
    foreach ($materialesAgrupados as $grupoMaterial) {

        $cantidadTotal = $grupoMaterial->sum('cantidad');
        $primerRegistro = $grupoMaterial->first(); 
        $idMaterial = $primerRegistro->id_material;
        $idTarjeta = $primerRegistro->id_tarjeta; 
        $monto = $cantidadTotal * $primerRegistro->material->precio_unitario;

        Expinsumos::updateOrCreate(          
          [
            'id_grupo' => 1,
            'id_presup' => $idPresup,
            'id_material' => $idMaterial,
            'id_categoria' => 0,
            'id_equipo' => 0,
            'id_tarjeta' => $idTarjeta, 
          ],
          [
            'cantidad' => $cantidadTotal,
            'monto' => $monto
          ]
        );
    }
}



}

