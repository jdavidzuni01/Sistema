<?php
include_once('../modelo/Crud.php');
session_start();
echo $_POST['idTI'];
if (isset($_POST['idTI'])){
    if (Crud::defTI($_SESSION['id'],$_POST['idTI'])!=NULL){
        $temp=Crud::getTI($_SESSION['id']);
        $_SESSION['TI']=$temp[0]['TI'];
        header('Location:../vista/home.php?pagina=1');
    }else{
        header('Location:../vista/home.php?pagina=1');
    }
}else{
    header('Location:../vista/home.php?pagina=1');
}