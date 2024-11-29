@extends('layouts.aplication')
@section('title', 'Editar Tarjetas')
@section('content')


<section class="section ">
  <div class="emergente__contenedor emergente__contain-display" id="emergente">

    <div class="emergente__header ">
      <h3 class="emergente__titulo">TARJETA DE COSTOS</h3>
      <div class="emergente__close">
        <a href="#">
          <h4 id="close" class="emergente__h4">cerrar</h4>
        </a>
      </div>
    </div>
    {{-- ---------------------------- --}}
    <form action="{{route('tarjetas.update', $tarjeta)}}" method="POST" class="form">
      @csrf
      @method('PUT')

      <div class="datosEmer">
        <div class="datosEmer__contain border-bottom">
          <h4>CONCEPTO:</h4>
          <textarea name="concepto"
            class="form__input form__input--area  pointer">{{$tarjeta->concepto}}</textarea>
        </div>
        <div class=" containDatos">
          <div class=" containDatos__datos">
            <h4>ID PRESUPUESTO:</h4>
             <input type="number" step="0" name="id_presupuesto" class="form__input" value="{{$tarjeta->id_presup}}">
          </div>
          <div class=" containDatos__datos ">
            <h4>ID TARJETA:</h4>
            <p>{{$tarjeta->id}}</p>
          </div>
          <div class=" containDatos__datos">
            <h4>PARTIDA:</h4>
            <input type="text" name="grupo" class="form__input select_auto pointer" value="{{$tarjeta->grupo->grupo}}">
          </div>
          <div class=" containDatos__datos">
            <h4>UNIDAD:</h4>
            <input type="text" name="unidad" class="form__input form__input--short select_auto pointer"
              value="{{$tarjeta->unidad->unidad}}">
          </div>

        </div>

      </div>
      {{-- ------------------------------ --}}

      <div class="contain__tablemergent">
        <table class="tablemergent">
          <thead class="tablemergent__thead">
            <tr>
              <th></th>
              <th>ID</th>
              <th>CONCEPTO</th>
              <th>UNIDAD</th>
              <th>CANTIDAD</th>
              <th>PRECIO UN.</th>
              <th>IMPORTE</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="button" class="form__boton form__boton--short" id="boton_add_mat" value="+ Fila"></td>
              <td></td>
              <th>MATERIALES</th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
          <tbody id="tbody_mat">
            @foreach ($conceptosIns as $conceptoIns)
            
            <tr>
              <td><a href="{{route('conceptoDeleteTarj', $conceptoIns['id_reg'])}}" class="form__span">X</a></td>
              {{-- <td><a href="" class="form__span">X</a></td> --}}
              <td>
                <div class="contain">
                  <div class="contain">
                    <select class="select_none" name="tipo_material[]">
                      <option value="material" @selected($conceptoIns['tipo']==='material' )>mat</option>
                      <option value="auxiliar" @selected($conceptoIns['tipo']==='auxiliar' )>aux</option>
                    </select>
                  </div>
                  <input type="number" step="0" name="id_material[]"
                    class="form__input  form__input--short select_auto pointer" value="{{$conceptoIns['id_insumo']}}">
                </div>
              </td>
              <td class="tablemergent__td">{{$conceptoIns['material']}}</td>
              <td>{{$conceptoIns['unidad']}}</td>
              <td>
                <input type="number" step="0.0001" name="cantidad_mater[]"
                  class="form__input form__input--short pointer select_auto " value="{{$conceptoIns['cantidad']}}">
              </td>
              <td>{{number_format ($conceptoIns['precio_unitario'], 2)}}</td>
              <td>{{number_format($conceptoIns['importe'], 2)}}</td>
            </tr>
            @endforeach
          </tbody>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>SUB-TOTAL</td>
              <td>{{number_format($tarjeta->costo_material,2)}}</td>
            </tr>
          </tbody>
          <tbody>
            <tr>
              <td><input type="button" class="form__boton form__boton--short" id="boton_add_mo" value="+ Fila"></td>
              <td></td>
              <th>MANO DE OBRA</th>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
          <tbody id="tbody_mo">
            @foreach ($conceptosMO as $conceptoMO)
            <tr>
              <td><a href="{}" class="form__span">X</a></td>
              <td>
                <div class="contain">
                  <div class="contain">
                    <select class="select_none" name="tipo_mano_obra[]">
                      <option value="categoria" @selected($conceptoMO['tipo']==='categoria' )>cat</option>
                      <option value="cuadrilla" @selected($conceptoMO['tipo']==='cuadrilla' )>cuad</option>
                    </select>
                  </div>
                  <input type="number" step="0" name="id_mano_obra[]"
                    class="form__input  form__input--short select_auto pointer" value="{{$conceptoMO['id_MO']}}">
                </div>
              </td>
              <td class="tablemergent__td">{{$conceptoMO['concepto_MO']}}</td>
              <td>{{$conceptoMO['unidad']}}</td>
              <td>
                <input type="number" step="0.0001" name="cant_mano_obra[]"
                  class="form__input form__input--short pointer select_auto " value="{{$conceptoMO['cantidad']}}">
              </td>
              <td>{{number_format ($conceptoMO['precio_unitario'], 2)}}</td>
              <td>{{number_format($conceptoMO['importe'], 2)}}</td>
            </tr>
            @endforeach
          </tbody>
          {{---------------------------------- --}}
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>SUB-TOTAL</td>
              <td>{{number_format($tarjeta->costo_mano_obra,2)}}</td>
            </tr>
          </tbody>
          {{---------------------------------- --}}
          <tbody>
            <tr>
              <td><input type="button" class="form__boton form__boton--short" id="boton_add_eq" value="+ Fila"></td>
              <td></td>
              <th>HERRAMIENTA Y EQUIPO</th>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
          {{---------------------------------- --}}
          <tbody id="tbody_eq">
            @foreach ($conceptosEq as $conceptoEq)
            <tr>
              <td><a href="{}" class="form__span">X</a></td>
              <td>
                <input type="number" step="0" name="id_equipo[]"
                  class="form__input  form__input--short select_auto pointer " value="{{$conceptoEq->id_equipo}}">
              </td>
              <td class="tablemergent__td">{{$conceptoEq->equipo->herramienta_equipo}}</td>
              <td>{{$conceptoEq->equipo->unidad->unidad}}</td>
              <td>
                <input type="number" step="0.0001" name="cant_equipo[]"
                  class="form__input form__input--short pointer select_auto " value="{{$conceptoEq->cantidad}}">
              </td>
              <td>{{$conceptoEq->equipo->precio_unitario}}</td>
              <td>{{number_format($conceptoEq->importe, 2)}}</td>
            </tr>
            @endforeach
          </tbody>
          {{-- ------------------------ --}}
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>SUB-TOTAL</td>
              <td>{{number_format($tarjeta->costo_equipo,2)}}</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <th>COSTO DIRECTO</th>
              <th>{{number_format($tarjeta->costo_directo,2)}}</th>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="subsection__tablaIndir">
        <div class=" contain__botonesIndir">
          <div class="contain__btn">
            <button type="submit" id="formBoton" class="form__boton">Editar</button>
    </form>
    <form action="{{route('tarjetas.index')}}">
      <button type="submit" class="form__boton">Tarjetas</button>
    </form>
  </div>
  </div>
  <div class="contain__tablaIndir">
    <table class="tablaindir tablemergent">
      <thead class="tablemergent__thead">
        <tr>
          <th>GASTOS INDIRECTOS</th>
          <th>PORCENTAJE</th>
          <th>MONTO</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>INDIRECTOS</td>
          <td>{{$tarjeta->presupuesto->porcent_indirecto}}</td>
          <td>{{number_format($tarjeta->indirectos,2)}}</td>
        </tr>
        <tr>
          <td>FINANCIAMIENTO</td>
          <td>{{$tarjeta->presupuesto->porcent_financiam}}</td>
          <td>{{number_format($tarjeta->financiam,2)}}</td>
        </tr>
        <tr>
          <td>UTILIDAD</td>
          <td>{{$tarjeta->presupuesto->porcent_utilidad}}</td>
          <td>{{number_format($tarjeta->utilidad,2)}}</td>
        </tr>
        <tr>
          <td>CARGOS ADICIONALES</td>
          <td>{{$tarjeta->presupuesto->porcent_costos_add}}</td>
          <td>{{number_format($tarjeta->cargos_adicion,2)}}</td>
        </tr>
        <tr>
          <td></td>
          <th>PRECIO UNITARIO</th>
          <th>{{number_format($tarjeta->precio_unitario,2)}}</th>
        </tr>
      </tbody>
    </table>
  </div>
  </div>
  </div>
</section>

{{-- esta funcion no se importa desde resources/js/functions/ --}}
<script type="text/javascript" src="{{ asset('js/delete_elements.js') }}"></script>




@endsection