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
use App\Models\Manodeobra;
use App\Models\Herramienta;
use App\Models\Presu;
use App\Models\ConceptosMateriales;
use App\Models\ConceptosManoObras;
use App\Models\ConceptosEquipos;

class TarjetaController extends Controller
{ 
  /**      * Display a listing of the resource.      */
  public function index(): View
  {
    $tarjetas = Tarjeta::all();
    return view('tabs/tarjetas',['tarjetas'=>$tarjetas]);              
  } 
  
 //---------------------------------------------
  /**  * Store a newly created resource in storage. */ //---optimizado------//
  public function store(Request $request): RedirectResponse
  {
    $dataRequest = $request->validate([
        'partida' => 'required',
        'concepto' => 'required',
        'unidad' => 'required',
        'id_presupuesto' => 'required'
    ]);

    $tipoMaterial = $request->input('tipo_material');
    $tipoManoObra = $request->input('tipo_mano_obra');

    DB::transaction(function () use ($request, $dataRequest) {
        $idTarjeta = $this->crearTarjeta($dataRequest, $request);

        //Recalcular costos con el id de la nueva tarjeta
        $this->calcularCostos($idTarjeta, $request);
    });

    return redirect()->route('tarjetas.index')->with('success', 'Tarjeta de costos Creada con Éxito');
  }

  /**--------new crearTarjeta---------- */
  private function crearTarjeta(array $dataRequest, Request $request)
  {
      $costoMaterial = $this->calcularConceptos(
          null,
          $request->input('tipo_material'),
          $request->input('id_material'),
          $request->input('cantidad_mater'),
          [], [], [],
          [], []
      );

      $costoManoObra = $this->calcularConceptos(
          null, [], [], [],
          $request->input('tipo_mano_obra'),
          $request->input('id_mano_obra'),
          $request->input('cant_mano_obra'),
          [], []
      );

      $costoEquipo = $this->calcularConceptos(
          null, [], [], [],
          [], [], [],
          $request->input('id_equipo'),
          $request->input('cant_equipo')
      );

      $tarjetaData = [
          'partida' => $dataRequest['partida'],
          'concepto' => $dataRequest['concepto'],
          'unidad' => $dataRequest['unidad'],
          'costo_material' => $costoMaterial[0],
          'costo_mano_obra' => $costoManoObra[1],
          'costo_equipo' => $costoEquipo[2],
          'costo_directo' => $this->calcularTarjeta($costoMaterial, $costoManoObra, $costoEquipo, $request)[0],
          'indirectos' => $this->calcularTarjeta($costoMaterial, $costoManoObra, $costoEquipo, $request)[1],
          'financiam' => $this->calcularTarjeta($costoMaterial, $costoManoObra, $costoEquipo, $request)[2],
          'utilidad' => $this->calcularTarjeta($costoMaterial, $costoManoObra, $costoEquipo, $request)[3],
          'cargos_adicion' => $this->calcularTarjeta($costoMaterial, $costoManoObra, $costoEquipo, $request)[4],
          'costo_indirecto' => $this->calcularTarjeta($costoMaterial, $costoManoObra, $costoEquipo, $request)[5],
          'precio_unitario' => $this->calcularTarjeta($costoMaterial, $costoManoObra, $costoEquipo, $request)[6],
          'id_presup' => $dataRequest['id_presupuesto']
      ];

      return Tarjeta::create($tarjetaData)->id;
  }

  /**------new calcularCostos ---------- */
  private function calcularCostos($idTarjeta, Request $request)
  {
      $this->calcularConceptos(
          $idTarjeta,
          $request->input('tipo_material'),
          $request->input('id_material'),
          $request->input('cantidad_mater'),
          [], [], [],
          [], []
      );

      $this->calcularConceptos(
          $idTarjeta, [], [], [],
          $request->input('tipo_mano_obra'),
          $request->input('id_mano_obra'),
          $request->input('cant_mano_obra'),
          [], []
      );

      $this->calcularConceptos(
          $idTarjeta, [], [], [],
          [], [], [],
          $request->input('id_equipo'),
          $request->input('cant_equipo')
      );
  }
  //---------------------------------------------

  //---------------------------------------------------------
  /** ---------calcularConceptos-------------- */ 
  private function calcularConceptos($idTarjeta, $tipoMateriales, $idMateriales, $cantidadesMateriales, $tipoManoObras, $idManoObras, $cantidadesManoObras, $idEquipos, $cantidadesEquipos)
  {
      $costoMaterial = $this->calcularCostoConcepto($idTarjeta, $tipoMateriales, $idMateriales, $cantidadesMateriales, 'material');
      $costoManoObra = $this->calcularCostoConcepto($idTarjeta, $tipoManoObras, $idManoObras, $cantidadesManoObras, 'manoObra');
      $costoEquipo = $this->calcularCostoConcepto($idTarjeta, [], $idEquipos, $cantidadesEquipos, 'equipo');

      return [$costoMaterial, $costoManoObra, $costoEquipo];
  }

  /**---------new----------- */
  private function calcularCostoConcepto($idTarjeta, $tipos, $ids, $cantidades, $tipoConcepto)
  {
      $costoTotal = 0;

      foreach ($ids as $key => $id) {
          $tipo = $tipos[$key] ?? null;
          $cantidad = $cantidades[$key];

          switch ($tipoConcepto) {
              case 'material':
                  $registro = $tipo === 'auxiliar' ? Auxi::find($id) : Materiales::find($id);
                  $precioUnitario = $registro->precio_unitario;
                  break;

              case 'manoObra':
                  if ($tipo === 'categoria') {
                      $registro = Manodeobra::find($id);
                      $precioUnitario = $registro->salario_real;
                      $concepto = $registro->categoria;
                  } else {
                      $registro = Cuadrillas::find($id);
                      $precioUnitario = $registro->total;
                      $concepto = $registro->descripcion;
                  }
                  break;

              case 'equipo':
                  $registro = Herramienta::find($id);
                  $precioUnitario = $registro->precio_unitario;
                  break;
          }

          $importe = $cantidad * $precioUnitario;
          $costoTotal += $importe;

          if ($idTarjeta !== null) {
              $this->guardarConcepto($registro, $precioUnitario, $cantidad, $importe, $id, $idTarjeta, $tipo, $tipoConcepto, $concepto ?? null);
          }
      }

      return $costoTotal;
  }

  /**---------new--------- */
  private function guardarConcepto($registro, $precioUnitario, $cantidad, $importe, $id, $idTarjeta, $tipo, $tipoConcepto, $concepto = null)
  {
      switch ($tipoConcepto) {
          case 'material':
              $this->guardarConceptosMateriales($registro, $precioUnitario, $cantidad, $importe, $id, $idTarjeta, $tipo);
              break;

          case 'manoObra':
              $this->guardarConceptosManoObras($registro, $concepto, $precioUnitario, $cantidad, $importe, $id, $idTarjeta);
              break;

          case 'equipo':
              $this->guardarConceptosEquipos($registro, $precioUnitario, $cantidad, $importe, $id, $idTarjeta);
              break;
      }
  }
  //-----------------------------------------------------


  /** -----calcularTarjeta--------- */
  private function calcularTarjeta ($costoMaterial, $costoManoObra, $costoEquipo, $request)
  {    
    $idPresupuesto = $request->input('id_presupuesto');      
    $presupuesto = Presu::find($idPresupuesto);  

    $porcentIndirecto = $presupuesto->porcent_indirecto;
    $porcentFinanciam = $presupuesto->porcent_financiam;
    $porcentUtilidad = $presupuesto->porcent_utilidad;
    $porcentCostosAdd = $presupuesto->porcent_costos_add;

    $costoDirecto = $costoMaterial[0] + $costoManoObra[1] + $costoEquipo[2]; 

    $indirecto = ($porcentIndirecto/100) * $costoDirecto; 
    $financiam = ($porcentFinanciam/100) * $costoDirecto;
    $utilidad = ($porcentUtilidad/100) * $costoDirecto;
    $cargosAdicion = ($porcentCostosAdd/100) * $costoDirecto;

    $costoIndirecto = $indirecto + $financiam + $utilidad + $cargosAdicion;
    $precioUnitario = $costoDirecto + $costoIndirecto; 

    return [$costoDirecto, $indirecto, $financiam, $utilidad, $cargosAdicion, $costoIndirecto, $precioUnitario ]; 
  }    
    
  /**---------- guardarConceptosMateriales--------- */
  private function guardarConceptosMateriales ($registroMaterial, $PUMaterial, $cantidadMaterial, $importeMaterial, $idMaterial, $idTarjeta, $tipoMaterial )
  {
    ConceptosMateriales::create([
        'id_material' => $idMaterial,
        'concepto' => $registroMaterial->material,
        'unidad' => $registroMaterial->unidad,
        'cantidad' => $cantidadMaterial,
        'precio_unitario' => $PUMaterial,
        'importe' => $importeMaterial,
        'id_tarjeta' => $idTarjeta,
        'tipo' => $tipoMaterial
    ]);
  }  

  /** ---------guardarConceptosManoObras----------- */
  private function guardarConceptosManoObras ($registroManoObra, $conceptoMO, $PUManoObra, $cantidadManoObra, $importeManoObra, $idManoObra, $idTarjeta )
  {           
    ConceptosManoObras::create([
      'id_mano_obra' => $idManoObra,
      'concepto' => $conceptoMO,
      'unidad' => $registroManoObra->unidad,
      'cantidad' => $cantidadManoObra,
      'precio_unitario' => $PUManoObra,
      'importe' => $importeManoObra,
      'id_tarjeta' => $idTarjeta
    ]);
  } 

  /** --------guardarConceptosEquipos---------- */
  private function guardarConceptosEquipos ($registroEquipo, $PUEquipo, $cantidadEquipo, $importeEquipo, $idEquipo, $idTarjeta )
  {           
    ConceptosEquipos::create([
      'id_equipo' => $idEquipo,
      'concepto' => $registroEquipo->equipo,
      'unidad' => $registroEquipo->unidad,
      'cantidad' => $cantidadEquipo,
      'precio_unitario' => $PUEquipo,
      'importe' => $importeEquipo,
      'id_tarjeta' => $idTarjeta
    ]);
  }    
    
  /**  * --------Remove the specified resource from storage.-------   */
  public function destroy(Tarjeta $tarjeta): RedirectResponse
  {
    $tarjeta->delete();
    return redirect()->route('tarjetas.index')->with('success', 'Tarjeta de costos Eliminada!');
  }   

}
  












