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

    /**      * Display a listing of the resource.      */
    public function index(): View
    {
      $tarjetas = Tarjeta::with(['grupo'])->get();
      return view('tabs/tarjetas',['tarjetas'=>$tarjetas]);              
    }

    /**  * Store a newly created resource in storage. */
    public function store(Request $request): RedirectResponse
    {
      $validatedRequest = $request->validate([
        'grupo' => 'required',
        'concepto' => 'required',
        'unidad' => 'required',
        'id_presupuesto' => 'required' ,        
        'cantidad_mater' => 'required' ,        
        'cant_mano_obra' => 'required' ,        
        'cant_equipo' => 'required'         
      ]);

      $tipoMaterial = $request->input('tipo_material');
      $tipoManoObra = $request->input('tipo_mano_obra');       

      DB::transaction(function () use ($request, $validatedRequest) {      
        $costoMaterial = $this->calcularConceptos(
          null,
          $request->input('tipo_material'), 
          $request->input('id_material'), 
          $request->input('cantidad_mater'),
          [], [], [],
          [], []
        );

        $costoManoObra = $this->calcularConceptos(
          null, [],  [], [],
            $request->input('tipo_mano_obra'),           
          $request->input('id_mano_obra'),
          $request->input('cant_mano_obra'),
          [], []
        );

        $costoEquipo = $this->calcularConceptos(
          null, [], [],  [],
            [], [], [],
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

        $ids = $this->getOrCreateIds($validatedRequest);

        $newTarjeta = Tarjeta::create ([
          'id_grupo' => $ids['grupo'],
          'concepto' => $validatedRequest['concepto'],   
          'id_unidad' => $ids['unidad'],  

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
          'id_presup' => $validatedRequest['id_presupuesto']
        ]);
    
        $idTarjeta = $newTarjeta->id;

        $costoMaterial = $this->calcularConceptos(
          $idTarjeta,
          $request->input('tipo_material'), 
          $request->input('id_material'),
          $request->input('cantidad_mater'),
          [], [], [],
          [], []
        );   

        $costoManoObra = $this->calcularConceptos(
          $idTarjeta, [], [], [],
          $request->input('tipo_mano_obra'),  
          $request->input('id_mano_obra'),
          $request->input('cant_mano_obra'),
          [], []
        );

        $costoEquipo = $this->calcularConceptos(
          $idTarjeta,  [], 
          [],  [],
          [], [], [],
          $request->input('id_equipo'),
          $request->input('cant_equipo'),
        );        
      });
      
      return redirect()->route('tarjetas.index')->with('success', 'Tarjeta de costos Creada con Exito');    
    }    
    
    private function calcularConceptos($idTarjeta, $tipoMateriales, $idMateriales, $cantidadesMateriales,
    $tipoManoObras, $idCategorias, $cantidadesManoObras, $idEquipos,  $cantidadesEquipos)       
    {    
      
      // --------------------------------------------------
      $costoMaterial = 0;
      foreach ($idMateriales as $key => $idMaterial) {
        $tipoMaterial = $tipoMateriales[$key];
        $cantidadMaterial = $cantidadesMateriales[$key];

        if($tipoMaterial == 'material')  {
          $registroMaterial = Materiales::find($idMaterial);
          $importeMaterial =  $cantidadMaterial * $registroMaterial->precio_unitario;
          $idAuxiliar = 0;

        }elseif ($tipoMaterial == 'auxiliar') {          
          $registroMaterial = Auxi::find($idMaterial);  
          $idAuxiliar = $registroMaterial->id; 
          $importeMaterial =  $cantidadMaterial * $registroMaterial->precio_unitario;
          $idMaterial = 0;
        }

        if ($idTarjeta !== null) { 
          $this->guardarConceptosMateriales($registroMaterial,
           $cantidadMaterial, $importeMaterial, $idMaterial, $idAuxiliar, $idTarjeta,  );
        }
        $costoMaterial += $importeMaterial;
      }      

      // ---------------------------------------------
      $costoManoObra = 0;
      foreach ($idCategorias as $key => $idCategoria){
        $tipoManoObra = $tipoManoObras[$key];
        $cantidadManoObra = $cantidadesManoObras[$key];

        if ($tipoManoObra == "categoria") {
            $registroManoObra = Manodeobra::find($idCategoria); 
            $importeManoObra =  $cantidadManoObra *  $registroManoObra->salario_real;
            $idCuadrilla = 0;            

        } elseif($tipoManoObra == "cuadrilla")  {
            $registroManoObra = Cuadrillas::find($idCategoria);
            $idCuadrilla = $registroManoObra->id;
            $importeManoObra =  $cantidadManoObra *  $registroManoObra->total;
            $idCategoria = 0;            
        }        

        if ($idTarjeta !== null) {
          $this->guardarConceptosManoObras( $registroManoObra,
             $cantidadManoObra, $importeManoObra, $idCategoria, $idCuadrilla, $idTarjeta);
        }
        $costoManoObra += $importeManoObra;
      }
      // ----------------------------------------------------------
      $costoEquipo = 0;
      foreach ($idEquipos as $key => $idEquipo){
        $registroEquipo = Herramienta::find($idEquipo);
        $cantidadEquipo = $cantidadesEquipos[$key];        
        $importeEquipo = $cantidadEquipo *  $registroEquipo->precio_unitario;

        if($idTarjeta !== null) {
          $this->guardarConceptosEquipos($registroEquipo,
            $cantidadEquipo, $importeEquipo, $idEquipo, $idTarjeta);
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
    
    private function guardarConceptosMateriales ($registroMaterial, $cantidadMaterial, 
    $importeMaterial, $idMaterial, $idAuxiliar, $idTarjeta,  )
    {
      ConceptosMateriales::create([
          'id_material' => $idMaterial,
          'id_auxiliar' => $idAuxiliar,
          'id_tarjeta' => $idTarjeta,
          'cantidad' => $cantidadMaterial,
          'importe' => $importeMaterial          
      ]);
    }  
    
    // pendiente aplicar misma logica de guardarConceptosMateriales pero con cuadrilla, agregar columna a tabla
    private function guardarConceptosManoObras ($registroManoObra,
       $cantidadManoObra, $importeManoObra, $idCategoria, $idCuadrilla, $idTarjeta )
    {           
      ConceptosManoObras::create([
        'id_categoria' => $idCategoria,
        'id_cuadrilla' => $idCuadrilla,
        'id_tarjeta' => $idTarjeta,
        'cantidad' => $cantidadManoObra,
        'importe' => $importeManoObra
      ]);
    } 

    private function guardarConceptosEquipos ($registroEquipo,
      $cantidadEquipo, $importeEquipo, $idEquipo, $idTarjeta )
    {           
      ConceptosEquipos::create([
        'id_equipo' => $idEquipo,
        'cantidad' => $cantidadEquipo,
        'importe' => $importeEquipo,
        'id_tarjeta' => $idTarjeta
      ]);
    } 
        
    /**  * Remove the specified resource from storage.   */
    public function destroy(Tarjeta $tarjeta): RedirectResponse
    {
      $tarjeta->delete();
      return redirect()->route('tarjetas.index')->with('success', 'Tarjeta de costos Eliminada!');
    }   

    /** Helper function to get or create related model IDs. */
    private function getOrCreateIds(array $data): array
    {
      $grupo = Grupos::firstOrCreate(['grupo' => $data['grupo']]);
      $unidad = Unidades::firstOrCreate(['unidad' => $data['unidad']]);
      return [
        'grupo' => $grupo->id,
        'unidad' => $unidad->id
      ];
    }

    //--------------------------------------------------------------

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

    //--------------------------------------------------------------

    // /**      * Display the specified resource. */
    // public function show( $id)
    // {     }
    
        /**      * Show the form for creating a new resource. */
    // public function create(): View
    // {    }  



}
  












