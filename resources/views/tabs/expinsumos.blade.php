@extends('layouts.aplication')
@section('title', 'exploinsumos')
@section('content')

<section class="section section--title">
  <h3>EXPLOSION DE INSUMOS</h3>
</section>
<section class="section__form ">
  <div class="form__titulo">
    <h5>SELECCIONAR PRESUPUESTO</h5>
  </div>
  <div class="contain">
    <form method="GET" action="{{route('expinsumos.index') }}" class="form">
      {{-- @csrf --}}
      <div class="modal__contain contain">
        <div class="contain">
          <label for="presup" class="modal__label">Id de Presupuesto:</label>
          <input type="number" id="presup" name="presup" class="modal__input" value="{{ request()->input('id_presu') }}"
            required>
        </div>
        <div class="contain">
          <button type="submit" class="modal__boton">Generar</button>
        </div>
      </div>
    </form>
  </div>

  <div class="form__alert">
    @if (Session::get('success'))
    <div class="alert alert--success ">
      <strong>{{Session::get('success')}} <br>
    </div>
    @endif
  </div>

  <div class=" form__alert ">
    @if ($errors->any())
    <div class="alert alert-danger ">
      <strong>¡Error al crear material!</strong>
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
      <h5>EXPLOSION DE INSUMOS DEL PRESUPUESTO Id = {{$idPresup}}</h5>
    </div>
  </div>

  <div class="tablaBase__container">
    <table class="tablaBase tablaExpinsumos" id="tabla_base">
      <thead>
        <tr class="tabla__titulos">
          <th>ID INSUMO</th>
          <th>TIPO</th>
          <th>INSUMO</th>
          <th>UNID</th>
          <th>CANTIDAD</th>
          <th>PRECIO UNIT.</th>
          <th>MONTO</th>
          <th>FECHA</th>
        </tr>
      </thead>

      <tbody class="tablaBase__tbody">
        @forelse ($materiales as $material )
        <tr class="">
          <td>{{$material->material->id}}</td>
          <td>{{$material->grupo->grupo}}</td>
          <td>{{$material->material->material}}</td>
          <td>{{$material->material->unidad->unidad}}</td>
          <td>{{number_format($material->cantidad, 2)}}</td>
          <td>{{number_format($material->material->precio_unitario, 2)}}</td>
          <td>{{number_format($material->monto, 2)}}</td>
          <td>{{$material->updated_at}}</td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="text-center">No hay registros disponibles</td>
        </tr>
        @endforelse
        @foreach ($categorias as $categoria )
        <tr class="">
          <td>{{$categoria->categoria->id}}</td>
          <td>{{$categoria->grupo->grupo}}</td>
          <td>{{$categoria->categoria->categoria}}</td>
          <td>{{$categoria->categoria->unidad->unidad}}</td>
          <td>{{number_format($categoria->cantidad, 2)}}</td>
          <td>{{number_format($categoria->categoria->salario_real, 2)}}</td>
          <td>{{number_format($categoria->monto, 2)}}</td>
          <td>{{$categoria->updated_at}}</td>
        </tr>
        @endforeach
        @foreach ($equipos as $equipo )
        <tr class="">
          <td>{{$equipo->equipo->id}}</td>
          <td>{{$equipo->grupo->grupo}}</td>
          <td>{{$equipo->equipo->herramienta_equipo}}</td>
          <td>{{$equipo->equipo->unidad->unidad}}</td>
          <td>{{number_format($equipo->cantidad, 2)}}</td>
          <td>{{number_format($equipo->equipo->precio_unitario, 2)}}</td>
          <td>{{number_format($equipo->monto, 2)}}</td>
          <td>{{$equipo->updated_at}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>


@endsection