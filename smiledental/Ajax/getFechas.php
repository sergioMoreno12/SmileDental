<?php
session_start();
include '../src/includes/autoloader.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["fecha"])) {
    $fecha = $_POST['fecha'];
    $citas = new Cita();
    $fechas = $citas->getDisponibildad($fecha);
    if($fecha){
        echo json_encode(["registrado" => true, "fechas" => $fechas]);
    }
     else {
    echo json_encode(["registrado" => false, "error" => "El paciente no está registrado."]);
}

      
}