<?php
session_start();
include '../src/includes/autoloader.inc.php';
if($_SERVER['REQUEST_METHOD']==='POST'&& isset($_POST["id_dentista"])){
    $id= $_POST['id_dentista'];
    $cita = new Cita();
    $horasDisponibles = $cita->getHoraEntradaYSalida($id);
    echo json_encode($horasDisponibles);
}else{
    json_encode(["error" => "No se proporcionó la fecha en la solicitud."]);
}