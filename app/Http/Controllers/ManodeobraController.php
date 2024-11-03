<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\Manodeobra;
use App\Models\Grupos;
use App\Models\Unidades;

class ManodeobraController extends Controller

{
  /**    * Display a listing of the resource.    */
  public function index(): View
  {
    $manodeobra = Manodeobra::with(['grupox', 'unidad'])->get();
    return view('tabs/manodeobra',['manodeobra'=>$manodeobra]);
  }

  /**    * Show the form for creating a new resource.    */
  // public function create(): View
  // {   }  

  /**    * Store a newly created resource in storage.    */
  public function store(Request $request): RedirectResponse
  {
    $validatedRequest = $request->validate([
      'grupo' => 'required',
      'categoria' => 'required',
      'unidad' => 'required',
      'salario_base' => 'required',
      'factor_sr' => 'required' 
    ]);        

    $salarioBase = $request->salario_base;
    $factorSr = $request->factor_sr;    
    $salarioReal = $this->dataOperations($salarioBase, $factorSr);  

    $ids = $this->getOrCreateIds($validatedRequest);

    Manodeobra::create ([
      'id_grupo' => $ids['grupo'],
      'categoria' => $validatedRequest['categoria'],
      'id_unidad' => $ids['unidad'],
      'salario_base' => $validatedRequest['salario_base'],
      'factor_sr' => $validatedRequest['factor_sr'],
      'salario_real'=> $salarioReal
    ]);
    return redirect()->route('manodeobra.index')->with('success', 'Categoria de mano de obra creada');
  }     

  // metodo usado en metodos store y update
  // recibe parametros $salariobase y $factorSr, reliza operaciones y retorna resultado
  public function dataOperations( $salarioBase , $factorSr) {         
    $salarioReal = $salarioBase * $factorSr;
    return $salarioReal;
  }

  /**    * Display the specified resource.    */
  // public function show(Manodeobra $manodeobra)
  // {    }

  /**    * Show the form for editing the specified resource.    */
  public function edit($id): View
  {        
    $manodeobra = Manodeobra::with(['grupox', 'unidad'])->findOrFail($id);
    return view('tabs/editmanodeobra',['manodeobra'=>$manodeobra]);
  }

  /**    * Update the specified resource in storage.   */
  public function update(Request $request, Manodeobra $manodeobra): RedirectResponse
  {
    $validatedRequest = $request->validate([
      'grupo' => 'required',
      'categoria' => 'required',
      'unidad' => 'required',
      'salario_base' => 'required',
      'factor_sr' => 'required' 
    ]);      
    
    $salarioBase = $request->salario_base;
    $factorSr = $request->factor_sr;    
    $salarioReal = $this->dataOperations($salarioBase, $factorSr);
    
    $ids = $this->getOrCreateIds($validatedRequest);

    $manodeobra->update($request->all());//---------------------

    $manodeobra->update ([
      'id_grupo' => $ids['grupo'],
      'categoria' => $validatedRequest['categoria'],
      'id_unidad' => $ids['unidad'],
      'salario_base' => $validatedRequest['salario_base'],
      'factor_sr' => $validatedRequest['factor_sr'],
      'salario_real'=> $salarioReal
    ]);

    return redirect()->route('manodeobra.index')->with('success', 'Categoria de mano de obra actualizada');
  }

  /**    * Remove the specified resource from storage.    */
  public function destroy(Manodeobra $manodeobra): RedirectResponse
  {
    $manodeobra->delete();
    return redirect()->route('manodeobra.index')->with('success', 'Categoria de mano de obra eliminada!');
  }

  /** Helper function to get or create related model IDs. */
  private function getOrCreateIds(array $data): array
  {
    $grupo = Grupos::firstOrCreate(['grupo' => $data['grupox']]);
    $unidad = Unidades::firstOrCreate(['unidad' => $data['unidad']]);

    return [
      'grupo' => $grupo->id,
      'unidad' => $unidad->id,
    ];
  }   


}