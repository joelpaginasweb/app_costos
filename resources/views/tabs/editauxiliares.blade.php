@extends('layouts.aplication')
@section('title', 'Editar Auxiliares')
@section('content')
<!----------- ventana emergente  ---------------->
<section>
  <div class=" form__alert ">
    @if (Session::get('success'))
    <div class="alert alert--success ">
      <strong>{{Session::get('success')}} <br>
    </div>
    @endif
  </div>
  {{-- <div class=" form__alert ">
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
  </div> --}}
</section>

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
          <textarea name="material_auxiliar"
            class="form__input form__input--area  pointer">{{$auxi->material}}</textarea>
        </div>
        <div class="datosEmer__contain">
          <div class="columna33">
            <div class="datosEmer__dato">
              <h4>ID AUXILIAR:</h4>
              <p>{{$auxi->id}}</p>
            </div>
          </div>
          <div class="columna50">
            <div class=" datosEmer__dato">
              <h4>GRUPO:</h4>
              {{----------- programar edicion------- --}}
              <input type="text" name="grupo" class="form__input select_auto pointer" value="{{$auxi->grupo->grupo}}">
            </div>
          </div>
          <div class="columna50">
            <div class=" datosEmer__dato ">
              <h4>UNIDAD:</h4>
              {{------------ programar edicion-------- --}}
              <input type="text" name="unidad" class="form__input select_auto pointer"
                value="{{$auxi->unidad->unidad}}">
            </div>
          </div>
        </div>
      </div>
      <div class="contain__tablemergent">
        <table class="tablaEmergent">
          <thead class="tablaEmergent__thead">
            <tr>
              <th><input type="button" class="form__boton form__boton--short" id="boton_crear_tr" value="+ Fila"></th>
              <th>ID MAT.</th>
              <th>MATERIAL</th>
              <th>UNIDAD</th>
              <th>CANTIDAD</th>
              <th>PRECIO UN.</th>
              <th>IMPORTE</th>
            </tr>
          </thead>
          <tbody id="crea_element">
            @foreach ($conceptos as $concepto)
            <tr>
              <td><a href="{{route('conceptoDeleteAux', $concepto->id)}}" class="form__span">X</a></td>
              <td><input type="number" step="0" name="id_material[]"
                  class="form__input  form__input--short select_auto pointer" value="{{$concepto->id_material}}"></td>
              <td>{{$concepto->materialData->material}}</td>              
              <td>{{$concepto->materialData->unidad->unidad}}</td>
              <td> <input type="number" step="0.0001" name="cantidad_mater[]"
                  class="form__input form__input--short pointer select_auto " value="{{$concepto->cantidad}}"></td>
              <td>{{$concepto->materialData->precio_unitario}}</td>
              <td> {{number_format($concepto->importe, 2)}}</td>
              {{-- <td> {{$concepto->importe}}</td> --}}
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
              {{-- <td>{{$auxi->precio_unitario}}</td> --}}
            </tr>
          </tfoot>
        </table>
        <div class="tablaEmergent__divFooter">
          <button type="submit" id="formBoton" class="form__boton">Editar</button>
    </form>    
    <form action="{{route('auxis.index')}}">
      <button type="submit" class="form__boton">Auxiliares</button>
    </form>
  </div>
</section>
{{-- esta funcion no se importa desde resources/js/functions/ --}}
<script type="text/javascript" src="{{ asset('js/delete_elements.js') }}"></script>




@endsection