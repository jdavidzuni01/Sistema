<?php
include_once('../layout/Header.php');
include_once('../layout/Body.php');
include_once('../modelo/Crud.php');

$idUsuario = $_SESSION["id"];
$usuario = Crud::getAllUsuario($idUsuario);

$encuestas = Crud::getAllEncuestasUsuario($idUsuario);
$strEncuestas = "";
foreach ($encuestas as $encuesta) {
    $strEncuestas .= "" . $encuesta['id_encuesta'] . "|";
}


if (count($usuario) == 0) {
    header('location:../login.php');
}
?>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Inicio</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Inicio</a></li>
                            <li class="active">Perfil</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-user"></i><strong class="card-title pl-2">Pefil</strong>
                    </div>
                    <div class="card-body">
                        <div class="mx-auto d-block">
                            <?php if ($usuario[0]["foto"]!="0") { ?>
                            <img class="rounded-circle mx-auto d-block" width="100" src="<?php echo $usuario[0]["foto"]; ?>" >
                            <?php } ?>

                            <?php if ($usuario[0]["foto"]=="0") { ?>
                                <img class="rounded-circle mx-auto d-block" src="../images/user.png" >
                            <?php } ?>
                            <h5 class="text-sm-center mt-2 mb-1"><?php echo $usuario[0]["nombre"] . " " . $usuario[0]["apellido"]; ?></h5>


                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <a href="#"> <i class="fa fa-user"></i><?php echo " " . $usuario[0]["usuario"]; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#"> <i class="fa fa-envelope-o"></i><?php echo " " . $usuario[0]["email"]; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#"> <i class="fa fa-phone"></i><?php echo " " . $usuario[0]["telefono"]; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#"> <i class="fa fa-calendar"></i><?php echo " " . $usuario[0]["fecha_nac"]; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#"> <i class="fa fa-asterisk"></i><?php echo " " . $usuario[0]["edad"]; ?></a>
                                </li>
                            </ul>


                        </div>

                    </div>
                </div>
                <hr>
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-user"></i><strong class="card-title pl-2">Actualizar avatar</strong>
                    </div>
                    <div class="card-body">
                        <div class="mx-auto d-block">


                            <div class="card-deck">
                                <div class="card">
                                    <img src="../images/user-avatar/user1.png" class="card-img-top" alt="...">
                                    <div class="card-footer">
                                        <small class=""><input type="radio" class="radio-avatar" name="radio-avatar"  value="../images/user-avatar/user1.png" ></small>
                                    </div>
                                </div>
                                <div class="card">
                                    <img src="../images/user-avatar/user2.png" class="card-img-top" alt="...">

                                    <div class="card-footer">
                                        <small class=""><input type="radio" class="radio-avatar" name="radio-avatar" value="../images/user-avatar/user2.png" ></small>
                                    </div>
                                </div>
                                <div class="card">
                                    <img src="../images/user-avatar/user3.png" class="card-img-top" alt="...">
                                    <div class="card-footer">
                                        <small class=""><input type="radio" class="radio-avatar" name="radio-avatar"  value="../images/user-avatar/user3.png" ></small>
                                    </div>
                                </div>
                            </div>


                            <div class="card-deck">
                                <div class="card">
                                    <img src="../images/user-avatar/user4.png" class="card-img-top" alt="...">
                                    <div class="card-footer">
                                        <small class=""><input type="radio" class="radio-avatar" name="radio-avatar"  value="../images/user-avatar/user4.png" ></small>
                                    </div>
                                </div>
                                <div class="card">
                                    <img src="../images/user-avatar/user5.png" class="card-img-top" alt="...">

                                    <div class="card-footer">
                                        <small class=""><input type="radio" class="radio-avatar" name="radio-avatar"  value="../images/user-avatar/user5.png" ></small>
                                    </div>
                                </div>
                                <div class="card">
                                    <img src="../images/user-avatar/user6.png" class="card-img-top" alt="...">
                                    <div class="card-footer">
                                        <small class=""><input type="radio" class="radio-avatar" name="radio-avatar" value="../images/user-avatar/user6.png" ></small>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="card-text text-sm-center">
                            <a href="#"><i class="fa fa-facebook pr-1"></i></a>
                            <a href="#"><i class="fa fa-twitter pr-1"></i></a>
                            <a href="#"><i class="fa fa-linkedin pr-1"></i></a>
                            <a href="#"><i class="fa fa-pinterest pr-1"></i></a>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm" onclick="updateAvatar()">Actualizar</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-user"></i><strong class="card-title pl-2">Actualizar perfil</strong>
                    </div>
                    <div class="card-body">
                        <div class="card-text text-sm-center">
                            <div class="card-body card-block">

                                <form action="#" method="post" class="">

                                    <div class="form-group">
                                        <label class=" form-control-label">Nombre</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-edit"></i></div>
                                            <input class="form-control"  id="nombre"  type="text" value="<?php echo $usuario[0]["nombre"]; ?>" required="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class=" form-control-label">Apellido</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-edit"></i></div>
                                            <input class="form-control"  id="apellido" type="text" value="<?php echo $usuario[0]["apellido"]; ?>" required="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class=" form-control-label">Usuario</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                            <input class="form-control"  id="usuario" type="text" value="<?php echo $usuario[0]["usuario"]; ?>" required="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class=" form-control-label">Correo</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                                            <input class="form-control" id="email"  type="email" value="<?php echo $usuario[0]["email"]; ?>" required="">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class=" form-control-label">Contraseña</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-ellipsis-h"></i></div>
                                            <input class="form-control" id="pass1"  type="password" value="000" required="">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class=" form-control-label">Confirmar contraseña</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-ellipsis-h"></i></div>
                                            <input class="form-control" id="pass2" type="password" value="000" required="">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class=" form-control-label">Telefono</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                            <input class="form-control" id="telefono" type="text" value="<?php echo $usuario[0]["telefono"]; ?>">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class=" form-control-label">Fecha nacimiento</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input class="form-control" type="date" id="fecha_nac" value="<?php
                                            if (is_null($usuario[0]["fecha_nac"])) {
                                                echo date("Y-m-d", strtotime($usuario[0]["fecha_nac"]));
                                            } else {
                                                echo date("Y-m-d");
                                            }
                                            ?>">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class=" form-control-label">Edad</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                                            <input class="form-control" type="number" id="edad" value="<?php echo $usuario[0]["edad"];
                                            ?>">
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div class="form-actions form-group"><button type="submit"   class="btn btn-success btn-sm">Actualizar</button></div>
                        </form>
                    </div>

                </div>
            </div>



           

    <div class="clearfix"></div>


    <?php
    include_once('../layout/Footer.php');
    ?>


    <script>

        $("form").submit(function (e) {
            e.preventDefault();
            actualizarDatos();
        });


        function updateAvatar() {

            if ($(".radio-avatar").is(':checked')) {
                $.ajax({
                    url: '../controlador/usuario.php',
                    method: "POST",
                    data: {foto_avatar: $(".radio-avatar:checked").val(), avatar_id_usuario: "<?php echo $idUsuario; ?>"},
                    success: function (res) {
                        res = res.trim();//eliminamos espacion en blanco a la izaquerda y delera
                        if (res != "") {//validamos si todo salio bien

                            showAlerta("success", "Avatar actualizado");
                            setTimeout(function () {
                                window.location.href = "../vista/perfil.php"; //refreca la página de nuevo a los 2 segundos
                            }, 2000);

                        } else {
                            showAlerta("error", "Avatar no actualizados");
                        }
                    },
                    error: function () {
                        showAlerta("error", "Error en el sistema");
                    }
                });
            } else {
                showAlerta("warning", "Seleciona un avatar por favor");
            }
        }

        function actualizarDatos() {

            $.ajax({
                url: '../controlador/usuario.php',
                method: "POST",
                data: {nombre: $("#nombre").val(), apellido: $("#apellido").val(), pass: $("#pass1").val(), usuario: $("#usuario").val(), email: $("#email").val()
                    , telefono: $("#telefono").val(), fecha_nac: $("#fecha_nac").val(), edad: $("#edad").val(), form_id_usuario: "<?php echo $idUsuario; ?>"},
                success: function (res) {
                    res = res.trim();//eliminamos espacion en blanco a la izaquerda y delera
                    if (res != "") {//validamos si todo salio bien

                        showAlerta("success", "Datos actualizados");
                        setTimeout(function () {
                            window.location.href = "../vista/perfil.php"; //refreca la página de nuevo a los 2 segundos
                        }, 2000);

                    } else {
                        showAlerta("error", "Datos no actualizados");
                    }
                },
                error: function () {
                    showAlerta("error", "Error en el sistema");
                }
            });
        }


        $("#pass2").keyup(function () {

            if ($("#pass1").val() != "") {

                if ($("#pass1").val() == $("#pass2").val()) {
                    $("#pass2").css("background-color", "white");
                } else {
                    $("#pass2").css("background-color", "red");
                }

            }

        });



        function cargarEncuestasUpdate(idEncuesta) {
            $.ajax({
                url: '../componentes/update-encuesta-usuario.php',
                method: "POST",
                data: {id_encuesta: idEncuesta, id_usuario: "<?php echo $idUsuario; ?>"},
                success: function (respuesta) {
                    $('#content_encuestas').append(respuesta)
                },
                error: function () {
                    showAlerta("error", "Error en el sistema");
                }
            });

        }


        $(function () {

            var data = "<?php echo $strEncuestas; ?>";
            ;
            data = data.split("|")
            data.pop()
            console.log(data)


            data.forEach(function (valor, indice, array) {
                cargarEncuestasUpdate(valor);
            });


        });


        function updateEncuesta(elem) {

            var idEncuesta = $(elem).attr("data-id-encuesta");

            //método que valida que los campos sean requeridos
            if (validador(idEncuesta)) {
                var dataLista = [];

                //recorremos cada opcion para asi guardarla

                $(".text_input" + idEncuesta).each(function () {
                    var data = {'id_pregunta': $(this).attr('data-id'), 'value': $(this).val(), 'tipo': 1}; //las preguntas que son texto
                    dataLista.push(data)
                });

                $(".check_input" + idEncuesta + ":checked").each(function () {
                    var data = {'id_pregunta': $(this).attr('data-id'), 'value': $(this).val(), 'tipo': 2};//las preguntas de selecion multiple
                    dataLista.push(data)
                });


                $(".radio_input" + idEncuesta + ":checked").each(function () {
                    var data = {'id_pregunta': $(this).attr('data-id'), 'value': $(this).val(), 'tipo': 3};//las preguntas de selecion unica
                    dataLista.push(data)
                });

                $(".number_input" + idEncuesta).each(function () {
                    var data = {'id_pregunta': $(this).attr('data-id'), 'value': $(this).val(), 'tipo': 4};//las preguntas que son de llenar numeros
                    dataLista.push(data)
                });


                dataJson = JSON.stringify(dataLista);
                updateRespuestaEncuesta(dataJson, idEncuesta);
            }
        }
        ;


        function updateRespuestaEncuesta(data, idEncuesta) {



            $.ajax({
                url: '../controlador/respuesta.php',
                method: "POST",
                data: {data_encuesta: data, id_usuario: "<?php echo $idUsuario; ?>", id_encuesta: idEncuesta},
                success: function (res) {

                    console.log(res)

                    res = res.trim();//eliminamos espacion en blanco a la izaquerda y delera

                    if (res != "") {//validamos si todo salio bien

                        showAlerta("success", "Encuesta actualizada");
                        setTimeout(function () {
                            window.location.href = "../vista/perfil.php"; //refreca la página de nuevo a los 2 segundos
                        }, 2000);

                    } else {
                        showAlerta("error", "Encuesta no guardada");
                    }
                },
                error: function () {
                    showAlerta("error", "Error en el sistema");
                }
            });

        }



        function validador(idEncuesta) {

            var flagText, flagNumber, flagCheck, flagRadio = false;

            $(".text_input" + idEncuesta).each(function () {


                $(this).css("background-color", "white");//coloca todos los input text en blanco
                if ($(this).attr('data-requerido') == "(*)") {
                    if ($(this).val() == "") {
                        flagText = true;
                        $(this).css("background-color", "orange");//si es requerido y esta vacio lo coloca en rojo

                    }
                }

            });


            $(".number_input" + idEncuesta).each(function () {
                $(this).css("background-color", "white");//coloca todos los input text en blanco
                if ($(this).attr('data-requerido') == "(*)") {
                    if ($(this).val() == "") {
                        flagNumber = true;
                        $(this).css("background-color", "orange");//si es requerido y esta vacio lo coloca en rojo
                        //$(this).focus();
                    }
                }
            });


            var dataPregunta = [];
            $(".check_input" + idEncuesta).each(function () {

                if ($(this).attr('data-requerido') == "(*)") {
                    var found = dataPregunta.find(dato => dato.attr('data-id-pregunta') === $(this).parent().attr('data-id-pregunta'));

                    if (found === undefined) {
                        dataPregunta.push($(this).parent().parent().parent());
                    }

                }

            });


            dataPregunta.forEach(function (element) {
                var cont = 0;
                $("#" + element.attr("id")).children().each(function () {
                    if ($(this).children().children().attr('data-requerido') == "(*)") {
                        if ($(this).children().children().is(':checked')) {
                            cont++;
                        }
                    }
                });

                if (cont == 0) {
                    flagCheck = true;

                }

            });


            dataPregunta = [];
            $(".radio_input" + idEncuesta).each(function () {

                if ($(this).attr('data-requerido') == "(*)") {
                    var found = dataPregunta.find(dato => dato.attr('data-id-pregunta') === $(this).parent().attr('data-id-pregunta'));

                    if (found === undefined) {
                        dataPregunta.push($(this).parent().parent().parent());
                    }

                }

            });


            dataPregunta.forEach(function (element) {
                var cont = 0;
                $("#" + element.attr("id")).children().each(function () {
                    if ($(this).children().children().attr('data-requerido') == "(*)") {
                        if ($(this).children().children().is(':checked')) {
                            cont++;
                        }
                    }
                });

                if (cont == 0) {
                    flagRadio = true;
                    //si hay una pregunta sin selecionar lo desplaza hasta ella
                }

            });


            if (flagText) {
                showAlerta("warning", "Algunas preguntas de campos de textos son requeridas");
            }

            if (flagNumber) {
                showAlerta("warning", "Algunas preguntas de campos de numero son requeridas");
            }

            if (flagCheck) {
                showAlerta("warning", "Algunas preguntas de selección multiple son requeridas");
            }

            if (flagRadio) {
                showAlerta("warning", "Algunas preguntas de seleción unica son requeridas");
            }


            if (flagText || flagNumber || flagCheck || flagRadio) {
                return false;
            }

            return true;
        }
    </script>

