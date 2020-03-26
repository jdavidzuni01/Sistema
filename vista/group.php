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
                            <li class="active">Grupos</li>
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
            <?php if (isset($_GET['status']) && $_GET['status'] == 0): ?>
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        No se pudo actualizar el grupo seleccionado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Relaciones de Estilos de Aprendizaje</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre del Estilo de Aprendizaje</th>
                                        <th>Tipos de Inteligencia Asociados</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $data = Crud::getGroups();

                                    for ($i = 0; $i < count($data); $i++) {
                                        echo '<tr>';
                                        foreach ($data[$i] as $key => $dato) {
                                            echo '<td>';
                                            echo $dato;
                                            echo '</td>';
                                        };
                                        echo '<td><a href="form-group.php?id=' . $data[$i]["idEA"] . '" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a> </td></tr>';
                                        
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