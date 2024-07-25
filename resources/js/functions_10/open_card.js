


document.querySelectorAll("#open_card").forEach(function(elemento) {
  elemento.addEventListener('click', function() {
    document.getElementById("card").style.display="block";
  });
});


document.getElementById("close").addEventListener('click', function() {	
  document.getElementById("card").style.display="none";	
});

