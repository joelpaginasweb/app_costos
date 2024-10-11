@extends('layouts.aplication')
@section('title', 'Editar Auxiliares')
@section('content')

{{-- <section class="section "> --}}
  {{-- <div> --}}
    {{-- <h1> EDITAR TARJETAS DE COSTOS MATERIALES AUXILIARES</h1> --}}
    {{-- <div> --}}
      <!----------- web components-------- -->
      {{-- <h3>-test web componentes-</h3> --}}
      {{-- <hola-mundo name="eba depru " surname="web componente nativo"></hola-mundo> --}}
      <!-- lit components -->
      {{-- <eit-box-info></eit-box-info> --}}
      {{-- <tabla-datos :conceptos='@json($conceptos)'></tabla-datos> --}}
      {{-- <eit-box-info message="prueba de Lit web component"></eit-box-info> --}}
      <!----------- web components-------- -->
      {{--
    </div> --}}
  {{-- </div> --}}
{{-- </section> --}}

{{-- <section class="section__form"> --}}
  {{-- <h4>EDITAR MATERIAL AUXILIAR </h4> --}}
{{-- </section> --}}

  <!----------- ventana emergente  ---------------->
<section class="section ">
  <div class="emergente__contain  emergente__contain-display" id="emergente">
    <div class="emergente__header ">
      <h3 class="emergente__titulo">TARJETA AUXILIAR</h3>
      <div class="emergente__close">
        <a href="#">
          <h4 id="close" class="emergente__h4">cerrar</h4>
          {{-- <img src="{{asset ('img/cruzblk.png') }}" alt="cruzblk" class="close__img" id="close"> --}}
        </a>
      </div>
    </div>

    <form action="{{route('auxis.update', $auxi)}}" method="POST" class="form">
      @csrf
      @method('PUT')

      <div class="datosEmer">

        <div class="datosEmer__contain border-bottom">
          <h4>CONCEPTO:</h4>
          <textarea name="material_auxiliar" class="form__input form__input--area  pointer">{{$auxi->material}}</textarea>
        </div>

        <div class="datosEmer__contain">
          <div class="columna33">
            <div class="datosEmer__dato">              
              <h4>CLAVE ID:</h4>                
                <p>{{$auxi->id}}</p>                
            </div>
          </div>
          <div class="columna50">
            <div class=" datosEmer__dato">
              <h4>GRUPO:</h4>
              <input type="text" name="grupo" class="form__input select_auto pointer" value="{{$auxi->grupo}}">
            </div>
          </div>
          <div class="columna50">
            <div class=" datosEmer__dato ">
              <h4>UNIDAD:</h4>
              <input type="text" name="unidad" class="form__input select_auto pointer" value="{{$auxi->unidad}}">
            </div>
          </div>
        </div>
      </div>

      <div class="contain__tablemergent">
        <table class="tablaEmergent">
          <thead class="tablaEmergent__thead">
            <tr>
              <th><input type="button" class="form__boton form__boton--short" id="boton_crear_tr" value="+ Fila"></th>
              <th>CLAVE ID</th>
              <th>CONCEPTO</th>
              <th>UNIDAD</th>
              <th>CANTIDAD</th>
              <th>PRECIO UN.</th>
              <th>IMPORTE</th>
            </tr>
          </thead>
          <tbody id="crea_element">
            @foreach ($conceptos as $concepto)
            <tr>
              <td> <a href="{{route('conceptoDelete', $concepto->id)}}" class="form__span">X</a> </td>
              <td><input type="number" step="0" name="id_material[]" class="form__input  form__input--short select_auto pointer"
                  value="{{$concepto->id_material}}"></td>
              <td>{{$concepto->concepto}}</td>
              <td>{{$concepto->unidad}}</td>
              <td> <input type="number" step="0.0001" name="cantidad_mater[]" class="form__input form__input--short pointer select_auto "
                  value="{{$concepto->cantidad}}"></td>
              <td>{{$concepto->precio_unitario}}</td>
              <td> {{number_format($concepto->importe, 2)}}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>C. DIRECTO</td>
              <td>{{number_format($auxi->precio_unitario, 2)}}</td>
            </tr>
          </tfoot>
        </table>
        <div class="tablaEmergent__divFooter">
          <button type="submit" id="formBoton" class="form__boton">Editar Auxiliar</button>    
        </div>
      </div>
    </form>
  </div>
</section>

{{-- esta funcion no se importa desde resources/js/functions/ --}}
<script type="text/javascript" src="{{ asset('js/delete_elements.js') }}"></script>


  

@endsection