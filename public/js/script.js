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
    var y = document.getElementById("footer");
    var z = document.getElementById("navtoggle");
    var o = document.getElementById("navprofil");
    y.classList.toggle("lightNav");
    y.classList.toggle("darkNav");
    z.classList.toggle("lightSubNav");
    z.classList.toggle("darkSubNav");
    o.classList.toggle("lightSubNav");
    o.classList.toggle("darkSubNav");
    // ligne ci-dessous à modifier
    document.body.classList.toggle("lightBody");
    document.body.classList.toggle("darkBody");
    document.p.style.color = "#545454";
}

// PAR DEFAUT //

// Nav
var navprofil = document.getElementById("navprofil");
navprofil.style.display="none";

var mainNavMobile = document.getElementById("mainNavMobile");
mainNavMobile.style.display="none";



// EVENEMENTS

// Nav
var logoProfil = document.getElementById("logoProfil");
logoProfil.onclick = toggleDisplayNav;

function toggleDisplayNav(){ 
    if(navprofil.style.display=="none"){
        navprofil.style.display="block";
    }else{
        navprofil.style.display="none";
    }
}

var burgerButton = document.getElementById("burgerButton");
burgerButton.onclick = toggleDisplayNavMobile;

function toggleDisplayNavMobile(){ 
    if(mainNavMobile.style.display=="none"){
        mainNavMobile.style.display="block";
    }else{
        mainNavMobile.style.display="none";
    }
}