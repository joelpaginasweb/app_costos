var botones = document.getElementsByClassName("display_action");
var elementos = document.getElementsByClassName("element_display");

for (let i = 0; i < botones.length; i++) {
    botones[i].addEventListener("click", function() {
        elementos[i].style.display = (elementos[i].style.display === "none" || elementos[i].style.display === "") ? "block" : "none";
    });
}