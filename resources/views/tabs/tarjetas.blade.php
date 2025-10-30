@extends('layouts.aplication')
@section('title', 'Tarjetas')


@section('content')



<section class="section section--title">
  <h3> TARJETAS DE COSTOS DE PRECIO UNITARIO </h3>
</section>

<section class="section__form">
  <div class="form__titulo display_action pointer">
    <h5>CREAR NUEVA TARJETA DE COSTOS</h5>
  </div>
  <div class="form__content element_display">

    <form action="{{route('tarjetas.store')}}" method="POST" class="form">
      @csrf
      <div class=" contain">
        <div class=" ">
          <input type="text" name="grupo" class="form__input" placeholder="partida">
          <textarea name="concepto" class=" form__textarea"
            placeholder="concepto nueva tarjeta de precio unitario"></textarea>
          <input type="text" name="unidad" class="form__input" placeholder="unidad">
          <input type="number" step="0" name="id_presupuesto" class="form__input" placeholder="id Presupuesto">
        </div>
      </div>
      <div class="container contain">
        <div class=" ">
          <div class=" contain ">
            <h5>MATERIALES</h5>
            <input type="button" class="form__boton" id="boton_crear_mat" value="+ Fila Mat">
          </div>
          <hr>
          {{------------------------}}
          <div class="" id="container_mater">
            <div class="container">
              {{-- --}}
              {{-- <span class="form__span" onclick="eliminar(this)">x</span> --}}

              <label for="select" class="form__label">Tipo</label>
              <select name="tipo_material[]">
                <option value="material" selected>material</option>
                <option value="auxiliar">auxiliar</option>
              </select>
              <label for="id_material" class="form__label">Id material</label>
              <input type="number" step="0" name="id_material[]" class="form__input" placeholder="id material">
              <label for="cantidad_mater" class="form__label">cantidad material</label>
              <input type="number" step="0.00001" name="cantidad_mater[]" class="form__input"
                placeholder="cantidad material">
            </div>
          </div>
          {{------------------------}}
          <br>
          <div class="contain">
            <h5>MANO DE OBRA</h5>
            <input type="button" class="form__boton" id="boton_crear_mo" value="+ Fila MO">
          </div>
          <hr>
          {{------------------------}}
          <div class="" id="container_mo">
            <div class="container ">
              {{-- <span class="form__span" onclick="eliminar(this)">x</span> --}}
              <label for="select" class="form__label">Tipo</label>
              <select name="tipo_mano_obra[]">
                <option value="categoria" selected>categoria</option>
                <option value="cuadrilla">cuadrilla</option>
              </select>
              <label for="id_mano_obra" class="form__label">Id mano de obra</label>
              <input type="number" step="0" name="id_mano_obra[]" class="form__input" placeholder="Id mano de obra">
              <label for="cant_mano_obra" class="form__label">cantidad M.O.</label>
              <input type="number" step="0.00001" name="cant_mano_obra[]" class="form__input" placeholder="cantidad MO">
            </div>
          </div>
          {{-- ---------------- --}}
          <br>
          <div class="contain">
            <h5>HERRAMIENTA Y EQUIPO</h5>
            <input type="button" class="form__boton" id="boton_crear_equipo" value="+ Fila H y E">
          </div>
          <hr>
          {{-- ---------------- --}}
          <div class="" id="container_equipo">
            <div class="container ">
              {{-- <span class="form__span" onclick="eliminar(this)">x</span> --}}
              <label for="id_equipo" class="form__label">Id equipo</label>
              <input type="number" step="0" name="id_equipo[]" class="form__input" placeholder="Id equipo">
              <label for="cant_equipo" class="form__label">cantidad equipo</label>
              <input type="number" step="0.00001" name="cant_equipo[]" class="form__input"
                placeholder="cantidad equipo">
            </div>
          </div>
          {{-- ---------------- --}}
          <div class="container ">
            <label for="formBoton" class="form__label"> Calcular y crear Tarjeta</label>
            <button type="submit" id="formBoton" class="form__boton">Crear Tarjeta</button>
          </div>
        </div>

      </div>
    </form>
  </div>
</section>
<section>
  <div class=" form__alert ">
    @if (Session::get('success'))
    <div class="alert alert--success ">
      <strong>{{Session::get('success')}} <br>
    </div>
    @endif
  </div>
  <div class=" form__alert ">
    @if ($errors->any())
    <div class="alert alert-danger ">
      <strong>¡Error al crear tarjeta de costos!</strong>
      <p>Los siguientes datos son necesarios: </p>
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
  </div>
</section>

<section class="section__tablaBase section--down">
  <div class="tablaBase__contain">
    <div class="tablaBase__title">
      <h5>LISTADO DE TARJETAS DE COSTOS</h5>
    </div>
  </div>

  <div class="tablaBase__container">
    <table class="tablaBase tablaTarjeta " id="tabla_base">
      <thead>
        <tr class="">
          <th>ID</th>
          <th>PARTIDA</th>
          <th>CONCEPTO</th>
          <th>UNI</th>
          <th>COSTO MAT</th>
          <th>COSTO MA</th>
          <th>COSTO EQ</th>
          <th>COSTO DIR</th>
          <th>COSTO IND</th>
          <th>PRECIO UN</th>
          <th>PRES</th>
          <th>ACCION</th>
        </tr>
      </thead>
      <tbody class="tablaBase__tbody">
        @foreach ($tarjetas as $tarjeta)
        <tr class="pointer" id="open">
          <td>{{$tarjeta->id}}</td>
          <td>{{$tarjeta->grupo->grupo}}</td>
          <td>{{$tarjeta->concepto}}</td>
          <td>{{$tarjeta->unidad->unidad}}</td>
          <td>
            {{number_format($tarjeta->costo_material, 2)}}
          </td>
          <td>
            {{number_format($tarjeta->costo_mano_obra, 2)}}
          </td>
          <td>
            {{number_format($tarjeta->costo_equipo, 2)}}
          </td>
          <td>
            {{number_format($tarjeta->costo_directo, 2)}}
          </td>
          <td>
            {{number_format($tarjeta->costo_indirecto, 2)}}
          </td>
          <td>
            {{number_format($tarjeta->precio_unitario, 2)}}
          </td>
          <td>{{$tarjeta->id_presup}}</td>
          <td>
            <div class="contain">
              <div class="contain">
                <a href=" {{route('tarjetas.edit', $tarjeta->id)}} " class="tablaBase__boton">Ed</a>
              </div>
              <div class="contain">
                <a href="{{route('tarjetasCopy', $tarjeta->id)}}" class="tablaBase__boton">Cop</a>
              </div>
              <div class="contain">
                <form action=" {{route('tarjetas.destroy', $tarjeta)}} " method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="tablaBase__boton">X</button>
                </form>
              </div>
            </div>
          </td>

        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</section>



{{-- esta funcion no se compila desde resources/js/functions/ --}}
<script type="text/javascript" src="{{ asset('js/delete_elements.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>



@endsection