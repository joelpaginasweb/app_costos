
// Constantes para el div contenedor de los inputs y el botón de agregar
const btnCrearTr = document.querySelector('#boton_crear_tr');
const conteinerAux = document.querySelector('#crea_element');

/**  * Método  clic al botón de agregar elementos  */
btnCrearTr.addEventListener('click', e => {

  let tr = document.createElement('tr');
  tr.innerHTML = `
    <tr>
      <td  class="form__span" onclick="eliminar(this)">X</td>
      <td><input type="number" step="0" name="id_material[]" class="form__input form__input--short select_auto pointer"
      value="Id Material"></td>
      <td>-</td>
      <td>-</td>
      <td> <input type="number" step="0.0001" name="cantidad_mater[]" class="form__input form__input--short select_auto pointer"
      value="{{$concepto->cantidad}}"></td>
      <td>0.00</td>
      <td>0.00</td>
    </tr>
  `;

  conteinerAux.appendChild(tr);
});




// const spanBorrarInput = document.getElementById('borrar_input');
// if(spanBorrarInput) {

//   spanBorrarInput.addEventListener('click', function() {
//     const eliminar = (e) => {
//       const divPadre = e.parentNode;
//       while (divPadre.firstChild) {
//           divPadre.firstChild.remove();
//       }
//       divPadre.remove();
//     };

//   });
// }




