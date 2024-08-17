@extends('layouts.aplication')
@section('title', 'Editar Auxiliares')
@section('content')

{{--

<head>
  <link rel="stylesheet" href="{{ asset ('css/auxiliares.css') }}">
</head> --}}

<section class="section section--up">
  <div>
    <h1> EDITAR TARJETAS DE COSTOS MATERIALES AUXILIARES</h1>
  </div>
</section>

<section class="section__form"> <!-- estilo de form en estilobase.css -->
  <div class="form__titulo">
    <h4>EDITAR MATERIAL AUXILIAR </h4>
  </div>

  <form action="{{route('auxis.update', $auxi)}}" method="POST" class="form">
    @csrf
    @method('PUT')

    <!-- ----------- -->
    <div class="contain">
      <div class="containerFlex ">
        <input type="text" name="grupo" class="form__input" value="{{$auxi->grupo}}">
        <textarea name="material_auxiliar" class=" form__textarea">{{$auxi->material}}</textarea>
        <input type="text" name="unidad" class="form__input" value="{{$auxi->unidad}}">
        <input type="button" class="form__boton" id="boton_crear_aux" value="Agregar Material">
      </div>
    </div>
    <!-- --------- -->

    <div class="container contain">


      <div class=" containerFlex " id="container_aux">
        <div class=" container contain_element ">
          <div class="">
            @foreach ($conceptos as $concepto)
            <span class="form__span" onclick="eliminar(this)">x</span>
            <label for="id_registro" class="form__label">Id registro {{$concepto->id}}</label>
            <label for="id_material" class="form__label">Id material</label>
            <input type="number" step="0" name="id_material[]" class="form__input" value="{{$concepto->id_material}}">
            <label for="cantidad_mater" class="form__label">cantidadmat</label>
            <input type="number" step="0.0001" name="cantidad_mater[]" class="form__input"
              value="{{$concepto->cantidad}}">
            <br>
            @endforeach
          </div>
        </div>
      </div>
      <div class="container contain">
        <div class="container contain">
          <label for="formBoton" class="form__label"> Calcular Importe y Editar auxiliar </label>
          <button type="submit" id="formBoton" class="form__boton">Editar Auxiliar</button>
        </div>
      </div>

    </div>

  </form>

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

{{-- esta funcion no se compila desde resources/js/functions/ --}}
<script type="text/javascript" src="{{ asset('js/delete_elements.js') }}"></script>
@endsection