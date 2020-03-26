<?php

/**
 * Representa el la estructura de las metas
 * almacenadas en la base de datos
 */
include_once('Database.php');

class Crud {

    function __construct() {
        
    }

    public static function deleteTabla($table, $campoId, $id) {
        try {
            $comando = "DELETE FROM " . $table . " WHERE " . $campoId . "=?";
            // Preparar la sentencia
            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            return $sentencia->execute(array($id));
        } catch (PDOException $e) {
            
        }
        return false;
    }

    public static function deleteRespuestasUsuario($idUsuario, $idEncuesta) {
        try {
            $comando = "DELETE FROM user_resp_encuesta  WHERE id_usuario=? and id_encuesta=?";
            // Preparar la sentencia
            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            return $sentencia->execute(array($idUsuario, $idEncuesta));
        } catch (PDOException $e) {
            
        }
        return false;
    }

////////////////////////////////operaciones usuarios/////////////////////////////////////////////// 



    public static function login($tipo, $pass) {
        // Consulta de la tarea
        $consulta = "SELECT * FROM usuarios WHERE email=? or usuario=?  and estado=true";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute(array($tipo, $tipo));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);

            if ($row && password_verify($pass, $row["contrasenna"])) {
                $_SESSION['usuario'] = $row['nombre'] . ' ' . $row['apellido'];
                $_SESSION['id'] = (int) $row['id'];
                $_SESSION['rol'] = $row['rol'];
                $_SESSION['isEncuesta'] = false;
                $_SESSION['foto'] = $row['foto'];
                $_SESSION['EA'] = $row['EA'];
                $_SESSION['TI'] = $row['TI'];
                $_SESSION['contar'] = (int) $row['iniSesion'];
                $_SESSION['Define'] = $row['defEATI'];


                //para guardar la primera encuesta si no tiene
                $encuestasUser = Crud::getTieneEncuesta($row['id'], true);
                $encuestas = Crud::getAllEncuesta(NULL, true);


                foreach ($encuestas as $encuesta) {
                    $isEncuesta = false;
                    foreach ($encuestasUser as $encUser) {
                        if ($encuesta["id_encuesta"] == $encUser["id_encuesta"]) {
                            $isEncuesta = true;
                            break;
                        }
                    }

                    if (!$isEncuesta) {
                        Crud::addEncuesta($row['id'], $encuesta["id_encuesta"]);
                    }
                }


                return true;
            }
        } catch (PDOException $e) {
            var_dump($e);
        }
        return false;
    }

    public static function addEncuesta($idUsuario, $idEncuesta) {
        try {
            $password = password_hash($pass, PASSWORD_BCRYPT);
            // Sentencia INSERT
            $comando = "INSERT INTO usuario_encuestas ( " .
                    "estado," .
                    "id_encuesta," .
                    "id_usuario)" .
                    "VALUES(?,?,?)";
            // Preparar la sentencia
            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            return $sentencia->execute(array(0, $idEncuesta, $idUsuario));
        } catch (PDOException $e) {
            
        }

        return false;
    }

    public static function registro($email, $pass, $nombre, $apellido, $usuario) {
        try {
            $password = password_hash($pass, PASSWORD_BCRYPT);
            // Sentencia INSERT
            $comando = "INSERT INTO usuarios ( " .
                    "nombre," .
                    "apellido," .
                    "contrasenna," .
                    "usuario," .
                    "email," .
                    "rol)" .
                    "VALUES(?,?,?,?,?,?)";
            // Preparar la sentencia
            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            return $sentencia->execute(array($nombre, $apellido, $password, $usuario, $email, 1));
        } catch (PDOException $e) {
            
        }

        return false;
    }

///////////////////////////// usuarios /////////////////////////////

    public static function updateUsuario($id, $email, $pass, $nombre, $apellido, $usuario, $telefono, $fechaNac, $edad, $rol = NULL, $estado = NULL) {

        try {
            // Creando consulta UPDATE
            $consulta = "UPDATE usuarios SET email=?,contrasenna=? ,nombre=?,apellido=?,usuario=?,telefono=? ,fecha_nac=? ,edad=?";
            $data = null;

            if (strcmp($pass, "000") == 0) {
                $consulta = "UPDATE usuarios SET email=? ,nombre=?,apellido=?,usuario=?,telefono=? ,fecha_nac=? ,edad=?";
                $data = array($email, $nombre, $apellido, $usuario, $telefono, $fechaNac, $edad);
            } else {
                $pass = password_hash($pass, PASSWORD_BCRYPT);
                $data = array($email, $pass, $nombre, $apellido, $usuario, $telefono, $fechaNac, $edad);
            }


            if (!is_null($rol) && !is_null($estado)) {
                array_push($data, $rol, $estado);
                $consulta .= " ,rol=? ,estado=?";
            }


            array_push($data, $id);
            $consulta .= " WHERE  id=?";


            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            // Relacionar y ejecutar la sentencia
            $cmd->execute($data);
            // Preparar la sentencia
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            return $cmd;
        } catch (PDOException $e) {
            
        }
        return false;
    }

    public static function updateUsuarioAvatar($id, $foto) {

        try {
            // Creando consulta UPDATE
            $consulta = "UPDATE usuarios SET foto=? where id=?";

            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            // Relacionar y ejecutar la sentencia
            $cmd->execute(array($foto, $id));
            // Preparar la sentencia
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            return $cmd;
        } catch (PDOException $e) {
            
        }
        return false;
    }

    public static function getAllUsuario($id = NULL) {
        $consulta = "SELECT id,nombre,apellido, usuario,rol,email,estado FROM usuarios";
        $data = array();
        if (!is_null($id)) {
            $data = array($id);
            $consulta = "SELECT `id`, `nombre`, `contrasenna`, `apellido`, `usuario`, `rol`, `email`, `estado`, `telefono`, `fecha_nac`, `edad`, `foto` FROM `usuarios` WHERE id=?";
        }
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute($data);
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getUsr($id) {
        $consulta = "SELECT * FROM usuarios WHERE id=:id";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando -> bindParam(':id',$id,PDO::PARAM_INT);
            // Ejecutar sentencia preparada
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function updateDeleteUsuario($id) {


        if ($_SESSION["id"] == $id) {
            return false;
        }
        try {
            // Creando consulta UPDATE
            $consulta = "UPDATE usuarios SET estado=false where id=?";

            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            // Relacionar y ejecutar la sentencia
            $cmd->execute(array($id));
            // Preparar la sentencia
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            return $cmd;
        } catch (PDOException $e) {
            
        }
        return false;
    }

    ////////////////////////////////operaciones encuesta///////////////////////////////////////////////    


    public static function updateEncuesta($id, $titulo, $descripcion, $estado) {

        try {
            // Creando consulta UPDATE
            $consulta = "UPDATE encuesta SET titulo=?,descripcion=?,estado=?  WHERE  id_encuesta=?";

            // Preparar la sentencia
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            // Relacionar y ejecutar la sentencia
            $cmd->execute(array($titulo, $descripcion, $estado, $id));
            // Preparar la sentencia
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            return $cmd;
        } catch (PDOException $e) {
            
        }
        return false;
    }

    public static function updateEstadoEncuestaUsuario($idUsuario, $idEncuesta) {

        try {
            // Creando consulta UPDATE
            $consulta = "UPDATE usuario_encuestas SET estado=true WHERE  id_usuario=? and id_encuesta=?";

            // Preparar la sentencia
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            // Relacionar y ejecutar la sentencia
            $cmd->execute(array($idUsuario, $idEncuesta));
            // Preparar la sentencia
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            return $cmd;
        } catch (PDOException $e) {
            
        }
        return false;
    }

    public static function insertEncuesta($titulo, $descripcion) {
        try {
            // Sentencia INSERT
            $comando = "INSERT INTO encuesta ( " . "titulo," .
                    "descripcion)" .
                    "VALUES(?,?)";

            // Preparar la sentencia
            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            return $sentencia->execute(array($titulo, $descripcion));
        } catch (PDOException $e) {
            
        }
        return false;
    }

    public static function getAllEncuesta($id = NULL, $estado = NULL) {
        $consulta = "SELECT * FROM encuesta";
        $data = array();
        if (!is_null($id)) {
            $data = array($id);
            $consulta = "SELECT * FROM encuesta where id_encuesta=?";
        }

        if (!is_null($estado)) {
            $consulta = "SELECT * FROM encuesta where estado=true";
        }

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute($data);

            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getAllEncuestasUsuario($idUsuario) {
        $consulta = "SELECT us.id_encuesta,en.titulo FROM usuario_encuestas us inner join encuesta en on(en.id_encuesta=us.id_encuesta)  where us.estado=true and us.id_usuario=?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idUsuario));

            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getTieneEncuesta($idUsuario, $est_true = NULL) {
        $consulta = "SELECT * FROM usuario_encuestas where estado=false and id_usuario=?";

        if (!is_null($est_true)) {
            $consulta = "SELECT * FROM usuario_encuestas  where id_usuario=?";
        }

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idUsuario));

            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getPreguntasEncuesta($idEcuesta) {
        $consulta = "SELECT * FROM encuesta en inner join pregunta pr on(pr.id_encuesta=en.id_encuesta) where  en.id_encuesta=?  ORDER BY pr.prioridad";
        try {

            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idEcuesta));

            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            
        }
        return array();
    }

    ////////////////////// pregunta ////////////////////////////////////// 


    public static function insertPregunta($Idencuesta, $nombre, $tipo, $prioridad, $requerido) {
        try {
            // Sentencia INSERT
            $comando = "INSERT INTO pregunta( " . "id_encuesta," .
                    "nombre_pregunta," .
                    "tipo," .
                    "prioridad," .
                    "requerido)" .
                    "VALUES(?,?,?,?,?)";
            // Preparar la sentencia
            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            return $sentencia->execute(array($Idencuesta, $nombre, $tipo, $prioridad, $requerido));
        } catch (PDOException $e) {
            
        }
        return false;
    }

    public static function updatePregunta($dato, $idEncuesta) {
        try {
            // Sentencia update
            $comando = "UPDATE pregunta SET nombre_pregunta=?,prioridad=?,requerido=? WHERE  id_pregunta=? and id_encuesta=?";
            // Preparar la sentencia
            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            return $sentencia->execute(array($dato->nombre, $dato->prioridad, $dato->requerido, $dato->id_pregunta, $idEncuesta));
        } catch (PDOException $e) {
            
        }
        return false;
    }

////////////////////// opciones//////////////////////////////////////

    public static function updateOpcion($dato) {
        try {
            // Sentencia update
            $comando = "UPDATE opciones SET opcion=? WHERE  id_opciones=?";
            // Preparar la sentencia
            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            return $sentencia->execute(array($dato->opcion, $dato->id_opcion));
        } catch (PDOException $e) {
            
        }
        return false;
    }

    public static function insertOpcion($idPregunta, $valor) {
        try {
            // Sentencia INSERT
            $comando = "INSERT INTO opciones( " . "id_pregunta," .
                    "opcion)" .
                    "VALUES(?,?)";
            // Preparar la sentencia
            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            return $sentencia->execute(array($idPregunta, $valor));
        } catch (PDOException $e) {
            var_dump($e);
        }
        return false;
    }

    public static function getOpcionesPregunta($idPregunta) {
        $consulta = "select * from pregunta pr inner join opciones op on(pr.id_pregunta=op.id_pregunta) where pr.id_pregunta=?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idPregunta));

            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            
        }
        return array();
    }

    ////////////////////// repuestas preguntas //////////////////////////////////////
    public static function getRespuestaPreguntaText($idPregunta, $idUsuario) {
        $consulta = "select * from pregunta pr inner join user_resp_encuesta re on(re.id_pregunta=pr.id_pregunta) where pr.id_pregunta=? and re.id_usuario=?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idPregunta, $idUsuario));

            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getRespuestaPreguntaOpc($idPregunta, $idUsuario) {
        $consulta = "select * from pregunta pr inner join user_resp_encuesta re on(re.id_pregunta=pr.id_pregunta) inner join opciones op on(re.valor=op.id_opciones) where pr.id_pregunta=? and re.id_usuario=?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idPregunta, $idUsuario));

            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            
        }
        return array();
    }

    ////////////////////// respuestas //////////////////////////////////////
    public static function insertRespuesta($dato, $idUsuario, $idEncuesta) {
        try {
            // Sentencia INSERT
            $comando = "INSERT INTO user_resp_encuesta( " . "id_usuario,id_encuesta," .
                    "id_pregunta," .
                    "valor)" .
                    "VALUES(?,?,?,?)";
            // Preparar la sentencia
            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            return $sentencia->execute(array($idUsuario, $idEncuesta, $dato->id_pregunta, $dato->value));
        } catch (PDOException $e) {
            
        }
        return false;
    }

////////////////////// video //////////////////////////////////////

    public static function getAllVideo($id = NULL) {
        $consulta = "SELECT id_item,tittle,descripcion,tags,video_PA_category,EA,TI FROM item";
        $data = array();


        if (!is_null($id)) {
            $data = array($id);
            $consulta = "SELECT * FROM item where id_item=?";
        }


        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute($data);

            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function updateVideo($id, $titulo, $descripcion, $tags, $categoria, $url, $TI, $EA) {

        try {
            // Creando consulta UPDATE
            $consulta = "UPDATE item SET tittle=?,descripcion=?,tags=?,video_PA_category=?,url=?,TI=?,EA=?  WHERE  id_item=?";

            // Preparar la sentencia
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            // Relacionar y ejecutar la sentencia
            $cmd->execute(array($titulo, $descripcion, $tags, $categoria, $url, $TI,$EA,$id));
            // Preparar la sentencia
            $cmd = Database::getInstance()->getDb()->prepare($consulta);
            return $cmd;
        } catch (PDOException $e) {
            
        }
        return false;
    }

    public static function insertVideo($titulo, $descripcion, $tags, $categoria, $url, $TI, $EA) {
        try {
            // Sentencia INSERT
            $comando = "INSERT INTO item (tittle,descripcion,tags,video_PA_category,TI,EA,url) VALUES (?,?,?,?,?,?,?)";

            // Preparar la sentencia
            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            return $sentencia->execute(array($titulo, $descripcion, $tags, $categoria, $TI, $EA, $url));
        } catch (PDOException $e) {
            
        }
        return false;
    }

    public static function getAllRamdonVideo() {
        $consulta = " SELECT * FROM item ORDER BY RAND() LIMIT 6;";
        $data = array();
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute($data);

            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            
        }
        return array();
    }

////Paginacion todos los videos
    public static function getNumVideos() {
        $consulta = "SELECT * FROM item";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
            $totVid = $comando->rowCount();
            return $totVid;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getAllInfo() {
        $consulta = "SELECT * FROM item";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getListVideos($ini,$long) {
        $consulta = "SELECT * FROM item LIMIT :ini,:long";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
           // Ejecutar sentencia preparada
            $comando->bindParam(':ini',$ini,PDO::PARAM_INT);
            $comando->bindParam(':long',$long,PDO::PARAM_INT);
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    //Videos para rankear en HOME

    public static function getPriorVideos($EA,$TI) {
        $temp = "%$TI%";
        $consulta = "SELECT id_item,likes,dislikes FROM item WHERE EA=:EA AND TI LIKE :TI";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->bindParam(':EA',$EA,PDO::PARAM_STR);
            $comando->bindParam(':TI',$temp,PDO::PARAM_STR);
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getSecVideos($EA,$TI) {
        $temp = "%$TI%";
        $consulta = "SELECT id_item,likes,dislikes FROM item WHERE EA=:EA OR TI LIKE :TI";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->bindParam(':EA',$EA,PDO::PARAM_STR);
            $comando->bindParam(':TI',$temp,PDO::PARAM_STR);
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getRestVideos($EA,$TI) {
        $temp = "%$TI%";
        $consulta = "SELECT id_item,likes,dislikes FROM item WHERE EA!=:EA AND TI NOT LIKE :TI";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->bindParam(':EA',$EA,PDO::PARAM_STR);
            $comando->bindParam(':TI',$temp,PDO::PARAM_STR);
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    ///paginacion búsqueda
    public static function getSearchVid($buscar) {

        $temp = "%$buscar%";

        $consulta = "SELECT id_item FROM item WHERE (
            descripcion LIKE :buscar OR 
            tittle LIKE :buscar OR 
            tags LIKE :buscar OR 
            video_PA_category LIKE :buscar
        ) ";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->bindParam(':buscar',$temp,PDO::PARAM_STR);
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getAllSearchVid($buscar,$ini,$long) {

        $temp = "%$buscar%";

        $consulta = 'SELECT * FROM item WHERE (
            descripcion LIKE :buscar OR 
            tittle LIKE :buscar OR 
            tags LIKE :buscar OR 
            video_PA_category LIKE :buscar
        ) LIMIT :ini,:long';
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->bindParam(':ini',$ini,PDO::PARAM_INT);
            $comando->bindParam(':long',$long,PDO::PARAM_INT);
            $comando->bindParam(':buscar',$temp,PDO::PARAM_STR);
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getUniqueRes($buscar) {
        $temp = "%$buscar%";

        $consulta = "SELECT * FROM item WHERE (
            descripcion LIKE :buscar OR 
            tittle LIKE :buscar OR 
            tags LIKE :buscar OR 
            video_PA_category LIKE :buscar
        ) ";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->bindParam(':buscar',$temp,PDO::PARAM_STR);
            $comando->execute();
            $totVid = $comando->rowCount();
            return $totVid;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    /////Video Individual

    public static function getVideo($id) {
        $consulta = "SELECT * FROM item WHERE id_item=:id";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando -> bindParam(':id',$id,PDO::PARAM_INT);
            // Ejecutar sentencia preparada
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function updateVidL($id,$Likes) {
        $consulta = "UPDATE item SET Likes=:Likes WHERE id_item=:id";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando -> bindParam(':id',$id,PDO::PARAM_INT);
            $comando -> bindParam(':Likes',$Likes,PDO::PARAM_INT);
            // Ejecutar sentencia preparada
            $comando->execute();
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function updateVidD($id,$Dlikes) {
        $consulta = "UPDATE item SET Dislikes=:Dlikes WHERE id_item=:id";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando -> bindParam(':id',$id,PDO::PARAM_INT);
            $comando -> bindParam(':Dlikes',$Dlikes,PDO::PARAM_INT);
            // Ejecutar sentencia preparada
            $comando->execute();
        } catch (PDOException $e) {
            
        }
        return array();
    }

    //Likes Dislikes
    
    public static function getAccion($idUser,$idVid){
        $consulta = "SELECT Accion FROM LikesDislikes WHERE idVid=:idVid AND idUser=:idUser";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando -> bindParam(':idVid',$idVid,PDO::PARAM_INT);
            $comando -> bindParam(':idUser',$idUser,PDO::PARAM_INT);
            // Ejecutar sentencia preparada
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
    }

    public static function getAllLD($idUser,$idVid){
        $consulta = "SELECT * FROM LikesDislikes WHERE idVid=:idVid AND idUser=:idUser";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando -> bindParam(':idVid',$idVid,PDO::PARAM_INT);
            $comando -> bindParam(':idUser',$idUser,PDO::PARAM_INT);
            // Ejecutar sentencia preparada
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
    }

    public static function addLD($idUser,$idVid,$Accion){
        $consulta = "INSERT INTO LikesDislikes (idUser,idVid,Accion) VALUES (:idUser,:idVid,:Accion)";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando -> bindParam(':idUser',$idUser,PDO::PARAM_INT);
            $comando -> bindParam(':idVid',$idVid,PDO::PARAM_INT);
            $comando -> bindParam(':Accion',$Accion);
            // Ejecutar sentencia preparada
            $comando->execute();
        } catch (PDOException $e) {
            
        }
    }

    public static function updateLD($id,$Accion){
        $consulta = "UPDATE LikesDislikes SET Accion=:Accion WHERE id=:id";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando -> bindParam(':id',$id,PDO::PARAM_INT);
            $comando -> bindParam(':Accion',$Accion);
            // Ejecutar sentencia preparada
            $comando->execute();
        } catch (PDOException $e) {
            
        }
    }

    //Videos recomendados en Individual

    public static function getRecAllAle($id) {
        $consulta = "SELECT * FROM item WHERE id_item!=:id ORDER BY RAND() LIMIT 3";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->bindParam(':id',$id,PDO::PARAM_INT);
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getRecAle($ids,$lim) {        
        $consulta = "SELECT * FROM item WHERE id_item NOT IN (";
        $flag = 1;
        foreach ($ids as $id) {
            if($flag==1){
                $consulta .= ":id$id";
            }else{
                $consulta .= ",:id$id";
            }
            $flag++;
        }
        $consulta .= ") ORDER BY RAND() LIMIT :lim";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            foreach ($ids as $id) {
                $comando->bindValue(":id$id",$id,PDO::PARAM_INT);
            }            
            $comando->bindValue(":lim",$lim,PDO::PARAM_INT);
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getRecVid($buscar,$id) {

        $temp = "%$buscar%";

        $consulta = "SELECT id_item FROM item WHERE (
            descripcion LIKE :buscar OR 
            tittle LIKE :buscar OR 
            tags LIKE :buscar OR 
            video_PA_category LIKE :buscar
        ) AND id_item!=:id ";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->bindParam(':id',$temp,PDO::PARAM_INT);
            $comando->bindParam(':buscar',$temp,PDO::PARAM_STR);
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getTagsVid($ID,$actId) {
        //evita obtener los datos del video actual, ya que es el primero en cumplir la condicion, entonces se descarta
        $consulta = "SELECT likes,dislikes FROM item WHERE id_item=:id AND id_item!=:idAct";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->bindParam(':id',$ID,PDO::PARAM_INT);
            $comando->bindParam(':idAct',$actId,PDO::PARAM_INT);
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getPRecVid($ID,$EA,$TI,$bus) {
        $temp = "%$bus%";
        $temp1 = "%$TI%";
        $consulta = "SELECT id_item FROM item WHERE 
        id_item!=:id AND
        (
            EA=:EA AND 
            TI LIKE :TI
        ) 
        AND         
        (
            descripcion LIKE :bus OR 
            tittle LIKE :bus OR 
            descripcion LIKE :bus OR 
            tags LIKE :bus
        )";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->bindParam(':id',$ID,PDO::PARAM_INT);
            $comando->bindParam(':EA',$EA,PDO::PARAM_STR);
            $comando->bindParam(':TI',$temp1,PDO::PARAM_STR);
            $comando->bindParam(':bus',$temp,PDO::PARAM_STR);
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getSRecVid($ID,$EA,$TI,$bus) {
        $temp = "%$bus%";
        $temp1 = "%$TI%";
        $consulta = "SELECT id_item FROM item WHERE 
        id_item!=:id AND
        (
            EA=:EA OR 
            TI LIKE :TI
        ) 
        AND         
        (
            descripcion LIKE :bus OR 
            tittle LIKE :bus OR 
            descripcion LIKE :bus OR 
            tags LIKE :bus
        )";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->bindParam(':id',$ID,PDO::PARAM_INT);
            $comando->bindParam(':EA',$EA,PDO::PARAM_STR);
            $comando->bindParam(':TI',$temp1,PDO::PARAM_STR);
            $comando->bindParam(':bus',$temp,PDO::PARAM_STR);
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getRRecVid($ID,$EA,$TI,$bus) {
        $temp = "%$bus%";
        $temp1 = "%$TI%";
        $consulta = "SELECT id_item FROM item WHERE 
        id_item!=:id AND
        (
            EA!=:EA AND
            TI NOT LIKE :TI
        ) 
        AND         
        (
            descripcion LIKE :bus OR 
            tittle LIKE :bus OR 
            descripcion LIKE :bus OR 
            tags LIKE :bus
        )";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->bindParam(':id',$ID,PDO::PARAM_INT);
            $comando->bindParam(':EA',$EA,PDO::PARAM_STR);
            $comando->bindParam(':TI',$temp1,PDO::PARAM_STR);
            $comando->bindParam(':bus',$temp,PDO::PARAM_STR);
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    ///Consultas para grupos videos
    public static function getGroups()
    {
        $consulta = "SELECT * FROM VidsGroups";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function updateGroup($id,$name,$TI)
    {
        $consulta = "UPDATE VidsGroups SET nameEA = :nombre, asocTI = :TI WHERE idEA = :id";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando -> bindParam(':nombre',$name);
            $comando -> bindParam(':TI',$TI);
            $comando -> bindParam(':id',$id);
            // Ejecutar sentencia preparada
            $comando->execute();
            return TRUE;
        } catch (PDOException $e) {
            
        }
        return FALSE;
    }

    public static function newGroup($id,$name,$TI)
    {
        $consulta = "INSERT INTO VidsGroups (idEA,nameEA,asocTI) VALUES (:id,:nombre,:TI)";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando -> bindParam(':id',$id);
            $comando -> bindParam(':nombre',$name);
            $comando -> bindParam(':TI',$TI);            
            // Ejecutar sentencia preparada
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getGroup($id) {
        $consulta = "SELECT * FROM VidsGroups WHERE idEA = :id";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->bindParam(':id',$id,PDO::PARAM_STR);
            // Ejecutar sentencia preparada
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    //Definir Estilo de aprendizaje y Tipo de inteligencia
    public static function defEA($idUser,$EA)
    {
        $consulta = "UPDATE usuarios SET EA = :EA WHERE id = :id";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando -> bindParam(':EA',$EA);
            $comando -> bindParam(':id',$idUser);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $EA;
        } catch (PDOException $e) {
            
        }
        return NULL;
    }

    public static function defTI($idUser,$TI)
    {
        $consulta = "UPDATE usuarios SET TI = :TI WHERE id = :id";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando -> bindParam(':TI',$TI);
            $comando -> bindParam(':id',$idUser);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $TI;
        } catch (PDOException $e) {
            
        }
        return NULL;
    }

    //Obtener TI o EA para actualizar el SESSION
    public static function getEA($idUser)
    {
        $consulta = "SELECT EA FROM usuarios WHERE id = :id";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando -> bindParam(':id',$idUser);
            // Ejecutar sentencia preparada
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getTI($idUser)
    {
        $consulta = "SELECT TI FROM usuarios WHERE id = :id";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando -> bindParam(':id',$idUser);
            // Ejecutar sentencia preparada
            $comando->execute();
            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (PDOException $e) {
            
        }
        return array();
    }
    
    //Contar inicios de sesión
    public static function contar($idUser,$inc)
    {
        $consulta = "UPDATE usuarios SET iniSesion = :ini WHERE id = :id";
        try {
            //Incrementar inicio de sesion
            $inc++;
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando -> bindParam(':ini',$inc);
            $comando -> bindParam(':id',$idUser);
            // Ejecutar sentencia preparada
            $comando->execute();
            return $inc;
        } catch (PDOException $e) {
            
        }
        return $inc;
    }

    /////////// cosultas encuestas

    public static function getporcentajeEncuesta($idEncuesta) {
        $consulta = "SELECT * from pregunta where id_encuesta=? and requerido='(*)'";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idEncuesta));

            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            
        }
        return array();
    }

    public static function getporcentajeRespEncuesta($idEncuesta, $Idusuario) {
        $consulta = "SELECT id_pregunta from user_resp_encuesta where id_encuesta=? and id_usuario=? GROUP by id_pregunta";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idEncuesta, $Idusuario));

            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            
        }
        return array();
    }

    ////////////////////// insert respuestas imagenes //////////////////////////////////////
    public static function insertRespuestaImg($data) {
        try {
            // Sentencia INSERT
            $comando = "INSERT INTO user_resp_imagenes( " . "id_usuario," .
                    "s1_ti_linguistica," .
                    "s1_ti_matematica," .
                    "s1_ti_naturalista," .
                    "s1_ti_musical," .
                    "s1_ti_interpersonal," .
                    "s1_ti_intrapersonal," .
                    "s2_ea_activo," .
                    "s2_ea_reflexivo," .
                    "s2_ea_sensitivo," .
                    "s2_ea_intuitivo," .
                    "s2_ea_visual," .
                    "s2_ea_verbal," .
                    "s2_ea_secuencial," .
                    "s2_ea_global," .
                    "s3_ti_linguistica," .
                    "s3_ti_matematica," .
                    "s3_ti_naturalista," .
                    "s3_ti_musical," .
                    "s3_ti_intrapersonal," .
                    "s3_ti_interpersonal," .
                    "s4_ea_verbal," .
                    "s4_ea_reflexivo," .
                    "s4_ea_activo," .
                    "s4_ea_sensitivo," .
                    "s4_ea_intuitivo," .
                    "s4_ea_visual,".
                    "s4_ea_secuencial," .
                    "s4_ea_global)" .
                    
                    "VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            // Preparar la sentencia
            $sentencia = Database::getInstance()->getDb()->prepare($comando);
            return $sentencia->execute($data);
        } catch (PDOException $e) {
            
        }
        return false;
    }
    
    
        /////////// cosultas encuestas imagenes
    public static function contRankingImagenes($campo,$ranking) {
        $consulta = "SELECT count(*) from user_resp_imagenes where ".$campo."=?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($ranking));

          return $comando->fetchColumn();
        } catch (PDOException $e) {
            
        }
        return 0;
    }
    
    
            /////////// cosultas si tiene encuestas usuario
    public static function ifEnecuestaImgUsuario($id_usuario) {
        $consulta = "SELECT count(*)  from user_resp_imagenes where id_usuario=?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($id_usuario));
            return $comando->fetchColumn();
  
            
        } catch (PDOException $e) {
            
        }
        return 0;
    }

}

?>
