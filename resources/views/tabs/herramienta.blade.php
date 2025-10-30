@extends('layouts.aplication')
@section('title', 'Herramienta y Eq')
@section('content')

<section class="section section--title">
    <h3>HERRAMIENTA MAQUINARIA Y EQUIPO</h3>
</section>

<section class="section__form">
  <div class="form__titulo display_action pointer">
    <h5>CREAR NUEVA HERRAMIENTA O EQUIPO</h5>
  </div>
  <div class="form__content element_display ">
    <form action="{{route('herramientas.store')}}" method="POST" class="form">
      @csrf
      <div class="contenedorFlex">
        <input type="text" name="grupo" class="form__input" placeholder="grupo">
        <textarea class="form__textarea" name="herr_equipo"
          placeholder="ingresar descripcion de la herramienta o equipo"></textarea>
        <input type="text" name="marca" placeholder="marca" class="form__input">
        <input type="text" name="proveedor" placeholder="proveedor" class="form__input">
        <input type="text" name="unidad" placeholder="unidad" class="form__input">
        <input type="number" step="0.01" name="precio_unitario" placeholder="precio unitario" class="form__input">
        <button type="submit" class="form__boton">Crear</button>
      </div>
    </form>
    
  </div>
</section>

<section>
  <div class="form__alert">
    @if (Session::get('success'))
    <div class="alert alert--success ">
      <strong>{{Session::get('success')}} <br>
    </div>
    @endif
  </div>
  <div class="form__alert">
    @if ($errors->any())
    <div class="alert alert-danger mt-3">
      <strong>¡Error al crear Herramienta o Equipo!</strong>
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
      <h5>LISTADO DE HERRAMIENTAS MAQUINARIA Y EQUIPO</h5>
    </div>
  </div>
  <div class="tablaBase__container">
    <table class="tablaBase tablaHerram" id="tabla_base">
      <thead>
        <tr class="tabla__titulos">
          <th>ID</th>
          <th>GRUPO</th>
          <th>DESCRIPCION DE HERR. O EQUIPO</th>
          <th>MARCA</th>
          <th>PROVEEDOR</th>
          <th>UNIDAD</th>
          <th>PRECIO UN</th>
          <th>FECHA</th>
          <th>ACCION</th>
        </tr>
      </thead>
      <tbody class="tablaBase__tbody">
        @foreach ($herramientas as $herramienta )
        <tr class="">
          <td>{{$herramienta->id}}</td>
          <td>{{$herramienta->grupo->grupo}}</td>
          <td>{{$herramienta->herramienta_equipo}}</td>
          <td>{{$herramienta->marca->marca}}</td>
          <td>{{$herramienta->proveedor->proveedor}}</td>
          <td>{{$herramienta->unidad->unidad}}</td>
          <td>{{$herramienta->precio_unitario}}</td>
          <td>{{$herramienta->updated_at}}</td>
          <td>
            <div class="contain">
              <div class="contain">
                <a href="{{route('herramientas.edit', $herramienta->id)}}" class="tablaBase__boton">Ed</a>
              </div>
               <div class="contain">
                <a href="{{route('herramientasCopy', $herramienta->id)}}" class="tablaBase__boton">Cop</a>
              </div>

              <div class="contain">
                <form action="{{route('herramientas.destroy', $herramienta)}}" method="POST" class="">
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