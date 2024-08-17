<?php

namespace App\Http\Controllers;

use App\Models\Manodeobra;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ManodeobraController extends Controller

{
  /**    * Display a listing of the resource.    */
  public function index(): View
  {
    $manodeobra = Manodeobra::all();
    return view('tabs/manodeobra',['manodeobra'=>$manodeobra]);
  }

  /**    * Show the form for creating a new resource.    */
  public function create(): View
  {
    
  }  

  /**    * Store a newly created resource in storage.    */
  public function store(Request $requests): RedirectResponse
  {
    $requests->validate([
      'grupo' => 'required',
      'categoria' => 'required',
      'unidad' => 'required',
      'salario_base' => 'required',
      'factor_sr' => 'required' 
    ]);        

    $salarioBase = $requests->salario_base;
    $factorSr = $requests->factor_sr;
    
    $salarioReal = $this->dataOperations($salarioBase, $factorSr);  
    $requests->merge(['salario_real' => $salarioReal]);  

    Manodeobra::create($requests->all());//--------------------
    return redirect()->route('manodeobra.index')->with('success', 'Categoria de mano de obra creada');
  }   
  

  // metodo usado en metodos store y update
  // recibe parametros $salariobase y $factorSr, reliza operaciones y retorna resultado
  public function dataOperations( $salarioBase , $factorSr) {         
    $salarioReal = $salarioBase * $factorSr;
    return $salarioReal;
  }

  /**    * Display the specified resource.    */
  public function show(Manodeobra $manodeobra)
  {
      //
  }

  /**    * Show the form for editing the specified resource.    */
  public function edit($id): View
  {        
    $manodeobra = Manodeobra::find($id);
    return view('tabs/editmanodeobra',['manodeobra'=>$manodeobra]);
  }

  /**    * Update the specified resource in storage.   */
  public function update(Request $request, Manodeobra $manodeobra): RedirectResponse
  {
    $request->validate([
      'grupo' => 'required',
      'categoria' => 'required',
      'unidad' => 'required',
      'salario_base' => 'required',
      'factor_sr' => 'required'
    ]);  
    
    $salarioBase = $request->salario_base;
    $factorSr = $request->factor_sr;       
    $salarioReal = $this->dataOperations($salarioBase , $factorSr);    
    $request->merge(['salario_real' => $salarioReal]);

    $manodeobra->update($request->all());//---------------------
    return redirect()->route('manodeobra.index')->with('success', 'Categoria de mano de obra actualizada');
  }

  /**    * Remove the specified resource from storage.    */
  public function destroy(Manodeobra $manodeobra): RedirectResponse
  {
    $manodeobra->delete();
    return redirect()->route('manodeobra.index')->with('success', 'Categoria de mano de obra eliminada!');
  }

    


}