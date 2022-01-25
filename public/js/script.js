function myFunction() {
var x = document.getElementById("navtoggle");
if (x.style.display === "none") {
    x.style.display = "grid";
} else {
    x.style.display = "none";
}
}

//Marche pas
function click() {
alert("Hello");
}

const heart = document.querySelector('.fa-heart');

heart.addEventListener('click', event => {
if (heart.style.color === "lightgray") {
    heart.style.color = "red";
} else {
    heart.style.color = "lightgray";
}
});