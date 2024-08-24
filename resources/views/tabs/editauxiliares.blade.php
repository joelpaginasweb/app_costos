@extends('layouts.aplication')
@section('title', 'Editar Auxiliares')
@section('content')

<section class="section ">
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
          {{-- <span>id={{$concepto->id}}</span> --}}

    <div class="container contain">
      <div class=" containerFlex " id="container_aux">

        @foreach ($conceptos as $concepto)
        <div class=" container contain_element ">
          {{-- <span class="form__label" >{{$concepto->id}}</span> --}}
          <a href="{{route('conceptoDelete', $concepto->id)}}" class="form__span" onclick="eliminar(this)">x</a>

          <label for="id_material" class="form__label">Id material</label>
          <input type="number" step="0" name="id_material[]" class="form__input" value="{{$concepto->id_material}}">
          <label for="cantidad_mater" class="form__label">cantidad material</label>
          <input type="number" step="0.0001" name="cantidad_mater[]" class="form__input"
            value="{{$concepto->cantidad}}">
        </div>
        @endforeach
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