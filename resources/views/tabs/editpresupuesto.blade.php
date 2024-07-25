@extends('layouts.aplication')
@section('title', 'Editar Presupuesto')

{{-- @section('scripts')
<script src="{{ asset('js/select_one_click.js') }}"></script>
@endsection --}}

@section('content')

{{-- <head>
  <link rel="stylesheet" href="{{ asset ('css/edit_presupuesto.css') }}">
  <link rel="stylesheet" href="{{ asset ('css/estilobase.css') }}">
</head> --}}

<section class="section section--up">
  <div>
    <h3 class="section__h">EDITAR PRESUPUESTO CATALOGO DE CONCEPTOS</h3>
  </div>
</section>

<section class="section">
  <div class="contain__datosobra">
    <div class="datosobra">
      <h5 class="datosobra__titulo">TITULO: </h5>
      <h5 class="datosobra__dato">{{$presu->obra}}</h5>
    </div>
    <div class="datosobra">
      <h5 class="datosobra__titulo">CLIENTE: </h5>
      <h5 class="datosobra__dato">{{$presu->cliente}}</h5>
    </div>
    <div class="datosobra">
      <h5 class="datosobra__titulo">DIRECCION: </h5>
      <h5 class="datosobra__dato">{{$presu->direccion}}</h5>
    </div>
    <div class="datosobra">
      <h5 class="datosobra__titulo">CIUDAD: </h5>
      <h5 class="datosobra__dato">{{$presu->municipio}}</h5>
    </div>
    <div class="datosobra">
      <h5 class="datosobra__titulo">ESTATUS: </h5>
      <h5 class="datosobra__dato">{{$presu->estatus}}</h5>
    </div>
    <div class="datosobra">
      <h5 class="datosobra__titulo">FECHA EDICION: </h5>
      <h5 class="datosobra__dato">{{$presu->updated_at}}</h5>
    </div>
  </div>

  <!------------------------------------>
  <div class="contain__tablamini">
    <div class="tablamini__titulo">
      <h5>PORCENTAJES DE INDIRECTOS</h5>
    </div>

    <table class="tablamini">
      <tbody>
        <tr>
          <td>INDIRECTOS</td>
          <td>{{$presu->porcent_indirecto}}</td>
          <td>{{number_format($presu->indirectos, 2)}}</td>
        </tr>
        <tr>
          <td>FINANC.</td>
          <td>{{$presu->porcent_financiam }}</td>
          <td>{{number_format($presu->financiam, 2)}}</td>
        </tr>
        <tr>
          <td>UTILIDAD</td>
          <td>{{$presu->porcent_utilidad}}</td>
          <td>{{number_format($presu->utilidad, 2)}}</td>
        </tr>
        <tr>
          <td>C.ADICIONALES</td>
          <td>{{$presu->porcent_costos_add}}</td>
          <td>{{number_format($presu->cargos_adicion, 2)}}</td>
        </tr>
        <tr>
          <td>TOTAL COSTOS IND.</td>
          <td>{{$presu-> porcent_suma}}</td>
          <td>{{number_format($presu->costo_indirecto, 2)}} </td>
        </tr>
        <tr>
          <td>COSTO DIRECTO</td>
          <td> </td>
          <td>{{number_format($presu->costo_directo, 2)}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<section id="secatalog" class="sectionTabla">
  <div class="row__presupMonto">
    <div class="presupMonto__titulo">
      <h5>PRESUPUESTO TOTAL</h5>
    </div>
    <div class="presupMonto__monto">
      <h5>{{number_format($presu->costo_total, 2)}}</h5>
    </div>
  </div>

  <div class="containerTabla">
    <table class="tabla ">
      <thead class="tabla__head">
        <tr>
          <th>ID CLAVE</th>
          <th>CONCEPTO</th>
          <th>UNIDAD</th>
          <th>CANTIDAD</th>
          <th>PRECIO UNITARIO</th>
          <th>IMPORTE</th>
        </tr>
      </thead>
    </table>
    <table class="tabla">
      {{-- <thead class="tabla__subhead">
        <tr>
          <th></th>
          <th>
            <div class="tabla__subtitulos">
              <div class="tabla__partidas">PARTIDA</div>
              <div class="tabla__partidas">PRELIMINARES</div>
            </div>
          </th>
          <th></th>
          <th></th>
          <th>TOTAL PARTIDA</th>
          <th>00.00</th>
        </tr>
      </thead> --}}
      <tbody>
        @foreach ($conceptos as $concepto)
        <tr>
          <td>{{$concepto->id}}</td>
          <td>{{$concepto->concepto}}</td>
          <td>{{$concepto->unidad}}</td>
          <td>
            <form action="{{ route('updateConceptoCantidad', $concepto->id) }}" method="POST">
              @csrf
            <input type="number" name="cantidad_concepto" id="select_auto" class="form__input-clear" value="{{$concepto->cantidad}}" step="0.01" onkeydown="handleKeyDown(event)">
            </form>
          </td>
          <td>
            {{-- {{$concepto->precio_unitario}} --}}
            {{number_format($concepto->precio_unitario, 2)}}
          </td>
          <td>
            {{-- {{$concepto->importe}} --}}
            {{number_format($concepto->importe, 2)}}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>


    <!-------------- para llenar dato como celda de excel ------------>
    <div id="excel-cell">
      <span id="cell-value" ondblclick="activateInput()"></span>
      <input id="input-cell" type="text" onkeydown="handleKeyDown(event)" style="display: none;">
    </div>


    {{---------------------------}}



  </div>


  @endsection