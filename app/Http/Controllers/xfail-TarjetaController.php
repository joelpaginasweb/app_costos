<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Models\Auxi;
use App\Models\Cuadrillas;
use App\Models\Tarjeta;
use App\Models\Materiales;
use App\Models\Manodeobra;
use App\Models\Herramienta;
use App\Models\Presu;
use App\Models\ConceptosMateriales;
use App\Models\ConceptosManoObras;
use App\Models\ConceptosEquipos;

class TarjetaController extends Controller
{ 
    public function index(): View
    {
        $tarjetas = Tarjeta::all();
        return view('tabs/tarjetas', ['tarjetas' => $tarjetas]);
    }

    public function store(Request $request): RedirectResponse
    {
        $dataRequest = $request->validate([
            'partida' => 'required',
            'concepto' => 'required',
            'unidad' => 'required',
            'id_presupuesto' => 'required'
        ]);

        try {
            DB::transaction(function () use ($request, $dataRequest) {
                [$costoMaterial, $costoManoObra, $costoEquipo] = $this->procesarCostos($request, null);

                $valoresTarjeta = $this->calcularTarjeta($costoMaterial, $costoManoObra, $costoEquipo, $request);
                // dd($valoresTarjeta);
                $newTarjeta = Tarjeta::create(array_merge($dataRequest, $valoresTarjeta));

                $this->procesarCostos($request, $newTarjeta->id);
            });

            return redirect()->route('tarjetas.index')->with('success', 'Tarjeta de costos creada con éxito');
        } catch (\Exception $e) {
            return Redirect::back()->withErrors('Error al crear la tarjeta: ' . $e->getMessage());
        }
    }

    private function procesarCostos(Request $request, ?int $idTarjeta): array
    {
        return $this->calcularConceptos(
            $idTarjeta,
            $request->input('tipo_material', []),
            $request->input('id_material', []),
            $request->input('cantidad_mater', []),
            $request->input('tipo_mano_obra', []),
            $request->input('id_mano_obra', []),
            $request->input('cant_mano_obra', []),
            $request->input('id_equipo', []),
            $request->input('cant_equipo', [])
        );
    }

    private function calcularConceptos(
        ?int $idTarjeta,
        array $tipoMateriales,
        array $idMateriales,
        array $cantidadesMateriales,
        array $tipoManoObras,
        array $idManoObras,
        array $cantidadesManoObras,
        array $idEquipos,
        array $cantidadesEquipos
    ): array {
        $costoMaterial = $this->calcularCostoItems($idTarjeta, $tipoMateriales, $idMateriales, $cantidadesMateriales, 'material');
        $costoManoObra = $this->calcularCostoItems($idTarjeta, $tipoManoObras, $idManoObras, $cantidadesManoObras, 'manoObra');
        $costoEquipo = $this->calcularCostoItems($idTarjeta, [], $idEquipos, $cantidadesEquipos, 'equipo');

        return [$costoMaterial, $costoManoObra, $costoEquipo];
    }

    private function calcularCostoItems(
        ?int $idTarjeta,
        array $tipos,
        array $ids,
        array $cantidades,
        string $tipo
    ): float {
        $totalCosto = 0;

        foreach ($ids as $key => $id) {
            $registro = $this->obtenerRegistro($tipo, $tipos[$key] ?? null, $id);
            $cantidad = $cantidades[$key];
            $precioUnitario = $registro->precio_unitario ?? $registro->salario_real ?? $registro->total;
            $importe = $cantidad * $precioUnitario;

            if ($idTarjeta !== null) {
                $this->guardarConcepto($tipo, $registro, $precioUnitario, $cantidad, $importe, $id, $idTarjeta);
            }

            $totalCosto += $importe;
        }

        return $totalCosto;
    }

    private function obtenerRegistro(string $tipo, ?string $subTipo, int $id)
    {
        return match ($tipo) {
            'material' => $subTipo === 'auxiliar' ? Auxi::find($id) : Materiales::find($id),
            'manoObra' => $subTipo === 'categoria' ? Manodeobra::find($id) : Cuadrillas::find($id),
            'equipo' => Herramienta::find($id),
            default => null
        };
    }

    private function guardarConcepto(string $tipo, $registro, $precioUnitario, $cantidad, $importe, $id, $idTarjeta)
    {
        $modelo = match ($tipo) {
            'material' => ConceptosMateriales::class,
            'manoObra' => ConceptosManoObras::class,
            'equipo' => ConceptosEquipos::class,
        };

        $modelo::create([
            'id_' . $tipo => $id,
            'concepto' => $registro->descripcion ?? $registro->categoria ?? $registro->material ?? $registro->equipo,
            'unidad' => $registro->unidad,
            'cantidad' => $cantidad,
            'precio_unitario' => $precioUnitario,
            'importe' => $importe,
            'id_tarjeta' => $idTarjeta,
        ]);
    }

    private function calcularTarjeta(float $costoMaterial, float $costoManoObra, float $costoEquipo, Request $request): array
    {
        $presupuesto = Presu::find($request->input('id_presupuesto'));

        $costoDirecto = $costoMaterial + $costoManoObra + $costoEquipo;

        $indirecto = ($presupuesto->porcent_indirecto / 100) * $costoDirecto;
        $financiam = ($presupuesto->porcent_financiam / 100) * $costoDirecto;
        $utilidad = ($presupuesto->porcent_utilidad / 100) * $costoDirecto;
        $cargosAdicion = ($presupuesto->porcent_costos_add / 100) * $costoDirecto;

        $costoIndirecto = $indirecto + $financiam + $utilidad + $cargosAdicion;
        $precioUnitario = $costoDirecto + $costoIndirecto;

        return compact('costoDirecto', 'indirecto', 'financiam', 'utilidad', 'cargosAdicion', 'costoIndirecto', 'precioUnitario');
    }

    public function destroy(Tarjeta $tarjeta): RedirectResponse
    {
        $tarjeta->delete();
        return redirect()->route('tarjetas.index')->with('success', 'Tarjeta de costos eliminada!');
    }
}
  