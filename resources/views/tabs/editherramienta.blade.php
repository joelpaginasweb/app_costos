@extends('layouts.aplication')
@section('title', 'Editar Herr. y Eq.')
@section('content')

<head>
  <link rel="stylesheet" href="{{ asset ('css/herramienta.css') }}">
</head>

<section class="section section--up">
  <div>
    <h1>EDITAR MAQUINARIA HERRAMIENTA Y EQUIPO</h1>
  </div>
</section>

<section class=section__form>
  <div class="form__titulo">
    <h4>EDITAR HERRAMIENTA Y EQUIPO </h4>
  </div>
  <form action="{{route('herramientas.update' ,$herramienta)}}" method="POST" class="form">
    @csrf
    @method('PUT')
    <div class="contenedorFlex">
      <input type="text" name="grupo" class="form__input" value="{{$herramienta->grupo}}">
      <textarea class="form__textarea" name="equipo">{{$herramienta->equipo}}</textarea>
      <input type="text" name="modelo" class="form__input" value="{{$herramienta->modelo}}">
      <input type="text" name="marca" class="form__input" value="{{$herramienta->marca}}">
    </div>
    <div class="contenedorFlex">
      <input type="text" name="proveedor" class="form__input" value="{{$herramienta->proveedor}}">
      <input type="text" name="unidad" class="form__input" value="{{$herramienta->unidad}}">
      <input type="number" step="0.01" name="precio_unitario" class="form__input" value="{{$herramienta->precio_unitario}}">
      <button type="submit" class="form__boton">Actualizar</button>
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