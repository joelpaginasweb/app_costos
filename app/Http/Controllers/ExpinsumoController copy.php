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
      $this->groupMateriales($idTarjetas, $idPresup);
      $insumos = Expinsumos::where('id_presup', $idPresup)->get();
    }
    return view('tabs/expinsumos', ['insumos' => $insumos, 'idPresup' => $idPresup]);
  }


  private function groupMateriales($idTarjetas, $idPresup)
  {
    if ($idTarjetas->isNotEmpty()) {
      $registrosCatalogo = Catalogo::whereIn('id_tarjeta', $idTarjetas)->get()->keyBy('id_tarjeta');
      
      $registroMaterialesGet = ConceptosMateriales::whereIn('id_tarjeta', $idTarjetas)->get();

      $registroMaterialesMat = $registroMaterialesGet->where('id_auxiliar', 0);

      $registroMaterialesAux = $registroMaterialesGet->where('id_material', 0);

      // $materialDeAuxiliar crear coleccion :  registros virtuales a partir de  los registros del modelo ConceptosAuxiliares que tengan el atributo idAuxiliar el mismo valor que atributo idAuxiliar del la variable $registroMaterialesAux
      //en la propiedad "cantidad" de  $materialDeAuxiliar debera ser igual a la multiplicacion de propiedad "cantidad" de ConceptosAuxiliares por propiedad "cantidad" de $registroMaterialesAux 

      // $registroMaterialesTot crear nueva coleccion = registroMaterialesMat + $materialDeAuxiliar
      
      $registroMaterialesCant = $registroMaterialesTot->map(function ($material) use ($registrosCatalogo)
      
      { $registroCatalogo = $registrosCatalogo->get($material->id_tarjeta);   

        if ($registroCatalogo) {
          $material->cantidad *= $registroCatalogo->cantidad;
          dd($material);
        }
        return $material;
      }      
    );
      $registroMateriales = $registroMaterialesCant->groupBy(fn($item) => $item->id_material . '-' . $item->concepto);
      $this->store($idPresup, $registroMateriales);
    }
  } 
      
}
