<?php
session_start();
include_once('../modelo/Crud.php');

if (isset($_POST['ins']) && isset($_POST['title']) && isset($_POST['descripcion']) && isset($_POST['tags'])  && isset($_POST['categoria']) && isset($_POST['url']) && isset($_POST['EA']) && isset($_POST['TI'])) {
    if (Crud::insertVideo($_POST['title'],$_POST['descripcion'],$_POST['tags'],$_POST['categoria'],$_POST['url'],$_POST['TI'],$_POST['EA'])) {
        header('location:../vista/video.php?status=1');
    } else {
        header('location:../vista/form-video.php?error=1');
    }
} else if (isset($_POST['form_id_video_adm_upd']) && isset($_POST['title']) && isset($_POST['descripcion']) && isset($_POST['tags']) && isset($_POST['categoria'])  && isset($_POST['url']) && isset($_POST['EA']) && isset($_POST['TI'])) {
    if (Crud::updateVideo($_POST['form_id_video_adm_upd'],$_POST['title'],$_POST['descripcion'],$_POST['tags'],$_POST['categoria'],$_POST['url'],$_POST['TI'],$_POST['EA'])) {
           header('location:../vista/video.php?status=1');
    } else {
      header('location:../vista/form-video.php?error=1&id=' . $_POST["form_id_video_adm_upd"]);
    }
} else if (isset($_POST['form_id_video_adm_del'])) {
    if (Crud::deleteTabla("item","id_item", $_POST["form_id_video_adm_del"]) == true) {
            header('location:../vista/video.php?status=1');
    } else {
     header('location:../vista/form-video.php?error=1&delete=' . $_POST["form_id_video_adm_del"]);  
    }

  
} else {
    header('location:../vista/form-video.php?error=1');
}
?>