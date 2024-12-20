<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\Cuadrillas;
use App\Models\Manodeobra;
use App\Models\ConceptosCuadrillas;
use App\Models\Grupos;
use App\Models\Unidades;

class CuadrillaController extends Controller
{

    /**       * Display a listing of the resource.      */
    public function index(): View
    {        
      $cuadrillas = Cuadrillas::with(['grupo','unidad'])->where('id', '!=', 0)->get();
      return view ('tabs/cuadrillas', ['cuadrillas'=>$cuadrillas]);
    }

    /**      * Store a newly created resource in storage.      */
    public function store(Request $request): RedirectResponse
    {        
        $validatedRequest = $request->validate([
          'grupo' => 'required',
          'descripcion' => 'required', 
          'unidad' => 'required'         
      ]);

      $totalCuadrilla = $this->guardarConcepto (
          null,
          $request->input('id_categoria'),
          $request->input('cantidad_mo')
      );

      $ids = $this->getOrCreateIds($validatedRequest);

      $newCuadrilla = Cuadrillas::create([
        'id_grupo' => $ids['grupo'],
        'descripcion' => $validatedRequest['descripcion'],
        'id_unidad' => $ids['unidad'], 
        'total' => $totalCuadrilla
      ]);

      $idCuadrilla = $newCuadrilla->id;
      $totalCuadrilla = $this->guardarConcepto (
        $idCuadrilla,
        $request->input('id_categoria'),
        $request->input('cantidad_mo')
      );
      return redirect()->route('cuadrillas.index')->with('success', 'Cuadrilla Creada');
    }

    //-------------crea y guarda conceptos de la cuadrilla-------------//
    private function guardarConcepto ($idCuadrilla, $idCategorias, $cantidades)
    {
      $totalCuadrilla = 0;      
      foreach ($idCategorias as $key => $idCategoria){ 
        $registroCategoria = Manodeobra::find($idCategoria);       
        $cantidad = $cantidades[$key]; 
        $salarioReal = $registroCategoria->salario_real;
        $importe = $salarioReal * $cantidad; 
        
        if (  $idCuadrilla !== null) {        
          ConceptosCuadrillas::create([            
            'id_categoria' => $idCategoria,      
            'id_cuadrilla' => $idCuadrilla ,
            'cantidad' => $cantidad, 
            'importe' => $importe            
          ]);                          
        }  
        $totalCuadrilla += $importe; 
      }    
      return $totalCuadrilla;
    }

    /**      * Show the form for editing the specified resource.      */
    public function edit($id): View
    {
      $cuadrilla = Cuadrillas::with(['grupo', 'unidad'])->findOrFail($id);
      $idCuadrilla = $id;        
      $conceptos = ConceptosCuadrillas::where('id_cuadrilla', $idCuadrilla)->with(['categoriaData', 'unidad'])->get();

      return view('tabs/editcuadrillas', ['cuadrilla'=>$cuadrilla, 'conceptos' =>$conceptos]);
    }

    /**      * Update the specified resource in storage.      */
    public function update(Request $request, Cuadrillas $cuadrilla): RedirectResponse
    {   
        $validatedRequest  = $request->validate([
          'grupo' => 'required',
          'descripcion' => 'required', 
          'unidad' => 'required'         
        ]);

        $idCuadrilla = $cuadrilla->id;
        
        $totalCuadrilla = $this->editarConcepto (
            $idCuadrilla,
            $request->input('id_categoria'),
            $request->input('cantidad_mo')
        );

        $descripcion = $request->input('descripcion');  
        $ids = $this->getOrCreateIds($validatedRequest);

        $updateCuadrilla = $cuadrilla->update([
          'id_grupo' => $ids['grupo'],
          'descripcion' => $validatedRequest['descripcion'],
          'id_unidad' => $ids['unidad'], 
          'total' => $totalCuadrilla          
        ]);
 
      return redirect()->back()->with('success', 'Cuadrilla actualizada!');      
    }

    private function editarConcepto ($idCuadrilla, $idCategorias, $cantidades)
    {
      $totalCuadrilla = 0;

      foreach ($idCategorias as $key => $idCategoria){ 
        $registroCategoria = Manodeobra::find($idCategoria);       
        $cantidad = $cantidades[$key]; 
        $salarioReal = $registroCategoria->salario_real;
        $importe = $salarioReal * $cantidad; 
        $idConcepto = ConceptosCuadrillas::where('id_cuadrilla', $idCuadrilla)->pluck('id')->get($key);
        
        if (  $idConcepto == null && $idCuadrilla !== null) { 
          ConceptosCuadrillas::create([            
            'id_categoria' => $idCategoria,      
            'id_cuadrilla' => $idCuadrilla ,
            'cantidad' => $cantidad, 
            'importe' => $importe
          ]);   

        }  elseif ( $idConcepto !== null && $idCuadrilla !== null){
          ConceptosCuadrillas::where('id', $idConcepto)->update([
            'id_categoria' => $idCategoria,
            'cantidad' => $cantidad, 
            'importe' => $importe 
          ]);
        }
        $totalCuadrilla += $importe; 
      }    
      return $totalCuadrilla;
    }

    /** *borra conceptos de ConceptosCuadrillas */
    public function deleteConcepto($idConcepto)
    {
      $conceptoDelete = ConceptosCuadrillas::where('id', $idConcepto)->first();
      $idCuadrilla = $conceptoDelete->id_cuadrilla;
      $conceptoDelete->delete();
      return redirect()->route('cuadrillas.edit', ['cuadrilla' => $idCuadrilla]);
    }

    /**     *copy the specified resource       */
    public function copy($id)
    {      
      $cuadrillaBase = Cuadrillas::find($id);
      $idCuadrilla = $id;  

      $cuadrillaNew = $cuadrillaBase->replicate();
      $cuadrillaNew->save();

      $idCuadrillaNew = $cuadrillaNew->id;  

      $conceptos = ConceptosCuadrillas::where('id_cuadrilla', $idCuadrilla)->get();
      $conceptosNew = collect(); //crea una nueva coleccion vacia para almacenar registros

      foreach ($conceptos as $concepto) {
        $conceptoNew = $concepto->replicate();      
        $conceptoNew->id_cuadrilla = $idCuadrillaNew; 
        $conceptoNew->save();
        $conceptosNew->push($conceptoNew);
      }

        // return redirect()->route('cuadrillas.index')->with('success', 'Cuadrilla Copiada'); 
      return redirect()->route('cuadrillas.edit', ['cuadrilla' => $idCuadrillaNew])->with('success', 'Cuadrilla Copiada');


    }

    /**      * Remove the specified resource from storage.      */
    public function destroy(Cuadrillas $cuadrilla): RedirectResponse
    {
      $idCuadrilla = $cuadrilla->id;
      $conceptos = ConceptosCuadrillas::where('id_cuadrilla', $idCuadrilla)->get();      
      foreach ($conceptos as $concepto ) {
          $concepto->delete();
        }              
      $cuadrilla->delete();
      return redirect()->route('cuadrillas.index')->with('success', 'Cuadrilla eliminada!');
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

    /**      * Show the form for creating a new resource.      */
    // public function create()
    // {   //   // }

        /**      * Display the specified resource.      */
    // public function show(Cuadrillas $cuadrillas)
    // {   //   // }
    
}
