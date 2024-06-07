<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\Auxi;
use App\Models\Materiales;
use App\Models\ConceptosAuxiliares;

class AuxiController extends Controller
{
  /**      * Display a listing of the resource.      */
  public function index(): View
  {
    $auxis = Auxi::all();
    return view('tabs/auxiliares',['auxis'=>$auxis]);      
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
        'grupo' => 'required',
        'concepto' => 'required',
        'unidad' => 'required'         
    ]);

    $costoDirecto = $this->guardarConcepto( //declara variable llamando al metodo
      null,
      $request->input('id_material'), 
      $request->input('cantidad_mater')
    );

    $newAuxiliar = Auxi::create([ 
        'grupo' => $dataRequest['grupo'],
        'concepto' => $dataRequest['concepto'],     
        'unidad' => $dataRequest['unidad'], 
        'costodirecto' => $costoDirecto    
    ]);

    $idAuxiliar = $newAuxiliar->id;

    $costoDirecto = $this->guardarConcepto( //vuelve a declarar variable llamando al metodo
      $idAuxiliar, 
      $request->input('id_material'),
      $request->input('cantidad_mater')
    );   

    return redirect()->route('auxis.index')->with('success', 'Auxiliar Creado');		
}  

  //---------------metodo guardarConcepto-------------//
  private function guardarConcepto ($idAuxiliar, $idMateriales, $cantidades)
  {
    $costoDirecto = 0; 
    foreach ($idMateriales as $key => $idMaterial){ 

      $registroMaterial = Materiales::find($idMaterial); 
      $cantidad = $cantidades[$key]; 
      $precioUnitario = $registroMaterial->precio_unitario;
      $importe = $precioUnitario * $cantidad;  

      if (  $idAuxiliar !== null) {        
        ConceptosAuxiliares::create([            
          'concepto' => $registroMaterial->material, 
          'unidad' => $registroMaterial->unidad, 
          'precio_unitario' => $precioUnitario,     
          'cantidad' => $cantidad, 
          'importe' => $importe,  
          'id_material' => $idMaterial,      
          'id_auxiliar' => $idAuxiliar 
        ]);                          
      }  
      $costoDirecto += $importe; 
    }    
    return $costoDirecto; 
  }  
  
  /**     * Show the form for editing the specified resource.     */
  public function edit($id): View
  {     
    $auxi = Auxi::find($id); 
      $idAuxiliar = $id;    
      $conceptos = ConceptosAuxiliares::where('id_auxiliar', $idAuxiliar)->get();
      return view('tabs/editauxiliares',['auxi'=>$auxi, 'conceptos'=>$conceptos]);
  }
  
  /**     * Update the specified resource in storage.     */
  public function update(Request $request, Auxi $auxi): RedirectResponse
  {
      $dataRequest = $request->validate([
        'grupo' => 'required',
        'concepto' => 'required',
        'unidad' => 'required'         
       ]);         
    
    $costoDirecto = $this->editarConcepto( 
      null,    
      $request->input('id_material'),
      $request->input('cantidad_mater')               
    );

    $concepto = $request->input('concepto');   

    $updateAuxiliar = $auxi->update ([ 
      'grupo' => $dataRequest['grupo'],
      'concepto' => $dataRequest['concepto'],     
      'unidad' => $dataRequest['unidad'], 
      'costodirecto' => $costoDirecto    
    ]);   

    $updateAuxiliar = Auxi::where('concepto',$concepto)->first();
    $idAuxiliar = $updateAuxiliar->id;

    $costoDirecto = $this->editarConcepto(
      $idAuxiliar,
      $request->input('id_material'),
      $request->input('cantidad_mater') 
    );   
    
    return redirect()->route('auxis.index')->with('success', 'Auxiliar actualizado!');
  }

  
  //------------Editar Concepto por ID---------//
  private function editarConcepto($idAuxiliar, $idMateriales, $cantidades)
  {
      $costoDirecto = 0;   
  
      foreach ($idMateriales as $key => $idMaterial) {
          $registroMaterial = Materiales::find($idMaterial);
          $cantidad = $cantidades[$key];
          $precioUnitario = $registroMaterial->precio_unitario;
          $importe = $precioUnitario * $cantidad;
  
          // Actualizar cada registro individualmente con su respectivo Id
          $idConcepto = ConceptosAuxiliares::where('id_auxiliar', $idAuxiliar)->pluck('id')->get($key);
          ConceptosAuxiliares::where('id', $idConcepto)->update([
              'concepto' => $registroMaterial->material, 
              'unidad' => $registroMaterial->unidad, 
              'cantidad' => $cantidad, 
              'precio_unitario' => $precioUnitario,       
              'importe' => $importe,  
              'id_material' => $idMaterial
          ]);             
  
          $costoDirecto += $importe;
      }    
      return $costoDirecto;
  }
  
  
  /**     * Remove the specified resource from storage.     */
  public function destroy(Auxi $auxi): RedirectResponse
  {
    //dd($auxi);
    $auxi->delete();
    return redirect()->route('auxis.index')->with('success', 'Auxiliar eliminado!');

  }


  /**      * Display the specified resource.     */
  public function show(Auxi $auxi)
  {
      //
  }



}
