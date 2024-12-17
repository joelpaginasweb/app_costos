<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

use App\Models\Dashbo;
use App\Models\Clientes;
use App\Models\Estados;
use App\Models\Ciudades;
use App\Models\Presu;
use App\Models\Tarjeta;
use App\Models\Catalogo;

class PresuController extends Controller
{
    public function index(): View
    {      
        $presus = Presu::with(['cliente'])->get();
        $clientes = Clientes::with(['ciudad', 'estado'])->get();

        return view('tabs/presupuesto',['presus'=>$presus, 'clientes'=>$clientes]);       
        
    }

    /**     * Show the form for creating a new resource.     */
    public function create(): View
    {        }

    /**    *guarda nuevo cliente* */
    public function storeCliente(Request $request): RedirectResponse
    { 
      $validatedRequest = $request->validate([
        'nombre' => 'required',
        'calle' => 'required', 
        'no_exterior' => 'required',       
        'cp' => 'required',       
        'colonia' => 'required',       
        'ciudad' => 'required',   
        'estado' => 'required' 
      ]);

      $ids = $this->getOrCreateIds($validatedRequest);
      // dd($ids);

      Clientes::create([
        'nombre' => $validatedRequest['nombre'],
        'calle' => $validatedRequest['calle'], 
        'no_exterior' => $validatedRequest['no_exterior'], 
        'cp' => $validatedRequest['cp'], 
        'colonia' => $validatedRequest['colonia'], 
        'id_ciudad' => $ids['ciudad'],
        'id_estado' => $ids['estado']
      ]);

      return redirect()->route('presus.index')->with('success', 'Nuevo Cliente Creado');
    }

    /**     * Store a newly presupuesto created resource in storage.     */
    public function store(Request $request): RedirectResponse
    {
        $validatedRequest = $request->validate([
          'proyecto'=>'required',
          'cliente'=>'required',
          'ubicacion'=>'required',
          'porcent_indirecto'=>'required',
          'porcent_financiam'=>'required',
          'porcent_utilidad'=>'required',
          'porcent_costos_add'=>'required'
        ]);

        $ids = $this->getIdCliente($validatedRequest);

        DB::transaction(function () use ($request, $validatedRequest, $ids) {
          $estatus = 'nuevo';
          $costoDirecto = 0; 
          $costoIndirecto = 0;
          $costoTotal = $costoDirecto + $costoIndirecto;

          $porcent_indirecto = $validatedRequest['porcent_indirecto'];
          $porcent_financiam = $validatedRequest['porcent_financiam'];
          $porcent_utilidad = $validatedRequest['porcent_utilidad'];
          $porcent_costos_add = $validatedRequest['porcent_costos_add'];          
      
          $porcentSuma = $porcent_indirecto + $porcent_financiam + $porcent_utilidad + $porcent_costos_add;

          $newPresupuesto =  Presu::create([
          'proyecto'=>$validatedRequest['proyecto'],
          'id_cliente'=>$ids['cliente'] ,
          'ubicacion'=>$validatedRequest['ubicacion'] ,

          'estatus'=> $estatus,
          'costo_directo' => $costoDirecto,
          'costo_indirecto' => $costoIndirecto,
          'costo_total' => $costoTotal,

          'porcent_indirecto'=>$validatedRequest['porcent_indirecto'] ,
          'porcent_financiam'=>$validatedRequest['porcent_financiam'] ,
          'porcent_utilidad'=>$validatedRequest['porcent_utilidad'] ,
          'porcent_costos_add'=>$validatedRequest['porcent_costos_add'] ,
          'porcent_suma' => $porcentSuma,

          'indirectos' => 0,
          'financiam' => 0,
          'utilidad' => 0,
          'cargos_adicion' => 0
        ]);
        $idPresup = $newPresupuesto->id;
      });
        return redirect()->route('presus.index')->with('success', 'Nuevo Presupuesto Creado');
    }

    /**     * Display the specified resource.     */
    public function show(Presu $presu)
    {
        //
    }

    /**     * Show the form for editing the specified resource.    */
    public function edit($idPresup, Request $request): View
    {
      $presu = Presu::with(['cliente'])->findOrFail($idPresup);
      $tarjetas = Tarjeta::where('id_presup', $idPresup)->get();

      foreach ($tarjetas as $tarjeta) {
        $idTarjeta = $tarjeta->id;
        $existeConcepto = Catalogo::where('id_tarjeta', $idTarjeta)->first();

        if (!$existeConcepto) {
          $newConcepto = Catalogo::create([
            'id_tarjeta' => $tarjeta->id,
            'id_presup' => $tarjeta->id_presup,
            'cantidad' => 0,            
            'importe' => 0,              
            'costo_directo' => 0,
            'costo_indirecto' => 0,
            'indirectos' => 0,
            'financiam' => 0,
            'utilidad' => 0,
            'cargos_adicion' => 0
          ]);
        }            
      }
        
      $conceptos = Catalogo::where('id_presup', $idPresup)->get();
      $costoTotal = 0;     
      return view('tabs/editpresupuesto', [ 'presu' => $presu, 'conceptos' => $conceptos,  'costoTotal' => $costoTotal  ]);
    }    
    
    //*--------------------------------------------------*/
    public function updateConceptoCantidad($id, Request $request)
    {      
      $concepto = Catalogo::find($id); 
      // dd($concepto);  
      $idTarjeta = $concepto->id_tarjeta;
      $tarjeta = Tarjeta::where('id', $idTarjeta)->first();   
      // dd($tarjeta);
      $costoDirectoTarjeta = $tarjeta->costo_directo; 
      $costoIndirectoTarjeta = $tarjeta->costo_indirecto;
      $indirectosTarjeta = $tarjeta->indirectos;
      $financiamTarjeta = $tarjeta->financiam;
      $utilidadTarjeta = $tarjeta->utilidad;
      $cargosAdicionTarjeta = $tarjeta->cargos_adicion;

      $cantidadConcepto= $request->input('cantidad_concepto');  
      // dd($cantidadConcepto);  

      // $PUConcepto =  $concepto->concepto->precio_unitario; antes de normalizar bd 
      $PUTarjeta = $tarjeta->precio_unitario;

      // dd($PUConcepto, $PUTarjeta); 
      // $importeConcepto = $cantidadConcepto * $PUConcepto;  antes de normalizar bd 

      $importeConcepto = $cantidadConcepto * $PUTarjeta;  
      $costoDirecto = $cantidadConcepto * $costoDirectoTarjeta;  // dd($costoDirecto);
      $costoIndirecto = $cantidadConcepto * $costoIndirectoTarjeta; //dd($costoIndirecto);
      $indirectosConcepto = $cantidadConcepto * $indirectosTarjeta;
      $financiamConcepto = $cantidadConcepto * $financiamTarjeta;
      $utilidadConcepto = $cantidadConcepto * $utilidadTarjeta;
      $cargosAdicionConcepto = $cantidadConcepto * $cargosAdicionTarjeta;

      $concepto->cantidad = $cantidadConcepto;
      $concepto->costo_directo = $costoDirecto;  //costodirecto
      $concepto->costo_indirecto = $costoIndirecto;
      $concepto->importe = $importeConcepto;  //importe
      $concepto->indirectos = $indirectosConcepto;
      $concepto->financiam = $financiamConcepto;
      $concepto->utilidad = $utilidadConcepto;
      $concepto->cargos_adicion = $cargosAdicionConcepto;
      $concepto->save();      
       
      $idPresup = $concepto->id_presup;
      // $costoTotal = $this->calcularConceptos($PUConcepto, $idPresup); antes de normalizar bd       
      $costoTotal = $this->calcularConceptos($PUTarjeta, $idPresup);        

      return redirect()->route('cantEdit', $concepto->id_presup);
    }

    //*--------------------------------------------------*/
    // public function calcularIndirectos ($id, Request $request )
      // {
      // }
    
    //*--------------------------------------------------*/
    // public function calcularConceptos($PUConcepto, $idPresup) antes de normalizar bd
    public function calcularConceptos($PUTarjeta, $idPresup)
    { 
        $presu = Presu::find($idPresup);        
        $conceptos = Catalogo::where('id_presup', $idPresup)->get();

        $costoTotal = 0;
        $costoDirectoTotal = 0; 
        $costoIndirectoTotal = 0;

        $indirectosTotal = 0;
        $financiamTotal = 0;
        $utilidadTotal = 0;
        $cargosAdicionTotal = 0;        

        foreach ($conceptos as $concepto) {  
          $indirectos = $concepto->indirectos;
          $indirectosTotal += $indirectos;

          $financiam = $concepto->financiam;
          $financiamTotal += $financiam;

          $utilidad = $concepto->utilidad;
          $utilidadTotal += $utilidad;

          $cargosAdicion = $concepto->cargos_adicion;
          $cargosAdicionTotal += $cargosAdicion; 
          // -----------------------------
          $costoIndirecto = $concepto->costo_indirecto;
          $costoIndirectoTotal += $costoIndirecto;

          $costoDirecto = $concepto->costo_directo;
          $costoDirectoTotal += $costoDirecto;

          $importeConcepto = $concepto->importe;
          $costoTotal += $importeConcepto;   
        }  

        $presu->indirectos = $indirectosTotal;
        $presu->financiam = $financiamTotal;
        $presu->utilidad = $utilidadTotal;
        $presu->cargos_adicion = $cargosAdicionTotal;
          // -----------------------------
        $presu->costo_indirecto = $costoIndirectoTotal;
        $presu->costo_directo = $costoDirectoTotal;
        $presu->costo_total = $costoTotal;

        $presu->save();          
    }


    /** Helper function to get or create related model IDs. */
    private function getIdCliente( $data)
    {        
      $cliente = Clientes::where('nombre' , $data['cliente'])->first();
      return [         'cliente' => $cliente->id     ];      
    }     

    /** Helper function to get or create related model IDs. */
    private function getOrCreateIds(array $data): array    {        
      $estado = Estados::firstOrCreate(['estado' => $data['estado']]);
      $ciudad = Ciudades::firstOrCreate([ 'ciudad' => $data['ciudad'],  'id_estado' => $estado->id, ]);

      return [
        'estado' => $estado->id,
        'ciudad' => $ciudad->id
      ];      
    }


    /**     * Update the specified resource in storage.     */
    public function update(Request $request, Presu $presu): RedirectResponse
    {
        //
    }

    /**     * Remove the presu specified resource from storage.     */
    public function destroy(Presu $presu): RedirectResponse
    {
      $presu->delete();
      return redirect()->route('presus.index')->with('success', 'Registro eliminado!');
    }

    /**     * Remove the cliente specified resource from storage.     */
    public function destroyClient( Clientes $cliente): RedirectResponse
    {       
      $cliente->delete();
      return redirect()->route('presus.index')->with('success', 'Registro eliminado!');
    }
}
