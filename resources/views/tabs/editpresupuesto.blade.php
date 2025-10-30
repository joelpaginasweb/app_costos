@extends('layouts.aplication')
@section('title', 'Editar Presupuesto')

@section('content')

<section class="section section--title">
  <h3 class="">EDITAR PRESUPUESTO</h3>
</section>

<!------------------------------------>
<section class="section__form">

  <div class="form__titulo pointer display_action">
    <h5>EDITAR DATOS GENERALES</h5>
  </div>

  <div class="form__content form__content--short  element_display">
    <br>
    <!-- <form action="{{route('presus.storeCliente')}}" method="POST" class="form"> -->
    <form action="{{route('presus.update' ,$presu)}}" method="POST" class="form">
      @csrf
      @method('PUT')
      <h5>EDITAR DATOS DE CLIENTE</h5>
      <div class="contenedorFlex">
        <div class="container">
          <label for="nombre" class="form__label">Nombre</label>
          <input type="text" name="nombre" placeholder="Nombre o razon social" class="form__input">
        </div>
        <div class="container">
          <label for="calle" class="form__label">Calle</label>
          <input type="text" name="calle" placeholder="Calle" class="form__input">
        </div>
        <div class="container">
          <label for="no_exterior" class="form__label">No_exterior</label>
          <input type="number" name="no_exterior" placeholder="Numero" class="form__input">
        </div>
        <div class="container">
          <label for="cp" class="form__label">C.P.</label>
          <input type="number" name="cp" placeholder="C.P." class="form__input form__input--short">
        </div>
      </div>
      <div class="contenedorFlex">
        <div class="container">
          <label for="colonia" class="form__label">Colonia</label>
          <input type="text" name="colonia" placeholder="Colonia" class="form__input">
        </div>
        <div class="container">
          <label for="ciudad" class="form__label">Ciudad</label>
          <input type="text" name="ciudad" placeholder="Ciudad" class="form__input">
        </div>
        <div class="container">
          <label for="estado" class="form__label">Estado</label>
          <select id="opciones" name="estado" placeholder="Estado" class="form__input">
            <option value></option>
            <option value="Aguascalientes">Aguascalientes</option>
            <option value="Baja California">Baja California</option>
            <option value="Baja California Sur">Baja California Sur</option>
            <option value="Campeche">Campeche</option>
            <option value="Chiapas">Chiapas</option>
            <option value="Chihuahua">Chihuahua</option>
            <option value="Ciudad de México">Ciudad de México</option>
            <option value="Coahuila">Coahuila</option>
            <option value="Colima">Colima</option>
            <option value="Durango">Durango</option>
            <option value="Estado de México">Estado de México</option>
            <option value="Guanajuato">Guanajuato</option>
            <option value="Guerrero">Guerrero</option>
            <option value="Hidalgo">Hidalgo</option>
            <option value="Jalisco">Jalisco</option>
            <option value="Michoacán">Michoacán</option>
            <option value="Morelos">Morelos</option>
            <option value="Nayarit">Nayarit</option>
            <option value="Nuevo León">Nuevo León</option>
            <option value="Oaxaca">Oaxaca</option>
            <option value="Puebla">Puebla</option>
            <option value="Querétaro">Querétaro</option>
            <option value="Quintana Roo">Quintana Roo</option>
            <option value="San Luis Potosí">San Luis Potosí</option>
            <option value="Sinaloa">Sinaloa</option>
            <option value="Sonora">Sonora</option>
            <option value="Tabasco">Tabasco</option>
            <option value="Tamaulipas">Tamaulipas</option>
            <option value="Tlaxcala">Tlaxcala</option>
            <option value="Veracruz">Veracruz</option>
            <option value="Yucatán">Yucatán</option>
            <option value="Zacatecas">Zacatecas</option>
          </select>
        </div>
        <div class="container">
          <button type="submit" class="form__boton">Editar</button>
        </div>
    </form>
  </div>
  <br>
  <hr>
  <br>
  {{--
</section> --}}
{{-- <section class="section__form"> --}}
  {{-- <div class="form__titulo pointer display_action"> --}}
    {{-- <h5>EDITAR DATOS DE PRESUPUESTO</h5> --}}
    {{-- </div> --}}
  {{-- <div class="form__content mostrar element_display"> --}}
    {{-- <div class="form__content "> --}}
      <div class=" ">
        <!-- <form action="{{route('presus.store')}}" method="POST" class="form"> -->
        <form action="{{route('presus.update' ,$presu)}}" method="POST" class="form">
          @csrf
          @method('PUT')
          <h5>EDITAR DATOS DE PRESUPUESTO</h5>
          <div class="contenedorFlex">
            <div class="container">
              <label for="proyecto" class="form__label">Proyecto</label>
              <input type="text" name="proyecto" class="form__input" value="{{$presu->proyecto}}">
            </div>
            <div class="container">
              <label for="cliente" class="form__label">Id Cliente</label>
              <input type="number" step="0" name="cliente" class="form__input form__input--short" value="{{$presu->id_cliente}}">
            </div>
            <div class="container">
              <label for="ubicacion" class="form__label">Ubicacion</label>
              <input type="text" name="ubicacion" class="form__input" value="{{$presu->ubicacion}}">
            </div>

          </div>
          <div class="contenedorFlex">
            <div class="container">
              <label for="porcent_indirecto" class="form__label">Indirectos</label>
              <input type="number" step="0" name="porcent_indirecto" class="form__input form__input--short"
                value="{{$porcent->porcent_indirecto}}">
            </div>
            <div class="container">
              <label for="porcent_financiam" class="form__label">Financiamiento</label>
              <input type="number" step="0" name="porcent_financiam" class="form__input form__input--short"
                value="{{$porcent->porcent_financiam}}">
            </div>
            <div class="container">
              <label for="porcent_utilidad" class="form__label">Utilidad</label>
              <input type="number" step="0" name="porcent_utilidad" class="form__input form__input--short"
                value="{{$porcent->porcent_utilidad}}">
            </div>
            <div class="container">
              <label for="porcent_costos_add" class="form__label">Costos adicionales</label>
              <input type="number" step="0" name="porcent_costos_add" class="form__input form__input--short"
                value="{{$porcent->porcent_costos_add}}">
            </div>
            <button type="submit" class="form__boton">Editar</button>
          </div>
        </form>
      </div>
</section>
<br>
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
          <td>{{$porcent->porcent_indirecto}}</td>
          <td>{{number_format($presu->indirectos, 2)}}</td>
        </tr>
        <tr>
          <td>FINANC.</td>
          <td>{{$porcent->porcent_financiam }}</td>
          <td>{{number_format($presu->financiam, 2)}}</td>
        </tr>
        <tr>
          <td>UTILIDAD</td>
          <td>{{$porcent->porcent_utilidad}}</td>
          <td>{{number_format($presu->utilidad, 2)}}</td>
        </tr>
        <tr>
          <td>C.ADICIONALES</td>
          <td>{{$porcent->porcent_costos_add}}</td>
          <td>{{number_format($presu->cargos_adicion, 2)}}</td>
        </tr>
        <tr>
          <td>TOTAL COSTOS IND.</td>
          <td>{{$porcent->porcent_suma}}</td>
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
    <div class="tablaBase__title tablaBase__title--datos">
      <h5>PRESUPUESTO TOTAL</h5>
      <h5>${{number_format($presu->costo_total, 2)}}</h5>
      {{-- <h5>{{$presu->costo_total}}</h5> --}}
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
                <input type="number" name="cantidad_concepto" class="form__input--table select_auto"
                  value="{{$concepto->cantidad}}" step="0.01" onkeydown="handleKeyDown(event)">
              </form>
            </td>
            <td>
              {{-- {{$concepto->concepto->precio_unitario}} --}}
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