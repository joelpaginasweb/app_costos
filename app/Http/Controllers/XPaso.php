<?php

namespace App\Http\Controllers;

//modifica el metodo saveGroupedInsumos para que pueda guardar todos los registros de las colecciones "materiales" "categorias" y "equipos"  con las indicaciones para cada variable que le corresponde a cada atributo indicado en los comments
class Controller extends Controller 
{
  
  private function saveGroupedInsumos($idPresup, $insumosAgrupados)
{
    $rowInsumos = Expinsumos::where('id_presup', $idPresup)->get();
    $montoTotal = 0; // Inicializamos la variable para almacenar la sumatoria
    $updatedInsumoIds = []; // Almacenar IDs de insumos actualizados

    foreach (['materiales', 'categorias', 'equipos'] as $tipo) {
        if (!isset($insumosAgrupados[$tipo])) {
            continue;
        }
        foreach ($insumosAgrupados[$tipo] as $grupoInsumo) {
            $primerRegistro = $grupoInsumo->first(function ($registro) {
                return isset($registro->id_tarjeta) && $registro->id_tarjeta !== null;
            });
            if (!$primerRegistro) {
                continue;
            }
            // Determinar valores según el tipo de insumo
            $idGrupo = match ($tipo) {
                'materiales' => 1,
                'categorias' => 2,
                'equipos' => 3,
            };
            $idTarjeta = $primerRegistro->id_tarjeta ?? null;
            $idMaterial = $primerRegistro->id_material ?? 0;
            $idCategoria = $primerRegistro->id_categoria ?? 0;
            $idEquipo = $primerRegistro->id_equipo ?? 0;
            $cantidadTotal = $grupoInsumo->sum('cantidad');
            
            // Determinar monto
            $precioUnitario = match ($tipo) {
                'materiales' => $primerRegistro->material->precio_unitario ?? 0,
                'categorias' => $primerRegistro->categoria->salario_real ?? 0,
                'equipos' => $primerRegistro->equipo->precio_unitario ?? 0,
            };
            $monto = $cantidadTotal * $precioUnitario;
            
            // Acumular el monto en montoTotal
            $montoTotal += $monto;
            
            // Guardar o actualizar el registro
            $expInsumo = Expinsumos::updateOrCreate(
                [
                    'id_grupo' => $idGrupo,
                    'id_presup' => $idPresup,
                    'id_tarjeta' => $idTarjeta,
                    'id_material' => $idMaterial,
                    'id_categoria' => $idCategoria,
                    'id_equipo' => $idEquipo,
                ],
                [
                    'cantidad' => $cantidadTotal,
                    'monto' => $monto,
                ]
            );
            
            // Agregar el ID del insumo actualizado
            $updatedInsumoIds[] = $expInsumo->id;
        }
    }
    
    // Identificar registros para eliminar
    $rowInsumosDelete = $rowInsumos->whereNotIn('id', $updatedInsumoIds);
    
    // Llamar al método para eliminar los insumos no actualizados
    $this->deleteInsumos($idPresup, $rowInsumosDelete);
    
    return $montoTotal;    
}

public function deleteInsumos($idPresup, $rowInsumosDelete)
{
    // Verificar si hay registros para eliminar
    if ($rowInsumosDelete->count() > 0) {
        // Eliminar los registros
        Expinsumos::whereIn('id', $rowInsumosDelete->pluck('id'))->delete();
    }
}

}
