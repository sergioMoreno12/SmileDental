<?php

include 'includes/autoloader.inc.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../src/javascript.js" defer></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="img/cepillo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Registro Secretario SmileDental</title>
    <script src="javascript.js" defer></script>
</head>
<body>
   
    <header class="cabecera">
        
        <div class="header itself">
            <div class ="column side">
                <img id="logo" src="img/logo.svg" alt="imagen" onerror="this.src='img/logo.jpg'">
            </div>
            <div class ="column main">
                <h1 class="titulo">SmileDental</h1>
                <span>Siempre lo mejor</span>
            </div>
        </div>
    </header>
    <section class="principal">
        <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="form" id="formulario" name="formulario" required>
            <h1 class = tituloForm>Registro Secretario SmileDental</h1>

            <fieldset><h3 class="mb-1 text-center">Información Personal</h2></fieldset>

              <div class = "input">
                <label for="nombre" class="letras">Introduce tu nombre</label>
                <input type="text" name="nombre" id="nombre"required>
                <div class="message" id="messageN">
                 <h5>Solo se admiten letras</h5>
                 <p id="comNombre" class="invalid"><b>Ok</b></p>
                </div>
                </div>

                <div class = "input">
                <label for="apellido" class="letras">Introduce tu apellido</label>
                <input type="text" name="apellido" id="apellido" required>
                <div class="message" id="messageA">
                 <h5>Solo se admiten letras</h5>
                 <p id="comApellido" class="invalid"><b>Ok</b></p>
                </div>
                </div>


                <div class = "input">
                <label for="dni" class="letras">Introduce tu DNI/NIE</label>
                <input type="text" name="dni" id="dni"required>
                <div class="message" id="messageD">
                 <h5>Solo se admite formato DNI/NIE</h5>
                 <p id="comDni" class="invalid"><b>Ok</b></p>
                 </div>
                </div>

                <div class = "input">
                <label for="clave" class="letras">Introduce tu contraseña</label>
                <input type="password" name="clave" class="pass"required id="pass">
                <img src="img/ver.png" alt="mostrar" class="icono-vc">
                <div class="message" id="messageP1">
                <h5>La contraseña debe contener:</h5>
                <p id="letter" class="invalid">Una <b>minúscula</b></p>
                <p id="capital" class="invalid">Una <b>mayúscula</b></p>
                <p id="number" class="invalid">un <b>número</b></p>
                <p id="special" class="invalid">Mínimo<b> un caracter especial !@#$&?¿¡%()^*ç</b></p>
                <p id="length" class="invalid">Mínimo <b>8 caracteres</b></p>
                </div>
                </div>

                <div class = "input">
                <label for="clave1" class="letras">Confirma tu contraseña</label>
                <input type="password" name="clave1" class="pass"required id="pass2" >
                <img src="img/ver.png" alt="mostrar" class="icono-vc">
                <div class="message" id="messageP2">
                 <h5>Ambas contraseñas deben coincidir</h5>
                 <p id="passConfirm" class="invalid">Sí <b>coinciden</b></p>
                </div>
                </div>
                
                <input type="submit" value="login" id ="botonS">
                
<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
 
    try {
        $user = new Secretario();
        $nombre = $user->test_input(@$_POST['nombre']);
        $apellido = $user->test_input(@$_POST['apellido']);
        $email = "secretario@smiledental.com";
        $dni = $user->test_input(@$_POST['dni']);
        $pass = $user->test_input(@$_POST['clave']);
        $telefono = "655194518";
        $registro = $user->setSecretario($nombre, $apellido, $dni, $email, $pass, $telefono);
        
        if ($registro) {
            echo "<script> alert('Registro exitoso') </script>";
            echo "<script>setTimeout(function() {
                window.location.href = 'portalSecretario.php';
            }, 500);</script>";
           
        } else {
            echo "<script> alert('Registro fallido, cargo ya existente, será redirigido') </script>";
            echo "<script>setTimeout(function() {
                window.location.href = 'index2.html';
            }, 500);</script>";
        }
    } catch (PDOException $e) {
        echo "Error en la inserción: " . $e->getMessage();
    }
}
?>
        </form>

   </section>

</body>
</html>