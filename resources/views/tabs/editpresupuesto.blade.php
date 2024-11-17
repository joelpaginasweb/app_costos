@extends('layouts.aplication')
@section('title', 'Editar Presupuesto')

@section('content')

<section class="section section--title">
    <h3 class="">EDITAR PRESUPUESTO CATALOGO DE CONCEPTOS</h3>
</section>

<section class="section">
  <div class="contain__datosobra">
      <div class="datosobra">
      <h5 class="datosobra__titulo">NUM. ID: </h5>
      <h5 class="datosobra__dato">{{$presu->id}}</h5>
    </div>
    <div class="datosobra">
      <h5 class="datosobra__titulo">TITULO: </h5>
      <h5 class="datosobra__dato">{{$presu->proyecto}}</h5>
    </div>
    <div class="datosobra">
      <h5 class="datosobra__titulo">CLIENTE: </h5>
      <h5 class="datosobra__dato">{{$presu->cliente->nombre}}</h5>
    </div>
    <div class="datosobra">
      <h5 class="datosobra__titulo">UBICACION: </h5>
      <h5 class="datosobra__dato">{{$presu->ubicacion}}</h5>
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

<section class="section__tablaBase section--down">
  <div class="tablaBase__contain">
    <div class="presupMonto">
      <h5>PRESUPUESTO TOTAL</h5>
      <h5>{{number_format($presu->costo_total, 2)}}</h5>
    </div>
  </div>

  <div class="tablaBase__container">
    {{-- <table class="tablaBase tablaEdit" id="tabla_base"> --}}
    <table class="tablaBase tablaEdit" id="tabla_base">
      <thead class="">
        <tr>
          <th>ID</th>
          <th>CONCEPTO</th>
          <th>UNIDAD</th>
          <th>CANTIDAD</th>
          <th>PRECIO UNITARIO</th>
          <th>IMPORTE</th>
        </tr>
      </thead>

      <tbody class="tablaBase__tbody">
        @foreach ($conceptos as $concepto)
        <tr>
          <td>{{$concepto->id}}</td>
          <td>{{$concepto->concepto->concepto}}</td>
          <td>{{$concepto->concepto->unidad->unidad}}</td>
          <td>
            <form action="{{ route('updateConceptoCantidad', $concepto->id) }}" method="POST">
              @csrf
              <input type="number" name="cantidad_concepto"  class="form__input--table select_auto"
                value="{{$concepto->cantidad}}" step="0.01" onkeydown="handleKeyDown(event)">
            </form>
          </td>
          <td>
            {{-- {{$concepto->precio_unitario}} --}}
            {{number_format($concepto->concepto->precio_unitario, 2)}}
          </td>
          <td>
            {{-- {{$concepto->importe}} --}}
            {{number_format($concepto->importe, 2)}}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>    
  </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>

@endsection