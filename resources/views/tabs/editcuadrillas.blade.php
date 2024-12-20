@extends('layouts.aplication')
@section('title', 'Editar Cuadrillas')
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
  <div class=" form__alert ">
    @if ($errors->any())
    <div class="alert alert-danger ">
      <strong>¡Error al crear cuadrilla de mano de obra!</strong>
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

  <section class="section ">
  <div class="emergente__contain  emergente__contain-display" id="emergente">
    <div class="emergente__header ">
      <h3 class="emergente__titulo">CUADRILLA DE MANO DE OBRA</h3>
      <div class="emergente__close">
        <a href="#">
          <h4 id="close" class="emergente__h4">----</h4>
          {{-- <img src="{{asset ('img/cruzblk.png') }}" alt="cruzblk" class="close__img" id="close"> --}}
        </a>
      </div>
    </div>

    <form action="{{route('cuadrillas.update', $cuadrilla)}}" method="POST" class="form">
      @csrf
      @method('PUT')

      <div class="datosEmer">

        <div class="datosEmer__contain border-bottom">
          <h4>CONCEPTO:</h4>
          <textarea name="descripcion" class="form__input form__input--area  pointer">{{$cuadrilla->descripcion}}</textarea>
        </div>

        <div class="datosEmer__contain">
          <div class="columna33">
            <div class="datosEmer__dato">              
              <h4>ID CUADRILLA:</h4>                
                <p>{{$cuadrilla->id}}</p>                
            </div>
          </div>
          <div class="columna50">
            <div class=" datosEmer__dato">
              <h4>GRUPO:</h4>
              <input type="text" name="grupo" class="form__input select_auto pointer" value="{{$cuadrilla->grupo->grupo}}">
            </div>
          </div>
          <div class="columna50">
            <div class=" datosEmer__dato ">
              <h4>UNIDAD:</h4>
              <input type="text" name="unidad" class="form__input select_auto pointer" value="{{$cuadrilla->unidad->unidad}}">
            </div>
          </div>
        </div>
      </div>

      <div class="contain__tablemergent">
        <table class="tablaEmergent">
          <thead class="tablaEmergent__thead">
            <tr>
              <th><input type="button" class="form__boton form__boton--short" id="boton_crear_fila" value="+ Fila"></th>
              <th>ID CATEG.</th>
              <th>CATEGORIA MANO DE OBRA</th>
              <th>UNIDAD</th>
              <th>CANTIDAD</th>
              <th>SALARIO REAL</th>
              <th>IMPORTE</th>
            </tr>
          </thead>
          <tbody id="fila_crear">
            @foreach ($conceptos as $concepto)
            <tr>
              {{-- <td> <a href="" class="form__span">X</a> </td> --}}
              <td> <a href="{{route('conceptoDeleteCuad', $concepto->id)}}" class="form__span">X</a> </td>
              <td><input type="number" step="0" name="id_categoria[]" class="form__input  form__input--short select_auto pointer"
                  value="{{$concepto->id_categoria}}"></td>
              <td>{{$concepto->categoriaData->categoria}}</td>
              <td>{{$concepto->categoriaData->unidad->unidad}}</td>
              <td> <input type="number" step="0.0001" name="cantidad_mo[]" class="form__input form__input--short pointer select_auto "
                  value="{{$concepto->cantidad}}"></td>
              <td>{{$concepto->categoriaData->salario_real}}</td>
              <td>{{number_format($concepto->importe, 2)}}</td>
              {{-- <td>{{$concepto->importe}}</td> --}}
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
              <td>TOTAL</td>
              <td>{{number_format($cuadrilla->total, 2)}}</td>
              {{-- <td>{{$cuadrilla->total}}</td> --}}
            </tr>
          </tfoot>
        </table>
        <div class="tablaEmergent__divFooter">
          <button type="submit" id="formBoton" class="form__boton">Editar</button>    
    </form>
        <form action="{{route('cuadrillas.index')}}">
      <button type="submit" class="form__boton">Cuadrillas</button>
    </form>
        </div>
      </div>
  </div>
</section>

{{-- esta funcion no se compila desde resources/js/functions/ --}}
<script type="text/javascript" src="{{ asset('js/delete_elements.js') }}"></script>


  

@endsection