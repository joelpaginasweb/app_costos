<?php

namespace App\Http\Controllers;

use App\Models\Herramienta;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HerramientaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $herramientas = Herramienta::all();
        return view('tabs/herramienta' ,['herramientas'=>$herramientas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tabs/herramienta');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
      //dd($request ->all());
      $request->validate([
          'grupo' => 'required',
          'equipo' => 'required',
          'modelo' => 'required',
          'marca' => 'required',
          'proveedor' => 'required',
          'unidad' => 'required',
          'precio_unitario' => 'required'
      ]);
      Herramienta::create($request->all());
      return redirect()->route('herramientas.index')->with('success', 'Herramienta Creada');

    }

    /**
     * Display the specified resource.
     */
    public function show(Herramienta $herramienta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        //dd($herramienta);
        $herramienta = Herramienta::find($id);
        return view('tabs/editherramienta',['herramienta'=>$herramienta]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Herramienta $herramienta): RedirectResponse
    {
        //dd($request->all());
        $request->validate([
            'grupo' => 'required',
            'equipo' => 'required',
            'modelo' => 'required',
            'marca' => 'required',
            'proveedor' => 'required',
            'unidad' => 'required',
            'precio_unitario' => 'required'
        ]);
        $herramienta->update($request->all());
        return redirect()->route('herramientas.index')->with('success', 'Herramienta o Equipo actualizado...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Herramienta $herramienta): RedirectResponse
    {
        //
        //dd($herramienta);
        $herramienta->delete();
        return redirect()->route('herramientas.index')->with('success', 'Herramienta o Equipo eliminado...');
        
    }
}
