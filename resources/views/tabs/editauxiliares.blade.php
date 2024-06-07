@extends('layouts.aplication')
@section('title', 'Editar Auxiliares')
@section('content')

<head>
  <link rel="stylesheet" href="{{ asset ('css/auxiliares.css') }}">
</head>

<section class="section section--up">
  <div>
    <h1> EDITAR TARJETAS DE COSTOS MATERIALES AUXILIARES</h1>
  </div>
</section>

<section class="section__form"> <!-- estilo de form en estilobase.css -->
  <div class="form__titulo">
    <h4>EDITAR MATERIAL AUXILIAR </h4>
  </div>
{{-- eeeeeeeeee --}}
  <form action="{{route('auxis.update', $auxi)}}" method="POST" class="form">
    @csrf
    @method('PUT')

    <div class="contain">
      <div class="containerFlex ">
        <input type="text" name="grupo" class="form__input" value="{{$auxi->grupo}}">
        <textarea name="concepto" class=" form__textarea">{{$auxi->concepto}}</textarea>
        <input type="text" name="unidad" class="form__input" value="{{$auxi->unidad}}">

      </div>
    </div>
    <div class="container contain">
      <div class="containerFlex ">

        @foreach ($conceptos as $concepto)
        <div class="container ">
         <label for="id_registro" class="form__label">Id registro  {{$concepto->id}}</label>       
          <div class="container">

          <label for="id_material" class="form__label">Id material</label>
          <input type="number" step="0"  name="id_material[]"class="form__input" value="{{$concepto->id_material}}">
          <div class="container ">

          </div>
          <label for="cantidad_mater" class="form__label">cantidadmat</label>
          <input type="number" step="0.00001" name="cantidad_mater[]" class="form__input" value="{{$concepto->cantidad}}">
        </div>        
        @endforeach

      </div>

      <div class="container ">
        <div class="container ">
          <label for="formBoton" class="form__label"> Editar auxiliar </label>
          <button type="submit" id="formBoton" class="form__boton">Editar Auxiliar</button>
        </div>
      </div>
    </div>
  </form>
  {{-- eeeeeeeeeee --}}

  <div class=" section ">
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
@endsection