<?php
include_once('../layout/Header.php');
include_once('../modelo/Crud.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idEA = $_GET['id'];
    $dato = Crud::getGroup($idEA);
}else{
    header('Location:group.php');
}

include_once('../layout/Body.php');

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
            </div>
            <form action="../controlador/group.php" method="post" class="row" >
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-user"></i><strong class="card-title pl-2">Form Grupos</strong>
                        </div>
                        <div class="card-body">
                            <div class="card-text text-sm-center">
                                <div class="card-body card-block">
                                        <input type="text" name="idEA" value="<?php echo $dato[0]['idEA'] ?>" style="display: none">
                                        <div class="form-group">
                                            <label class=" form-control-label">Nombre Estilo de Aprendizaje</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-edit"></i></div>
                                                    <input class="form-control"  name="nameEA"  type="text" value="<?php
                                                        if (isset($dato) && count($dato) > 0) {
                                                        echo $dato[0]['nameEA'];
                                                        }
                                                    ?>" required="">
                                            </div>
                                        </div>

                                    <div class="form-group">
                                        <label class=" form-control-label">Tipos de Inteligencia Asociados</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-edit"></i></div>
                                            <input class="form-control"  name="asocTI" type="text" value="<?php
                                                    if (isset($dato) && count($dato) > 0) {
                                                    echo $dato[0]['asocTI'];
                                                    }
                                            ?>" required="">
                                            <a tabindex="0" class="btn btn-outline-info mx-1" role="button" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-title="Valores" data-content="Lingüistica(TI1),Matemática(TI2),Naturalista(TI3),Musical(TI4),Intrapersonal(TI5) y Interpersonal(TI6)"><i class="fa fa-info-circle text-info mx-0 py-0 py-0 my-0"></i></a>
                                        </div>
                                    </div>
                                                        
                                    <div class="form-actions form-group">
                                        <button type="submit"   class="btn btn-success btn-sm">Actualizar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

<div class="clearfix"></div>
<?php
    include_once('../layout/Footer.php');
?>
<script >
$(function () {
  $('[data-toggle="popover"]').popover()
})
</script>