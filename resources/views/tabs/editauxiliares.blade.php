@extends('layouts.aplication')
@section('title', 'Editar Auxiliares')
@section('content')

<section class="section ">
  <div>
    <h1> EDITAR TARJETAS DE COSTOS MATERIALES AUXILIARES</h1>
    {{-- <div> --}}
      <!----------- web components-------- -->
      {{-- <h3>-test web componentes-</h3> --}}
      {{-- <hola-mundo name="eba depru " surname="web componente nativo"></hola-mundo> --}}
      <!-- lit components -->
      {{-- <eit-box-info></eit-box-info> --}}
      {{-- <tabla-datos :conceptos='@json($conceptos)'></tabla-datos> --}}
      {{-- <eit-box-info message="prueba de Lit web component"></eit-box-info> --}}
      <!----------- web components-------- -->
    {{-- </div> --}}
  </div>  
</section>

<section class="section__form">  
    <h4>EDITAR MATERIAL AUXILIAR </h4>
</section>

<section class="section ">
  <!----------- ventana emergente  ---------------->
  <div class="emergente__contain  emergente__contain-display" id="emergente">
    <div class="emergente__header ">
      <h3 class="emergente__titulo">TARJETA AUXILIAR</h3>
      <div class="emergente__close">
        <a href="#">
          {{-- <h4 id="close" class="emergente__h4">cerrar</h4> --}}
          <h4 id="close"></h4>

          <!-- <img src="{{asset ('img/cruzblk.png') }}" alt="cruzblk" class="close__img" id="close"> -->
        </a>
      </div>
    </div>

    <form action="{{route('auxis.update', $auxi)}}" method="POST" class="form">
      @csrf
      @method('PUT')
      <div class="containDatosTarj">
        <div class="containConceptoTarj">
          <h4>CONCEPTO:</h4>       
          <textarea name="material_auxiliar" class=" form__textarea">{{$auxi->material}}</textarea>
        </div>
        <div class=" containDatos">
          <div class="columna50">
            <div class=" containDatos__datos ">
              <h4>CLAVE ID:</h4>
              <p>{{$auxi->id}}</p>
            </div>
          </div>
          <div class="columna50">
            <div class=" containDatos__datos">
              <h4>GRUPO:</h4>
              <p><input type="text" name="grupo" class="form__input" value="{{$auxi->grupo}}"></p>
            </div>
          </div>
          <div class="columna50">
            <div class=" containDatos__datos ">
              <h4>UNIDAD:</h4>
              
              <input type="text" name="unidad" class="form__input" value="{{$auxi->unidad}}">
            </div>
          </div>
        </div>
      </div>

      <div class="contain__tablaemergent">
        <table class="tabtarjetac">
          <thead class="">
            <tr>
              <th><input type="button" class="form__boton" id="boton_crear_Tr" value="Agregar Tr"></th>
              <th>CLAVE ID</th>
              <th>CONCEPTO</th>
              <th>UN.</th>
              <th>CANTIDAD</th>
              <th>PRECIO UN.</th>
              <th>IMPORTE</th>
            </tr>
          </thead>
          <tbody id="container_tr">
            @foreach ($conceptos as $concepto)
            <tr>
              <td> <a href="{{route('conceptoDelete', $concepto->id)}}" class="form__span"
                  >X</a> </td>
              <td><input type="number" step="0" name="id_material[]" class="form__input"
                  value="{{$concepto->id_material}}"></td>
              <td>{{$concepto->concepto}}</td>
              <td>{{$concepto->unidad}}</td>
              <td> <input type="number" step="0.0001" name="cantidad_mater[]" class="form__input"
                  value="{{$concepto->cantidad}}"></td>
              <td>{{$concepto->precio_unitario}}</td>
              <td>{{$concepto->importe}}</td>
            </tr>
            @endforeach
          </tbody>
    </form>
    <tbody>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>COSTO DIRECTO</td>
        <td>{{number_format($auxi->precio_unitario, 2)}}</td>
      </tr>
    </tbody>
    </table>
    <button type="submit" id="formBoton" class="form__boton">Editar Auxiliar</button>
  </div>
  </div>
</section>


{{-- esta funcion no se compila desde resources/js/functions/ --}}
<script type="text/javascript" src="{{ asset('js/delete_elements.js') }}"></script>

<script>
	const conceptos = @json($conceptos);
  //iterar en conceptos
  //const concepto = @json($concepto);
 // const unidades = conceptos.map(concepto => concepto.unidad).join(', ');
  //document.getElementById('concepto_unidad').textContent = unidades;
</script>

@endsection