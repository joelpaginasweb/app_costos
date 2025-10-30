<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\Herramienta;
use App\Models\Grupos;
use App\Models\Marcas;
use App\Models\Proveedores;
use App\Models\Unidades;

class HerramientaController extends Controller
{
    /**    * Display a listing of the resource.   */
    public function index(): View
    {
        $herramientas = Herramienta::with(['grupo', 'marca', 'unidad', 'proveedor'])->where('id', '!=', 0)->get();
        return view('tabs/herramienta' ,['herramientas'=>$herramientas]);
    }

    /**   * Show the form for creating a new resource.    */
    // public function create(): View
    // {    }

    /**   * Store a newly created resource in storage.    */
    public function store(Request $request): RedirectResponse
    {
      $validatedRequest = $request->validate([
          'grupo' => 'required',
          'herr_equipo' => 'required',
          'marca' => 'required',
          'proveedor' => 'required',
          'unidad' => 'required',
          'precio_unitario' => 'required'
      ]);

      // dd($validateData);

      $ids = $this->getOrCreateIds($validatedRequest);

      Herramienta::create([
        'id_grupo' => $ids['grupo'],
        'herramienta_equipo' => $validatedRequest['herr_equipo'],
        'precio_unitario' => $validatedRequest['precio_unitario'],
        'id_marca' => $ids['marca'],
        'id_proveedor' => $ids['proveedor'],
        'id_unidad' => $ids['unidad']
      ]);
      return redirect()->route('herramientas.index')->with('success', 'Herramienta o Equipo Creada');

    }

    /**      * Display the specified resource.      */
    // public function show(Herramienta $herramienta)
    // {     }

    /**      * Show the form for editing the specified resource.      */
    public function edit($id): View
    {
        $herramienta = Herramienta::with(['grupo', 'marca', 'unidad', 'proveedor'])->findOrFail($id);
        return view('tabs/editherramienta',['herramienta'=>$herramienta]);
    }

    /**      * Update the specified resource in storage.      */
    public function update(Request $request, Herramienta $herramienta): RedirectResponse
    {
      $validatedRequest = $request->validate([
        'grupo' => 'required',
        'herr_equipo' => 'required',
        'marca' => 'required',
        'proveedor' => 'required',
        'unidad' => 'required',
        'precio_unitario' => 'required'
      ]);
      
      $ids = $this->getOrCreateIds($validatedRequest);
      
      $herramienta->update([
        'id_grupo' => $ids['grupo'],
        'herramienta_equipo' => $validatedRequest['herr_equipo'],
        'precio_unitario' => $validatedRequest['precio_unitario'],
        'id_marca' => $ids['marca'],
        'id_proveedor' => $ids['proveedor'],
        'id_unidad' => $ids['unidad']
      ]);

        return redirect()->route('herramientas.index')->with('success', 'Herramienta o Equipo actualizado...');
    }

    /**      * Remove the specified resource from storage.      */
    public function destroy(Herramienta $herramienta): RedirectResponse
    {
        $herramienta->delete();
        return redirect()->route('herramientas.index')->with('success', 'Herramienta o Equipo eliminado...');        
    }

    /**  * Remove the specified resource from storage. */
    public function copy($id)
    {
      $equipoBase = Herramienta::find($id);
      $idEquipo = $id;
      $equipoNew = $equipoBase->replicate();
      $equipoNew->save();

      return redirect()->route('herramientas.index')->with('success', 'Herramienta o Equipo duplicado...');      
    }

    /** Helper function to get or create related model IDs. */
    private function getOrCreateIds(array $data): array 
    {
      $grupo = Grupos::firstOrCreate(['grupo' => $data['grupo']]);
      $marca = Marcas::firstOrCreate(['marca' => $data['marca']]);
      $unidad = Unidades::firstOrCreate(['unidad' => $data['unidad']]);
      $proveedor = Proveedores::firstOrCreate(['proveedor' => $data['proveedor']]);

      return [
        'grupo' => $grupo->id,
        'marca' => $marca->id,
        'unidad' => $unidad->id,
        'proveedor' => $proveedor->id
      ];

    }
}
