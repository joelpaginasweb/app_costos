<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

use App\Models\Auxi;
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


    /**  * Store a newly created resource in storage. */
    public function store(Request $request): RedirectResponse
    {
      $dataRequest = $request->validate([
        'partida' => 'required',
        'concepto' => 'required',
        'unidad' => 'required',
        'id_presupuesto' => 'required'         
      ]);

      $tipoMaterial = $request->input('tipo_material');
      

      DB::transaction(function () use ($request, $dataRequest) {      
        $costoMaterial = $this->calcularConceptos(
          null,
          $request->input('tipo_material'), 
          $request->input('id_material'), 
          $request->input('cantidad_mater'),
          [], [], 
          [], []
        );

        $costoManoObra = $this->calcularConceptos(
          null, [],
          [], [],
          $request->input('id_mano_obra'),
          $request->input('cant_mano_obra'),
          [], []
        );

        $costoEquipo = $this->calcularConceptos(
          null, [], 
          [], [],
          [], [],
          $request->input('id_equipo'),
          $request->input('cant_equipo'),
        ); 
      
        $costoDirecto = $this->calcularTarjeta ($costoMaterial, $costoManoObra, $costoEquipo, $request); 
        $indirecto = $this->calcularTarjeta($costoMaterial, $costoManoObra, $costoEquipo, $request);
        $financiam = $this->calcularTarjeta($costoMaterial, $costoManoObra, $costoEquipo, $request);
        $utilidad = $this->calcularTarjeta($costoMaterial, $costoManoObra, $costoEquipo, $request);
        $cargosAdicion = $this->calcularTarjeta($costoMaterial, $costoManoObra, $costoEquipo, $request);
        $costoIndirecto = $this->calcularTarjeta($costoMaterial, $costoManoObra, $costoEquipo, $request);
        $precioUnitario = $this->calcularTarjeta($costoMaterial, $costoManoObra, $costoEquipo, $request);

        $newTarjeta = Tarjeta::create ([
          'partida' => $dataRequest['partida'],
          'concepto' => $dataRequest['concepto'],     
          'unidad' => $dataRequest['unidad'],

          'costo_material' => $costoMaterial[0],
          'costo_mano_obra' => $costoManoObra[1],
          'costo_equipo' => $costoEquipo [2],

          'costo_directo' => $costoDirecto[0],
          'indirectos' => $indirecto[1],
          'financiam' => $financiam[2],
          'utilidad' => $utilidad[3],
          'cargos_adicion' => $cargosAdicion[4],
          'costo_indirecto' => $costoIndirecto[5],
          'precio_unitario' => $precioUnitario[6],
          'id_presup' => $dataRequest['id_presupuesto']
        ]);
    
        $idTarjeta = $newTarjeta->id;

        $costoMaterial = $this->calcularConceptos(
          $idTarjeta,
          $request->input('tipo_material'), 
          $request->input('id_material'),
          $request->input('cantidad_mater'),
          [], [], 
          [], []
        );   

        $costoManoObra = $this->calcularConceptos(
          $idTarjeta, [], 
          [], [],
          $request->input('id_mano_obra'),
          $request->input('cant_mano_obra'),
          [], []
        );

        $costoEquipo = $this->calcularConceptos(
          $idTarjeta,  [], 
          [],  [],
          [], [],
          $request->input('id_equipo'),
          $request->input('cant_equipo'),
        );  
      
      });
      
      return redirect()->route('tarjetas.index')->with('success', 'Tarjeta de costos Creada con Exito');    
    }

    private function calcularConceptos( $idTarjeta, $tipoMateriales,
      $idMateriales, $cantidadesMateriales,
      $idManoObras, $cantidadesManoObras,
      $idEquipos,  $cantidadesEquipos  )      
    {     
      $costoMaterial = 0;
      foreach ($idMateriales as $key => $idMaterial) {
        $tipoMaterial = $tipoMateriales[$key];

         if ($tipoMaterial == "auxiliar") {          
           $registroMaterial = Auxi::find($idMaterial);           
          } else  {
            $registroMaterial = Materiales::find($idMaterial);
          } 
          
        $cantidadMaterial = $cantidadesMateriales[$key];
        $PUMaterial = $registroMaterial->precio_unitario; 
        $importeMaterial =  $cantidadMaterial * $PUMaterial;
        
        if ($idTarjeta !== null) { 
          $this->guardarConceptosMateriales($registroMaterial, $PUMaterial, $cantidadMaterial, $importeMaterial, $idMaterial, $idTarjeta);
        }
        $costoMaterial += $importeMaterial;
      }
      
      $costoManoObra = 0;
      foreach ($idManoObras as $key => $idManoObra){
        $registroManoObra = Manodeobra::find($idManoObra);
        $cantidadManoObra = $cantidadesManoObras[$key];
        $PUManoObra = $registroManoObra->salario_real;
        $importeManoObra =  $cantidadManoObra * $PUManoObra;

        if ($idTarjeta !== null) {
          $this->guardarConceptosManoObras( $registroManoObra, $PUManoObra, $cantidadManoObra, $importeManoObra, $idManoObra, $idTarjeta);
        }
        $costoManoObra += $importeManoObra;
      }

      $costoEquipo = 0;
      foreach ($idEquipos as $key => $idEquipo){
        $registroEquipo = Herramienta::find($idEquipo);
        $cantidadEquipo = $cantidadesEquipos[$key];        
        $PUEquipo = $registroEquipo->precio_unitario;
        $importeEquipo = $cantidadEquipo * $PUEquipo;

        if($idTarjeta !== null) {
          $this->guardarConceptosEquipos($registroEquipo, $PUEquipo, $cantidadEquipo, $importeEquipo, $idEquipo, $idTarjeta);
        }
        $costoEquipo += $importeEquipo;
      }
      return [$costoMaterial, $costoManoObra, $costoEquipo];
    }
    
    private function calcularTarjeta ($costoMaterial, $costoManoObra, $costoEquipo, $request){    
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

    private function guardarConceptosMateriales ($registroMaterial, $PUMaterial, $cantidadMaterial, $importeMaterial, $idMaterial, $idTarjeta )
    {
      ConceptosMateriales::create([
          'id_material' => $idMaterial,
          'concepto' => $registroMaterial->material,
          'unidad' => $registroMaterial->unidad,
          'cantidad' => $cantidadMaterial,
          'precio_unitario' => $PUMaterial,
          'importe' => $importeMaterial,
          'id_tarjeta' => $idTarjeta
      ]);
    }  

    private function guardarConceptosManoObras ($registroManoObra, $PUManoObra, $cantidadManoObra, $importeManoObra, $idManoObra, $idTarjeta )
    {           
      ConceptosManoObras::create([
        'id_mano_obra' => $idManoObra,
        'concepto' => $registroManoObra->categoria,
        'unidad' => $registroManoObra->unidad,
        'cantidad' => $cantidadManoObra,
        'precio_unitario' => $PUManoObra,
        'importe' => $importeManoObra,
        'id_tarjeta' => $idTarjeta
      ]);
    } 

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
  
    /**  * Show the form for editing the specified resource.*   */ 
    public function edit(Tarjeta $tarjeta): View
    {
      //
    }
    
    /**      * Update the specified resource in storage. */
    public function update(Request $request, Tarjeta $tarjeta): RedirectResponse
    {
      //
    }
    
    /**  * Remove the specified resource from storage.   */
    public function destroy(Tarjeta $tarjeta): RedirectResponse
    {
      $tarjeta->delete();
      return redirect()->route('tarjetas.index')->with('success', 'Tarjeta de costos Eliminada!');

    }    
    
    /**      * Show the form for creating a new resource. */
    public function create(): View
    {
        // return view('tabs/tarjetas');
    } 

    /**      * Display the specified resource. */
    public function show( $id)
    {
      // $registro = Tarjeta::find($id);
      // return view('vista', ['campo' => $registro->campo]);
    }
  }
  