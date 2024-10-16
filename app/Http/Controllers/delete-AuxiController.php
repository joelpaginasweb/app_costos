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
          'material_auxiliar' => 'required', 
          'unidad' => 'required'         
      ]);

      $costoDirectoAux = $this->guardarConcepto( //declara variable llamando al metodo
        null,
        $request->input('id_material'), 
        $request->input('cantidad_mater')
      );

      $newAuxiliar = Auxi::create([ 
          'grupo' => $dataRequest['grupo'],
          'material' => $dataRequest['material_auxiliar'],  
          'unidad' => $dataRequest['unidad'], 
          'precio_unitario' => $costoDirectoAux  
      ]);

      $idAuxiliar = $newAuxiliar->id;
      $costoDirectoAux = $this->guardarConcepto( //vuelve a declarar variable llamando al metodo
        $idAuxiliar, 
        $request->input('id_material'),
        $request->input('cantidad_mater')
      );   
      return redirect()->route('auxis.index')->with('success', 'Auxiliar Creado');		
  }  

  /**      * Display the specified resource.     */
  // public function show(Auxi $auxi)
  // {
  //     
  // }

  //----------crea y guarda conceptos del auxiliar-------------//
  private function guardarConcepto ($idAuxiliar, $idMateriales, $cantidades)
  {
    $costoDirectoAux = 0; 
    
    foreach ($idMateriales as $key => $idMaterial){ 

      $registroMaterial = Materiales::find($idMaterial);       
      $cantidad = $cantidades[$key]; 
      $precioUnitario = $registroMaterial->precio_unitario;
      $importe = $precioUnitario * $cantidad;  

      if (  $idAuxiliar !== null) {        
        ConceptosAuxiliares::create([            
          'concepto' => $registroMaterial->material, 
          'unidad' => $registroMaterial->unidad, 
          'cantidad' => $cantidad, 
          'precio_unitario' => $precioUnitario,     
          'importe' => $importe,  
          'id_material' => $idMaterial,      
          'id_auxiliar' => $idAuxiliar 
        ]);                          
      }  
      $costoDirectoAux += $importe; 
    }    
    return $costoDirectoAux; 
  }  
  
  /**     * Show the form for editing the specified resource.   */
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
        'material_auxiliar' => 'required', 
        'unidad' => 'required'         
       ]);   


    $costoDirectoAux = $this->editarConcepto( 
      null,    
      $request->input('id_material'),
      $request->input('cantidad_mater')               
    );
      
    $materialAuxiliar = $request->input('material_auxiliar'); 

    $updateAuxiliar = $auxi->update ([ 
      'grupo' => $dataRequest['grupo'],
      'material' => $dataRequest['material_auxiliar'],   
      'unidad' => $dataRequest['unidad'], 
      'precio_unitario' => $costoDirectoAux   
    ]);   


    $updateAuxiliar = Auxi::where('material',$materialAuxiliar)->first();
    $idAuxiliar = $updateAuxiliar->id;

    $costoDirectoAux = $this->editarConcepto(
      $idAuxiliar,
      $request->input('id_material'),
      $request->input('cantidad_mater') 
    );   
    
    return redirect()->route('auxis.index')->with('success', 'Auxiliar actualizado!');
  }
  
  //------edita y crea conceptos del auxiliar ---------//
  private function editarConcepto($idAuxiliar, $idMateriales, $cantidades)
  {
      $costoDirectoAux = 0;  

      foreach ($idMateriales as $key => $idMaterial) { 
        $registroMaterial = Materiales::find($idMaterial);
        $cantidad = $cantidades[$key];
        $precioUnitario = $registroMaterial->precio_unitario;
        $importe = $precioUnitario * $cantidad;
        $idConcepto = ConceptosAuxiliares::where('id_auxiliar', $idAuxiliar)->pluck('id')->get($key);      
        
        if ( $idConcepto == null && $idAuxiliar !== null ) {     
          
          ConceptosAuxiliares::create([            
            'concepto' => $registroMaterial->material, 
            'unidad' => $registroMaterial->unidad, 
            'cantidad' => $cantidad, 
            'precio_unitario' => $precioUnitario,     
            'importe' => $importe,  
            'id_material' => $idMaterial,      
            'id_auxiliar' => $idAuxiliar 
          ]);  
          
        } elseif ($idConcepto !== null && $idAuxiliar !== null){         

          ConceptosAuxiliares::where('id', $idConcepto)->update([
            'concepto' => $registroMaterial->material, 
            'unidad' => $registroMaterial->unidad, 
            'cantidad' => $cantidad, 
            'precio_unitario' => $precioUnitario,       
            'importe' => $importe,  
            'id_material' => $idMaterial
          ]);
        } 
        $costoDirectoAux += $importe;
      }          
      return $costoDirectoAux;
  }  

  /** *borra conceptos de ConceptosAuxiliares */
  public function deleteConcepto($idConcepto)
  {
    $conceptoDelete = ConceptosAuxiliares::where('id', $idConcepto)->first();
    $idAuxiliar = $conceptoDelete->id_auxiliar;
    $conceptoDelete->delete();
    return redirect()->route('auxis.edit', ['auxi' => $idAuxiliar]);
  }  

  /**     *copy the specified resource       */
  public function copy($id)
  {      
      $auxiBase = Auxi::find($id);
      $idAuxiliar = $id;    
      $auxiNew = $auxiBase->replicate();
      $auxiNew->save();
      $idAuxiliarNew = $auxiNew->id;
      $conceptos = ConceptosAuxiliares::where('id_auxiliar', $idAuxiliar)->get();
      $conceptosNew = collect(); //crea una nueva coleccion vacia para almacenar registros

      foreach ($conceptos as $concepto) {
      $conceptoNew = $concepto->replicate();      
      $conceptoNew->id_auxiliar = $idAuxiliarNew; 
      $conceptoNew->save();
      $conceptosNew->push($conceptoNew);
      }
      return redirect()->route('auxis.index')->with('success', 'Auxiliar Copiado');	      
  }
  
  /**     * Remove the specified resource from storage.     */
  public function destroy(Auxi $auxi): RedirectResponse
  {    
    $idAuxiliar = $auxi->id;
    $conceptos = ConceptosAuxiliares::where('id_auxiliar', $idAuxiliar)->get();

    foreach ($conceptos as $concepto ) {
        $concepto->delete();
      }
            
    $auxi->delete();
    return redirect()->route('auxis.index')->with('success', 'Auxiliar eliminado!');
  }

}
