<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

use App\Models\Auxi;
use App\Models\Cuadrillas;
use App\Models\Tarjeta;
use App\Models\Materiales;
use App\Models\Grupos;
use App\Models\Manodeobra;
use App\Models\Herramienta;
use App\Models\Presu;
use App\Models\Unidades;
use App\Models\ConceptosMateriales;
use App\Models\ConceptosManoObras;
use App\Models\ConceptosEquipos;


class TarjetaController extends Controller
{    
  private const VALIDATION_RULES = [
      'grupo' => 'required',
      'concepto' => 'required',
      'unidad' => 'required',
      'id_presupuesto' => 'required',
      'cantidad_mater' => 'required',
      'cant_mano_obra' => 'required',
      'cant_equipo' => 'required'
  ];

  /**      * Display a listing of the resource.      */
  public function index(): View
  {
      $tarjetas = Tarjeta::with(['grupo'])->get();
      return view('tabs/tarjetas', ['tarjetas' => $tarjetas]);
  }

  /**     * Store a newly created resource in storage.     */ 
  public function store(Request $request): RedirectResponse
  {
    $validatedData = $request->validate(self::VALIDATION_RULES);
    // dd($validatedData);

      try {
        DB::transaction(function () use ($request, $validatedData) {
          $costos = $this->calcularCostos($request);
          // dd($costos);

          $tarjeta = $this->guardarOActualizarTarjeta($validatedData, $costos);
          // dd($tarjeta);
          $this->guardarConceptosDetallados($tarjeta->id, $request);
        });

          return redirect()->route('tarjetas.index')
              ->with('success', 'Tarjeta de costos Creada con Éxito');
      } catch (\Exception $e) {
          return redirect()->route('tarjetas.index')
              ->with('error', 'Error al crear la tarjeta: ' . $e->getMessage());
      }
  }

  private function calcularCostos(Request $request): array
  {
  //  dd($request);
      $costosBase = $this->calcularCostosBase($request);
      return array_merge(
          $costosBase,
          $this->calcularCostosAdicionales($costosBase, $request->input('id_presupuesto'))
      );
  }

  private function calcularCostosBase(Request $request): array
  {
      $costoMaterial = $this->calcularCostoMaterial(
          $request->input('tipo_material'),
          $request->input('id_material'),
          $request->input('cantidad_mater')
      );

      $costoManoObra = $this->calcularCostoManoObra(
          $request->input('tipo_mano_obra'),
          $request->input('id_mano_obra'),
          $request->input('cant_mano_obra')
      );

      $costoEquipo = $this->calcularCostoEquipo(
          $request->input('id_equipo'),
          $request->input('cant_equipo')
      );

      $costoDirecto = $costoMaterial + $costoManoObra + $costoEquipo;

      return [
          'costo_material' => $costoMaterial,
          'costo_mano_obra' => $costoManoObra,
          'costo_equipo' => $costoEquipo,
          'costo_directo' => $costoDirecto
      ];
  }

  private function calcularCostoMaterial(array $tipos, array $ids, array $cantidades): float
  {
      $costo = 0;
      foreach ($ids as $key => $id) {
          $tipo = $tipos[$key];
          $cantidad = $cantidades[$key];
          
          $registro = $tipo === 'material' 
              ? Materiales::find($id) 
              : Auxi::find($id);
              
          $costo += $cantidad * $registro->precio_unitario;
      }
      return $costo;
  }

  private function calcularCostoManoObra(array $tipos, array $ids, array $cantidades): float
  {
      $costo = 0;
      foreach ($ids as $key => $id) {
          $tipo = $tipos[$key];
          $cantidad = $cantidades[$key];
          
          $registro = $tipo === 'categoria' 
              ? Manodeobra::find($id) 
              : Cuadrillas::find($id);
              
          $precioUnitario = $tipo === 'categoria' 
              ? $registro->salario_real 
              : $registro->total;
              
          $costo += $cantidad * $precioUnitario;
      }
      return $costo;
  }

  private function calcularCostoEquipo(array $ids, array $cantidades): float
  {
      $costo = 0;
      foreach ($ids as $key => $id) {
          $registro = Herramienta::find($id);
          $costo += $cantidades[$key] * $registro->precio_unitario;
      }
      return $costo;
  }

  private function calcularCostosAdicionales(array $costosBase, int $idPresupuesto): array
  {
      $presupuesto = Presu::find($idPresupuesto);
      $costoDirecto = $costosBase['costo_directo'];

      $indirectos = ($presupuesto->porcent_indirecto / 100) * $costoDirecto;
      $financiamiento = ($presupuesto->porcent_financiam / 100) * $costoDirecto;
      $utilidad = ($presupuesto->porcent_utilidad / 100) * $costoDirecto;
      $cargosAdicionales = ($presupuesto->porcent_costos_add / 100) * $costoDirecto;
      $costoIndirecto = $indirectos + $financiamiento + $utilidad + $cargosAdicionales;

      return [
          'indirectos' => $indirectos,
          'financiam' => $financiamiento,
          'utilidad' => $utilidad,
          'cargos_adicion' => $cargosAdicionales,
          'costo_indirecto' => $costoIndirecto,
          'precio_unitario' => $costoDirecto + $costoIndirecto
      ];
  }

  /**--------------------------------------------------------------------------------------*/
  private function guardarOActualizarTarjeta(array $validatedData, array $costos): Tarjeta  
  {

      $ids = $this->getOrCreateIds($validatedData);
      return Tarjeta::updateOrCreate(
          ['id' => $validatedData['id'] ?? null], 
          [
              'id_grupo' => $ids['grupo'],
              'concepto' => $validatedData['concepto'],
              'id_unidad' => $ids['unidad'],
              'id_presup' => $validatedData['id_presupuesto'],
              ...$costos
          ]
      );
  }

  private function guardarConceptosDetallados(int $idTarjeta, Request $request): void
  {
      $this->guardarOActualizarConceptosMaterial
      (
          $idTarjeta,
          $request->input('tipo_material'),
          $request->input('id_material'),
          $request->input('cantidad_mater')
      );

      $this->guardarOActualizarConceptosManoObra
      (
          $idTarjeta,
          $request->input('tipo_mano_obra'),
          $request->input('id_mano_obra'),
          $request->input('cant_mano_obra')
      );

      $this->guardarOActualizarConceptosEquipo
      (
          $idTarjeta,
          $request->input('id_equipo'),
          $request->input('cant_equipo')
      );
  }

  /**----------------- ----------------------------------------------------------------*/
  private function guardarOActualizarConceptosMaterial(int $idTarjeta, array $tipos, array $ids, array $cantidades): void
  {
      // First, delete existing concepts to avoid duplicates during update
      ConceptosMateriales::where('id_tarjeta', $idTarjeta)->delete();

      foreach ($ids as $key => $id) {
          $tipo = $tipos[$key];
          $cantidad = $cantidades[$key];
          
          ConceptosMateriales::updateOrCreate(
              [
                  'id_tarjeta' => $idTarjeta,
                  'id_material' => $tipo === 'material' ? $id : 0,
                  'id_auxiliar' => $tipo === 'auxiliar' ? $id : 0
              ],
              [
                  'cantidad' => $cantidad,
                  'importe' => $cantidad * ($tipo === 'material' 
                      ? Materiales::find($id)->precio_unitario 
                      : Auxi::find($id)->precio_unitario)
              ]
          );
      }
  }

  /** -----------------------------------------------------------------------------------*/
  private function guardarOActualizarConceptosManoObra(int $idTarjeta, array $tipos, array $ids, array $cantidades): void
  {
      // First, delete existing concepts to avoid duplicates during update
      ConceptosManoObras::where('id_tarjeta', $idTarjeta)->delete();

      foreach ($ids as $key => $id) {
          $tipo = $tipos[$key];
          $cantidad = $cantidades[$key];
          
          ConceptosManoObras::updateOrCreate(
              [
                  'id_tarjeta' => $idTarjeta,
                  'id_categoria' => $tipo === 'categoria' ? $id : 0,
                  'id_cuadrilla' => $tipo === 'cuadrilla' ? $id : 0
              ],
              [
                  'cantidad' => $cantidad,
                  'importe' => $cantidad * ($tipo === 'categoria'
                      ? Manodeobra::find($id)->salario_real
                      : Cuadrillas::find($id)->total)
              ]
          );
      }
  }
  
  /**--------------------------------------------------------------------------------------- */
  private function guardarOActualizarConceptosEquipo(int $idTarjeta, array $ids, array $cantidades): void
  {
      // First, delete existing concepts to avoid duplicates during update
      ConceptosEquipos::where('id_tarjeta', $idTarjeta)->delete();

      foreach ($ids as $key => $id) {
          $cantidad = $cantidades[$key];
          $registro = Herramienta::find($id);
          
          ConceptosEquipos::updateOrCreate(
              [
                  'id_tarjeta' => $idTarjeta,
                  'id_equipo' => $id
              ],
              [
                  'cantidad' => $cantidad,
                  'importe' => $cantidad * $registro->precio_unitario
              ]
          );
      }
  }

  /** Helper function to get or create related model IDs. */
  private function getOrCreateIds(array $data): array
  {
      return [
          'grupo' => Grupos::firstOrCreate(['grupo' => $data['grupo']])->id,
          'unidad' => Unidades::firstOrCreate(['unidad' => $data['unidad']])->id
      ];
  }

  /**      * Show the form for editing the specified resource.      */
    /**-----pendiente optimizar metodo edit--------- */
    public function edit($id): View
  {
    $tarjeta = Tarjeta::with(['grupo', 'unidad'])->findOrFail($id);

    $idTarjeta = $id;

    //$conceptosMat = ConceptosMateriales::where([['id_tarjeta', $idTarjeta],
    // ['id_auxiliar', 0]])->with(['material'])->get();

    $conceptosMat = ConceptosMateriales::where([['id_tarjeta', $idTarjeta],
    ['id_auxiliar', 0]])->get();
    // dd($conceptosMat);

    $conceptosAux = ConceptosMateriales::where([['id_tarjeta', $idTarjeta],
    ['id_material', 0]])->get();

    // Crear colección de conceptosIns
    $conceptosIns = collect();

    foreach ($conceptosMat as $conceptoMat) {
        if ($conceptoMat->id_material != 0) {
            $conceptosIns->push([
                'id_insumo' => $conceptoMat->id_material,
                'material' => $conceptoMat->material->material,
                'unidad' => $conceptoMat->material->unidad->unidad,
                'cantidad' => $conceptoMat->cantidad ?? 0,
                'precio_unitario' => $conceptoMat->material->precio_unitario,
                'importe' => $conceptoMat->importe ?? 0,
                'tipo' => 'material', // Indica que es un material
            ]);
        }
    }

    foreach ($conceptosAux as $conceptoAux) {
        if ($conceptoAux->id_auxiliar != 0) {
            $conceptosIns->push([
                'id_insumo' => $conceptoAux->id_auxiliar,
                'material' => $conceptoAux->auxiliar->material,
                'unidad' => $conceptoAux->auxiliar->unidad->unidad,
                'cantidad' => $conceptoAux->cantidad ?? 0,
                'precio_unitario' => $conceptoAux->auxiliar->precio_unitario,
                'importe' => $conceptoAux->importe ?? 0,
                'tipo' => 'auxiliar', // Indica que es un auxiliar

            ]);
        }
    }

    $conceptosCat = ConceptosManoObras::where([['id_tarjeta', $idTarjeta],
        ['id_cuadrilla', 0]])->get();

    $conceptosCuad = ConceptosManoObras::where([['id_tarjeta', $idTarjeta],
        ['id_categoria', 0]])->get();

    //$conceptosCat = ConceptosManoObras::where([['id_tarjeta', $idTarjeta],
    //['id_cuadrilla', 0]])->with(['categoria'])->get();
    // dd($conceptosCat, $conceptosCuad);

    $conceptosMO = collect();

    foreach ($conceptosCat as $conceptoCat) {
      if($conceptoCat->id_categoria !=0) {
        $conceptosMO->push([
          'id_MO' => $conceptoCat->id_categoria,
          'concepto_MO' => $conceptoCat->categoria->categoria,
          'unidad' => $conceptoCat->categoria->unidad->unidad,
          'cantidad' => $conceptoCat->cantidad,
          'precio_unitario' => $conceptoCat->categoria->salario_real,
          'importe' => $conceptoCat->importe,
          'tipo' => 'categoria'
        ]);
      }
    }  

    foreach ($conceptosCuad as $conceptoCuad) {
      if($conceptoCuad->id_cuadrilla !=0) {
        $conceptosMO->push([
          'id_MO' => $conceptoCuad->id_cuadrilla,
          'concepto_MO' => $conceptoCuad->cuadrilla->descripcion,
          'unidad' => $conceptoCuad->cuadrilla->unidad->unidad,
          'cantidad' => $conceptoCuad->cantidad,
          'precio_unitario' => $conceptoCuad->cuadrilla->total,
          'importe' => $conceptoCuad->importe,
          'tipo' => 'cuadrilla'
        ]);
      }
    } 



    $conceptosEq = ConceptosEquipos::where('id_tarjeta', $idTarjeta)
        ->with(['equipo'])->get();

    // dd($conceptosIns);


    return view('tabs/edittarjetas', [
        'tarjeta' => $tarjeta,
        'conceptosIns' => $conceptosIns, 
        'conceptosMO' => $conceptosMO,
        'conceptosEq' => $conceptosEq,
    ]);
  }


  /**   * Update the specified resource in storage.   */
  public function update(Request $request, Tarjeta $tarjeta): RedirectResponse
  {
      // Añade el ID de la tarjeta a los datos validados
      $validatedData = $request->validate(self::VALIDATION_RULES);
      $validatedData['id'] = $tarjeta->id;

      try {
          DB::transaction(function () use ($request, $validatedData, $tarjeta) {
              $costos = $this->calcularCostos($request);     
              $tarjeta = $this->guardarOActualizarTarjeta($validatedData, $costos);
              $this->guardarConceptosDetallados($tarjeta->id, $request);
          });

          return redirect()->back()
              ->with('success', 'Tarjeta de costos Editada con Éxito');
      } catch (\Exception $e) {
          return redirect()->route('tarjetas.index')
              ->with('error', 'Error al crear la tarjeta: ' . $e->getMessage());
      }   
  }

    /** *borra conceptos de ConceptosAuxiliares */
    public function deleteConcepto($idConcepto)
    {

      $conceptoDelete = ConceptosMateriales::where('id', $idConcepto)->first();

      $idAuxiliar = $conceptoDelete->id_auxiliar;
      $conceptoDelete->delete();
      return redirect()->route('auxis.edit', ['auxi' => $idAuxiliar]);
    }

  /** *copy the specified resource  */
  public function copy($id)
  {
    //
  }

  public function destroy(Tarjeta $tarjeta): RedirectResponse
  {
      try {
          $tarjeta->delete();
          return redirect()->route('tarjetas.index')
              ->with('success', 'Tarjeta de costos Eliminada!');
      } catch (\Exception $e) {
          return redirect()->route('tarjetas.index')
              ->with('error', 'Error al eliminar la tarjeta: ' . $e->getMessage());
      }
  }
    
}















