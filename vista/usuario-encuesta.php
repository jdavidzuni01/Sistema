<?php
include_once('../layout/Header.php');
include_once('../layout/Body.php');
include_once('../modelo/Crud.php');

if (!isset($_GET['id'])) {
    header('location:../login.php');
}

$idUsuario = $_GET['id'];
$encuestas = Crud::getAllEncuestasUsuario($idUsuario);
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
                                <li class="active">Usuario encuestas</li>
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

                <div class="col-lg-3 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-five">
                                <div class="stat-icon dib flat-color-3">
                                    <i class="pe-7s-browser"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="text-left dib">
                                        <div class="stat-text"><span class="count"><?php echo " " . count($encuestas); ?></span></div>
                                        <div class="stat-heading">Encuestas</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($encuestas as $encuesta) { ?>
                                    <li class="list-group-item">
                                        <a href="#" onclick="abriEncuesta('<?php echo " " . $encuesta["id_encuesta"]; ?>')" > <i class="fa fa-bar-chart"></i><?php echo " " . $encuesta["titulo"]; ?> <span class="badge badge-primary pull-right"> <i class="fa fa-eye"></i> Ver</span></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div><!-- .row -->
        </div><!-- .animated -->
    </div><!-- .content -->

    <div class="clearfix"></div>


    <div class="modal fade" id="modalEncuesta" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollmodalLabel">Encuesta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <div class="col-xs-6 col-sm-12" id="content_encuesta">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <?php
    include_once('../layout/Footer.php');
    ?>


    <script>

        function abriEncuesta(id) {
            $.ajax({
                url: '../componentes/respuesta-usuario.php',
                method: "POST",
                data: {id_usuario: "<?php echo $idUsuario; ?>", id_encuesta: id},
                success: function (respuesta) {
                    $('#content_encuesta').html(respuesta)
                    $('#modalEncuesta').modal({backdrop: 'static', keyboard: false})
                    $('#modalEncuesta').modal('show');
                },
                error: function () {
                    showAlerta("error", "Error en el sistema");
                }
            });
        }

    </script>
