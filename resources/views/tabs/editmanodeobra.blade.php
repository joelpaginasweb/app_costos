@extends('layouts.aplication')
@section('title', 'Editar Mano de obra')
@section('content')

{{--

<head>
  <link rel="stylesheet" href="{{ asset ('css/manodeo.css') }}">
</head> --}}

<section class="section section--up">
  <div>
    <h1>EDITAR CATEGORIAS DE MANO DE OBRA</h1>
  </div>
</section>
<section class="section">
  <h4>Categoria de Mano de Obra Actual</h4>
  <div class="contenedorFlex">
    <div class="container">
      <p>Grupo: {{ $manodeobra->grupox->grupo}}</p>
    </div>
    <div class="container">
      <p>Categoria: {{$manodeobra->categoria}}</p>
    </div>
    <div class="container">
      <p>Unidad: {{$manodeobra->unidad->unidad}}</p>
    </div>
    <div class="container">
      <p>Salario Base: {{$manodeobra->salario_base}}</p>
    </div>
    <div class="container">
      <p>Factor Salario Real: {{$manodeobra->factor_sr}}</p>
    </div>
  </div>
</section>



<section class="section__form">
  <div class="form__titulo">
    <h4>Actualizas datos de Categoria Id {{$manodeobra->id}} </h4>
  </div>
  <form action="{{route('manodeobra.update' ,$manodeobra)}}" method="POST" class="form">
    @csrf
    @method('PUT')
    <div class="contenedorFlex">
      <div class="container">
        <input type="text" name="grupo" class="form__input" value="{{$manodeobra->grupox->grupo}}">
      </div>
      <div class="container">
        <input type="text" name="categoria" class="form__input" value="{{$manodeobra->categoria}}">
      </div>
      <div class="container">
        <input type="text" name="unidad" class="form__input" value="{{$manodeobra->unidad->unidad}}">
      </div>
      <div class="container">
        <input type="number" step="0.01" name="salario_base" class="form__input" value="{{$manodeobra->salario_base}}">
      </div>
      <div class="container">
        <input type="number" step="0.01" name="factor_sr" class="form__input" value="{{$manodeobra->factor_sr}}">
      </div>
      <div class="container">
        <button type="submit" class="form__boton">Actualizar</button>
      </div>
    </div>
  </form>
  <div class="section">
    @if ($errors->any())
    <div class="alert alert-danger">
      <strong>¡Error al editar categoria de Mano de Obra!</strong>
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