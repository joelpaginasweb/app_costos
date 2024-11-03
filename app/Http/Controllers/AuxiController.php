<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\Auxi;
use App\Models\Materiales;
use App\Models\ConceptosAuxiliares;
use App\Models\Grupos;
use App\Models\Unidades;

class AuxiController extends Controller
{

  /**      * Display a listing of the resource.      */
  public function index(): View
  {
    $auxis = Auxi::with(['grupo', 'unidad'])->get();    
    return view('tabs/auxiliares',['auxis'=>$auxis]);
  }
    /**     * Show the form for creating a new resource.     */
  // public function create(): View
  // {      } 

  /**     * Store a newly created resource in storage.     */  
  public function store(Request $request): RedirectResponse
  { 
      $validatedRequest = $request->validate([
          'grupo' => 'required',
          'material_auxiliar' => 'required', 
          'unidad' => 'required'         
      ]);

      $costoDirectoAux = $this->guardarConcepto( 
        null,
        $request->input('id_material'), 
        $request->input('cantidad_mater')
      );

      $ids = $this->getOrCreateIds($validatedRequest);

      $newAuxiliar = Auxi::create([ 
          'id_grupo' => $ids['grupo'],
          'material' => $validatedRequest['material_auxiliar'],  
          'id_unidad' => $ids['unidad'], 
          'precio_unitario' => $costoDirectoAux  
      ]);

      $idAuxiliar = $newAuxiliar->id;
      $costoDirectoAux = $this->guardarConcepto( 
        $idAuxiliar, 
        $request->input('id_material'),
        $request->input('cantidad_mater')
      );   
      return redirect()->route('auxis.index')->with('success', 'Auxiliar Creado');		
    } 
    
    /**      * Display the specified resource.     */
    // public function show(Auxi $auxi)
    // {  }       
    
    /** * crea y guarda conceptos del auxiliar  */
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
          'id_material' => $idMaterial,      
          'id_auxiliar' => $idAuxiliar,
          'cantidad' => $cantidad, 
          'importe' => $importe
        ]);                          
      }  
      $costoDirectoAux += $importe; 
    }    
    return $costoDirectoAux; 
  }  
  
  /** * Show the form for editing the specified resource. */
  public function edit($id): View
  {          
    $auxi = Auxi::with(['grupo', 'unidad'])->findOrFail($id);
    $idAuxiliar = $id;  
    $conceptos = ConceptosAuxiliares::where('id_auxiliar', $idAuxiliar)->with(['materialData', 'unidad'])->get();

    return view('tabs/editauxiliares',['auxi'=>$auxi, 'conceptos'=>$conceptos]);
  }
  
  /**  * Update the specified resource in storage.  */
  public function update(Request $request, Auxi $auxi): RedirectResponse
  {
      $validatedRequest = $request->validate([
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

    $ids = $this->getOrCreateIds($validatedRequest);

    $updateAuxiliar = $auxi->update ([ 
      'grupo' => $validatedRequest['grupo'],
      'id_grupo' => $ids['grupo'],
      'material' => $validatedRequest['material_auxiliar'],   
      'unidad' => $validatedRequest['unidad'], 
      'id_unidad' => $ids['unidad'],
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
  
  /** *edita y crea conceptos del auxiliar */
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
            'id_material' => $idMaterial,      
            'id_auxiliar' => $idAuxiliar,
            'cantidad' => $cantidad, 
            'importe' => $importe
          ]);  
          
        } elseif ($idConcepto !== null && $idAuxiliar !== null){         
          ConceptosAuxiliares::where('id', $idConcepto)->update([
            'id_material' => $idMaterial,
            'cantidad' => $cantidad, 
            'importe' => $importe  
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

  /** *copy the specified resource  */
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
  
  /**  * Remove the specified resource from storage. */
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


  


}
