
const altaD = document.getElementById("altaD");
const bajaD = document.getElementById("bajaD");
const formularioAD = document.getElementById("formularioA");
const formularioBD = document.getElementById("formularioB");

function muestraAlta(){
  formularioAD.style.display ="block";
}
    
altaD.addEventListener("click", muestraAlta);

var especialidad = document.getElementById("especialidad");
var general = document.getElementById("odGral");
var especial = document.getElementById("odEspecial");

especialidad.addEventListener("change",function(){
var valor = especialidad.value;
if(valor === "general"){
  general.classList.remove("non-visible");
  general.classList.add("visible");
  especial.classList.remove("visible");
  especial.classList.add("non-visible");
}else if(valor === "cirugia"||valor === "estetica"|| valor === "endodoncia"){
  especial.classList.remove("non-visible");
  especial.classList.add("visible");
    general.classList.remove("visible");
    general.classList.add("non-visible");
  
}
});

