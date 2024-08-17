<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\Materiales;

class MaterialesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {   
      //$materiales = Materiales::latest()->get();   aparecen arriba nuevos registros 
      $materiales = Materiales::all();
      return view('tabs/materiales' ,['materiales'=>$materiales]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
       
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //dd($request ->all());
        $request->validate([
            'grupo' => 'required',
            'material' => 'required',
            'unidad' => 'required',
            'precio_unitario' => 'required',
            'proveedor' => 'required'
        ]);
        Materiales::create($request->all());
        return redirect()->route('materiales.index')->with('success', 'Material Creado');

    }

    /**
     * Display the specified resource.
     */
    public function show(Materiales $materiale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        //dd($materiale);        
        $materiale = Materiales::find($id);
        return view('tabs/editmateriales',['materiale'=>$materiale]);
                
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materiales $materiale): RedirectResponse
    {
        //dd($request->all());

        $request->validate([
            'grupo' => 'required',
            'material' => 'required',
            'unidad' => 'required',
            'precio_unitario' => 'required',
            'proveedor' => 'required'
        ]);
        $materiale->update($request->all());
        return redirect()->route('materiales.index')->with('success', 'Material actualizado...');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materiales $materiale): RedirectResponse
    {
        //dd($materiale);
        $materiale->delete();
        return redirect()->route('materiales.index')->with('success', 'Material eliminado!');
    }
}
