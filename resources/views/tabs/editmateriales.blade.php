@extends('layouts.aplication')
@section('title', 'Editar Materiales')
@section('content')

<head>
  <link rel="stylesheet" href="{{ asset ('css/materiales.css') }}">
</head>

<section class="section section--up">
  <div>
    <h1>EDITAR MATERIALES</h1>
  </div>
</section>

<section class="section__form">
  <div class="form__titulo">
    <h4>EDITAR MATERIAL </h4>
  </div>


  <form action="{{route('materiales.update' ,$materiale)}}" method="POST" class="form">
    @csrf
    @method('PUT')

    <div class="contenedorFlex">
      <input type="text" name="grupo" class="form__input" value="{{$materiale->grupo}}">
      <textarea class="form__textarea" name="material">{{$materiale->material}}</textarea>
      <input type="text" name="unidad" class="form__input" value="{{$materiale->unidad}}">
      <input type="number" step="0.01" name="precio_unitario" class="form__input"
        value="{{$materiale->precio_unitario}}">
      <input type="text" name="proveedor" class="form__input" value="{{$materiale->proveedor}}">
      <button type="submit" class="form__boton">Actualizar</button>
    </div>
  </form>
  <div class="section ">
    @if ($errors->any())
    <div class="alert alert-danger">
      <strong>¡Error al editar material!</strong>
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

{{-- ---------------------- ------}}
<section class="section">
  <div class="x">
    <div class="middlexx">
      <h2>mostrar datos en forma de prueba</h2>
      <p> grupo: {{$materiale->grupo}} </p>
      <p> descripcion: {{$materiale->material}} </p>
      <p> unidad: {{$materiale->unidad}} </p>
      <p> precio unitario: {{$materiale->precio_unitario}} </p>
      <p> proveedor: {{$materiale->proveedor}} </p>
    </div>
  </div>
</section>
{{-- --------------------------- --}}

@endsection