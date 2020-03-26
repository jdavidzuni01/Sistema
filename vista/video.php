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
                            <li class="active">Videos</li>
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

            <div class="col-md-12">

                <?php if (isset($_GET['status']) && $_GET['status'] == 1): ?>
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Operación exitosa.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Lista videos</strong>
                        <a   href="form-video.php?" class="btn btn-primary pull-right">Crear Video</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Titulo</th>
                                        <th>Descripción</th>
                                        <th>Tags</th>
                                        <th>Categoria</th>
                                        <th>EA</th>
                                        <th>TI</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $data = Crud::getAllVideo();

                                    for ($i = 0; $i < count($data); $i++) {
                                        echo '<tr>';
                                        foreach ($data[$i] as $key => $dato) {
                                            echo '<td>' . $dato . '</td>';
                                        };
                                        echo '<td><a href="form-video.php?id=' . $data[$i]["id_item"] . '" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a> '
                                        . '<a href="form-video.php?delete=' . $data[$i]["id_item"] . '" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>'
                                        . '</td>   </tr>';
                                        //<i class="fas fa-trash-alt"></i>
                                    };
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- .row -->
    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>


<?php
include_once('../layout/Footer.php');
?>
