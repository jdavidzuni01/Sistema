<?php

include_once('../modelo/Crud.php');

if (isset($_POST['usr']) && isset($_POST['vid']) && isset($_POST['Accion'])){

    try {
        $acNew = strip_tags(trim($_POST['Accion']));
        $idUsr = (int) strip_tags(trim($_POST['usr']));
        $idVid = (int) strip_tags(trim($_POST['vid']));
        //Validaciones
        if ($idVid <= 0 || $idUsr <= 0){
            echo 'Ids no válidos, redireccionando a la página principal...';
            header('refresh:3;url=http://localhost/SistemaRec/vista/home.php?pagina=1'); 
        }
        if ($acNew == 'NL' || $acNew == 'ND' || $acNew == 'L' || $acNew == 'D'){
            
            $Vid = Crud::getVideo($idVid);
            if ($Vid==[]){
                echo 'No existe el video, redireccionando a la página principal...';
                header('refresh:3;url=http://localhost/SistemaRec/vista/home.php?pagina=1');
            }
            $Usr = Crud::getUsr($idUsr);
            if ($Usr==[]){
                echo 'No existe el usuario, redireccionando a la página principal...';
                header('refresh:3;url=http://localhost/SistemaRec/vista/home.php?pagina=1');
            }
            
            //Proceso para sumar o restar Likes o Dislikes
            $numL = (int) $Vid[0]['Likes'];
            $numD = (int) $Vid[0]['Dislikes'];                  
            $regLD = Crud::getAllLD($idUsr,$idVid);
            $idLD = $regLD[0]['id'];
            $acPas = $regLD[0]['Accion'];            
            if ($regLD==[]){
                //Estados L o D
                Crud::addLD($idUsr,$idVid,$acNew);
                if ($acNew == 'L'){
                    $numL++;
                    Crud::updateVidL($idVid,$numL);
                }else{
                    $numD++;
                    Crud::updateVidD($idVid,$numD);
                }
                header("Location:http://localhost/SistemaRec-master/vista/videoShow.php?id=$idVid");
            }else{
                if ($acPas == 'L'){
                    if ($acNew == 'NL'){
                        $numL--;
                        Crud::updateLD($idLD,$acNew);
                        Crud::updateVidL($idVid,$numL);
                    }else{
                        $numL--;
                        $numD++;
                        Crud::updateLD($idLD,$acNew);
                        Crud::updateVidD($idVid,$numD);
                        Crud::updateVidL($idVid,$numL);
                    }
                }elseif ($acPas == 'D'){
                    if ($acNew == 'ND'){
                        $numD--;
                        Crud::updateLD($idLD,$acNew);
                        Crud::updateVidD($idVid,$numD);
                    }else{
                        $numD--;
                        $numL++;
                        Crud::updateLD($idLD,$acNew);
                        Crud::updateVidD($idVid,$numD);
                        Crud::updateVidL($idVid,$numL);
                    }
                }else{
                    if ($acNew == 'L'){
                        $numL++;
                        Crud::updateLD($idLD,$acNew);
                        Crud::updateVidL($idVid,$numL);
                    }else{
                        $numD++;
                        Crud::updateLD($idLD,$acNew);
                        Crud::updateVidD($idVid,$numD);
                    }
                }
                header("Location:http://localhost/SistemaRec-master/vista/videoShow.php?id=$idVid");
            }           
        }else{
            echo 'Acción desconocida, redireccionando a la página principal...';
            header('refresh:3;url=http://localhost/SistemaRec-master/vista/home.php?pagina=1');
        }        

    } catch (\Throwable $th) {
        echo 'Algo salió mal :(';
        echo 'Redireccionando a la página principal...';
        header('refresh:3;url=http://localhost/SistemaRec-master/vista/home.php?pagina=1');
    }

}else{
    echo 'Valor Nulo, redireccionando a la página principal...';
    header('refresh:3;url=http://localhost/SistemaRec-master/vista/home.php?pagina=1');
}


