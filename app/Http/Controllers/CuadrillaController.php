<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\Cuadrillas;
use App\Models\Manodeobra;
use App\Models\ConceptosCuadrillas;

class CuadrillaController extends Controller
{

    /**       * Display a listing of the resource.      */
    public function index(): View
    {
        
        $cuadrillas = Cuadrillas::all();
        return view ('tabs/cuadrillas', ['cuadrillas'=>$cuadrillas]);
    }

    /**      * Show the form for creating a new resource.      */
    public function create()
    {
        //
    }

    /**      * Store a newly created resource in storage.      */
    public function store(Request $request): RedirectResponse
    {        
        $dataRequest = $request->validate([
          'grupo' => 'required',
          'descripcion' => 'required', 
          'unidad' => 'required'         
      ]);

      $totalCuadrilla = $this->guardarConcepto (
          null,
          $request->input('id_categoria'),
          $request->input('cantidad_mo')
      );

      $newCuadrilla = Cuadrillas::create([
        'grupo' => $dataRequest['grupo'],
        'descripcion' => $dataRequest['descripcion'],
        'unidad' => $dataRequest['unidad'], 
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

    /**      * Display the specified resource.      */
    // public function show(Cuadrillas $cuadrillas)
    // {
    //     //
    // }

    //-------------crea y guarda conceptos de la cuadrilla-------------//
    private function guardarConcepto ($idCuadrilla, $idCategorias, $cantidades){

      $totalCuadrilla = 0;
      
      foreach ($idCategorias as $key => $idCategoria){ 

        $registroCategoria = Manodeobra::find($idCategoria);       
        $cantidad = $cantidades[$key]; 
        $salarioReal = $registroCategoria->salario_real;
        $importe = $salarioReal * $cantidad; 
        
        if (  $idCuadrilla !== null) {        
          ConceptosCuadrillas::create([            
            'categoria' => $registroCategoria->categoria, 
            'unidad' => $registroCategoria->unidad, 
            'cantidad' => $cantidad, 
            'salario' => $salarioReal,     
            'importe' => $importe,  
            'id_categoria' => $idCategoria,      
            'id_cuadrilla' => $idCuadrilla 
          ]);                          
        }  
        $totalCuadrilla += $importe; 
      }    
      return $totalCuadrilla;
    }

    /**      * Show the form for editing the specified resource.      */
    public function edit($id): View
    {
      $cuadrilla = Cuadrillas::find($id);
      $idCuadrilla = $id;        
      $conceptos = ConceptosCuadrillas::where('id_cuadrilla', $idCuadrilla)->get();
      return view('tabs/editcuadrillas', ['cuadrilla'=>$cuadrilla, 'conceptos' =>$conceptos]);
    }

    /**      * Update the specified resource in storage.      */
    public function update(Request $request, Cuadrillas $cuadrilla): RedirectResponse
    {   
        $dataRequest = $request->validate([
          'grupo' => 'required',
          'descripcion' => 'required', 
          'unidad' => 'required'         
        ]);

        $totalCuadrilla = $this->editarConcepto (
            null,
            $request->input('id_categoria'),
            $request->input('cantidad_mo')
        );

        $descripcion = $request->input('descripcion');        
        $updateCuadrilla = $cuadrilla->update([
          'grupo' => $dataRequest['grupo'],
          'descripcion' => $dataRequest['descripcion'],
          'unidad' => $dataRequest['unidad'], 
          'total' => $totalCuadrilla
        ]);

      $updateCuadrilla = Cuadrillas::where('descripcion', $descripcion)->first();
      $idCuadrilla = $updateCuadrilla->id;

      $totalCuadrilla = $this->editarConcepto (
        $idCuadrilla,
        $request->input('id_categoria'),
        $request->input('cantidad_mo')
      );

      return redirect()->route('cuadrillas.index')->with('success', 'Cuadrilla Actualizada');        
    }

    private function editarConcepto ($idCuadrilla, $idCategorias, $cantidades){

      $totalCuadrilla = 0;
      
      foreach ($idCategorias as $key => $idCategoria){ 

        $registroCategoria = Manodeobra::find($idCategoria);       
        $cantidad = $cantidades[$key]; 
        $salarioReal = $registroCategoria->salario_real;
        $importe = $salarioReal * $cantidad; 
        $idConcepto = ConceptosCuadrillas::where('id_cuadrilla', $idCuadrilla)->pluck('id')->get($key);
        
        if (  $idConcepto == null && $idCuadrilla !== null) {   

          ConceptosCuadrillas::create([            
            'categoria' => $registroCategoria->categoria, 
            'unidad' => $registroCategoria->unidad, 
            'cantidad' => $cantidad, 
            'salario' => $salarioReal,     
            'importe' => $importe,  
            'id_categoria' => $idCategoria,      
            'id_cuadrilla' => $idCuadrilla 
          ]);   

        }  elseif ( $idConcepto !== null && $idCuadrilla !== null){

          ConceptosCuadrillas::where('id', $idConcepto)->update([
            'categoria' => $registroCategoria->categoria, 
            'unidad' => $registroCategoria->unidad, 
            'cantidad' => $cantidad, 
            'salario' => $salarioReal,     
            'importe' => $importe,  
            'id_categoria' => $idCategoria,
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
        return redirect()->route('cuadrillas.index')->with('success', 'Cuadrilla Copiada');  
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
    
}
