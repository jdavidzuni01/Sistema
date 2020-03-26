<?php
include_once('../modelo/Crud.php');
session_start();
echo $_POST['idEA'];
if (isset($_POST['idEA'])){
    if (Crud::defEA($_SESSION['id'],$_POST['idEA'])!=NULL){
        $temp=Crud::getEA($_SESSION['id']);
        $_SESSION['EA']=$temp[0]['EA'];
        header('Location:../vista/home.php?pagina=1');
    }else{
        header('Location:../vista/home.php?pagina=1');
    }
}else{
    header('Location:../vista/home.php?pagina=1');
}