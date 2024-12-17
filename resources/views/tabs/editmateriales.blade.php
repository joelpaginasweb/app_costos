@extends('layouts.aplication')
@section('title', 'Editar Materiales')
@section('content')

<section class="section section--title">
    <h3>EDITAR MATERIALES</h3>
</section>

<section class="section section--title">
  
  <div class="contenedorFlex">
     <div class="container">
      <p><strong>Material Actual</strong></p>
    </div>
    <div class="container">
      <p>Grupo: {{ $materiale->grupo->grupo}}</p>
    </div>
    <div class="container">
      <p> Material: {{$materiale->material}} </p>
    </div>
    <div class="container">
      <p>Unidad: {{ $materiale->unidad->unidad}}</p>
    </div>
    <div class="container">
      <p> precio unitario: {{$materiale->precio_unitario}} </p>
    </div>
    <div class="container">
      <p>Proveedor: {{ $materiale->proveedor->proveedor}}</p>
    </div>
  </div>
</section>

<section class="section__form">
  <div class="form__titulo">
    <h5>ACTUALIZAR DATOS DEL MATERIAL Numero de Id = {{$materiale->id}}</h5>
  </div>

  <form action="{{route('materiales.update' ,$materiale)}}" method="POST" class="form">
    @csrf
    @method('PUT')

    <div class="contenedorFlex">
      <div class="container">
        <label for="grupo" class="form__label">grupo</label>
        <input type="text" name="grupo" class="form__input" value="{{$materiale->grupo->grupo}}">
      </div>
      <div class="container">
        <label for="material" class="form__label">material</label>
        <textarea class="form__textarea" name="material">{{$materiale->material}}</textarea>
      </div>
      <div class="container">
        <label for="unidad" class="form__label">unidad</label>
        <input type="text" name="unidad" class="form__input" value="{{$materiale->unidad->unidad}}">
      </div>
      <div class="container">
          <label for="precio_unitario" class="form__label">precio unitario</label> 
        <input type="number" step="0.01" name="precio_unitario" class="form__input"
          value="{{$materiale->precio_unitario}}">
      </div>
      <div class="container">
        <label for="proveedor" class="form__label">proveedor</label>
        <input type="text" name="proveedor" class="form__input" value="{{$materiale->proveedor->proveedor}}">
      </div>
      <div class="container">
        <button type="submit" class="form__boton">Actualizar</button>
      </div>
    </div>

  </form>
  <div class="form__alert ">
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

@endsection