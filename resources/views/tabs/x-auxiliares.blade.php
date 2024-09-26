@extends('layouts.aplication')
@section('title', 'Auxiliares')
@section('content')

<section class="section">
  <div>
    <h1> TARJETAS AUXILIARES DE COSTOS </h1>
    <h4>APLICACION EN CONSTRUCCION</h4>
    <br>
    <div>
      <!----------- web components-------- -->
      {{-- <h3>-test web componentes-</h3> --}}
      <hola-mundo name="prueba de " surname="web componente nativo"></hola-mundo>
      <!-- lit components -->
      {{-- <eit-box-info message="prueba de Lit web component"></eit-box-info> --}}
      <!----------- web components-------- -->
    </div>
  </div>
</section>

<section class="section__form" id="nuevo_material">
  <div class="form__titulo">
    <h4>CREAR NUEVO MATERIAL AUXILIAR </h4>
  </div>

  <form action="{{route('auxis.store')}}" method="POST" class="form">
    @csrf

    <div class=" contain">
      <div class="containerFlex ">
        <input type="text" name="grupo" class="form__input" placeholder="grupo">
        <textarea name="material_auxiliar" class=" form__textarea" placeholder="concepto nuevo auxiliar"></textarea>
        <input type="text" name="unidad" class="form__input" placeholder="unidad">
        <input type="button" class="form__boton" id="boton_crear_aux" value="Agregar Material">
      </div>
    </div>

    <div class="container contain">
      <div id="container_aux" class="containerFlex">
        <div class="container contain_element">
          <span class="form__span" onclick="eliminar(this)">x</span>
          <label for="id_material" class="form__label">Id material</label>
          <input type="number" step="0" name="id_material[]" class="form__input" placeholder="id material">
          <label for="cantidad_mater" class="form__label">cantidad material</label>
          <input type="number" step="0.00001" name="cantidad_mater[]" class="form__input"
            placeholder="cantidad material">
        </div>
      </div>

      {{-- ----------------------- --}}
      <!-- ------------------------ -->

      <div class="container ">
        <div class="container ">
          <label for="formBoton" class="form__label"> Crear Auxiliar </label>
          <button type="submit" id="formBoton" class="form__boton">Crear Auxiliar</button>
        </div>
      </div>
    </div>
  </form>

  <div class=" section ">
    @if (Session::get('success'))
    <div class="alert alert--success ">
      <strong>{{Session::get('success')}} <br>
    </div>
    @endif
  </div>

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


<!----------- ventana emergente  ---------------->
<div class="emergente__contain" id="emergente">
  <div class="emergente__header ">
    <h3 class="emergente__titulo">TARJETA AUXILIARES</h3>
    <div class="emergente__close">
      <a href="#">
        <h4 id="close" class="emergente__h4">cerrar</h4>
        <!-- <img src="{{asset ('img/cruzblk.png') }}" alt="cruzblk" class="close__img" id="close"> -->
      </a>
    </div>
  </div>
  <div class="containDatosTarj">
    <div class="containConceptoTarj">
      <h4>CONCEPTO:</h4>
      <p>Mortero cemento-arena prop 1:4 - ejemplo de view </p>
    </div>
    <div class=" containDatos">
      <div class="columna50">
        <div class=" containDatos__datos ">
          <h4>CLAVE ID:</h4>
          <p>1</p>
        </div>
      </div>
      <div class="columna50">
        <div class=" containDatos__datos">
          <h4>GRUPO:</h4>
          <p>MATERIAL</p>
        </div>
      </div>
      <div class="columna50">
        <div class=" containDatos__datos ">
          <h4>UNIDAD:</h4>
          <p>m3</p>
        </div>
      </div>
    </div>
  </div>

  <div class="contain__tablaemergent">
    <table class="tabtarjetac">
      <thead class="thead">
        <tr>
          <th>CLAVE ID</th>
          <th>CONCEPTO</th>
          <th>UNIDAD</th>
          <th>CANTIDAD</th>
          <th>PRECIO UN.</th>
          <th>IMPORTE</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td></td>
          <th>MATERIALES</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <td>1</td>
          <td>cemento gris portland bulto 50kg</td>
          <td>bto</td>
          <td>8.90</td>
          <td>249.00</td>
          <td>2216.10</td>
        </tr>
        <tr>
          <td>2</td>
          <td>arena TRITURADA Num 4</td>
          <td>m3</td>
          <td>1.21</td>
          <td>750.00</td>
          <td>907.50</td>
        </tr>
        <tr>
          <td>3</td>
          <td>agua de red municipal</td>
          <td>m3</td>
          <td>0.346</td>
          <td>20.00</td>
          <td>6.92</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>SUB TOTAL</td>
          <td>3130.52</td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <td></td>
          <th>MANO DE OBRA</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <td>0</td>
          <td>NO APLICA </td>
          <td>jr</td>
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
        </tr>
        <tr>
          <td>0</td>
          <td>NO APLICA </td>
          <td>jr</td>
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
        </tr>
        <tr>
          <td>0</td>
          <td>NO APLICA</td>
          <td>jr</td>
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>SUB TOTAL</td>
          <td>0.00</td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <td></td>
          <th>HERRAMIENTA Y EQUIPO</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <td>0</td>
          <td>NO APLICA</td>
          <td>hr</td>
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
        </tr>
        <tr>
          <td>0</td>
          <td>NO APLICA</td>
          <td>hr</td>
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
        </tr>
        <tr>
          <td>0</td>
          <td>NO APLICA</td>
          <td>hr</td>
          <td>0.00</td>
          <td>0.00</td>
          <td>0.00</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>SUB TOTAL</td>
          <td>0.00</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <th>COSTO DIRECTO</th>
          <th>3130.52</th>
        </tr>
      </tbody>
    </table>
  </div>

</div>
<!----------- fin ventana emergente  --------------->

<section class="section__tablaBase section--down">
  <div class="tablaBase__contain">
    <div class="tablaBase__title">
      <h5>LISTADO DE TARJETAS DE COSTOS AUXILIARES</h5>
    </div>
  </div>

  <div class="tablaBase__container">
    <table class="tablaBase tablaAux" id="tabla_base">
      <thead>
        <tr class="">
          <th>ch</th>
          <th>ID</th>
          <th>GRUPO</th>
          <th>MATERIAL AUXILIAR</th>
          <th>UNID</th>
          <th>PRECIO UN</th>
          <th>FECHA</th>
          <th>ACCION</th>
        </tr>
      </thead>

      <tbody class="tablaBase__tbody">
        @foreach ($auxis as $auxi)
        <tr class="">
          <td><input type="checkbox" name="" id=""></td>
          <td>{{$auxi->id}}</td>
          <td>{{$auxi->grupo}}</td>
          <td id="open" class="pointer">{{$auxi->material}}</td>
          <td>{{$auxi->unidad}}</td>
          <td>{{number_format($auxi->precio_unitario, 2)}}</td>
          <td>{{$auxi->updated_at}}</td>
          <td>
            <div class="contain">
              <div class="contain">
                <a href="{{route('auxisCopy', $auxi->id)}}" class="tablaBase__boton">Cop</a>
              </div>
              <div class="contain">
                <a href="{{route('auxis.edit', $auxi->id)}}" class="tablaBase__boton">Ed</a>
              </div>
              <div class="contain">
                <form action="{{route('auxis.destroy', $auxi)}}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="tablaBase__boton">X</button>
                </form>
              </div>
            </div>
          </td>
          {{-- ----------- --}}
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</section>

{{-- esta funcion no se compila desde resources/js/functions/ --}}
<script type="text/javascript" src="{{ asset('js/delete_elements.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script>let dataTableC = new simpleDatatables.DataTable("#tabla_base");</script>

@endsection