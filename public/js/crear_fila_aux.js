function crearFilaAux (){
  const containerAux = document.querySelector('#container_aux');

  var container = document.createElement('div');
  container.setAttribute('class', 'container');

  var labelMaterialAux = document.createElement('label');
  labelMaterialAux.setAttribute('for', 'id_material');
  labelMaterialAux.setAttribute('class', 'form__label');
  labelMaterialAux.innerText = 'Id material';

  var inputMaterialAux = document.createElement('input');
  inputMaterialAux.setAttribute('type', 'number');
  inputMaterialAux.setAttribute('step', '0');
  inputMaterialAux.setAttribute('name', 'id_material[]');
  inputMaterialAux.setAttribute('class', 'form__input');
  inputMaterialAux.setAttribute('placeholder', 'id material');

  var labelCantidadAux = document.createElement('label');
  labelCantidadAux.setAttribute('for', 'cantidad_mater');
  labelCantidadAux.setAttribute('class', 'form__label');
  labelCantidadAux.innerText = 'cantidad material';

  var inputCantidadAux = document.createElement('input');
  inputCantidadAux.setAttribute('type', 'number');
  inputCantidadAux.setAttribute('step', '0.0001');
  inputCantidadAux.setAttribute('name', 'cantidad_mater[]');
  inputCantidadAux.setAttribute('class', 'form__input');
  inputCantidadAux.setAttribute('placeholder', 'cantidad material'); 
  
  container.appendChild(labelMaterialAux);
  container.appendChild(inputMaterialAux);
  container.appendChild(labelCantidadAux);
  container.appendChild(inputCantidadAux);
  
  containerAux.appendChild(container);
}

document.getElementById('boton_crear_aux').addEventListener('click', function() { 
  crearFilaAux(); 
});

// /-------------------------------------------

// function ajax(){
//   const http = new XMLHttpRequest();
//   const url  = 'http://localhost/pag-react-fetch/pagina.html';

//   http.onreadystatechange = function(){
//   if(this.readyState == 4 && this.status == 200){
//     console.log(this.responseText);
//     document.getElementById("response").innerHTML = this.responseText;
//   }
//   }
//   http.open("GET", url);
//   http.send();   
// }

// document.getElementById("boton").addEventListener("click", function(){
// ajax();
// });

