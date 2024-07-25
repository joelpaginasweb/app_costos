
const botonCrearEquipo = document.getElementById('boton_crear_equipo');

if(botonCrearEquipo){
  
  botonCrearEquipo.addEventListener('click', function() {

    const containerEquipo = document.querySelector('#container_equipo');

      var container = document.createElement('div');
      container.setAttribute('class', 'container');

      var labelEquipo = document.createElement('label');
      labelEquipo.setAttribute('for', 'id_equipo');
      labelEquipo.setAttribute('class', 'form__label');
      labelEquipo.innerText = 'Id equipo';

      var inputEquipo = document.createElement('input');
      inputEquipo.setAttribute('type', 'number');
      inputEquipo.setAttribute('step', '0');
      inputEquipo.setAttribute('name', 'id_equipo[]');
      inputEquipo.setAttribute('class', 'form__input');
      inputEquipo.setAttribute('placeholder', 'Id equipo');

      var labelCantidad = document.createElement('label');
      labelCantidad.setAttribute('for', 'cant_equipo');
      labelCantidad.setAttribute('class', 'form__label');
      labelCantidad.innerText = 'cantidad equipo';

      var inputCantidad = document.createElement('input');
      inputCantidad.setAttribute('type', 'number');
      inputCantidad.setAttribute('step', '0.00001');
      inputCantidad.setAttribute('name', 'cant_equipo[]');
      inputCantidad.setAttribute('class', 'form__input');
      inputCantidad.setAttribute('placeholder', 'cantidad equipo');


      container.appendChild(labelEquipo);
      container.appendChild(inputEquipo);
      container.appendChild(labelCantidad);
      container.appendChild(inputCantidad);

      containerEquipo.appendChild(container);

  });
}

