<?php
include '../src/includes/autoloader.inc.php';
session_start();
if($_SERVER['REQUEST_METHOD']==='GET'&& isset($_GET['fecha'])){
    $fecha = $_GET['fecha'];
    $cita = new Cita();
    $horasDisponibles = $cita->getHorasDisponibles($fecha);
    echo json_encode($horasDisponibles);
}else{
    json_encode(["error" => "No se proporcionó la fecha en la solicitud."]);
}


