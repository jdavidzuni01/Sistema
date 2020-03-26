<?php
include_once('../modelo/Crud.php');
include_once('../layout/Header.php');

//Obtener si es hora de preguntarle las imagenes al usuario otra vez
$Contar = $_SESSION['contar']%30;
if ($Contar == 0 && $_SESSION['rol']==1){
    $_SESSION['contar']++;
    $_SESSION['EA'] = Crud::defEA($_SESSION['id'],NULL);
    $_SESSION['TI'] = Crud::defTI($_SESSION['id'],NULL);
}

$EA = $_SESSION['EA'];
$TI = $_SESSION['TI'];

if ((empty($EA) && empty($TI)) || (empty($EA) || empty($TI))){
    //Paginacion
    $vidPagina = 6;
    $totVid= Crud::getNumVideos();
    $paginas = ceil($totVid/$vidPagina);
    if (!$_GET) {
        header('Location:home.php?pagina=1');
    }
    $pagActual = $_GET['pagina'];
    try {
        $pagActual = (int) $pagActual;
    } catch (\Throwable $th) {
        header('Location:home.php?pagina=1');
    }
    if (($pagActual>$paginas) || ($pagActual<=0)){
        header('Location:home.php?pagina=1');
    }
    $ini = ($pagActual-1)*$vidPagina;
    $videos = Crud::getListVideos($ini,$vidPagina);
    //Fin Paginación
}else{
    //Paginacion
    $vidPagina = 6;
    $totVid= Crud::getNumVideos();
    $paginas = ceil($totVid/$vidPagina);

    if (!$_GET) {
        header('Location:home.php?pagina=1');
    }

    $pagActual = $_GET['pagina'];

    try {
        $pagActual = (int) $pagActual;
    } catch (\Throwable $th) {
        header('Location:home.php?pagina=1');
    }

    if (($pagActual>$paginas) || ($pagActual<=0)){
        header('Location:home.php?pagina=1');
    }

    $ini = ($pagActual-1)*$vidPagina;
    //Fin Paginación

    //Obtener idvideos, likes y dislikes 
    $prior = Crud::getPriorVideos($EA,$TI);
    $sec = Crud::getSecVideos($EA,$TI);
    $rest = Crud::getRestVideos($EA,$TI);

    //Hacer el rank de los videos
    //Prioritarios
    $rankPri=[];
    foreach ($prior as $pri) {
        $rank = 0;
        $id = $pri['id_item'];
        $lks = (int) $pri['likes']; 
        $dlks = (int) $pri['dislikes'];

        $rank = $lks - $dlks;

        $rankPri[]=['rank'=>$rank,'id'=>$id];
    }
    //Secundarios
    $rankSec=[];
    foreach ($sec as $se) {
        $rank = 0;
        $id = $se['id_item'];
        $lks = (int) $se['likes']; 
        $dlks = (int) $se['dislikes'];

        $rank = $lks - $dlks;

        $rankSec[]=['rank'=>$rank,'id'=>$id];
    }
    //resto de videos
    $rankRest=[];
    foreach ($rest as $res) {
        $rank = 0;
        $id = $res['id_item'];
        $lks = (int) $res['likes']; 
        $dlks = (int) $res['dislikes'];

        $rank = $lks - $dlks;

        $rankRest[]=['rank'=>$rank,'id'=>$id];
    }
    //Ordenar prioridades individualmente
    arsort($rankPri);
    arsort($rankSec);
    arsort($rankRest);

    //unir los ids de los videos ya ordenados para salir
    $idRank = [];
    foreach ($rankPri as $vid) {
        $idRank[] = $vid['id']; 
    }
    foreach ($rankSec as $vid) {
        $idRank[] = $vid['id']; 
    }
    foreach ($rankRest as $vid) {
        $idRank[] = $vid['id']; 
    }
    
    //Eliminar valores repetidos
    $idRank = array_unique($idRank);

    //Paginación videos para mostrar
    $vidPerPag=[];
    $auxCont=1;
    $auxPag=1;
    foreach ($idRank as $id) {
        $vidPerPag[] = [$id,$auxPag];
            if (($auxCont%6)==0){
                $auxPag++;
            }
        $auxCont++;
    }

    //Buscar los videos de x pagina
    $idVids=[];
    foreach ($vidPerPag as $vid) {
        if($vid[1]==$pagActual){
            $idVids[] = $vid[0];
        }
    }



    //Obtener Videos para página actual
    $videos;
    $temp1=[];
    foreach ($idVids as $id) {
        $temp1[] = Crud::getVideo($id);
    } 
    foreach ($temp1 as $temp2) {
        foreach ($temp2 as $video) {
            $videos[] = $video;    //        
        }
    }

    //Limpiar variables que no se usarán más
    unset($prior,$sec,$res,$rankPri,$rankRest,$rankSec,$idRank,$vidPerPag,$idVids);
}

include_once('../layout/Body.php');

//////////////////////////////Encuestas
//$idUsuario = $_SESSION["id"];
//$encuesta = Crud::getTieneEncuesta($idUsuario);

//if (count($encuesta) > 0) {
//    $idEncuesta = $encuesta[0]["id_encuesta"];
//}
?>
<!-- Header-->

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Bienvenido Liceistas</h1>
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

            <?php foreach ($videos as $pos => $video) {

                //Obtener id del video

                $partes = explode("/",$video['url']);
                $idvid[] = $partes[4];

                ?>
                <div class="col-md-4">
                    <a class="border-0" href="videoShow.php?id=<?php echo $video['id_item']?>&pag=<?php echo $pagActual?>">
                        <div class="card">
                        <div class="embed-responsive embed-responsive-16by9">
                                <img class="embed-responsive-item" src="https://img.youtube.com/vi/<?php echo $idvid[$pos]; ?>/hqdefault.jpg"/>                            
                            </div>
                            <div class="card-body">
                                <h4 class="card-title mb-3"><?php echo $video["tittle"]; ?></h4>
                                <p class="card-text">Categoria: <?php echo $video["video_PA_category"]; ?></p>
                                <p class="card-text"><?php echo $video["descripcion"]; ?></p>
                            </div>
                        </div>
                    </a>
                </div>

            <?php } ?>
            
        </div> 
        <nav aria-label="Paginación">
            <ul class="pagination justify-content-center">

                <li class="page-item <?php echo $pagActual<=1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="home.php?pagina=<?php echo $pagActual-1?>">Anterior</a>
                </li>

                <?php for ($i=0;$i<$paginas;$i++):?>

                    <li class="page-item <?php echo $pagActual==$i+1 ? 'active' : '' ?>">
                        <a class="page-link" href="home.php?pagina=<?php echo ($i+1)?>">
                            <?php echo ($i+1)?>
                        </a>
                    </li>

                <?php endfor?>

                <li class="page-item <?php echo $pagActual>=$paginas ? 'disabled' : '' ?>">
                    <a class="page-link" href="home.php?pagina=<?php echo $pagActual+1?>">Siguiente</a>
                </li>

            </ul>
        </nav>
    </div> 
</div>  

<div class="clearfix"></div>


<!--Saber si el estudiante ya definio su estilo de aprendizaje y tipo de inteligencia crear los modal correspondientes-->
<?php if (empty($EA) && $_SESSION['rol']==1): ?>
    <div class="modal fade" id="modalEA" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Elige la imagen que más te guste</h5>
            </div>
            <div class="modal-body">

                <form method="post" action="../controlador/defEA.php">
                    <div class="row">
                        <?php for ($c = 1; $c <= 8; $c++) { ?>
                        
                            <div class="col-md-4">
                            <button class="btn btn-light px-0 mx-0 my-0 py-0" type="submit" name="idEA" value="<?php echo "EA$c";?>">
                                <div class="card">
                                    <img  src="<?php echo "../assets/img/seccion_4/img-" . $c; ?>.jpg" class="card-img-top" >
                                </div>
                            </button>
                            </div>
                        
                        <?php } ?>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>

    <?php include_once('../layout/Footer.php'); 
    //Scripts para ejecutar los modales correspondientes?>
    <script>
        $(document).ready(function () {
            $('#modalEA').modal({backdrop: 'static', keyboard: false})
            $("#modalEA").modal("show");
        });
    </script>
<?php elseif (empty($TI)  && $_SESSION['rol']==1):?>
    <div class="modal fade" id="modalTI" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Elige la imagen que más te guste</h5>
            </div>
            <div class="modal-body">

                <form method="post" action="../controlador/defTI.php">
                    <div class="row">
                        <?php for ($c = 1; $c <= 6; $c++) { ?>
                        
                            <div class="col-md-4">
                            <button class="btn btn-light px-0 mx-0 my-0 py-0" type="submit" name="idTI" value="<?php echo "TI$c";?>">
                                <div class="card">
                                    <img  src="<?php echo "../assets/img/seccion_1/img-" . $c; ?>.jpg" class="card-img-top" >
                                </div>
                            </button>
                            </div>
                        
                        <?php } ?>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>

    <?php include_once('../layout/Footer.php');
    //Scripts para ejecutar los modales correspondientes?>
    <script>
        $(document).ready(function () {
            $('#modalTI').modal({backdrop: 'static', keyboard: false})
            $("#modalTI").modal("show");
        });
    </script>
<?php else:?>
    <?php include_once('../layout/Footer.php');?>
<?php endif;?>
