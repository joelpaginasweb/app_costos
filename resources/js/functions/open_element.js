

document.querySelectorAll("#open").forEach(function(element) {
  element.addEventListener('click', function() {
    document.getElementById("emergente").style.display="block";
  });
});
    
  const emergente = document.getElementById("emergente");
  if(emergente) {
    document.getElementById("close").addEventListener('click', function() {	
      document.getElementById("emergente").style.display="none";	
    });
  }