@extends('layouts.aplication')
@section('title', 'Tarjetas')


@section('content')
<section class="section section--up">
  <div>
    <h1> TARJETAS DE COSTOS DE PRECIO UNITARIO </h1>
    <h4>APLICACION EN CONSTRUCCION</h4>
  </div>
</section>

<section class="section__form">
  <div class="form__titulo">
    <h4>CREAR NUEVA TARJETA DE COSTOS</h4>
  </div>

  <form action="{{route('tarjetas.store')}}" method="POST" class="form">
    @csrf
    <div class=" contain">
      <div class="containerFlex ">
        <input type="text" name="partida" class="form__input" placeholder="partida">
        <textarea name="concepto" class=" form__textarea"
          placeholder="concepto nueva tarjeta de precio unitario"></textarea>
        <input type="text" name="unidad" class="form__input" placeholder="unidad">
        <input type="text" name="id_presupuesto" class="form__input" placeholder="id Presupuesto">
      </div>
    </div>
    <div class="container contain">
      <div class="containerFlex ">
        <div class=" contain ">
          <h5>MATERIALES</h5>
          <input type="button" class="form__boton" id="boton_crear_mat" value="+ Fila Mat">
        </div>

        <hr>
        {{------------------------}}
        <div class="containerFlex" id="container_mater">
          <div class="container">
            <label for="select" class="form__label">Tipo</label>
            <select name="tipo_material[]">
              <option value="material" selected>material</option>
              <option value="auxiliar">auxiliar</option>
            </select>
            <label for="id_material" class="form__label">Id material</label>
            <input type="number" step="0" name="id_material[]" class="form__input" placeholder="id material">
            <label for="cantidad_mater" class="form__label">cantidad material</label>
            <input type="number" step="0.00001" name="cantidad_mater[]" class="form__input"
              placeholder="cantidad material">
          </div>
        </div>
        {{------------------------}}


        <br>
        <div class="contain">
          <h5>MANO DE OBRA</h5>
          <input type="button" class="form__boton" id="boton_crear_mo" value="+ Fila MO">
        </div>
        <hr>

        {{------------------------}}
        <div class="containerFlex" id="container_mo">
          <div class="container ">
            <label for="select" class="form__label">Tipo</label>
            <select name="tipo_mano_obra[]">
              <option value="categoria" selected>categoria</option>
              <option value="cuadrilla">cuadrilla</option>
            </select>
            <label for="id_mano_obra" class="form__label">Id mano de obra</label>
            <input type="number" step="0" name="id_mano_obra[]" class="form__input" placeholder="Id mano de obra">
            <label for="cant_mano_obra" class="form__label">cantidad M.O.</label>
            <input type="number" step="0.00001" name="cant_mano_obra[]" class="form__input" placeholder="cantidad MO">
          </div>
        </div>
        {{-- ---------------- --}}
        <br>
        <div class="contain">
          <h5>HERRAMIENTA Y EQUIPO</h5>
          <input type="button" class="form__boton" id="boton_crear_equipo" value="+ Fila H y E">
        </div>
        <hr>
        {{-- ---------------- --}}

        <div class="containerFlex" id="container_equipo">
          <div class="container ">
            <label for="id_equipo" class="form__label">Id equipo</label>
            <input type="number" step="0" name="id_equipo[]" class="form__input" placeholder="Id equipo">
            <label for="cant_equipo" class="form__label">cantidad equipo</label>
            <input type="number" step="0.00001" name="cant_equipo[]" class="form__input" placeholder="cantidad equipo">
          </div>
        </div>
        {{-- ---------------- --}}

        <div class="container ">
          <label for="formBoton" class="form__label"> Calcular y crear Tarjeta</label>
          <button type="submit" id="formBoton" class="form__boton">Crear Tarjeta</button>
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
      <strong>¡Error al crear tarjeta de costos!</strong>
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


<!----------- ventana emergente tarjeta de costos ---------------->
<div class="emergente__contain" id="emergente">

  <div class="emergente__header ">
    <h3 class="emergente__titulo">TARJETA DE COSTOS</h3>
    <div class="emergente__close">
      <a href="#" >
      <h4 id="close" class="emergente__h4">cerrar</h4>
    
        <!-- <img src="{{asset ('img/cruzblk.png') }}" alt="cruzblk" class="close__img" id="close"> -->
      </a>
    </div>
  </div>

  <div class="containDatosTarj">
    <div class="containConceptoTarj">
      <h4>CONCEPTO:</h4>
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias est, aliquam architecto harum id assumenda
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo necessitatibus exercitationem quaerat, sunt haru.
      </p>
    </div>
    <div class=" containDatos">
      <div class="columna50">
        <div class=" containDatos__datos ">
          <h4>CLAVE ID:</h4>
          <p> 100</p>
        </div>
        <div class=" containDatos__datos">
          <h4>PARTIDA:</h4>
          <p>cimentaciones</p>
        </div>
      </div>
      <div class="columna100">
        <div class=" containDatos__datos">
          <h4>OBRA:</h4>
          <p>nombre de la obra</p>
        </div>
        <div class=" containDatos__datos">
          <h4>OTRO DATO:</h4>
          <p>otros datos de la tarjeta</p>
        </div>
      </div>
    </div>
  </div>
  <div class="contain__tablaemergent">
    <table class="tablemergent">
      <thead class="tablemergent__thead">
        <tr>
          <th>ID</th>
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
          <td>234</td>
          <td>MORTERO Lorem ipsum, dolor sit amet </td>
          <td>m3</td>
          <td>234</td>
          <td>542</td>
          <td>2145</td>
        </tr>

        <tr>
          <td>234</td>
          <td>GRAVA TRITURADA Lorem ipsum, dolor sit amet </td>
          <td>m3</td>
          <td>234</td>
          <td>542</td>
          <td>2145</td>
        </tr>
        <tr>
          <td>234</td>
          <td>BLOCK Lorem ipsum, dolor sit amet consectetur ad </td>
          <td>m3</td>
          <td>234</td>
          <td>542</td>
          <td>2145</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>SUB TOTAL</td>
          <td>4145</td>
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
          <td>234</td>
          <td>OFICIAL ALBAÑIL Lorem ipsum, dolor sit amet consectetur ad </td>
          <td>m3</td>
          <td>234</td>
          <td>542</td>
          <td>2145</td>
        </tr>
        <tr>
          <td>234</td>
          <td>AYUDANTE GENERAL consectetur ad </td>
          <td>m3</td>
          <td>234</td>
          <td>542</td>
          <td>2145</td>
        </tr>
        <tr>
          <td>234</td>
          <td>CONTRATISTA PLOMERO Lorem ipsum, dolor sit </td>
          <td>m3</td>
          <td>234</td>
          <td>542</td>
          <td>2145</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>SUB TOTAL</td>
          <td>4145</td>
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
          <td>234</td>
          <td>ROTOMARTILLO Lorem ipsum, dolor sit amet consectetur ad</td>
          <td>m3</td>
          <td>234</td>
          <td>542</td>
          <td>2145</td>
        </tr>
        <tr>
          <td>234</td>
          <td>COMPACTADORA Lorem ipsum, dolor sit amet consectetur ad</td>
          <td>m3</td>
          <td>234</td>
          <td>542</td>
          <td>2145</td>
        </tr>
        <tr>
          <td>234</td>
          <td>GENERADOR Lorem ipsum, dolor sit amet consectetur ad</td>
          <td>m3</td>
          <td>234</td>
          <td>542</td>
          <td>2145</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>SUB TOTAL</td>
          <td>4145</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <th>COSTO DIRECTO</th>
          <th>41746.35</th>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="contain__tablaindir">
    <table class="tablaindir tablemergent">
      <thead class="tablemergent__thead">
        <tr>
          <th>GASTOS INDIRECTOS</th>
          <th>PORCENTAJE</th>
          <th>MONTO</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>INDIRECTOS</td>
          <td>5</td>
          <td>234</td>
        </tr>
        <tr>
          <td>FINANCIAMIENTO</td>
          <td>2</td>
          <td>23</td>
        </tr>
        <tr>
          <td>UTILIDAD</td>
          <td>15</td>
          <td>334</td>
        </tr>
        <tr>
          <td>CARGOS ADICIONALES</td>
          <td>10</td>
          <td>534</td>
        </tr>
        <tr>
          <td></td>
          <th>PRECIO UNITARIO</th>
          <th>53245.86</th>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!----------- fin ventana emergente tarjeta de costos -------------->


<section class="section__tablaBase section--down">
  <div class="tablaBase__contain">
    <div class="tablaBase__title">
      <h5>LISTADO DE TARJETAS DE COSTOS</h5>
    </div>
  </div>

  <div class="tablaBase__container">
    <table class="tablaBase tablaTarjeta " id="tabla_base">
    <thead>
        <tr class="">
          <th>ID</th>
          <th>PARTIDA</th>
          <th>CONCEPTO</th>
          <th>UNI</th>
          <th>COSTO MAT</th>
          <th>COSTO MA</th>
          <th>COSTO EQ</th>
          <th>COSTO DIR</th>
          <th>COSTO IND</th>
          <th>PRECIO UN</th>
          <th>PRES</th>
          <th>ACCION</th>
        </tr>
      </thead>
      <tbody class="tablaBase__tbody">      
        @foreach ($tarjetas as $tarjeta)
        <tr class="pointer" id="open">
          <td>{{$tarjeta->id}}</td>
          <td>{{$tarjeta->partida}}</td>
          <td>{{$tarjeta->concepto}}</td>
          <td>{{$tarjeta->unidad}}</td>
          <td>
            {{-- {{$tarjeta->costo_material}} --}}
            {{number_format($tarjeta->costo_material, 2)}}
          </td>
          <td>
            {{number_format($tarjeta->costo_mano_obra, 2)}}
          </td>
          <td>
            {{number_format($tarjeta->costo_equipo, 2)}}
          </td>
          <td>
            {{number_format($tarjeta->costo_directo, 2)}}
          </td>

          <td>          
          {{number_format($tarjeta->costo_indirecto, 2)}}
          </td>

          <td>
            {{number_format($tarjeta->precio_unitario, 2)}}
          </td>

          <td>{{$tarjeta->id_presup}}</td>

          <td>
            <div class="contain">
              <div class="contain">
                {{-- <a href=" {{route('tarjetas.edit', $tarjeta->id)}} " class="tabla__boton">Ed</a> --}}
              </div>
              <div class="contain">
                <form action=" {{route('tarjetas.destroy', $tarjeta)}} " method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="tablaBase__boton">X</button>
                </form>
              </div>
            </div>
          </td>

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