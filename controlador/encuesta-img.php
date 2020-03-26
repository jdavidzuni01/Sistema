<?php

session_start();
include_once('../modelo/Crud.php');

if (isset($_POST['data_encuesta']) && isset($_POST['id_usuario'])) {
    $datos = json_decode($_POST['data_encuesta']);
    $dataArray = array();
    array_push($dataArray, $_POST['id_usuario']);
    foreach ($datos as $dato) {
        array_push($dataArray, $dato->value);
    }

    if (Crud::insertRespuestaImg($dataArray)) {
        $_SESSION['isEncuestaImg'] = true;
        echo 'si';
    }
} else {
    header('location:../vista/home.php?error=1');
}
?>
