@extends('layouts.aplication')
@section('title', 'Editar Mano de obra')
@section('content')

<section class="section section--title">
    <h3>EDITAR CATEGORIAS DE MANO DE OBRA</h3>
</section>

<section class="section__form">
  <div class="form__titulo">
    <h5>ACTUALIZAR DATOS DE LA CATEGORIA DE M.O. con Numero de Id = {{$manodeobra->id}} </h5>
  </div>

  <div class="form__content">  
    <div class=" container contenedorFlex">
      <div class="container">
        <p>Grupo: {{ $manodeobra->grupoData->grupo}}</p>
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
  </div>  

    <div class="form__content"> 

    <form action="{{route('manodeobra.update' ,$manodeobra)}}" method="POST" class="form">
      @csrf
      @method('PUT')
      <div class="contenedorFlex">
        <div class="container">
          <label for="grupo" class="form__label">grupo</label>
          <input type="text" name="grupo" class="form__input" value="{{$manodeobra->grupoData->grupo}}">
        </div>
        <div class="container">
        <label for="categoria" class="form__label">categoria</label>
          <input type="text" name="categoria" class="form__input" value="{{$manodeobra->categoria}}">
        </div>
        <div class="container">
          <label for="unidad" class="form__label">unidad</label>
          <input type="text" name="unidad" class="form__input" value="{{$manodeobra->unidad->unidad}}">
        </div>
        <div class="container">
          <label for="salario_base" class="form__label">salario_base</label>
          <input type="number" step="0.01" name="salario_base" class="form__input" value="{{$manodeobra->salario_base}}">
        </div>
        <div class="container">
          <label for="factor_sr" class="form__label">factor_S.R.</label>
          <input type="number" step="0.01" name="factor_sr" class="form__input" value="{{$manodeobra->factor_sr}}">
        </div>
        <div class="container">
          <button type="submit" class="form__boton">Actualizar</button>
        </div>
      </div>
    </form>
    <div class="form__alert">
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
  </div>  



</section>
@endsection