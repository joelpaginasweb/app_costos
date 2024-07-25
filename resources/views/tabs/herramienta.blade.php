@extends('layouts.aplication')

@section('title', 'Herramienta y Eq')

@section('content')



<section class="section section--up">
  <div>
    <h1>HERRAMIENTA EQUIPO Y MAQUINARIA</h1>
    <h4>APLICACION EN CONSTRUCCION</h4>
  </div>
</section>

<section class="section__form">
  <div class="form__titulo">
    <h4>CREAR NUEVA HERRAMIENTA EQUIPO O MAQUINARIA</h4>
  </div>
  <form action="{{route('herramientas.store')}}" method="POST" class="form">
    @csrf
    <div class="contenedorFlex">
      <input type="text" name="grupo" class="form__input" placeholder="grupo">
      <textarea class="form__textarea" name="equipo"
        placeholder="descripcion de la  herramienta, maquinaria o equipo"></textarea>
      <input type="text" name="modelo" placeholder="modelo" class="form__input">
      <input type="text" name="marca" placeholder="marca" class="form__input">
    </div>
    <div class="contenedorFlex">
      <input type="text" name="proveedor" placeholder="proveedor" class="form__input">
      <input type="text" name="unidad" placeholder="unidad" class="form__input">
      <input type="number" name="precio_unitario" placeholder="precio unitario" step="0.01" class="form__input">
      <button type="submit" class="form__boton">Crear</button>
    </div>
  </form>
  <div class="section">
    @if (Session::get('success'))
    <div class="alert alert--success ">
      <strong>{{Session::get('success')}} <br>
    </div>
    @endif
  </div>
  <div class="section">
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



<section class="sectionTabla">
  <div class="tabla__nombre">
    <div class="nombre">
      <h5>LISTADO DE HERRAMIENTAS EQUIPOS Y MAQUINARIA</h5>
    </div>
  </div>
  <div class="containerTabla">
    <table class="tabla">
      <tbody>
        <tr class="tabla__titulos">
          <td>CLAVE ID</td>
          <td>GRUPO</td>
          <td>NOMBRE DE EQUIPO</td>
          <td>MODELO</td>
          <td>MARCA</td>
          <td>PROVEEDOR</td>
          <td>UNIDAD</td>
          <td>PRECIO UN</td>
          <td>FECHA</td>
          <td>ACCION</td>
        </tr>
        @foreach ($herramientas as $herramienta )
        <tr onclick="abrir()" class="tabla__body">
          <td>{{$herramienta->id}}</td>
          <td>{{$herramienta->grupo}}</td>
          <td>{{$herramienta->equipo}}</td>
          <td>{{$herramienta->modelo}}</td>
          <td>{{$herramienta->marca}}</td>
          <td>{{$herramienta->proveedor}}</td>
          <td>{{$herramienta->unidad}}</td>
          <td>{{$herramienta->precio_unitario}}</td>
          <td>{{$herramienta->updated_at}}</td>
          <td>
            <div class="contain">
              <div class="contain">
                <a href="{{route('herramientas.edit', $herramienta->id)}}" class="tabla__boton">Ed</a>
              </div>
              <div class="contain">
                <form action="{{route('herramientas.destroy', $herramienta)}}" method="POST" class="">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="tabla__boton">X</button>
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
@endsection