@extends('layouts.aplication')
@section('title', 'Editar Herr. y Eq.')
@section('content')

<section class="section section--title">
    <h3>EDITAR HERRAMIENTA / EQUIPO</h3>
</section>


<section class=section__form>
  <div class="form__titulo">
    <h5> ACTUALIZAR DATOS DE LA HERRAMIENTA O EQUIPO con Numero de  Id = {{$herramienta->id}}</h5>
    <!-- <h5> ACTUALIZAR DATOS DE LA HERRAMIENTA O EQUIPO Numero de  Id = {{$herramienta->id}}</h5> -->
  </div>
  <div class="form__content">

    <div class="container contenedorFlex">
      <div class="container">
        <p>Grupo: {{ $herramienta->grupo->grupo}}</p>
      </div>
      <div class="container">
        <p> Descripcion: {{$herramienta->herramienta_equipo}} </p>
      </div>
      <div class="container">
        <p>Marca: {{ $herramienta->marca->marca}}</p>
      </div>
      <div class="container">
        <p>Proveedor: {{ $herramienta->proveedor->proveedor}}</p>
      </div>
      <div class="container">
        <p>Unidad: {{ $herramienta->unidad->unidad}}</p>
      </div>
      <div class="container">
        <p> precio unitario: {{$herramienta->precio_unitario}} </p>
      </div>
    </div>
  </div>

  <div class="form__content">
    <form action="{{route('herramientas.update' ,$herramienta)}}" method="POST" class="form">
      @csrf
      @method('PUT')
      <div class="contenedorFlex">
        <div class="container">
          <label for="grupo" class="form__label">grupo</label>
          <input type="text" name="grupo" class="form__input" value="{{$herramienta->grupo->grupo}}">
        </div>
        <div class="container">
          <label for="herr_equipo" class="form__label">descripcion</label>
          <textarea class="form__textarea" name="herr_equipo">{{$herramienta->herramienta_equipo}}</textarea>
        </div>
        <div class="container">
          <label for="marca" class="form__label">marca</label>
          <input type="text" name="marca" class="form__input" value="{{$herramienta->marca->marca}}">
        </div>
        <div class="container">
          <label for="proveedor" class="form__label">proveedor</label>
          <input type="text" name="proveedor" class="form__input" value="{{$herramienta->proveedor->proveedor}}">
        </div>
        <div class="container">
          <label for="unidad" class="form__label">unidad</label>          
          <input type="text" name="unidad" class="form__input" value="{{$herramienta->unidad->unidad}}">
        </div>
        <div class="container">
          <label for="precio_unitario" class="form__label">precio_unitario</label> 
          <input type="number" step="0.01" name="precio_unitario" class="form__input"
            value="{{$herramienta->precio_unitario}}">
        </div>
        <div class="container">
          <button type="submit" class="form__boton">Actualizar</button>
        </div>
      </div>

    </form>
    <div class="form__alert">
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
  </div>

</section>
@endsection