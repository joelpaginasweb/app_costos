



document.querySelectorAll("#open").forEach(function(element) {
  element.addEventListener('click', function() {
    document.getElementById("emergente").style.display="block";
  });
});



document.getElementById("close").addEventListener('click', function() {	
  document.getElementById("emergente").style.display="none";	
});