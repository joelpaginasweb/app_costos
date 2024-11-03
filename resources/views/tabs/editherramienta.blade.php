@extends('layouts.aplication')
@section('title', 'Editar Herr. y Eq.')
@section('content')

<section class="section section--up">
  <div>
    <h1>EDITAR HERRAMIENTA / EQUIPO</h1>
  </div>
</section>

<section class="section">
  <h4>Herramienta/Equipo Actual</h4>
  <div class="contenedorFlex">
    <div class="container">
      <p>Grupo: {{ $herramienta->grupo->grupo}}</p>
    </div>
    <div class="container">
      <p> Material: {{$herramienta->herramienta_equipo}} </p>
    </div>
    <div class="container">
      <p>Unidad: {{ $herramienta->unidad->unidad}}</p>
    </div>
    <div class="container">
      <p> precio unitario: {{$herramienta->precio_unitario}} </p>
    </div>
    <div class="container">
      <p>Proveedor: {{ $herramienta->proveedor->proveedor}}</p>
    </div>
  </div>
</section>

<section class=section__form>
  <div class="form__titulo">
    <h3>Actualizar datos de la herramienta o equipo Id {{$herramienta->id}}</h3>
  </div>
  <form action="{{route('herramientas.update' ,$herramienta)}}" method="POST" class="form">
    @csrf
    @method('PUT')
    <div class="contenedorFlex">

      <div class="container">
        <input type="text" name="grupo" class="form__input" value="{{$herramienta->grupo->grupo}}">
      </div>
      <div class="container">
        <textarea class="form__textarea" name="herr_equipo">{{$herramienta->herramienta_equipo}}</textarea>
      </div>
      <div class="container">
        <input type="text" name="marca" class="form__input" value="{{$herramienta->marca->marca}}">
      </div>
      <div class="container">
        <input type="text" name="proveedor" class="form__input" value="{{$herramienta->proveedor->proveedor}}">
      </div>
      <div class="container">
        <input type="text" name="unidad" class="form__input" value="{{$herramienta->unidad->unidad}}">
      </div>
      <div class="container">
        <input type="number" step="0.01" name="precio_unitario" class="form__input"
          value="{{$herramienta->precio_unitario}}">
      </div>
      <div class="container">
        <button type="submit" class="form__boton">Actualizar</button>
      </div>
    </div>

  </form>
  <div class="section">
    @if ($errors->any())
    <div class="alert alert-danger mt-3">
      <strong>¡Error al editar equipo!</strong>
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
@endsection