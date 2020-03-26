<?php
include_once("../modelo/Crud.php");

if (isset($_POST['idEA'])){
    $idEA = $_POST['idEA'];
    $res = Crud::getGroup($idEA);
    echo $res[0]['asocTI'];
}