@extends('layouts.aplication')
@section('title', 'Tarjetas')
@section('scripts')
{{-- <script src="{{ asset('js/ventana_popup.js') }}"></script> --}}
@endsection
@section('content')

<head>
  <link rel="stylesheet" href="{{ asset ('css/tarjetas.css') }}">
  <link rel="stylesheet" href="{{ asset ('css/estilobase.css') }}">
</head>

<section class="section section--up">
  <div>
    <h1> TARJETAS DE COSTOS DE PRECIO UNITARIO </h1>
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
        <textarea name="concepto" class=" form__textarea" placeholder="concepto nueva tarjeta de precio unitario"></textarea>
        <input type="text" name="unidad" class="form__input" placeholder="unidad">       
        <input type="text" name="id_presupuesto" class="form__input" placeholder="id Presupuesto">
      </div>
    </div>
    <div class="container contain">
      <div class="containerFlex ">
        <h5>MATERIALES</h5>
        <hr>
        <div class="container ">          
          <label for="id_material" class="form__label">Id material</label>         
          <input type="number" step="0" name="id_material[]" class="form__input" placeholder="id material">
          <label for="cantidad_mater" class="form__label">cantidad material</label>
          <input type="number" step="0.00001" name="cantidad_mater[]" class="form__input"
            placeholder="cantidad material">
        </div>  
        <div class="container ">
          <label for="id_material" class="form__label">Id material</label>
          <input type="number" step="0" name="id_material[]" class="form__input" placeholder="id material">

          <label for="cantidad_mater" class="form__label">cantidad material</label>
          <input type="number" step="0.00001" name="cantidad_mater[]" class="form__input"
            placeholder="cantidad material">
        </div>
        {{------------------------}}
        <br>
        <h5>MANO DE OBRA</h5>
        <hr>      
        <div class="container ">
          <label for="id_mano_obra" class="form__label">Id mano de obra</label>
          <input type="number" step="0" name="id_mano_obra[]" class="form__input" placeholder="Id mano de obra">

          <label for="cant_mano_obra" class="form__label">cantidad MO</label>
          <input type="number" step="0.00001" name="cant_mano_obra[]" class="form__input"
            placeholder="cantidad MO">
        </div>        
        <div class="container ">
          <label for="id_mano_obra" class="form__label">Id mano de obra</label>
          <input type="number" step="0" name="id_mano_obra[]" class="form__input" placeholder="Id mano de obra">

          <label for="cant_mano_obra" class="form__label">cantidad MO</label>
          <input type="number" step="0.00001" name="cant_mano_obra[]" class="form__input"
            placeholder="cantidad MO">
        </div>
        {{-- ---------- --}}

        <br>
        <h5>HERRAMIENTA Y EQUIPO</h5>
        <hr>
        <div class="container ">
          <label for="id_equipo" class="form__label">Id equipo</label>
          <input type="number" step="0" name="id_equipo[]" class="form__input" placeholder="Id equipo">

          <label for="cant_equipo" class="form__label">cantidad equipo</label>
          <input type="number" step="0.00001" name="cant_equipo[]" class="form__input"
            placeholder="cantidad equipo">
        </div>   
        <div class="container ">
          <label for="id_equipo" class="form__label">Id equipo</label>
          <input type="number" step="0" name="id_equipo[]" class="form__input" placeholder="Id equipo">

          <label for="cant_equipo" class="form__label">cantidad equipo</label>
          <input type="number" step="0.00001" name="cant_equipo[]" class="form__input"
            placeholder="cantidad equipo">
        </div> 
        {{-- ----------------  --}}

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
      <a href="#" onclick="cerrar()">
        <img src="{{asset ('img/cruzblk.png') }}" alt="cruzblk" class="close__img">
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
    <table class="tablaindir tablemergent" >
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
  <div id="fotervent" class="footer__emergente"></div>
</div>
<!----------- fin ventana emergente tarjeta de costos -------------->


<section class="sectionTabla">
  <div id="presglobtit" class="tabla__nombre">
    <div class="nombre">
      <h5>LISTADO DE TARJETAS DE COSTOS</h5>
    </div>
  </div>

  <div class="containerTabla">
    <table class="tablaTarjetas">
      <tbody>
        <tr class="tablaTarjetas__head">
          <td>CLAVE ID</td>
          <td>PARTIDA</td>
          <td>CONCEPTO</td>
          <td>UNID</td>
          <td>COSTO MAT</td>
          <td>COSTO MA</td>
          <td>COSTO HyEQ</td>
          <td>COSTO DIR</td>
          <td>COSTO IND</td>
          <td>PRECIO UN</td>
          <td>ID PRES</td>
          <td>ACCION</td>
        </tr>
        @foreach ($tarjetas as $tarjeta)
        <tr onclick="abrir()" class="tablaTarjetas__body">
          <td>{{$tarjeta->id}}</td>
          <td>{{$tarjeta->partida}}</td>
          <td>{{$tarjeta->concepto}}</td>
          <td>{{$tarjeta->unidad}}</td>
          <td>
              {{-- {{$tarjeta->costo_material}} --}}
               {{number_format($tarjeta->costo_material, 2)}}   
          </td>
          <td>
          {{-- {{$tarjeta->costo_mano_obra}} --}}
          {{number_format($tarjeta->costo_mano_obra, 2)}} 
          </td>
          <td>
              {{-- {{$tarjeta->costo_equipo}} --}}
              {{number_format($tarjeta->costo_equipo, 2)}} 
          </td>
          <td>
              {{-- {{$tarjeta->costo_directo}} --}}
              {{number_format($tarjeta->costo_directo, 2)}} 
          </td>
          <td>
              {{-- {{$tarjeta->costo_indirecto}}</td> --}}
              {{number_format($tarjeta->costo_indirecto, 2)}} 
          <td>
              {{-- {{$tarjeta->precio_unitario}} --}}
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
                  <button type="submit" class="tabla__boton">X</button>
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

@endsection