


document.querySelectorAll("#xxxxxx").forEach(function(element) {
  element.addEventListener('click', function() {
    // Obtén la variable PHP desde el atributo data
    const dataAuxi = element.getAttribute('data-auxi');

    // Usa la variable PHP en el contenido del elemento emergente
    document.getElementById("emergente").innerText = dataAuxi;

    // Muestra el elemento emergente
    document.getElementById("emergente").style.display = "block";
  });
});

const emergente = document.getElementById("emergente");
if(emergente) {
  document.getElementById("close").addEventListener('click', function() {
    document.getElementById("emergente").style.display = "none";
  });
}

