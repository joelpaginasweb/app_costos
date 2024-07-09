
document.getElementById("excel-input").addEventListener("dblclick", function() {
  this.disabled = false; // Habilitar el input al hacer doble clic
});

document.getElementById("excel-input").addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    event.preventDefault(); // Evitar el comportamiento predeterminado del Enter
    // Aquí puedes enviar el dato ingresado al servidor
    this.disabled = true; // Deshabilitar el input después de enviar el dato
  }
});