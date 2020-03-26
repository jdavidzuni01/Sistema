<?php
include_once('../layout/Header.php');
include_once('../layout/Body.php');
include_once('../modelo/Crud.php');

//Obtener Tipos de inteligencia asociados con el Estilo de aprendizaje
$EA = Crud::getGroups();
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
                            <li class="active">Video</li>
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
                            <i class="fa fa-user"></i><strong class="card-title pl-2">Desea eliminar este video?</strong>
                        </div>
                        <div class="card-body">
                            <form action="../controlador/video.php" method="POST">
                                <?php if (isset($_GET['delete'])): ?>
                                    <input type="text" name="form_id_video_adm_del" value="<?php echo $_GET['delete'] ?>" style="display: none">
                                <?php endif; ?>
                                <div class="regsitrotran">
                                    <button class="btn-danger btn"><B>Eliminar</B></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>



            <?php if (!isset($_GET['delete'])): ?>

                <div class="col-md-6">

                    <?php
                    if (isset($_GET['id'])) {
                        $idItem = $_GET['id'];
                        $dato = Crud::getAllVideo($idItem);
                    }
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-user"></i><strong class="card-title pl-2">Form Video</strong>
                        </div>
                        <div class="card-body">

                            <form action="../controlador/video.php" method="post"  >
                                <div class="card-text">
                                    <div class="card-body card-block">

                                        <?php if (isset($_GET['id'])): ?>
                                            <input type="text" name="form_id_video_adm_upd" value="<?php echo $_GET['id'] ?>" style="display: none">
                                        <?php endif; ?>

                                        <?php if (!isset($_GET['id'])): ?>
                                            <input type="text" name="ins" value="0" style="display: none">
                                        <?php endif; ?>

                                        <div class="form-group">
                                            <label class=" form-control-label">Titulo</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-edit"></i></div>
                                                <input class="form-control"  name="title"  type="text" value="<?php
                                                if (isset($dato) && count($dato) > 0) {
                                                    echo $dato[0]['tittle'];
                                                }
                                                ?>" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class=" form-control-label">Descripcion</label>
                                            <div class="input-group">
                                                <textarea   rows="3" name='descripcion' placeholder="Descripción" class="form-control"><?php if (isset($dato) && count($dato) > 0) {echo $dato[0]['descripcion'];}?> </textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class=" form-control-label">Tags</label>
                                            <div class="input-group">
                                                <textarea   rows="3" name='tags' placeholder="Tags" class="form-control"><?php if (isset($dato) && count($dato) > 0) {echo $dato[0]['tags'];}?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class=" form-control-label">Url</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-rocket"></i></div>
                                                <input class="form-control" name="url"  type="text" value="<?php
                                                if (isset($dato) && count($dato) > 0) {
                                                    echo $dato[0]['url'];
                                                }
                                                ?>" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class=" form-control-label">Categoria</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-sitemap"></i></div>
                                                <input class="form-control" name="categoria"  type="text" value="<?php
                                                if (isset($dato) && count($dato) > 0) {
                                                    echo $dato[0]['video_PA_category'];
                                                }
                                                ?>" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class=" form-control-label">Estilo de Aprendizaje</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-list"></i></div>
                                                <select name="EA" id="selEA" required>
                                                    <?php 

                                                        if (isset($dato) && count($dato) > 0) {
                                                            $actual = $dato[0]['EA']; 

                                                            foreach ($EA as $value) {
                                                                if ($actual==$value['idEA']){
                                                                    echo "<option value=".$value['idEA'].">".$value['nameEA']."</option>";
                                                                    continue;
                                                                }
                                                            }

                                                            foreach ($EA as $value) {
                                                                if ($actual==$value['idEA']){
                                                                    continue;
                                                                }
                                                                echo "<option value=".$value['idEA'].">".$value['nameEA']."</option>";
                                                            }

                                                        }else{
                                                            foreach ($EA as $value) {
                                                                echo "<option value=".$value['idEA'].">".$value['nameEA']."</option>";
                                                            }
                                                        }                                                       

                                                    ?>
                                                </select>                                               

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class=" form-control-label">Tipos de Inteligencia</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-child"></i></div>
                                                <input class="form-control" id="txtTI" name="TI" readonly type="text" value="<?php echo (isset($dato) && count($dato) > 0) ? $dato[0]['TI'] : '' ?>">
                                                <a tabindex="0" class="btn btn-outline-info mx-1" role="button" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-title="Valores" data-content="Lingüistica(TI1),Matemática(TI2),Naturalista(TI3),Musical(TI4),Intrapersonal(TI5) y Interpersonal(TI6)"><i class="fa fa-info-circle text-info mx-0 py-0 py-0 my-0"></i></a>
                                                <a onclick="unlock()" class="btn btn-outline-dark"><i id="iIcon" class="fa fa-lock"></i></a>
                                            </div>
                                        </div>

                                        <div class="form-actions form-group"><button type="submit"   class="btn btn-success btn-sm"><?php
                                                    if (isset($_GET['id'])) {
                                                        echo 'Actualizar';
                                                    } else {
                                                        echo 'Guardar';
                                                    }
                                                    ?></button>
                                                </div>
                                    </div>

                                    

                                </div>  
                                
                            </form>
                    
                </div>

            </div>
        </div>


        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-user"></i><strong class="card-title pl-2">Ver video</strong>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="embed-responsive embed-responsive-21by9">
                            <iframe class="embed-responsive-item" id="iframe-video" src="<?php if (isset($dato) && count($dato) > 0) {echo $dato[0]['url'];}?>" allow='autoplay' allowfullscreen></iframe>
                        </div>
                    </div>

                    <div class="form-group">
                        <textarea rows="5" class="form-control" placeholder="video youtuve"></textarea>
                        <label class=" form-control-label">Copiar el src video para vizualizar</label>
                        <div class="input-group">
                            <input class="form-control" id="url" placeholder="url video ">
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="vizualizarVideo()">Vizualizar</button>
                </div>
            </div>

        <?php endif; ?>
    </div>
</div><!-- .row -->
</div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>

<?php
include_once('../layout/Footer.php');
?>


<script>

    function vizualizarVideo() {

        $("#iframe-video").attr("src", $("#url").val());
    }

</script>
<script >
$(function () {
  $('[data-toggle="popover"]').popover()
})
</script>