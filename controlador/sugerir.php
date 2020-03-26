<?php
require_once('../modelo/Crud.php');

class sugerir{
    //obtener videos para rankear
    public static function getResults($tags,$flag,$EA,$TI,$idVid){
        $Resultado=[];
        // Limpiar signos
        foreach ($tags as $tag) {
            $signos = ['.',':',';','{','}','[',']','*','+','-','_','?','¿','@','!','¡','/','^','#','%','&','(',')','=','|','°'];
            $tag = str_replace($signos,'',$tag);
            $tag = trim($tag);
            //Ver que videos se requieren
            if ($flag==1){
                $Resultado[] = Crud::getPRecVid($idVid,$EA,$TI,$tag); //Vector 3D
            }elseif ($flag==2) {
                $Resultado[] = Crud::getSRecVid($idVid,$EA,$TI,$tag); //Vector 3D
            }else{
                $Resultado[] = Crud::getRRecVid($idVid,$EA,$TI,$tag); //Vector 3D
            }            
        }
        return $Resultado;
    } 

    public static function filtClean($vector) {
        $Resultado = [];
        foreach ($vector as $temp) {
            foreach ($temp as $value) {
                if (!empty($value)){
                    $Resultado[] = (int) $value['id_item'];
                }
            }            
        }
        return $Resultado;
    }

    public static function Rank($aux,$vector,$idVid) {
        if ($aux!=0){
            //Rankear por aparición y eliminar duplicados
            $contar = array_count_values($vector);
            arsort($contar);                        

            //Obtener los likes y dislikes de los videos para Rank total
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

            return $auxIds;
        }else{
            return array();
        }
    }
   
    public static function Concatenar($Pri,$Sec,$Rest) {
        //Identificar los vectores vacíos
        $ContPri = count($Pri);
        $ContSec = count($Sec);
        $ContRest = count($Rest);

        //Los no vacíos se concatenan
        $Conc = [];
        if ($ContPri != 0){
            foreach ($Pri as $value) {
                $Conc[] = $value['id'];
            }
        }
        if ($ContSec != 0){
            foreach ($Sec as $value) {
                $Conc[] = $value['id'];
            }
        }
        if ($ContRest != 0){
            foreach ($Rest as $value) {
                $Conc[] = $value['id'];
            }
        }

        //Eliminar duplicados        
        $Conc = array_unique($Conc);

        return $Conc;

    }    

    public static function getVidsByRand($idVid,$VideosRec,$falta)
    {
        $Conc = [$idVid];
        foreach ($VideosRec as $value) {              
            $Conc[] = (int) $value[0]['id_item'];                    
        }
        $temp=Crud::getRecAle($Conc,$falta);
        foreach ($temp as $val) {
            $VideosRec[] = [$val];
        }           
        return $VideosRec;
    }

    public static function arrayMultUnique($vector,$key)
    {   
        $temp = []; //Almacena los vectores luego de filtrar los repetidos
        $keys = []; //Almacena los id del vector
        foreach ($vector as $value) {
            if (!in_array($value[$key],$keys)){
                $temp[]=$value;
                $keys[]=$value[$key];
            }
        }
        return $temp;
    }

}