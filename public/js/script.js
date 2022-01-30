/* Parametric function */

/* 1 - Toggle the actual class of the target element e to the switch class */
function toggleTarget(e, actualClass, switchClass){
    var x = document.getElementById(e);
    x.classList.toggle(actualClass);
    x.classList.toggle(switchClass);
}

/* 2 - Toggle the actual class of the this element to the switch class */
function toggleThis(e, actualClass, switchClass){
    e.classList.toggle(actualClass);
    e.classList.toggle(switchClass);
}

/* 3 - Toggle the actual class of 2 target element (e1 & e2) to the switch class */
function dualToggleTarget(e1,e2,actualClass, switchClass){
    var x = document.getElementById(e1);
    var y = document.getElementById(e2);
    x.classList.toggle(actualClass);
    y.classList.toggle(actualClass);
    x.classList.toggle(switchClass);
    y.classList.toggle(switchClass);
}

// Comment faire pour faire un grand changement de class
function toggleClass(actualClass){

}

/* Dark mode */

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