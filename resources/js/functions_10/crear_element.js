
const botonCrear = document.getElementById('boton_crear');

if (botonCrear) {

  botonCrear.addEventListener('click', function() {

    const contenedor = document.querySelector('#elemento_crear');

    var elementoCrear = document.createElement('div');
    elementoCrear.setAttribute('class', 'containerFlex');
    elementoCrear.setAttribute('id', 'elemento_crear');

    var container = document.createElement('div');
    container.setAttribute('class', 'container');

    var labelId = document.createElement('label');
    labelId.setAttribute('for', 'id_material');
    labelId.setAttribute('class', 'form__label');
    labelId.innerText = 'Id material';

    var inputId = document.createElement('input');
    inputId.setAttribute('type', 'number');
    inputId.setAttribute('step', '0');
    inputId.setAttribute('name', 'id_material[]');
    inputId.setAttribute('class', 'form__input');
    inputId.setAttribute('placeholder', 'id material');

    var labelCantidad = document.createElement('label');
    labelCantidad.setAttribute('for', 'cantidad_mater');
    labelCantidad.setAttribute('class', 'form__label');
    labelCantidad.innerText = 'cantidad material';

    var inputCantidad = document.createElement('input');
    inputCantidad.setAttribute('type', 'number');
    inputCantidad.setAttribute('step', '0.0001');
    inputCantidad.setAttribute('name', 'cantidad_mater[]');
    inputCantidad.setAttribute('class', 'form__input');
    inputCantidad.setAttribute('placeholder', 'cantidad material');

    container.appendChild(labelId);
    container.appendChild(inputId);
    container.appendChild(labelCantidad);
    container.appendChild(inputCantidad);

    elementoCrear.appendChild(container);
    contenedor.appendChild(container);
  });
}



// document.getElementById('boton_crear').addEventListener('click', function() {
//   const contenedor = document.querySelector('#elemento_crear');

//   var elementoCrear = document.createElement('div');
//   elementoCrear.setAttribute('class', 'containerFlex');
//   elementoCrear.setAttribute('id', 'elemento_crear');

//   var container = document.createElement('div');
//   container.setAttribute('class', 'container');

//   var labelId = document.createElement('label');
//   labelId.setAttribute('for', 'id_material');
//   labelId.setAttribute('class', 'form__label');
//   labelId.innerText = 'Id material';

//   var inputId = document.createElement('input');
//   inputId.setAttribute('type', 'number');
//   inputId.setAttribute('step', '0');
//   inputId.setAttribute('name', 'id_material[]');
//   inputId.setAttribute('class', 'form__input');
//   inputId.setAttribute('placeholder', 'id material');

//   var labelCantidad = document.createElement('label');
//   labelCantidad.setAttribute('for', 'cantidad_mater');
//   labelCantidad.setAttribute('class', 'form__label');
//   labelCantidad.innerText = 'cantidad material';

//   var inputCantidad = document.createElement('input');
//   inputCantidad.setAttribute('type', 'number');
//   inputCantidad.setAttribute('step', '0.0001');
//   inputCantidad.setAttribute('name', 'cantidad_mater[]');
//   inputCantidad.setAttribute('class', 'form__input');
//   inputCantidad.setAttribute('placeholder', 'cantidad material');

//   container.appendChild(labelId);
//   container.appendChild(inputId);
//   container.appendChild(labelCantidad);
//   container.appendChild(inputCantidad);

//   elementoCrear.appendChild(container);
//   contenedor.appendChild(container);
// });
