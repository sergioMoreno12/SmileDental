<?php
session_start();
include '../src/includes/autoloader.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["dni"])) {
    $dni = $_POST['dni'];
    $paciente = new Paciente();
 
    $infoPaciente = $paciente->alreadyIn($dni);

if ($infoPaciente) {
    $id_paciente = $infoPaciente['id_paciente'];
    $citas = new Cita();
    $fechas = $citas->tieneCitaGeneral($id_paciente);

    echo json_encode(["registrado" => true, "fechas" => $fechas]);
} else {
    echo json_encode(["registrado" => false, "error" => "El paciente no está registrado."]);
}

      
}
