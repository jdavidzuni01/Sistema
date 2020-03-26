<?php
include_once('../modelo/Crud.php');
include_once('../layout/Header.php');

$busqueda = strtolower($_GET['buscar']);
if(empty($busqueda)){
    header('Location:home.php?pagina=1');
}

$vidPagina = 6;
$flag = 0; //Bandera para mostrar cuando no hay resultados de búsqueda


$pbuscar = explode(" ",$busqueda);
if (count($pbuscar)==1){

    //Limpeza
    $signos = [',','.',':',';','{','}','[',']','*','+','-','_','?','¿','@','!','¡','/','^','#','%','&','(',')','=','|','°'];
    $busqueda = str_replace($signos,'',$busqueda);

    //Paginacion
    $totVid= Crud::getUniqueRes($busqueda);

    if ($totVid==0){

        $mensaje = "No hay registros para la búsqueda solicitada";
        
    }else{
        $flag=1;//hay videos para mostrar

        $paginas = ceil($totVid/$vidPagina);

        if (!$_GET) {
            header("Location:resultados.php?buscar=$busqueda&pagina=1");
        }    

        $pagActual = $_GET['pagina'];

        try {
            $pagActual = (int) $pagActual;
        } catch (\Throwable $th) {
            header("Location:resultados.php?buscar=$busqueda&pagina=1");
        }

        if (($pagActual>$paginas) || ($pagActual<=0)){
            header("Location:resultados.php?buscar=$busqueda&pagina=1");
        }

        $ini = ($pagActual-1)*$vidPagina;
        $videos = Crud::getAllSearchVid($busqueda,$ini,$vidPagina);

        //fin paginacion y datos videos
    }
}else{
    $temp=[];
    $aux=[];

    //Obtener resultados de todas las palabras
    foreach ($pbuscar as $word) {
        if (strlen($word)<=3 && !is_numeric($word)){
            continue;
        }else{
            $signos = ['.',':',';','{','}','[',']','*','+','-','_','?','¿','@','!','¡','/','^','#','%','&','(',')','=','|','°'];
            $word = str_replace($signos,'',$word);
            $temp[] = Crud::getSearchVid($word); //vector 3D                    
        }
    }

    //Filtrar y asignar prioridad
    foreach ($temp as $temp1) {
        foreach ($temp1 as $temp2) {
            foreach ($temp2 as $idVid) {
                $aux[] = $idVid;
            }
        }
    }

    //contar repetidos y borrar duplicados
    $contar = array_count_values($aux); 

    //ordenar de mayor a menor coincidencia
    arsort($contar);
    
    //Paginacion
    $vidPerPag=[];
    $auxCont=1;
    $auxPag=1;
    foreach ($contar as $id => $cant) {
        $vidPerPag[] = [$id,$auxPag];
        if (($auxCont%6)==0){
            $auxPag++;
        }
        $auxCont++;
    }
    
    $totVid = count($vidPerPag);
    if ($totVid==0){

        $mensaje = "No hay registros para la búsqueda solicitada";

    }else{
        $flag=1;
        $paginas = ceil($totVid/$vidPagina);

        if (!$_GET) {
            header("Location:resultados.php?buscar=$busqueda&pagina=1");
        }

        $pagActual = $_GET['pagina'];

        try {
            $pagActual = (int) $pagActual;
        } catch (\Throwable $th) {
            header("Location:resultados.php?buscar=$busqueda&pagina=1");
        }

        if (($pagActual>$paginas) || ($pagActual<=0)){
            header("Location:resultados.php?buscar=$busqueda&pagina=1");
        }
        //Fin Paginación

        //Seccion videos
        $idVids=[];
        $temp1 = [];

        //Buscar los videos de x pagina
        foreach ($vidPerPag as $Pos => $vid) {
            if($vid[1]==$pagActual){
                $idVids[] = $vid[0];
            }
        }
        //Obtener Videos para página actual
        $videos;
        foreach ($idVids as $id) {
            $temp1[] = Crud::getVideo($id);
        } 
        foreach ($temp1 as $temp2) {
            foreach ($temp2 as $pos => $video) {
                $videos[] = $video;    //        
            }
        }
    }
    
    //liberar memoria
    unset($temp,$aux,$contar,$vidPerPag,$idVids,$temp1);
    
}

?>

<body>
        <!-- Left Panel -->
        <?php
        include_once('../layout/LeftPanel.php');
        ?>
        <!-- /#left-panel -->

        <div id="right-panel" class="right-panel">


            <header id="header" class="header">
                <div class="top-left">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#"><img src="../images/logo.png" alt="Logo"></a>
                        <a class="navbar-brand hidden" href="#"><img src="../images/logo2.png" alt="Logo"></a>
                        <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                    </div>
                </div>                
                <div class="top-right">
                    <div class="header-menu">
                        <div class="header-left open">
                            <button class="search-trigger"><i class="fa fa-search"></i></button>
                            <div class="form-inline">
                                <form class="search-form" method="get" action="../vista/resultados.php">
                                    <input class="form-control" type="text" placeholder="Search ..." aria-label="Search" name="buscar" value="<?php echo $busqueda?>">
                                    <button class="d-none" name="pagina" value="1" type="submit"><i class="fa fa-search"></i></button>     
                                    <button class="search-close"><i class="fa fa-close"></i></button>
                                </form>
                            </div>

                            <div class="dropdown for-notification">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell"></i>
                                    <span class="count bg-danger">1</span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="notification">
                                    <p class="red">Tiene 1 notificación</p>
                                    <a class="dropdown-item media" href="#">
                                        <i class="fa fa-check"></i>
                                        <p>Saludos usuario nuevo</p>
                                    </a>

                                </div>
                            </div>

                            <div class="dropdown for-message">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="message" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-envelope"></i>
                                    <span class="count bg-primary">1</span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="message">
                                    <p class="red">Tiene 1 mensage</p>

                                    <a class="dropdown-item media" href="#">
                                        <span class="photo media-left"><img alt="avatar" src="../images/avatar/2.jpg"></span>
                                        <div class="message media-body">
                                            <span class="name float-left">MATEMATICA</span>
                                            <span class="time float-right">5 minutes ago</span>
                                            <p>Bienvenido</p>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>

                        <div class="user-area dropdown float-right">
                            <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php if (isset($_SESSION["foto"]) && $_SESSION["foto"] != "0") { ?>
                                <img class="user-avatar rounded-circle" src="<?php echo  $_SESSION["foto"]; ?>" >
                                <?php } ?>

                                <?php if (isset($_SESSION["foto"]) && $_SESSION["foto"] == "0") { ?>
                                    <img class="user-avatar rounded-circle" src="../images/user.png" >
                                <?php } ?>


                            </a>

                            <div class="user-menu dropdown-menu">
                                <a class="nav-link" href="../vista/perfil.php"><i class="fa fa-user"></i><?php
                                    if (isset($_SESSION["usuario"])) {
                                        echo $_SESSION["usuario"];
                                    }
                                    ?></a>
                                <a class="nav-link" href="#"><i class="fa fa-bell-o"></i>Notificiones <span class="count">1</span></a>

                                <a class="nav-link" href="#"><i class="fa fa-cog"></i>Ajustes</a>

                                <a class="nav-link" data-toggle="modal" data-target="#exampleModal" href="#"><i class="fa fa-power-off"></i>Salir</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header><!-- /header -->
            <div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Resultados de Búsqueda</h1>
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


<?php if ($flag==0): ?>
    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-12">
                    <h2 class="pl-4 page-title"><?php echo $mensaje?></h2>
                </div>
            </div>
        </div>
    </div>
<?php else:?>
    <div class="content">
        <div class="animated fadeIn">
            <div class="row">

                <?php 
                    
                    foreach ($videos as $pos => $video) {

                    //Obtener id del video
                    $partes = explode("/",$video['url']);                
                    $idvid[] = $partes[4];

                    ?>
                    <div class="col-md-4">
                        <a class="border-0" href="videoShow.php?id=<?php echo $video['id_item']?>&buscar=<?php echo $busqueda?>&pag=<? echo $pagActual?>">
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
                        <a class="page-link" href="resultados.php?buscar=<?php echo $busqueda?>&pagina=<?php echo $pagActual-1?>">Anterior</a>
                    </li>

                    <?php for ($i=0;$i<$paginas;$i++):?>

                        <li class="page-item <?php echo $pagActual==$i+1 ? 'active' : '' ?>">
                            <a class="page-link" href="resultados.php?buscar=<?php echo $busqueda?>&pagina=<?php echo ($i+1)?>">
                                <?php echo ($i+1)?>
                            </a>
                        </li>

                    <?php endfor?>

                    <li class="page-item <?php echo $pagActual>=$paginas ? 'disabled' : '' ?>">
                        <a class="page-link" href="resultados.php?buscar=<?php echo $busqueda?>&pagina=<?php echo $pagActual+1?>">Siguiente</a>
                    </li>

                </ul>
            </nav>
        </div> 
    </div> 
<?php endif;?>
 

<div class="clearfix"></div>
<?php include_once('../layout/Footer.php'); ?>