<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\Expinsumos; 
use App\Models\Presu; 
use App\Models\Catalogo; 
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

    if ($request->has('presup')) {
      $idPresup = $request->input('presup');
      $idTarjetas = Catalogo::where('id_presup', $idPresup)->pluck('id_tarjeta');

      $this->groupMateriales($idTarjetas, $idPresup);

      $insumos = Expinsumos::where('id_presup', $idPresup)->get();
    }
    return view('tabs.expinsumos', ['insumos' => $insumos]);
  }

  //---multiplica cant material * cant registroCatalogo, agrupa materiales, ejecuta store--------
  private function groupMateriales($idTarjetas, $idPresup)
  {
    if ($idTarjetas->isNotEmpty()) {
      $registrosCatalogo = Catalogo::whereIn('id_tarjeta', $idTarjetas)->get()->keyBy('id_tarjeta');
      $registroMaterialesAll = ConceptosMateriales::whereIn('id_tarjeta', $idTarjetas)->get();

      // dd($registroMaterialesAll);
      // tipo  material/auxiliar

      //---multiplica cant conceptoMateriales * cant Catalogo
      //------pendiente multiplicar cantidades de materiales de auxiliares

      $registroMaterialesCant = $registroMaterialesAll->map(function ($material) use ($registrosCatalogo)
            { $registroCatalogo = $registrosCatalogo->get($material->id_tarjeta);
              //--------------------------------------------
        // dd($material);
        //----------------------------------------------
          if ($registroCatalogo) {
              $material->cantidad *= $registroCatalogo->cantidad;
          }
          return $material;
        }
      );

      // dd($registroMaterialesCant);


      $registroMateriales = $registroMaterialesCant->groupBy(fn($item) => $item->id_material . '-' . $item->concepto);
      $this->store($idPresup, $registroMateriales);


    }
  }


  //------store suma cantidades de registros agrupados------
  public function store($idPresup, $registroMateriales)
  {
    if ($idPresup && $registroMateriales->isNotEmpty()) {

      foreach ($registroMateriales as $registroMaterialGroup) {
        // Sumar las cantidades de todos los elementos en este grupo
        $cantidadTotal = $registroMaterialGroup->sum('cantidad');

        // Toma el primer elemento del grupo para obtener el resto de los datos
        $primerRegistro = $registroMaterialGroup->first();

        Expinsumos::updateOrCreate(
          [
            'tipo' => 'material',
            'insumo' => $primerRegistro->concepto,
            'unidad' => $primerRegistro->unidad,
            'precio_unitario' => $primerRegistro->precio_unitario,
            'id_presup' => $idPresup
          ],
          [
            'cantidad' => $cantidadTotal,
            'monto' => $cantidadTotal * $primerRegistro->precio_unitario
          ]
        );
      }
    }
  }  
  
  /**     * Show the form for creating a new resource.*/
  public function create()
  {
    //
  }

  /**     * Display details of the specified resource.     */
  public function show(Expinsumo $expinsumo)
  {
      //
  }

  /**     * Show the form for editing the specified resource.     */
  public function edit(Expinsumo $expinsumo)
  {
      //
  }

  /**     * Update the specified resource in storage.     */
  public function update(Request $request, Expinsumo $expinsumo)
  {
      //
  }

  /**     * Remove the specified resource from storage.     */
  public function destroy(Expinsumo $expinsumo)
  {
      //
  }
}
