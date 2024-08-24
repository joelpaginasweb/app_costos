// --------- resources

/**
 * Método para eliminar el div contenedor del input *  *  
 * @param {this} e 
 */
const eliminar = (e) => {
  const divPadre = e.parentNode;
  while (divPadre.firstChild) {
      divPadre.firstChild.remove();
  }
  divPadre.remove();
};


