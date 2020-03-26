        <?php
include_once('../layout/Header.php');
include_once('../layout/Body.php');
include_once('../modelo/Crud.php');
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

                <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error</strong> en la operación
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>


                <?php if (isset($_GET['delete'])): ?>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-user"></i><strong class="card-title pl-2">Desea eliminar este usuario?</strong>
                            </div>
                            <div class="card-body">
                                <form action="../controlador/usuario.php" method="POST">
                                    <?php if (isset($_GET['delete'])): ?>
                                        <input type="text" name="form_id_usuario_del_adm" value="<?php echo $_GET['delete'] ?>" style="display: none">
                                    <?php endif; ?>
                                    <div class="regsitrotran">
                                        <button class="btn-danger btn"><B>Eliminar</B></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>


            <?php if (!isset($_GET['delete'])): ?>
                <form action="../controlador/usuario.php" method="post" class="row" >
                    <div class="col-md-6">

                        <?php
                        if (isset($_GET['id'])) {
                            $idUsuario = $_GET['id'];
                            $dato = Crud::getAllUsuario($idUsuario);
                        }
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-user"></i><strong class="card-title pl-2">Form usuario</strong>
                            </div>
                            <div class="card-body">
                                <div class="card-text text-sm-center">
                                    <div class="card-body card-block">

                                        <?php if (isset($_GET['id'])): ?>
                                            <input type="text" name="form_id_usuario_adm_upd" value="<?php echo $_GET['id'] ?>" style="display: none">
                                        <?php endif; ?>

                                        <div class="form-group">
                                            <label class=" form-control-label">Nombre</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-edit"></i></div>
                                                <input class="form-control"  name="nombre"  type="text" value="<?php
                                                if (isset($dato) && count($dato) > 0) {
                                                    echo $dato[0]['nombre'];
                                                }
                                                ?>" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class=" form-control-label">Apellido</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-edit"></i></div>
                                                <input class="form-control"  name="apellido" type="text" value="<?php
                                                if (isset($dato) && count($dato) > 0) {
                                                    echo $dato[0]['apellido'];
                                                }
                                                ?>" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class=" form-control-label">Usuario</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                                <input class="form-control"  name="usuario" type="text" value="<?php
                                                if (isset($dato) && count($dato) > 0) {
                                                    echo $dato[0]['usuario'];
                                                }
                                                ?>" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class=" form-control-label">Correo</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                                                <input class="form-control" name="email"  type="email" value="<?php
                                                if (isset($dato) && count($dato) > 0) {
                                                    echo $dato[0]['email'];
                                                }
                                                ?>" required="">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class=" form-control-label">Contraseña</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-ellipsis-h"></i></div>
                                                <input class="form-control" id="pass1" name="pass"  type="password" value="000" required="">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class=" form-control-label">Confirmar contraseña</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-ellipsis-h"></i></div>
                                                <input class="form-control" id="pass2" type="password" value="000" required="">
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-user"></i><strong class="card-title pl-2">Form usuario</strong>
                            </div>
                            <div class="card-body">
                                <div class="card-text text-sm-center">
                                    <div class="card-body card-block">

                                        <div class="form-group">
                                            <label class=" form-control-label">Telefono</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                                <input class="form-control" name="telefono" type="text" value="<?php
                                                if (isset($dato) && count($dato) > 0) {
                                                    echo $dato[0]['telefono'];
                                                }
                                                ?>">
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label class=" form-control-label">Fecha nacimiento</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input class="form-control" type="date" name="fecha_nac" value="<?php
                                                if (isset($dato) && count($dato) > 0) {
                                                    if (is_null($dato[0]["fecha_nac"])) {
                                                        echo date("Y-m-d", strtotime($dato[0]["fecha_nac"]));
                                                    } else {
                                                        echo date("Y-m-d");
                                                    }
                                                }
                                                ?>">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class=" form-control-label">Edad</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                                                <input class="form-control" type="number" name="edad" value="<?php
                                                if (isset($dato) && count($dato) > 0) {
                                                    echo $dato[0]['edad'];
                                                }
                                                ?>">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class=" form-control-label">Rol</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-warning"></i></div>
                                                <select name="rol"  class="form-control">
                                                    <?php
                                                    $uno = "false";
                                                    $dos = "false";
                                                    $tres = "false";
                                                    if (isset($dato) && count($dato) > 0) {

                                                        $d = $dato[0]['rol'];

                                                        if ($d == 1) {
                                                            echo '<option value="1"  selected="" >User</option>';
                                                        } else {
                                                            echo '<option value="1" >User</option>';
                                                        }

                                                        if ($d == 2) {
                                                            echo '<option value="2"  selected="" >Admin</option>';
                                                        } else {
                                                            echo '<option value="2">Admin</option>';
                                                        }

                                                        if ($d == 3) {
                                                    //        echo '<option value="3" selected="" >Manager</option>';
                                                        } else {
                                                      //      echo '<option value="3" >Manager</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="1" >User</option>';
                                                        echo '<option value="2">Admin</option>';
                                                       // echo '<option value="3" >Manager</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class=" form-control-label">Estado</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-eye"></i></div>
                                                <select name="estado"  class="form-control">
                                                    <?php
                                                    $uno = "false";
                                                    $dos = "false";
                                                    $tres = "false";
                                                    if (isset($dato) && count($dato) > 0) {

                                                        $d = $dato[0]['estado'];

                                                        if ($d == 0) {
                                                            echo '<option value="0"  selected="" >Inactivo</option>';
                                                        } else {
                                                            echo '<option value="0" >Inactivo</option>';
                                                        }

                                                        if ($d == 1) {
                                                            echo '<option value="1"  selected="" >Activo</option>';
                                                        } else {
                                                            echo '<option value="1">Activo</option>';
                                                        }
                                                    } else {

                                                        echo '<option value="1">Activo</option>';
                                                        echo '<option value="1">Activo</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions form-group"><button type="submit"   class="btn btn-success btn-sm"><?php
                                        if (isset($_GET['id'])) {
                                            echo 'Actualizar';
                                        } else {
                                            echo 'Guardar';
                                        }
                                        ?></button></div>

                            </div>

                        </div>
                    </div>
                </form>
            <?php endif; ?>

        </div><!-- .row -->
    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>


<?php
include_once('../layout/Footer.php');
?>


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
</script>

