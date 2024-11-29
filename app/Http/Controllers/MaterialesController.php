<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Materiales;
use App\Models\Grupos;
use App\Models\Proveedores;
use App\Models\Unidades;

class MaterialesController extends Controller
{
    /** Display a listing of the resource. */
    public function index(): View
    {   
        $materiales = Materiales::with(['grupo', 'unidad', 'proveedor'])->where('id', '!=', 0)->get();
        return view('tabs/materiales', ['materiales' => $materiales]);
    }  

    /**     * Show the form for creating a new resource.     */
    // public function create(): View
    // {           } 

    /** Store a newly created resource in storage. */
    public function store(Request $request): RedirectResponse
    {
        $validatedRequest = $request->validate([
            'grupo' => 'required',
            'material' => 'required',
            'unidad' => 'required',
            'precio_unitario' => 'required',
            'proveedor' => 'required'
        ]);

        $ids = $this->getOrCreateIds($validatedRequest);

        Materiales::create([
            'id_grupo' => $ids['grupo'],
            'material' => $validatedRequest['material'],
            'id_unidad' => $ids['unidad'],
            'precio_unitario' => $validatedRequest['precio_unitario'],
            'id_proveedor' => $ids['proveedor']
        ]);

        return redirect()->route('materiales.index')->with('success', 'Material creado');
    }

    /**     * Display the specified resource.     */
    // public function show(Materiales $materiale)
    // {          }

    
    /** Show the form for editing the specified resource. */
    public function edit($id): View
    {
      $materiale = Materiales::with(['grupo', 'unidad', 'proveedor'])->findOrFail($id);
      return view('tabs/editmateriales', ['materiale' => $materiale]);                
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, Materiales $materiale): RedirectResponse
    {
      $validatedRequest = $request->validate([
        'grupo' => 'required',
        'material' => 'required',
        'unidad' => 'required',
        'precio_unitario' => 'required',
        'proveedor' => 'required'
      ]);

      $ids = $this->getOrCreateIds($validatedRequest);

      $materiale->update([
        'id_grupo' => $ids['grupo'],
        'material' => $validatedRequest['material'],
        'id_unidad' => $ids['unidad'],
        'precio_unitario' => $validatedRequest['precio_unitario'],
        'id_proveedor' => $ids['proveedor']
      ]);

        return redirect()->route('materiales.index')->with('success', 'Material actualizado');
    }

    /** Remove the specified resource from storage. */
    public function destroy(Materiales $materiale): RedirectResponse
    {  
      $materiale->delete();
      return redirect()->route('materiales.index')->with('success', 'Material eliminado!');
    }

    /** Helper function to get or create related model IDs. */
    private function getOrCreateIds(array $data): array
    {
      $grupo = Grupos::firstOrCreate(['grupo' => $data['grupo']]);
      $unidad = Unidades::firstOrCreate(['unidad' => $data['unidad']]);
      $proveedor = Proveedores::firstOrCreate(['proveedor' => $data['proveedor']]);

      return [
        'grupo' => $grupo->id,
        'unidad' => $unidad->id,
        'proveedor' => $proveedor->id
      ];
    }
}