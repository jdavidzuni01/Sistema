<?php
include_once('../modelo/Crud.php');
include_once('../layout/Header.php');
require_once('../controlador/sugerir.php');

//Variables
try {
    $idVid = (int) $_GET['id'];
    if ($idVid <= 0){
        header('Location:home.php?pagina=1');
    }

} catch (\Throwable $th) {
    header('Location:home.php?pagina=1');
}

$idUsr = (int) $_SESSION['id'];
$EA = $_SESSION['EA'];
$TI = $_SESSION['TI'];

//Obtener Datos del video
$video = Crud::getVideo($idVid);
if ($video==[]){
    header('Location:home.php?pagina=1');
}

//Likes y Dislikes
$stateLD = Crud::getAccion($idUsr,$idVid); 

//Saber a donde regresar
if (!isset($_GET['buscar'])){
    $flag = 0;
    if (empty($_GET['pag'])){
        $rethome = "home.php?pagina=1";
    }else{
        $pag = (int) $_GET['pag'];
        $rethome = "home.php?pagina=$pag";
    }
    
}else{
    $flag = 1;
    $busqueda = $_GET['buscar'];
    if (empty($_GET['pag'])){
        $retbus = "resultados.php?buscar=$busqueda&pagina=1";
    }else{
        $pag = (int) $_GET['pag'];
        $retbus = "resultados.php?buscar=$busqueda&pagina=$pag";
    }
}

//Videos recomendados

//Obtener EA, TI y tags del video actual si es un estudiante
if ($_SESSION['rol']==1){
    $EAR = $video[0]['EA'];
    $TIR = $video[0]['TI'];
    $tags = $video[0]['tags'];

    //Bandera para saber cuando mostrar videos random y cuando no
    $flagRand = 0;

    if((empty($EA) && empty($TI)) || (empty($EA) || empty($TI))){
        
        //Recomendacion por tags y por Likes-Dislikes
        $VideosRec = [];
        $aux = [];
        $temp = [];
        $tags = explode(",",$tags);
        //Resultados para todos los tags
        foreach ($tags as $tag) {
            $signos = ['.',':',';','{','}','[',']','*','+','-','_','?','¿','@','!','¡','/','^','#','%','&','(',')','=','|','°'];
            $tag = str_replace($signos,'',$tag);
            $temp[] = Crud::getRecVid(trim($tag),$idVid); //Vector 3D
        }
        //Filtrar y asignar prioridad
        foreach ($temp as $temp1) {
            foreach ($temp1 as $temp2) {
                foreach ($temp2 as $temp3) {
                    $aux[] = $temp3;
                }
            }
        }
        //contar repetidos y borrar duplicados
        $contar = array_count_values($aux); //vector del tipo $contar=[id1 => veces, id2 => veces, idn => veces]

        //Obtener los likes y dislikes de los videos que cumplen con los tags y obtener el rango total
        $rank = 0;     
        $auxIds = []; //será un vector de la forma [[id1 => rank1],[id2 => rank2]]
        foreach ($contar as $id => $cant) {
            $temp1 = Crud::getTagsVid($id,$idVid);
            foreach ($temp1 as $vid) {
                $lks = $vid['likes'];
                $dslks = $vid['dislikes'];
                $rank = ($cant+$lks)-$dslks;
                $auxIds[] = ['rank'=>$rank,'id'=>$id];
            }            
        }

        //ordenar videos de mayor a menor valor de rank
        arsort($auxIds);        

        //Dejar solo los 3 videos con rank más alto para mostrar
        $auxCont = 1;
        foreach ($auxIds as $vid) {
            $VideosRec[] = Crud::getVideo($vid['id']);            
            if ($auxCont==3){
                break;
            }
            $auxCont++;
        }      
        
        //Ver si hay al menos 3 videos
        $max = 3;
        $numVidRec = count($VideosRec);
        //Bandera para saber como mostrar los videos
        $flagRec = 0;

        //Si faltan 3 videos
        $temp4 = [];        
        if ($numVidRec==0){
            $flagRec=1;
            $numVidRec=3;
            $temp4=Crud::getRecAllAle($idVid);
            foreach ($temp4 as $ranVid) {                
                $VideosRec[]=$ranVid;
            }
        }

        //Si faltan 1 o 2 videos
        $Conc = [$idVid];
        if ($numVidRec<$max){
            $falta = $max - $numVidRec;
            foreach ($VideosRec as $value) {              
                $Conc[] = (int) $value[0]['id_item'];                    
            }
            $temp4=Crud::getRecAle($Conc,$falta);
            foreach ($temp4 as $key => $val) {
                $VideosRec[] = [$val];
            }           
        }                       
        
        //limpiar memoria
        unset($auxIds,$contar,$aux,$temp,$tags,$rank,$auxCont,$temp4,$Conc);

    }else{
        //Recomendacion por EA, TI, por tags y por Likes-Dislikes 

        $VideosRec =[]; //Videos a mostrar
        $VideosAuxRec =[]; //Para guardar ids anteriores
        $VideosPRec =[]; //Prioritarios
        $VideosSRec =[]; //Secundarios
        $VideosRRec =[]; //Resto

        //Obtener tags a buscar.
        $tags = explode(",",$tags);

        //obtener todos los videos que cumplen con esos tags

        //Prioritarios
        $VideosPRec = sugerir::getResults($tags,1,$EA,$TI,$idVid);
        //Secundarios
        $VideosSRec = sugerir::getResults($tags,2,$EA,$TI,$idVid);
        //Resto
        $VideosRRec = sugerir::getResults($tags,3,$EA,$TI,$idVid);

        //Filtrar y eliminar todos los resultados vacíos
        $VideosPRec = sugerir::filtClean($VideosPRec);
        $VideosSRec = sugerir::filtClean($VideosSRec);
        $VideosRRec = sugerir::filtClean($VideosRRec);

        //Revisar cuantos id están almacenados en cada vector
        $AuxVPR=count($VideosPRec);
        $AuxVSR=count($VideosSRec);
        $AuxVRR=count($VideosRRec);

        //Los que sean diferentes de 0 se rankean
        $VideosPRec = sugerir::Rank($AuxVPR,$VideosPRec,$idVid);
        $VideosSRec = sugerir::Rank($AuxVSR,$VideosSRec,$idVid);
        $VideosRRec = sugerir::Rank($AuxVRR,$VideosRRec,$idVid);

        //Concatenar los vectores que no estén vacíos y eliminar posibles duplicados
        $VideosAuxRec = sugerir::Concatenar($VideosPRec,$VideosSRec,$VideosRRec);

        //Asegurarse de que al menos hay 3 videos para mostrar
        $AuxTIds = count($VideosAuxRec);

        $flagRec = 0;
        if ($AuxTIds==0){
            $flagRec=1; //saber como se mostraran los videos
            $temp=Crud::getRecAllAle($idVid);
            foreach ($temp as $ranVid) {                
                $VideosRec[]=$ranVid;
            }
        }elseif ($AuxTIds==1) {
            //Faltan 2 Videos
            //Obtener los datos del video que ya se tiene
            foreach ($VideosAuxRec as $vid) {
                $VideosRec[] = Crud::getVideo($vid);
            }
            $VideosRec = sugerir::getVidsByRand($idVid,$VideosRec,2);
        }elseif ($AuxTIds==2) {
            //Falta 1 video
            //Obtener los datos de los 2 videos que ya se tienen
            foreach ($VideosAuxRec as $vid) {
                $VideosRec[] = Crud::getVideo($vid);
            } 
            $VideosRec = sugerir::getVidsByRand($idVid,$VideosRec,1);
        }else{
            //Dejar solo los 3 videos con rank más alto para mostrar
            $auxCont = 1;
            foreach ($VideosAuxRec as $vid) {
                $VideosRec[] = Crud::getVideo($vid);            
                if ($auxCont==3){
                    break;
                }
                $auxCont++;
            } 
        }                

        //limpiar memoria
        unset($VideosAuxRec,$AuxVPR,$AuxVRR,$AuxVSR,$AuxTIds,$VideosPRec,$VideosRRec,$VideosSRec,$tags);       
    }
}



include_once('../layout/Body.php');
?>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <a class = "text-dark" href="<?php echo $flag==0 ? $rethome : $retbus;?>">
                            <h1><i class="fa fa-arrow-circle-left px-1"></i>Regresar</h1>
                        </a>    
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="home.php">Inicio</a></li>
                            <li class="active">Videos</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row bg-light">
            <div class="<?php echo $_SESSION['rol']==1 ? 'col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 py-3' : 'col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-3' ?>">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="<?php echo $video[0]['url']; ?>" allowfullscreen></iframe>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <?php if($_SESSION['rol']==1):?>
                            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12 py-3 my-0 py-0 border-bottom">
                                <h2 class="font-weight-bold" style = "font-size:1.3em;"><?php echo $video[0]['tittle']; ?></h2>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 py-3 my-0 py-0 text-right border-bottom">
                                <?php if ($stateLD==[] or $stateLD[0]['Accion']=='ND' or $stateLD[0]['Accion']=='NL'): ?>
                                    <form action="../controlador/controlLD.php" method="post">
                                        <input type="hidden" name="usr" value="<?php echo $idUsr?>">
                                        <input type="hidden" name="vid" value="<?php echo $idVid?>">
                                        <button class="btn btn-light px-0 mx-0 my-0 py-0" type="submit" name="Accion" value="L">
                                            <i class="fa fa-thumbs-o-up px-1 mx-1"> <?php echo $video[0]['Likes']?></i>
                                        </button>
                                        <button class="btn btn-light px-0 mx-0 my-0 py-0" type="submit" name="Accion" value="D">
                                            <i class="fa fa-thumbs-o-down px-1 px-1 mx-1"> <?php echo $video[0]['Dislikes']?></i>
                                        </button>                                    
                                    </form>
                                <?php elseif ($stateLD[0]['Accion']=='L'): ?>
                                    <form action="../controlador/controlLD.php" method="post">
                                        <input type="hidden" name="usr" value="<?php echo $idUsr?>">
                                        <input type="hidden" name="vid" value="<?php echo $idVid?>">
                                        <button class="btn btn-light text-primary px-0 mx-0 my-0 py-0" type="submit" name="Accion" value="NL">
                                            <i class="fa fa-thumbs-o-up px-1 mx-1"> <?php echo $video[0]['Likes']?></i>
                                        </button>
                                        <button class="btn btn-light px-0 mx-0 my-0 py-0" type="submit" name="Accion" value="D">
                                            <i class="fa fa-thumbs-o-down px-1 px-1 mx-1"> <?php echo $video[0]['Dislikes']?></i>
                                        </button>                                    
                                    </form>
                                <?php else: ?>
                                    <form action="../controlador/controlLD.php" method="post">
                                        <input type="hidden" name="usr" value="<?php echo $idUsr?>">
                                        <input type="hidden" name="vid" value="<?php echo $idVid?>">
                                        <button class="btn btn-light px-0 mx-0 my-0 py-0" type="submit" name="Accion" value="L">
                                                <i class="fa fa-thumbs-o-up px-1 mx-1"> <?php echo $video[0]['Likes']?></i>
                                        </button>
                                        <button class="btn btn-light text-danger px-0 mx-0 my-0 py-0" type="submit" name="Accion" value="ND">
                                            <i class="fa fa-thumbs-o-down px-1 px-1 mx-1"> <?php echo $video[0]['Dislikes']?></i>
                                        </button>                                    
                                    </form>
                                <?php endif;?>                        
                            </div>
                        <?php else:?>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-3 my-0 py-0 border-bottom">
                                <h2 class="font-weight-bold" style = "font-size:1.3em;"><?php echo $video[0]['tittle']; ?></h2>
                            </div>
                        <?php endif;?>
                        <p class="p-3 text-dark"><?php echo $video[0]['descripcion']?></p>
                    </div>
                </div>                
            </div>
            <?php if($_SESSION['rol']==1):?>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 py-3">
                    <h2 class="text-center py-1 font-weight-bold" style = "font-size:1.1em;">Videos Sugeridos</h2>
                        <?php 
                            
                            foreach ($VideosRec as $pos => $VideoRec) {
                                
                                if($flagRec==0){
                                    $partes = explode("/",$VideoRec[0]['url']);
                                    $idVidR[] = $partes[4]; 
                                }else{
                                    $partes = explode("/",$VideoRec['url']);
                                    $idVidR[] = $partes[4]; 
                                }                                             
                                
                            ?>

                            <a class="border-0 text-dark font-weight-bold text-center" style="font-size:0.8em" href="videoShow.php?id=<?php echo $flagRec==0 ? $VideoRec[0]['id_item'] : $VideoRec['id_item']?>">
                                <div class="card py-1 my-1 px-1">
                                    <div class="embed-responsive embed-responsive-16by9 py-1 my-0 rounded">
                                        <img class="embed-responsive-item" src="https://img.youtube.com/vi/<?php echo $idVidR[$pos]; ?>/hqdefault.jpg"/>                            
                                    </div>
                                    <div class="card-body py-1 my-0">
                                        <h7 class="card-title py-0 my-0"><?php echo $flagRec==0 ? $VideoRec[0]["tittle"] : $VideoRec["tittle"]; ?></h7>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>                    
            <?php endif;?>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<?php
include_once('../layout/Footer.php');
?>