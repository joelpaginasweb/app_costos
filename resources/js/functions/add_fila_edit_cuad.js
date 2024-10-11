document.addEventListener('DOMContentLoaded', () => {
  
  // Constantes para el div contenedor de los inputs y el botón de agregar
  const btnCrearCuad = document.querySelector('#boton_crear_fila');
  const conteinerCuad = document.querySelector('#fila_crear');
  
  /**  * Método  clic al botón de agregar elementos  */
  btnCrearCuad.addEventListener('click', e => {
    
    let tr = document.createElement('tr');
    tr.innerHTML = `
    <tr>
    <td  class="form__span" onclick="eliminar(this)">X</td>
    <td><input type="number" step="0" name="id_categoria[]" class="form__input form__input--short select_auto pointer" value=""></td>
    <td>-</td>
    <td>-</td>
    <td> <input type="number" step="0.0001" name="cantidad_mo[]" class="form__input form__input--short select_auto pointer"
    value=""></td>
    <td>0.00</td>
    <td>0.00</td>
    </tr>
    `;
    
    conteinerCuad.appendChild(tr);
  });
  
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




