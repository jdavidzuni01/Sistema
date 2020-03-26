<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ela Admin - HTML5 Admin Template</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
</head>
<body class="bg-light">

    <?php

include_once('modelo/Crud.php');

if (isset($_GET['status']) && $_GET['status'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Datos almacenados correctamente.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
<?php 
 header( "refresh:3; url=login.php" );   
endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error</strong> Al guardar usuario
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
    
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.php">
                        <img class="align-content" src="images/logo.png" alt="">
                    </a>
                </div>
                <div class="login-form">
                     <form action="controlador/usuario.php" method="POST">
                        <div class="form-group">
                            

<label>NOMBRE COMPLETO</label>
<input type="text" class="form-control" name="nombre" onkeypress="return soloLetras(event)">
                            
<!--                            <label>NOMBRE COMPLETO</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre completo">-->
                        </div>
                          <div class="form-group">
                            <label>GENERO</label>
                            <input type="text" class="form-control" name="apellido" placeholder="Genero" required="">
                        </div>
                          <div class="form-group">
                            <label>USUARIO</label>
                            <input type="text" class="form-control" name="usuario" placeholder="Usuario" required="">
                        </div>
                        <div class="form-group">
                            <label>CORREO</label>
                            <input type="email" class="form-control" name="email" placeholder="Correo" required="">
                        </div>
                        <div class="form-group">
                            <label>CONTRASEÑA</label>
                            <input type="password" id="pass1" class="form-control" name="pass" placeholder="Contraseña" required="">
                        </div>
                          <div class="form-group">
                            <label>CONFIRMAR CONTRASEÑA</label>
                            <input type="password" id="pass2" class="form-control"  placeholder="Confirmar contraseña" required="">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" required=""> Acordar los términos y la política.
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Registrarse</button>
<!--                        <div class="social-login-content">
                            <div class="social-button">
                                <button type="button" class="btn social facebook btn-flat btn-addon mb-3"><i class="ti-facebook"></i>Registrate en facebook</button>
                                <button type="button" class="btn social twitter btn-flat btn-addon mt-2"><i class="ti-twitter"></i>Registrate en twitter</button>
                            </div>
                        </div>-->
                        <div class="register-link m-t-15 text-center">
                            <p>¿Ya tienes cuenta? <a href="login.php"> ir al login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>

      <script>
  
        $("#pass2").keyup(function () {

            if ($("#pass1").val() != "") {

                if ($("#pass1").val() == $("#pass2").val()) {
                    $("#pass2").css("background-color", "white");
                } else {
                    $("#pass2").css("background-color", "red");
                }

            }

        });

        function soloLetras(e){
           key = e.keyCode || e.which;
           tecla = String.fromCharCode(key).toLowerCase();
           letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
           especiales = "8-37-39-46";

           tecla_especial = false
           for(var i in especiales){
                if(key == especiales[i]){
                    tecla_especial = true;
                    break;
                }
            }

            if(letras.indexOf(tecla)==-1 && !tecla_especial){
                return false;
            }
        }


  </script>

</body>
</html>
