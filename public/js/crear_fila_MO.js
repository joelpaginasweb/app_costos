function crearFilaMO(){
  const containerMO = document.querySelector('#container_mo');//

  var container = document.createElement('div');//
  container.setAttribute('class', 'container');//

  var labelMO = document.createElement('label');//
  labelMO.setAttribute('for', 'id_mano_obra');
  labelMO.setAttribute('class', 'form__label');
  labelMO.innerText = 'Id mano de obra';

  var inputMO = document.createElement('input');//
  inputMO.setAttribute('type', 'number');
  inputMO.setAttribute('step', '0');
  inputMO.setAttribute('name', 'id_mano_obra[]');
  inputMO.setAttribute('class', 'form__input');
  inputMO.setAttribute('placeholder', 'Id mano de obra');

  var labelCantidadMO = document.createElement('label');//
  labelCantidadMO.setAttribute('for', 'cant_mano_obra');
  labelCantidadMO.setAttribute('class', 'form__label');
  labelCantidadMO.innerText = 'cantidad M.O.';

  var inputCantidadMO = document.createElement('input');
  inputCantidadMO.setAttribute('type', 'number');
  inputCantidadMO.setAttribute('step', '0.00001');
  inputCantidadMO.setAttribute('name', 'cant_mano_obra[]');
  inputCantidadMO.setAttribute('class', 'form__input');
  inputCantidadMO.setAttribute('placeholder', 'cantidad MO');

  container.appendChild(labelMO);//
  container.appendChild(inputMO);//
  container.appendChild(labelCantidadMO);//
  container.appendChild(inputCantidadMO);//

  containerMO.appendChild(container);
}

document.getElementById('boton_crear_mo').addEventListener('click', function() { 
  crearFilaMO();
});