let formulario = document.getElementById("formulario");
const boton = document.getElementById("botonR");
const botonS = document.getElementById("botonS");
setTimeout(function() {

  formulario.style.opacity = "1"; 
}, 1200);

// Agrega un controlador de eventos al elemento close
let iconos = document.querySelectorAll(".icono-vc");

iconos.forEach(function(icono) {
  icono.addEventListener("mouseover", function() {
    const inputElement = icono.previousElementSibling;
    if (inputElement) {
      inputElement.type = "text";
    }
  });
});

iconos.forEach(function(icono) {
  icono.addEventListener("mouseout", function() {
    const inputElement = icono.previousElementSibling;
    if (inputElement) {
      inputElement.type = "password";
    }
  });
});
 
if(document.getElementById("aviso")){
    formulario.style.display="none";
    
}
//-----------PARA COMPROBAR----------//

  function wellName(nombreV){
    var regex = /^[a-zA-Z\s]{3,}$/g;
    return regex.test(nombreV);
  }

  const nombre = document.getElementById("nombre");
  let comNombre = document.getElementById("comNombre");

  nombre.onfocus = function(){
    document.getElementById("messageN").style.display="block";
  }

  nombre.onblur =function(){
    document.getElementById("messageN").style.display="none";
  }
nombre.onkeyup =function(){
   
  var nombreValue = nombre.value;
  var isNameValid = wellName(nombreValue);
  console.log(isNameValid);
    if(isNameValid){
        comNombre.classList.remove("invalid");
        comNombre.classList.add("valid");
        
    }else{
        comNombre.classList.remove("valid");
        comNombre.classList.add("invalid");
        
    }
 }
 //para comprobar el apellido
 const apellido=document.getElementById("apellido");
 let comApellido=document.getElementById("comApellido");
 apellido.onfocus = function(){
    document.getElementById("messageA").style.display="block";
  }

  apellido.onblur =function(){
    document.getElementById("messageA").style.display="none";
  }

  apellido.onkeyup =function(){
    
    var apellidoValue = apellido.value;
    var isLastValid = wellName(apellidoValue);
    console.log(isLastValid);
    if(isLastValid){
        comApellido.classList.remove("invalid");
        comApellido.classList.add("valid");
       
    }else{
        comApellido.classList.remove("valid");
        comApellido.classList.add("invalid");
       
    }
 }

 //para comprobar el dni
 function wellDni(dniV){
  var patronDni=/^\d{8}[a-zA-Z]$/g;
  var patronNie =/^[XYZxyz]\d{7}[A-Za-z]$/g;
  if(patronDni.test(dniV)||patronNie.test(dniV)){
    return true;
  }else {
    return false;
  }

 }

const dni = document.getElementById("dni")
 let comDni =document.getElementById("comDni");

 dni.onfocus = function(){
    document.getElementById("messageD").style.display="block";
  }

  dni.onblur =function(){
    document.getElementById("messageD").style.display="none";
  }

 dni.onkeyup=function(){
  var dniValue = dni.value;
  var dniValid = wellDni(dniValue);
 if(dniValid){
        comDni.classList.remove("invalid");
        comDni.classList.add("valid");
      
    }else{
        comDni.classList.remove("valid");
        comDni.classList.add("invalid");
       
 }
}

function wellPassword(password) {
  var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&*()<>?/\\|}{~:¡¿!?]).{8,}$/;
  // var regex = /^[a-zA-Z0-9@#$%^&*()<>?/\|}{~:!¡¿]{8,}$/;
  return regex.test(password);
}

const myInput = document.getElementById("pass");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var special = document.getElementById("special");
var length = document.getElementById("length");

myInput.onfocus =function(){
    document.getElementById("messageP1").style.display ="block";
}

myInput.onblur = function(){
    document.getElementById("messageP1").style.display ="none";
}

myInput.onkeyup = function(){
  var inputVal = myInput.value;
  var inputValid = wellPassword(inputVal);
    var minuscula = /[a-z]/g;
    if(myInput.value.match(minuscula)){
        letter.classList.remove("invalid");
        letter.classList.add("valid");
    }else{
        letter.classList.remove("valid");
        letter.classList.add("invalid");
    }

    var mayuscula = /[A-Z]/g;
    if(myInput.value.match(mayuscula)){
        capital.classList.remove("invalid");
        capital.classList.add("valid");
    }else{
        capital.classList.remove("valid");
        capital.classList.add("invalid");
    }

    var numero = /[0-9]/g;
    if(myInput.value.match(numero)){
        number.classList.remove("invalid");
        number.classList.add("valid");
    }else{
        number.classList.remove("valid");
        number.classList.add("invalid");
    }

    var especialChar =/[!@#$&?¿¡%()^*ç]/g;
    if(myInput.value.match(especialChar)){
        special.classList.remove("invalid");
        special.classList.add("valid");
    }else{
        special.classList.remove("valid");
        special.classList.add("invalid");
    }

    if(myInput.value.length>=8){
        length.classList.remove("invalid");
        length.classList.add("valid");
    }else{
        length.classList.remove("valid");
        length.classList.add("invalid");
    }
}

/**Para Comprobar que coincidan ambas */
var myInput2 = document.getElementById("pass2");
var passConfirm =document.getElementById("passConfirm");

myInput2.onfocus =function(){
    document.getElementById("messageP2").style.display ="block";
}

myInput2.onblur = function(){
    document.getElementById("messageP2").style.display ="none";
}

myInput2.onkeyup =function(){
    if(myInput2.value === myInput.value){
        passConfirm.classList.remove("invalid");
        passConfirm.classList.add("valid");
    }else{
        passConfirm.classList.remove("valid");
        passConfirm.classList.add("invalid");
    }
}
 if(typeof botonS !== undefined){
  botonS.addEventListener("click",function(event){
    event.preventDefault();
    const nombreValido = wellName(nombre.value);
    const apellidoValido = wellName(apellido.value);
    const dniValido = wellDni(dni.value);
    const passValido = wellPassword(myInput.value);
    const coinciden = myInput2.value === myInput.value; 
  
    if(
      nombreValido &&
      apellidoValido &&
      dniValido&&
      passValido&&
      coinciden){
        formulario.submit();
      }else {
        alert("Por favor complete todas las validaciones");
      }
  })
 }


 //PAra comprobarel telefono 
function wellNumber(numberV){
  var regex = /^\d{9}$/;
  return regex.test(numberV);
}

const telefono = document.getElementById("telefono");
let comT = document.getElementById("comTelefono");
telefono.onfocus = function(){
  document.getElementById("messageT").style.display = "block";
}
telefono.onblur=function(){
  document.getElementById("messageT").style.display = "none";
}

telefono.onkeyup = function(){
  var tlfValue = telefono.value;
  var isTlfValid = wellNumber(tlfValue);
  if(isTlfValid){
    comT.classList.remove("invalid");
    comT.classList.add("valid");
  }else{
    comT.classList.remove("valid");
    comT.classList.add("invalid");
  }
}

//comprobar que es mayor de edad
function wellEdad(age){
const edadNumerica = parseInt(age, 10);
if(isNaN(edadNumerica)){
  return false;
}
if (edadNumerica<17){
return false;
}else{
  return true;
}
}

const edad = document.getElementById("fdn");
var comE = document.getElementById("comFdn");

edad.onfocus = function(){
  document.getElementById("messageF").style.display = "block";
}
edad.onblur=function(){
  document.getElementById("messageF").style.display = "none";
}

edad.onkeyup = function(){
  var edadV = edad.value;
  var edadBien = wellEdad(edadV);
  if(edadBien){
    comE.classList.remove("invalid");
    comE.classList.add("valid");
  }else{
    comE.classList.remove("valid");
    comE.classList.add("invalid");
  }
}

   //PARA COMPROBAR EL CORREO
   function validCorreo(correoV) {
    var patronCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return patronCorreo.test(correoV);
  }
  
  var correo = document.getElementById("correo");
  var comC = document.getElementById("comCorreo");
  
  correo.onfocus = function () {
    document.getElementById("messageC").style.display = "block";
  };
  
  correo.onblur = function () {
    document.getElementById("messageC").style.display = "none";
  };
  
  correo.onkeyup = function(){
    var correoValue = correo.value;
    var wellCorreo = validCorreo(correoValue);
    if (wellCorreo) {
      comC.classList.remove("invalid");
      comC.classList.add("valid");
    } else {
      comC.classList.remove("valid");
      comC.classList.add("invalid");
    }
  }
 


  
boton.addEventListener("click", function(event){
event.preventDefault();
const nombreValido = wellName(nombre.value);
const apellidoValido = wellName(apellido.value);
const telefonoValido = wellNumber(telefono.value);
const dniValido = wellDni(dni.value);
const edadValida = wellEdad(fdn.value);
const edadCorreo = validCorreo(correo.value);
const passValido = wellPassword(myInput.value);
const coinciden = myInput2.value === myInput.value;

console.log("nombreValido: " + nombreValido);
console.log("apellidoValido: " + apellidoValido);
console.log("telefonoValido: " + telefonoValido);
console.log("dniValido: " + dniValido);
console.log("edadValida: " + edadValida);
console.log("edadCorreo: " + edadCorreo);
console.log("passValido: " + passValido);
console.log("coinciden: " + coinciden);

if(nombreValido &&
  apellidoValido &&
  telefonoValido&&
  dniValido&&
  edadValida&&
  edadCorreo&&
  passValido&&
  coinciden){
    formulario.submit();
  }else {
    alert("Por favor complete todas las validaciones");
  }
})


