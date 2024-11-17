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

        // Crear registros virtuales a partir de ConceptosAuxiliares
        $materialDeAuxiliar = collect();
        foreach ($registroMaterialesAux as $materialAux) {
            // Obtener los conceptos auxiliares relacionados
            $conceptosAuxiliares = ConceptosAuxiliares::where('id_auxiliar', $materialAux->id_auxiliar)->get();
            
            foreach ($conceptosAuxiliares as $conceptoAux) {
                // Crear una copia del registro base
                $nuevoMaterial = clone $materialAux;
                
                // Actualizar propiedades del nuevo material
                $nuevoMaterial->id_material = $conceptoAux->id_material;
                $nuevoMaterial->concepto = $conceptoAux->concepto;
                // Multiplicar las cantidades como se especifica
                $nuevoMaterial->cantidad = $conceptoAux->cantidad * $materialAux->cantidad;
                
                $materialDeAuxiliar->push($nuevoMaterial);
            }
        }

        // Combinar las colecciones de materiales directos y auxiliares
        $registroMaterialesTot = $registroMaterialesMat->concat($materialDeAuxiliar);

        $registroMaterialesCant = $registroMaterialesTot->map(function ($material) use ($registrosCatalogo) {
            $registroCatalogo = $registrosCatalogo->get($material->id_tarjeta);   
            if ($registroCatalogo) {
                $material->cantidad *= $registroCatalogo->cantidad;
            }
            return $material;
        });

        $registroMateriales = $registroMaterialesCant->groupBy(fn($item) => $item->id_material . '-' . $item->concepto);
        $this->store($idPresup, $registroMateriales);
    }
}



// --------------------

  //error Call to undefined method stdClass::getKey()
  private function groupMaterialesChatGPT($idTarjetas, $idPresup)
  {
      if ($idTarjetas->isNotEmpty()) {
          $registrosCatalogo = Catalogo::whereIn('id_tarjeta', $idTarjetas)->get()->keyBy('id_tarjeta');  
          $registroMaterialesGet = ConceptosMateriales::whereIn('id_tarjeta', $idTarjetas)->get();  
          $registroMaterialesMat = $registroMaterialesGet->where('id_auxiliar', 0);  
          $registroMaterialesAux = $registroMaterialesGet->where('id_material', 0);
  
          // Crear los registros virtuales en $materialDeAuxiliar
          $materialDeAuxiliar = $registroMaterialesAux->flatMap(function ($registroAux) {
              $conceptosAuxiliares = ConceptosAuxiliares::where('id_auxiliar', $registroAux->id_auxiliar)->get();
              return $conceptosAuxiliares->map(function ($conceptoAuxiliar) use ($registroAux) {
                  return (object)[
                      'id_tarjeta' => $registroAux->id_tarjeta,
                      'id_material' => $conceptoAuxiliar->id_material,
                      'id_auxiliar' => $registroAux->id_auxiliar,
                      'concepto' => $registroAux->concepto,
                      'cantidad' => $registroAux->cantidad * $conceptoAuxiliar->cantidad,
                  ];
              });
          });
  
          // Combinar los registros de $materialDeAuxiliar y $registroMaterialesMat
          $registroMaterialesTot = $registroMaterialesMat->merge($materialDeAuxiliar);
  
          // Ajustar las cantidades basándose en los registros del catálogo
          $registroMaterialesCant = $registroMaterialesTot->map(function ($material) use ($registrosCatalogo) {
              $registroCatalogo = $registrosCatalogo->get($material->id_tarjeta);
  
              if ($registroCatalogo) {
                  $material->cantidad *= $registroCatalogo->cantidad;
              }  
              return $material;
          });
  
          // Agrupar los materiales por id_material y concepto
          $registroMateriales = $registroMaterialesCant->groupBy(fn($item) => $item->id_material . '-' . $item->concepto);
  
          // Guardar los registros procesados
          $this->store($idPresup, $registroMateriales);
      }
  }  

// --------------------
  //---multiplica cant material tarjeta * cant registroCatalogo
  //agrupa materiales, 
  //ejecuta store--------
  //---multiplica cant conceptoMateriales * cant Catalogo
  // private function oldXgroupMateriales($idTarjetas, $idPresup)
  // {
  //   if ($idTarjetas->isNotEmpty()) {
  //     $registrosCatalogo = Catalogo::whereIn('id_tarjeta', $idTarjetas)->get()->keyBy('id_tarjeta');
      
  //     // $registroMaterialesAll = ConceptosMateriales::whereIn('id_tarjeta', $idTarjetas)->get();
  //     $registroMaterialesGet = ConceptosMateriales::whereIn('id_tarjeta', $idTarjetas)->get();
  //     // dd($registroMaterialesGet);

  //     $registroMaterialesMat = $registroMaterialesGet->where('id_auxiliar', 0);
  //     // dd($registroMaterialesMat);

  //     // -------------------------------------------

  //       $registroMaterialesAux = $registroMaterialesGet->where('id_material', 0);
  //         // dd($registroMaterialesAux);

  //         // $registroMaterialesTot = $registroMaterialesMat + $materialDeAuxiliar

  //     // -------------------------------------------
      
  //     // $registroMaterialesCant = $registroMaterialesAll->map(function ($material) use ($registrosCatalogo)
  //     $registroMaterialesCant = $registroMaterialesMat->map(function ($material) use ($registrosCatalogo)
  //     // $registroMaterialesCant = $registroMaterialesTot->map(function ($material) use ($registrosCatalogo)
      
  //     { $registroCatalogo = $registrosCatalogo->get($material->id_tarjeta);
  //       // dd($registroCatalogo);
  //       // dd($material->id_tarjeta);
  //       // dd($material);

  //       if ($registroCatalogo) {
  //         //multiplica cant material tarjeta * cant registroCatalogo(catalogo conceptos)           
  //         $material->cantidad *= $registroCatalogo->cantidad;
  //         // dd($registroCatalogo->cantidad);
  //         dd($material);
  //       }
  //       return $material;
  //     }
      
  //   );

  //   //registros de conceptos_materiales multiplicados por cantidad de catalogo_conceptos
  //   // dd($registroMaterialesCant);
  //   // dd($registroMaterialesCant->cantidad);
  //     $registroMateriales = $registroMaterialesCant->groupBy(fn($item) => $item->id_material . '-' . $item->concepto);
  //     //  dd($registroMateriales);
  //     $this->store($idPresup, $registroMateriales);
  //   }
  // }

// --------------------

  //------store suma cantidades de registros agrupados------
  public function store($idPresup, $registroMateriales)
  {
    if ($idPresup && $registroMateriales->isNotEmpty()) {

      foreach ($registroMateriales as $registroMaterialGroup) {
        // Sumar las cantidades de todos los elementos en este grupo
        $cantidadTotal = $registroMaterialGroup->sum('cantidad');

        // Toma el primer elemento del grupo para obtener el resto de los datos
        $primerRegistro = $registroMaterialGroup->first();
        $idMaterial = $primerRegistro->id_material;
        $monto = $cantidadTotal * $primerRegistro->material->precio_unitario;

        // dd($primerRegistro);

        Expinsumos::updateOrCreate(
          [
            'id_grupo' => 1,            
            'id_presup' => $idPresup,
            'id_material'=>$idMaterial,
            'id_categoria' => 0,
            'id_equipo' => 0,
            // 'id_tarjeta'=>$primerRegistro->id_tarjeta,
          ],
          [
            'cantidad' => $cantidadTotal,
            'monto' => $monto
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
