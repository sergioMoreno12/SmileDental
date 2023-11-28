<?php
session_start();
include 'includes/autoloader.inc.php';
$hours = new Hora();
$cita = new Cita();
$fecha = "2023-11-30";
$hora = 8;
$dentistasDisponibles=[];
// $horasO = $cita->getHorasOcupadas($fecha);
// var_dump($horasO);

$citasOcupadas = $hours->revisaCitas($fecha, $hora);
var_dump($citasOcupadas);
echo"EL OTRO ARRAY";
$odontologos = $hours->getIdGeneral($hora);

var_dump($odontologos);
$dentistasDisponibles = array_diff($odontologos, $citasOcupadas);
echo"Dentista--->";
var_dump($dentistasDisponibles);