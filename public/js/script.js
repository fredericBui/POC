function displayNoneMenu(){
    var x = document.getElementById("navtoggle");
    if (x.style.display === "none") {
        x.style.display = "grid";
    } else {
        x.style.display = "none";
    }
}

function displayNoneProfil(){
    var x = document.getElementById("navprofil");
    if (x.style.display === "none") {
        x.style.display = "grid";
    } else {
        x.style.display = "none";
    }
}

function turnRed(e) {
    if (e.style.color === "lightgray") {
        e.style.color = "red";
    } else {
        e.style.color = "lightgray";
    }
}

function darkMode(){
    var x = document.getElementById("navstable");
    var y = document.getElementById("footer");
    x.classList.toggle("lightNav");
    y.classList.toggle("lightNav");
    x.classList.toggle("darkNav");
    y.classList.toggle("darkNav");
    // ligne ci-dessous à modifier
    document.body.style.backgroundColor="grey";
}