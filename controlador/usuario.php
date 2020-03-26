<?php

session_start();

include_once('../modelo/Crud.php');

if (isset($_POST['tipo']) && isset($_POST['pass'])) {
    if (Crud::login($_POST["tipo"], $_POST["pass"]) == true) {
        $_SESSION['contar']=Crud::contar($_SESSION['id'],$_SESSION['contar']);
        header('location:../vista/home.php');
    } else {
        header('location:../login.php?error=1');
    }
} else if (!isset($_POST['form_id_usuario_adm_ins']) && !isset($_POST['form_id_usuario_adm_upd']) && !isset($_POST['form_id_usuario']) && isset($_POST['email']) && isset($_POST['nombre']) && isset($_POST['usuario']) && isset($_POST['pass']) && isset($_POST['apellido'])) {
    if (Crud::registro($_POST["email"], $_POST["pass"], $_POST["nombre"], $_POST["apellido"], $_POST["usuario"]) == true) {

        header('location:../registro.php?status=1');
    } else {

        header('location:../registro.php?error=1');
    }
} else if (isset($_POST['form_id_usuario'])) {

    if (isset($_POST['email']) && isset($_POST['nombre']) && isset($_POST['usuario']) && isset($_POST['pass']) && isset($_POST['apellido']) && isset($_POST['telefono']) && isset($_POST['fecha_nac']) && isset($_POST['edad'])) {

        if (Crud::updateUsuario($_POST['form_id_usuario'], $_POST['email'], $_POST['pass'], $_POST['nombre'], $_POST['apellido'], $_POST['usuario'], $_POST['telefono'], $_POST['fecha_nac'], $_POST['edad'])) {
            echo "actualizado";
        }
    } else {
        
    }
} else if (isset($_POST['form_id_usuario_adm_upd'])) {

    if (isset($_POST['email']) && isset($_POST['nombre']) && isset($_POST['usuario']) && isset($_POST['pass']) && isset($_POST['apellido']) && isset($_POST['telefono']) && isset($_POST['fecha_nac']) && isset($_POST['edad']) && isset($_POST['rol']) && isset($_POST['estado'])) {

        if (Crud::updateUsuario($_POST['form_id_usuario_adm_upd'], $_POST['email'], $_POST['pass'], $_POST['nombre'], $_POST['apellido'], $_POST['usuario'], $_POST['telefono'], $_POST['fecha_nac'], $_POST['edad'], $_POST['rol'], $_POST['estado'])) {
            header('location:../vista/usuario.php?status=1');
        }
    } else {
        header('location:../vista/form-usuario.php?error=1&id==' . $_POST["form_id_usuario_del_adm"]);
    }
} else if (isset($_POST['form_id_usuario_del_adm'])) {
    if (Crud::updateDeleteUsuario($_POST['form_id_usuario_del_adm'])) {
        header('location:../vista/usuario.php?status=1');
    } else {
        header('location:../vista/form-usuario.php?error=1&id=0&delete=' . $_POST["form_id_usuario_del_adm"]);
    }
} else if (isset($_POST['foto_avatar']) && isset($_POST['avatar_id_usuario'])) {
    if (Crud::updateUsuarioAvatar($_POST['avatar_id_usuario'], $_POST['foto_avatar'])) {
           $_SESSION["foto"]=$_POST['foto_avatar'];
           echo "actualizado";
    } 
} else {
    header('location:../vista/home.php');
}
?>
