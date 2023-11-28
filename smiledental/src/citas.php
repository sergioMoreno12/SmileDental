<?php
session_start();
include 'includes/autoloader.inc.php';
if(!isset($_SESSION['secretario'])){
  header("location: loginSecretario.php");
  exit();}
if($_SERVER['REQUEST_METHOD'] === "POST"){
    $query = new Query();
    $paciente = new Paciente();
    $cita = new Cita();
    if(isset($_POST['registro-emergencia'])){
        $dni = $query->test_input($_POST['dni-emergencia'])? $_POST['dni-emergencia']:"";
        $id_paciente = $paciente->alreadyIn($dni)['id_paciente'];
        $fecha = $_POST['fecha-emergencia'];
        $value= $_POST['drCita'];
        $mapaDentistas = array(
        'Sergio' => 40,
        'Jessi' => 41,
        'Giova' => 42,
        'Emma' => 43
        );
        $id_dentista = $mapaDentistas[$value];
        $hora = $_POST['hora-cita'];
       

        $insercion = $cita->insertCita($id_paciente, $id_dentista, $fecha, $hora);
        if($insercion){
            echo "<script> alert('Cita Reservada') </script>";
        }else{
            var_dump($id_dentista);
            echo "<script> alert('Error') </script>";
         }

    }
    else if(isset($_POST['reservar'])){
        $paciente = new Paciente();
        $dni = $_POST['dni'];
        $id_paciente = $paciente->alreadyIn($dni)['id_paciente'];
        $mapaEspecialidades = array(
            'endodoncia' => 46,
            'cirugia' => 44,
            'estetica' => 45
        );
        $valor = $_POST['tipo'];
        $id_dentista = $mapaEspecialidades[$valor];
        $fecha = $_POST['fecha-cita'];
        $hora = $_POST['hours'];
        $cita = new Cita();
        $cita->insertCita($id_paciente,$id_dentista,$fecha,$hora);
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <title>SmileDental - Gestión de Citas</title>
    <link rel="icon" type="image/png" href="img/cepillo.png">
    <link rel="stylesheet" href="css/perfiles.css">
    <script src="javascript/citas.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid bg-primary">
 <div class="row align-items-center">
    <div class ="col-sm-6 col-md-3 text-center"> <img id="logo" src="img/logo.svg" alt="imagen" onerror="this.src='img/logo.jpg'"></div>
    <div class ="col-sm-6 col-md-9 text-center "> <h1> Área Secretario Smile Dental</h1><p>Citas</p></div>
 </div>
</div>
<nav class="navbar bg-dark text-center" data-bs-theme="dark">
<div class="container-fluid text-center">
    <a class="navbar-brand " href="#">Menú de Navegación</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active lista" aria-current="page" href="#">Nueva Cita</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active lista" aria-current="page" href="#">Citas por Paciente</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active lista" aria-current="page" href="#">Citas por Fecha</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<section class ="principal">
    <div id="main-citas">
    <div class="container-fluid">
    <div class="row justify-content-center">
       <div class="col-md-4 bg-light mt-4">
        <h3>Registro de Citas de Emergencia</h3>
        <p>En caso de que llegue un paciente de emergencia, debe seguir el siguiente proceso:</p>
        <ul> 
            <li>Se puede registrar retroactivamente</li>
            <li>Registrar al paciente en <a href="register.php" target="_blank" class="primary">este enlace</a> si no estuviera registrado</li>
            <li>La contraseña será en estos casos: 'nombrePaciente01!!', luego él podrá cambiarla</li>
            <li>Rellene los datos de la cita:</li>
        </ul>
        <form action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="text-center">
            <h4>Datos de la cita</h4>
            <div class="input mb-2" id="first">
                <label for="fecha-cita">Fecha de la cita</label>
                <input type="date" name="fecha-emergencia" id="fecha-emergencia">
                <p id ="avisoFecha"></p>
            </div>
            <div class="input mt-2" id="second">
                <label for="dni-emergencia">DNI del paciente:</label>
                <input type="text" name="dni-emergencia" id="dni-emergencia">
            </div>
            <div class="mt-2" id ="third">
                <label for="hora-cita">Hora Cita:</label>
                <select name="hora-cita" id="hora-cita">
                    <?php
                    for($i = 8; $i < 21; $i++){
                        echo "<option class='h-cita' value=".$i.">".$i.":00 </option>";
                    }
                    ?>
                </select>
            </div>
            <div class="input" id="fourth">
                  <label for="dr-cita">Atendido por:</label>
                  <select name="drCita" id="dr-cita">
                    <option value="Sergio" class="dCita">Sergio M</option>
                    <option value="Jessi" class="dCita">Jessica L</option>
                    <option value="Giova" class="dCita">Giovanni A</option>
                    <option value="Emma" class="dCita">Emmanuel G</option>
                  </select>
            </div>
            <div class="input mb-2" id="fifth">
                <input type="submit" value="Registrar Cita" name="registro-emergencia">
            </div>
        </form>
       </div>
    </div>
</div>


<div class="container-fluir">
    <div class="row justify-content-center text-center">
     <div class="col-md-4">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="mt-4 p-3 bg-light">
        <h3>Cita de especialista</h3>
         <div class="input">
          <label for="dni">DNI:</label>
          <input type="text" name="dni" id="dni" placeholder="Dni del paciente">
            <div>
             <button id = "verificar-form" class="mt-2">Verificar</button>
            </div>
            <p id = "resultado" ></p>
          </div>
          <div id ="espec">
          <div class="mt-2" id="menu-especialidades">
            <select name="tipo" id="tipo">Especialidad
                <option hidden selected>Seleccione una</option>
                <option value="endodoncia" name=46>Endodoncia</option>
                <option value="cirugia" name = 44>Cirugía</option>
                <option value="estetica" name = 45>Estética</option>
            </select>
          </div>
          <div>
            <label for="dia" class="mt-2">Seleccione un día</label>
             <select name="dia" id="dia">
                <option hidden selected>Seleccione una</option>
                <option class = "dias"></option>
                <option class = "dias"></option>
             </select>
          </div>
          <div id="fecha" class="mt-1">
             <label for="fecha-cita">Seleccione la fecha:</label>
             <input type="date" name="fecha-cita" id="fecha-cita">
            <p id ="aviso"></p>
          </div>
          <div>
             <label for="hora">Seleccione la hora</label>
             <select name="hours" id="hours"></select>
          </div>
           <input type="submit" value="reservar" name ="reservar"class="p-1 m-2">
          </div>
        </form>
     </div>
    </div>
</div>
    </div>
    <div id="main-pacientes">
      <div class="container-fluid">
        <div class="row justify-content-center text-center">
         <div class="col-md-4 bg-light mt-4">
           <h2>Buscador de Citas por DNI de paciente registrado</h2>
           <div>
            <label for="dni-paciente">DNI del paciente</label>
            <input type="text" name="dni-paciente" id="dniMainPacientes">
            <button id ="verificaMainPacientes">Verificar</button>
            <p id="parrafoVerifica"></p>
           </div>
           <div id ="tabla" class="d-flex justify-content-center align-items-center">
              <div id="contenedorTabla">

              </div>
           </div>
        </div>
       </div>
      </div>
    </div>

    <div id="main-fechas">
      <div class="container-fluid">
        <div class="row justify-content-center text-center">
         <div class="col-md-4 bg-light mt-4">
           <h2>Buscador de citas por fecha</h2>
           <div>
                    <label for="dateApp">Fecha:</label>
                    <input type="date" name="" id="dateApp">
                    <button id="lookUpForDate">Verificar</button>
                    <p id="parrafoFecha"></p>
            </div>
            <div id ="tablaFecha" class="d-flex justify-content-center align-items-center">
                 <div id="contenedorTablaFecha"></div>
            </div>
        </div>
       </div>
      </div>
    </div>
    
</section>

</body>
</html>