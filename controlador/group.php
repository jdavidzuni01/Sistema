<?php
include_once('../modelo/Crud.php');
if (isset($_POST['idEA']) && isset($_POST['nameEA']) && isset($_POST['asocTI'])){

    if (Crud::updateGroup($_POST['idEA'],$_POST['nameEA'],$_POST['asocTI'])){
        header('Location:../vista/group.php?status=1');
    }else{
        header('Location:../vista/group.php?status=0');
    }

}else{

    header('Location:../vista/group.php?status=0');

}