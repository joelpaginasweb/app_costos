@extends('layouts.aplication')
@section('title', 'Presupuesto')
@section('content')

<section class="section section--title">
  <h3>PRESUPUESTOS</h3>
</section>
<!-- -------------------------- -->
<section class="section__form">
  <div class="form__titulo pointer display_action">
    <h5>REGISTRAR NUEVO CLIENTE</h5>
  </div>
  <div class="form__content form__content--short  element_display">
    <form action="{{route('presus.storeCliente')}}" method="POST" class="form">
      @csrf
      <div class="contenedorFlex">
        <input type="text" name="nombre" placeholder="Nombre o razon social" class="form__input">
        <input type="text" name="calle" placeholder="Calle" class="form__input">
        <input type="number" name="no_exterior" placeholder="Numero" class="form__input">
        <input type="number" name="cp" placeholder="Codigo Postal " class="form__input">
      </div>
      <div class="contenedorFlex">
        <input type="text" name="colonia" placeholder="Colonia" class="form__input">
        <input type="text" name="ciudad" placeholder="Ciudad" class="form__input">
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
        <button type="submit" class="form__boton">Crear</button>
    </form>
    <div class="">
      <div class="container">
        <!-- <button type="submit" class="form__boton">Editar</button> -->
        <div class="form__boton display_action">
          <p>Consultar Clientes</p>
        </div>
      </div>
    </div>
  </div>
</section>
{{-- --------------------- --}}
<section class="section__tablaBase element_display ">
  <div class="tablaBase__container">
    <div class="tablaBase__container">
      <table class="tablaBase tablaCliente" id="tabla_cliente">
        <thead>
          <tr class="">
            <th>ID</th>
            <th>CLIENTE</th>
            <th>CALLE</th>
            <th>NUM.</th>
            <th>COLONIA</th>
            <th>CP</th>
            <th>CIUDAD</th>
            <th>ESTADO</th>
            <th>FECHA EDICION</th>
            <th>ACCION</th>
          </tr>
        </thead>
        <tbody class="tablaBase__tbody">
          @foreach ($clientes as $cliente)
          <tr class="tablaBase__tr">
            <td>{{$cliente->id}}</td>
            <td>{{$cliente->nombre}}</td>
            <td>{{$cliente->calle}}</td>
            <td>{{$cliente->no_exterior}}</td>
            <td>{{$cliente->colonia}}</td>
            <td>{{$cliente->cp}}</td>
            <td>{{$cliente->ciudad->ciudad}}</td>
            <td>{{$cliente->estado->estado}}</td>
            <td>{{$cliente->updated_at}}</td>
            <td>
              <div class="contain">
                <form action="{{route('presus.destroyCliente', $cliente)}}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="tablaBase__boton">X</button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</section>

<!-- ------------------------------------------ -->

<section class="section__form">
  <div class="form__titulo pointer display_action">
    <h5>REGISTRAR NUEVO PRESUPUESTO</h5>
  </div>
  <div class="form__content mostrar element_display">
    <form action="{{route('presus.store')}}" method="POST" class="form">
      @csrf
      <div class="contenedorFlex">
        <input type="text" name="proyecto" placeholder="Nombre del Proyecto" class="form__input">
        <input type="text" name="cliente" placeholder="cliente" class="form__input" value="Cliente Generico">
        <input type="text" name="ubicacion" placeholder="ubicacion" class="form__input">
        {{-- <input type="text" name="colonia" placeholder="colonia" class="form__input"> --}}
        {{-- <input type="text" name="municipio" placeholder="municipio" class="form__input"> --}}
        {{-- <input type="text" name="estado" placeholder="estado " class="form__input"> --}}
      </div>
      <div class="contenedorFlex">
        <div class="container">
          <label for="porcent_indirecto" class="form__label">indirectos</label>
          <input type="number" step="0" name="porcent_indirecto" class="form__input" placeholder="indirectos">
        </div>
        <div class="container">
          <label for="porcent_financiam" class="form__label">financiamiento</label>
          <input type="number" step="0" name="porcent_financiam" class="form__input" placeholder="financiamiento">
        </div>
        <div class="container">
          <label for="porcent_utilidad" class="form__label">utilidad</label>
          <input type="number" step="0" name="porcent_utilidad" class="form__input" placeholder="utilidad">
        </div>
        <div class="container">
          <label for="porcent_costos_add" class="form__label">costos adicionales</label>
          <input type="number" step="0" name="porcent_costos_add" class="form__input" placeholder="costos adicionales">
        </div>
        <button type="submit" class="form__boton">Crear</button>
      </div>
    </form>
  </div>
</section>

<section>
  <div class="form__alert">
    @if (Session::get('success'))
    <div class="alert alert--success ">
      <strong>{{Session::get('success')}} <br>
    </div>
    @endif
  </div>
  <div class="form__alert">
    @if ($errors->any())
    <div class="alert alert-danger mt-3">
      <strong>¡Error al crear registro!</strong>
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

{{-- --------------------------- --}}

<section class="section__tablaBase section--down">
  <div class="tablaBase__contain">
    <div class="tablaBase__title">
      <h5>LISTADO DE PRESUPUESTOS</h5>
    </div>
  </div>
  <div class="tablaBase__container">
    <table class="tablaBase tablaPresus" id="tabla_base">
      <thead>
        <tr class="">
          <th>ID</th>
          <th>PROYECTO</th>
          <th>CLIENTE</th>
          <th>UBICACION</th>
          <th>ESTATUS</th>
          <th>COSTO DIR</th>
          <th>COSTO IND</th>
          <th>COSTO TOTAL</th>
          <th>FECHA EDICION</th>
          <th>ACCION</th>
        </tr>
      </thead>

      <tbody class="tablaBase__tbody">
        @foreach ($presus as $presu)
        <tr class="tablaBase__tr">
          <td>{{$presu->id}}</td>
          <td>{{$presu->proyecto}}</td>
          <td>{{$presu->cliente->nombre}}</td>
          <td>{{$presu->ubicacion}}</td>

          <td>{{$presu->estatus}}</td>
          <td>
            {{-- {{$presu->costo_directo}} --}}
            {{number_format($presu->costo_directo, 2)}}
          </td>
          <td>
            {{-- {{$presu->costo_indirecto}} --}}
            {{number_format($presu->costo_indirecto, 2)}}
          </td>
          <td>
            {{-- {{$presu->costo_total}} --}}
            {{number_format($presu->costo_total, 2)}}
          </td>
          <td>{{$presu->updated_at}}</td>
          {{-- ------------------ --}}
          <td>
            <div class="contain">

              <div class="contain">
                <a href="{{route('presus.edit', $presu->id)}}" class="tablaBase__boton">Ed</a>
              </div>

              <div class="contain">
                <a href="{{route('presusCopy', $presu->id)}}" class="tablaBase__boton">Cop</a>
              </div>

              <div class="contain">
                <form action="{{route('presus.destroy', $presu)}}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="tablaBase__boton">X</button>
                </form>
              </div>

            </div>
          </td>
          {{-- ------------------ --}}

        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>

@endsection