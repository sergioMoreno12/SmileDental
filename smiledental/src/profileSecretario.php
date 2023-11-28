<?php
session_start();
include 'includes/autoloader.inc.php';
$_SESSION['paciente'] = "";
 if(!isset($_SESSION['secretario'])){
 header("location: loginSecretario.php");
 exit();
}else{
if($_SERVER['REQUEST_METHOD']=='POST'){
    $query = new Query();
    $dentist = new Dentist();
    $paciente = new Paciente();

    if (isset($_POST['boton']) && $_POST['boton'] === 'Enviar'){
        $datos = array(
            "nombre" => isset($_POST['nombre']) ? $_POST['nombre'] : '',
            'apellido' => isset($_POST['apellido']) ? $_POST['apellido'] : '',
            'dni' => isset($_POST['dni']) ? $_POST['dni'] : '',
            'colegiado' => isset($_POST['colegiado']) ? $_POST['colegiado'] : '',
            'correo'=> isset($_POST['correo']) ? $_POST['correo'] : '',
            'clave' => isset($_POST['clave']) ? $_POST['clave'] : '',
            'telefono' => isset($_POST['telefono']) ? $_POST['telefono'] : '',
            'especialidad' => isset($_POST['especialidad']) ? $_POST['especialidad'] : ''
        );
        
        if (!empty($datos)) {
            
            $aprobado = true;
            foreach ($datos as $clave => $valor) {
                if (!$query->test_input($valor)) {
                    $aprobado = false;
                    break;
                }
            }

           if($aprobado==true){
            $clave = $datos['clave'];

            $dentist->insertaDentist(
                $datos['nombre'],
                $datos['apellido'],
                $datos['dni'],
                $datos['colegiado'],
                $datos['correo'],
                $clave,
                $datos['telefono'],
                $datos['especialidad']
            );
        
            $id_dentista = $dentist->getId($datos['dni']);
           
           
            if($datos['especialidad'] !== "general"){
                if (isset($_POST['lunes'])) {
                    $dia = 1; // Lunes
                    $horaE = $_POST['horaIL'];
                    $horaS = $_POST['horaFL'];
                    $disponibilidad = new Disponibilidad($id_dentista, $dia, $horaE, $horaS);
                    $disponibilidad->insertDisponibilidad();
                }
                if (isset($_POST['martes'])) {
                    $dia = 2; // Martes
                    $horaE = $_POST['horaIM'];
                    $horaS = $_POST['horaFM'];
                    $disponibilidad = new Disponibilidad($id_dentista, $dia, $horaE, $horaS);
                    $disponibilidad->insertDisponibilidad();
                }
                 
                if (isset($_POST['miercoles'])) {
                    $dia = 3; // Miercoles
                    $horaE = $_POST['horaIX'];
                    $horaS = $_POST['horaFX'];
                    $disponibilidad = new Disponibilidad($id_dentista, $dia, $horaE, $horaS);
                    $disponibilidad->insertDisponibilidad();
                }
                if (isset($_POST['jueves'])) {
                    $dia = 4; // Jueves
                    $horaE = $_POST['horaIJ'];
                    $horaS = $_POST['horaFJ'];
                    $disponibilidad = new Disponibilidad($id_dentista, $dia, $horaE, $horaS);
                    $disponibilidad->insertDisponibilidad();
                }
                if (isset($_POST['viernes'])) {
                    $dia = 5; // Viernes
                    $horaE = $_POST['horaIV'];
                    $horaS = $_POST['horaFV'];
                    $disponibilidad = new Disponibilidad($id_dentista, $dia, $horaE, $horaS);
                    $disponibilidad->insertDisponibilidad();
                }
            }else if($datos['especialidad'] === "general"){
                if($_POST['jornada']==="manana"){
                    $disponibilidad = new Disponibilidad($id_dentista, null, 8, 16);  
                $disponibilidad->insertGeneral();
                }else if($_POST['jornada']==="tarde"){
                    $disponibilidad = new Disponibilidad($id_dentista, null, 13, 21);  
                    $disponibilidad->insertGeneral();
                }
                
               
            }
            header("Location: {$_SERVER['PHP_SELF']}");
            exit;
           }
        }
    
    }else if (isset($_POST['botonB']) && $_POST['botonB'] === 'Enviar') {
        $dni = $query->test_input($_POST['dni']);
        $row = $dentist->selectByDni($dni);
       
        if($row){    
        $dentist = new Dentist();
            $dentist->insertBaja($dni);
            $dentist->deleteDentist($dni);
        
            echo "<script>alert('Dentista eliminado de la tabla, cargado a \"baja dentistas\"');</script>";

        }else{
            echo"<script>Dentista no encontrado</script>";
            header("Location: {$_SERVER['PHP_SELF']}");
            exit;
        }

    }else if(isset($_POST['botonC']) && $_POST['botonC'] === 'Enviar') {
        if(isset($_POST['dniM'])) {
            $dentist1 = new Dentist();
            $query1 = new Query();
            $dni = $query1->test_input($_POST['dniM'])? $_POST['dniM'] : "";
            $modificacion = $_POST['modificacion'];
            $valor = $query1->test_input($_POST['valor'])? $_POST['valor'] : "";
    
            if($modificacion == "clave") {
                $nuevaClave = $_POST['valor'];
                $claveHasheada = password_hash($nuevaClave, PASSWORD_DEFAULT);
                $dentist1->update($dni, $modificacion, $claveHasheada);
            } else {
                $registrado = $dentist1->selectByDni($dni);
                $dentist1->update($dni, $modificacion, $valor);
            }
        } else {
            var_dump($dni, $modificacion, $valor);
        }
    }
    
    
    else if(isset($_POST['paciente']) && $_POST['botonD'] === 'Buscar'){
        $patient = $_POST['paciente'];
        $_SESSION['paciente'] = $patient;
        $resultado = $paciente->searchPacienteBynName($patient);
        if (count($resultado) > 0) {
        header('location: listaPacientes.php');
        exit(); 
    }
    }
    else if(isset($_POST['accion'])){
        $_SESSION=[];
        session_destroy();
        header('Location: loginSecretario.php');
        exit();
    }
    
}
   
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <!--Se puede añadir meta http-equiv="refresh" content="30" se refresca la pagina cada 30 segs-->
     <title>SmileDental - Portal Secretario</title>
     <link rel="icon" type="image/png" href="img/cepillo.png">
     <link rel="stylesheet" href="css/perfiles.css">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid bg-primary">
 <div class="row align-items-center">
    <div class ="col-sm-6 col-md-3 text-center"> <img id="logo" src="img/logo.svg" alt="imagen" onerror="this.src='img/logo.jpg'"></div>
    <div class ="col-sm-6 col-md-9 text-center "> <h1> Área Secretario Smile Dental</h1></div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <input type="hidden" name="accion">
        <input type="submit" value="Volver">
     </form>
 </div>
</div>


<nav class="navbar bg-dark text-center" data-bs-theme="dark">
<div class="container-fluid">
    <a class="navbar-brand" href="#">Menú de Navegación</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="citas.php" target="_blank">Citas</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gestión de Odontólogos
          </a>
          <ul class="dropdown-menu text-center">
            <li><a class="dropdown-item lista" href="#">Alta Odontólogos</a></li>
            <li><a class="dropdown-item lista" href="#">Baja Odontólogos</a></li>
            <li><a class="dropdown-item lista" href="#">Modificación Odontólogos</a></li>
            <li><a class="dropdown-item" href="listaDentistas.php" target="_blank">Ver Todos</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gestión de Pacientes
          </a>
          <ul class="dropdown-menu text-center">
            <li><a class="dropdown-item" href="#">Alta Paciente</a></li>
            <li><a class="dropdown-item lista" href="#">Modificación Paciente</a></li>
            <li><a class="dropdown-item" href="listaPacientes.php" target="_blank">Ver Lista</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="portalSecretario.php">Cerrar Sesión</a>
        </li>
    
      </ul>
    </div>
  </div>
</nav>
 
<section class="principal">
    <!-- ALTA ODONTOLOGO -->
<div class="container-fluid" id="alta">
     <div class="row">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="col-4 mx-auto text-center p-3 rounded-5 d-flex flex-column mt-3 formulario" id="formularioA">
            <h2>Alta Odontólogo</h2>
            <div class="input form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre">
            </div>

            <div class="input form-group">
                <label for="apellido">Apellido</label>
                <input type="text" name="apellido">
            </div>

            <div class="input form-group">
                <label for="dni">Dni</label>
                <input type="text" name="dni">
            </div>

            <div class="input form-group">
                <label for="colegiado">Colegiado nro:</label>
                <input type="text" name="colegiado">
            </div>

            <div class="input form-group">
                <label for="correo">Correo</label>
                <input type="email" name="correo">
            </div>

            <div class="input form-group">
                <label for="clave">Clave</label>
                <input type="text" name="clave">
            </div>

            <div class="input form-group">
                <label for="telefono">Telefono</label>
                <input type="text" name="telefono">
            </div>

            <div class="input form-group">
               <label for="especialidad">Especialidad</label>
               <select name="especialidad" id="especialidad">
               <option hidden selected>Seleccione una</option>
               <option value="general" name="general">General</option>
               <option value="cirugia" name="cirugia">Cirugía</option>
               <option value="endodoncia" name="endodoncia">Endodoncia</option>
               <option value="estetica" name="estetica">Estética</option>
               </select>
            </div>
            <div id="odGral" class="non-visible mt-1 text-center">
                <label for="jornada">Jornada</label>
                <select name="jornada">
                    <option value="manana">Mañana</option>
                    <option value="tarde">Tarde</option>
                </select>
            </div>
            <div id ="odEspecial" class="non-visible">
            <div class="input form-group">
               <label for="lunes">Lunes</label>
               <input type="checkbox" name="lunes" value=1>
               <label for="horaIL">Hora de Entrada</label>
               <select name="horaIL">
                        <?php
                        for($i=8; $i <= 21; $i++){
                            echo"<option value ='".$i."'>".$i.":00</option>";
                        }
                        ?>
                    </select>
                <label for="horaFL">Hora de Salida</label>
                <select name="horaFL">
                        <?php
                        for($i=8; $i <= 21; $i++){
                            echo"<option value ='".$i."'>".$i.":00</option>";
                        }
                        ?>
                    </select>
                     <!--                                              Martes -->
            </div>
            <div class="input form-group">
               <label for="martes">Martes</label>
               <input type="checkbox" name="martes" value=2>
               <label for="horaIM">Hora de Entrada</label>
               <select name="horaIM">
                        <?php
                        for($i=8; $i <= 21; $i++){
                            echo"<option value ='".$i."'>".$i.":00</option>";
                        }
                        ?>
                    </select>
                <label for="horaFM">Hora de Salida</label>
                <select name="horaFM">
                        <?php
                        for($i=8; $i <= 21; $i++){
                            echo"<option value ='".$i."'>".$i.":00</option>";
                        }
                        ?>
                    </select>
                     <!--                                              Miercoles -->
            </div>
            <div class="input form-group">
               <label for="miercoles">Miércoles</label>
               <input type="checkbox" name="miercoles" value=3>
               <label for="horaIX">Hora de Entrada</label>
               <select name="horaIX">
                        <?php
                        for($i=8; $i <= 21; $i++){
                            echo"<option value ='".$i."'>".$i.":00</option>";
                        }
                        ?>
                    </select>
                <label for="horaFX">Hora de Salida</label>
                <select name="horaFX">
                        <?php
                        for($i=8; $i <= 21; $i++){
                            echo"<option value ='".$i."'>".$i.":00</option>";
                        }
                        ?>
                    </select>
                      <!--                                             Jueves -->
            </div>
            <div class="input form-group">
               <label for="Jueves">Jueves</label>
               <input type="checkbox" name="jueves" value=4>
               <label for="horaIJ">Hora de Entrada</label>
               <select name="horaIJ">
                        <?php
                        for($i=8; $i <= 21; $i++){
                            echo"<option value ='".$i."'>".$i.":00</option>";
                        }
                        ?>
                    </select>
                <label for="horaFJ">Hora de Salida</label>
                <select name="horaFJ">
                        <?php
                        for($i=8; $i <= 21; $i++){
                            echo"<option value ='".$i."'>".$i.":00</option>";
                        }
                        ?>
                    </select>
                     <!--                                             Viernes -->
            </div>
            <div class="input form-group">
               <label for="Viernes">Viernes</label>
               <input type="checkbox" name="viernes" value=5>
               <label for="horaIV">Hora de Entrada</label>
               <select name="horaIV">
                        <?php
                        for($i=8; $i <= 21; $i++){
                            echo"<option value ='".$i."'>".$i.":00</option>";
                        }
                        ?>
                    </select>
                <label for="horaFV">Hora de Salida</label>
                <select name="horaFV">
                        <?php
                        for($i=8; $i <= 21; $i++){
                            echo"<option value ='".$i."'>".$i.":00</option>";
                        }
                        ?>
                    </select>
            </div>
            </div>

            <div class="input form-group">
                <input type="submit" value="Enviar" name="boton" id="boton">
            </div>
        </form>
    </div>
</div>
<!-- BAJA DENTISTA -->
<div class="container-fluid" id="baja">
<div class="row">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="col-4 mx-auto text-center p-3 rounded-5 d-flex flex-column mt-3 formulario" id="formularioB">
            <h2>Baja Odontólogo</h2>

            <div class="input form-group">
                <label for="dniM">Dni</label>
                <input type="text" name="dniM">
            </div>

            <div class="input form-group">
                <input type="submit" value="Enviar" name="botonB" id="botonB">
            </div>
        </form>
    </div>
</div>
    
<!-- MODIFICACION DEL Odontólogo -->
<div class="container-fluid" id="modificar">
<div class="row">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method ="POST" class="col-4 mx-auto text-center p-3 rounded-5 d-flex flex-column mt-3 formulario" id="formularioB">
    <h2>Modificación Odontólogo</h2>
    <div class="p-3">
        <div><h3>¿A cuál dentista?</h3>
       <div class="input form-group">

                <label for="dniM">Dni</label>
                <input type="text" name="dniM" id="dniD">
               
        </div>
        </div>
        <div class="mt-3">
        <label for="modifacion">¿Qué desea modificar?</label>
        <select name="modificacion" id="modificacion">
            <option hidden selected>Seleccione una</option>
            <option value="nombre">Nombre</option>
            <option value="apellido">Apellido</option>
            <option value="dni">DNI</option>
            <option value="nro_colegiado">Nro de Colegiado</option>
            <option value="correo">Correo</option>
            <option value= "clave">Clave</option>
            <option value= "telefono">Teléfono</option>
        </select>
        <div id = "cambio"></div>
        <div class="input form-group">
                <label for="valor">Nuevo Valor:</label>
                <input type="text" name="valor">
        </div>
        </div>
       

        <div class="input form-group">
                <input type="submit" value="Enviar" name="botonC" id="botonC">
        </div>

    </div>
    </form>
</div>
</div>

<!-- Modificacion Paciente -->
<div class="container" id="paciente">
        <div class="row">
          <div class="col-4 mx-auto text-center p-3 rounded-5 d-flex flex-column mt-3 formulario">
             <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method= "POST" class="bg-light">
                <div class="select-box">
                    <h2>Modificación del Paciente</h2>
                    <div class="select-option">
                        <input type="text" name="paciente" id="paciente" placeholder="Nombre del Paciente">
                    </div>
                </div>
                <div class="mt-2">
                    <input type="submit" value="Buscar" name="botonD">
                </div>
             </form>
          </div>
        </div>
    </div>
</section>

<script>
 
        const modificacionSelect = document.getElementById('modificacion');
     const valorInput = document.querySelector('input[name="valor"]');

    modificacionSelect.addEventListener("change",function(){
        const selectedOption = modificacionSelect.value;
        if(selectedOption === "clave"){
            valorInput.type = "password";
        }else{
            valorInput.type = "text";
        }
    })

    // SABER SI EL DENTISTA ESTA REGISTRADO

    let dni = document.getElementById("dniD");
    let verifica = document.getElementById("verifica");
    let aviso = document.getElementById("textoDni");
    let registrado = false;


    function validarDNI(dni) {
    const formatoDNI = /^[0-9]{8}[a-zA-Z]$/;
    const formatoNIE =/^[YXYZ]\d{7}[A-Za-z]$/;
    if(formatoDNI.test(dni)){
        return true;
    }else{
        return formatoNIE.test(dni);
    }
} 

    let alta =document.getElementById("alta");
    alta.style.display ="none";

    let baja = document.getElementById("baja");
    baja.style.display ="none";

    let modificar = document.getElementById("modificar");
    modificar.style.display ="none";

    let paciente = document.getElementById("paciente");
    paciente.style.display="none";

    let opciones = [alta, baja, modificar, paciente];

    let lista = document.querySelectorAll(".lista");

    lista.forEach((elemento, index) => {
    elemento.addEventListener("click", function() {
        opciones.forEach((opcion, i) => {
            if (i === index) {
                opcion.style.display = "block";
            } else {
                opcion.style.display = "none";
            }
        });
    });
});


     
</script>
</body>
</html>