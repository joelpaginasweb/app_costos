<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

use App\Models\Dashbo;
use App\Models\Presu;
use App\Models\Tarjeta;
use App\Models\Catalogo;

class PresuController extends Controller
{
    /**     * Display a listing of the resource.     */
    public function index(): View
    {      
        $presus = Presu::all();        
        return view('tabs/presupuesto',['presus'=>$presus]);       
        
    }

    /**     * Show the form for creating a new resource.     */
    public function create(): View
    {
        //
    }

    /**     * Store a newly created resource in storage.     */
    public function store(Request $request): RedirectResponse
    {
        $dataRequest = $request->validate([
          'obra'=>'required',
          'cliente'=>'required',
          'direccion'=>'required',
          'colonia'=>'required',
          'municipio'=>'required',
          'estado'=>'required',
          'porcent_indirecto'=>'required',
          'porcent_financiam'=>'required',
          'porcent_utilidad'=>'required',
          'porcent_costos_add'=>'required'
        ]);

        DB::transaction(function () use ($request, $dataRequest) {
          $estatus = 'nuevo';
          $costoDirecto = 0; 
          $costoIndirecto = 0;
          $costoTotal = $costoDirecto + $costoIndirecto;

          $porcent_indirecto = $dataRequest['porcent_indirecto'];
          $porcent_financiam = $dataRequest['porcent_financiam'];
          $porcent_utilidad = $dataRequest['porcent_utilidad'];
          $porcent_costos_add = $dataRequest['porcent_costos_add'];          
      
          $porcentSuma = $porcent_indirecto + $porcent_financiam + $porcent_utilidad + $porcent_costos_add;

          $newPresupuesto =  Presu::create([
          'obra'=>$dataRequest['obra'],
          'cliente'=>$dataRequest['cliente'] ,
          'direccion'=>$dataRequest['direccion'] ,
          'colonia'=>$dataRequest['colonia'] ,
          'municipio'=>$dataRequest['municipio'] ,
          'estado'=>$dataRequest['estado'] ,

          'estatus'=> $estatus,
          'costo_directo' => $costoDirecto,
          'costo_indirecto' => $costoIndirecto,
          'costo_total' => $costoTotal,

          'porcent_indirecto'=>$dataRequest['porcent_indirecto'] ,
          'porcent_financiam'=>$dataRequest['porcent_financiam'] ,
          'porcent_utilidad'=>$dataRequest['porcent_utilidad'] ,
          'porcent_costos_add'=>$dataRequest['porcent_costos_add'] ,
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
        $presu = Presu::find($idPresup);     

        $tarjetas = Tarjeta::where('id_presup', $idPresup)->get();
        foreach ($tarjetas as $tarjeta) {
            $idTarjeta = $tarjeta->id;
            $existeConcepto = Catalogo::where('id_tarjeta', $idTarjeta)->first();

            if (!$existeConcepto) {
                $newConcepto = Catalogo::create([
                  'concepto' => $tarjeta->concepto,
                  'unidad' => $tarjeta->unidad,   
                  'cantidad' => 0,            
                  'precio_unitario' => $tarjeta->precio_unitario,  
                  'importe' => 0,              
                  'id_tarjeta' => $tarjeta->id,
                  'id_presup' => $tarjeta->id_presup,
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

        return view('tabs/editpresupuesto', [
            'presu' => $presu,
            'conceptos' => $conceptos,
            'costoTotal' => $costoTotal
        ]);
    }    
    
    //*--------------------------------------------------*/
    public function updateConceptoCantidad($id, Request $request)
    {      
      $concepto = Catalogo::find($id); 
      $idTarjeta = $concepto->id_tarjeta;
      $tarjeta = Tarjeta::where('id', $idTarjeta)->first();  // dd($tarjeta);

      $costoDirectoTarjeta = $tarjeta->costo_directo; //dd($costoDirectoTarjeta);  
      $costoIndirectoTarjeta = $tarjeta->costo_indirecto;
      $indirectosTarjeta = $tarjeta->indirectos;
      $financiamTarjeta = $tarjeta->financiam;
      $utilidadTarjeta = $tarjeta->utilidad;
      $cargosAdicionTarjeta = $tarjeta->cargos_adicion;

      $cantidadConcepto= $request->input('cantidad_concepto');     
      $PUConcepto =  $concepto->precio_unitario; 

      $costoDirecto = $cantidadConcepto * $costoDirectoTarjeta;  // dd($costoDirecto);
      $costoIndirecto = $cantidadConcepto * $costoIndirectoTarjeta; //dd($costoIndirecto);
      $importeConcepto = $cantidadConcepto * $PUConcepto;  
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
      $costoTotal = $this->calcularConceptos($PUConcepto, $idPresup);        

      return redirect()->route('cantEdit', $concepto->id_presup);
    }

    //*--------------------------------------------------*/
    // public function calcularIndirectos ($id, Request $request )
      // {
      // }
    
    //*--------------------------------------------------*/
    public function calcularConceptos($PUConcepto, $idPresup)
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
          $importeConcepto = $concepto->importe;
          $costoTotal += $importeConcepto;   

          $costoDirecto = $concepto->costo_directo;
          $costoDirectoTotal += $costoDirecto;

          $costoIndirecto = $concepto->costo_indirecto;
          $costoIndirectoTotal += $costoIndirecto;       

          $indirectos = $concepto->indirectos;
          $indirectosTotal += $indirectos;

          $financiam = $concepto->financiam;
          $financiamTotal += $financiam;

          $utilidad = $concepto->utilidad;
          $utilidadTotal += $utilidad;

          $cargosAdicion = $concepto->cargos_adicion;
          $cargosAdicionTotal += $cargosAdicion; 
        }

        // dd($costoIndirectoTotal);
        $presu->indirectos = $indirectosTotal;

        $presu->costo_directo = $costoDirectoTotal;
        $presu->costo_indirecto = $costoIndirectoTotal;
        $presu->costo_total = $costoTotal;

        $presu->indirectos = $indirectosTotal;
        $presu->financiam = $financiamTotal;
        $presu->utilidad = $utilidadTotal;
        $presu->cargos_adicion = $cargosAdicionTotal;

        $presu->save();          
    }

    /**     * Update the specified resource in storage.     */
    public function update(Request $request, Presu $presu): RedirectResponse
    {
        //
    }

    /**     * Remove the specified resource from storage.     */
    public function destroy(Presu $presu): RedirectResponse
    {
        //
    }
}
