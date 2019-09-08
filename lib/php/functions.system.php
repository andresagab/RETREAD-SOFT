<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 11/06/2018
 * Time: 17:33
 */
function getFoto($source){
    if (file_exists($source)) return $source;
    else return dirname(__FILE__) . "/../../design/pics/imagenes/not_image.jpg";
}

function getStatusDelete($id, $tables, $field) {
    $status = true;
    if ($id!=null && $tables!=null && $field!=null) {
        for ($i=0; $i<count($tables); $i++) {
            $sql = "select $field from $tables[$i] where $field=$id";
            $r = Conector::ejecutarQuery($sql, null);
            if ($r!=null) {
                if ($r[0][0]==$id) {
                    $i = count($tables);
                    $status = false;
                }
            }
        }
    }
    return $status;
}

function validVal($value){
    if ($value!=null && $value!='' && $value!=" ") return true;
    else return false;
}

/**
 * @param $initTime = Fecha en formato AAAA-MM-DD HH:II:SS correspondiente a la fecha y hora de inicio
 * @param $status = Estado correspondiente al processo de reencauche (prf = Proceso Finalizado)
 * @param $limit = Limite de tiempo para que la diferencia entre el tiempo de inicio y el tiempo actual sea mayor al ingresado por este parametro
 * @return $color = Corresponde al color del resultado de cada validación.
 */
function getColorStatusProcess($initTime, $status, $limit){
    $color = '#ffffff';//Blanco
    if ($initTime!=null) {
        $diffTime = getDiffTimeInSeconds($initTime, date('Y-m-d H:i:s'));
        $color = '#f1b154';//Naranja
        if ($diffTime>=$limit) {
            $color = '#f1d968';//Amarillo
        }
    }
    if ($status==='prf') {
        $color = '#b8ef78';//Verde
    }
    return $color;
}

function uploadFile($dataFile, $nameArray, $route, $id) {
    $namePhoto = '';
    if (isset($dataFile["$nameArray"])){
        if (!is_dir(dirname(__FILE__) . $route)) {
            if (mkdir(dirname(__FILE__) . $route, 0777)) echo 'ok';
        }
        $foto = $dataFile["$nameArray"]['name'];
        $cutExt = substr($foto, strpos($foto, "."));
        $namePhoto = $id . "_" . date("Y-m-d") . $cutExt;
        if (file_exists(dirname(__FILE__) . $route . "$namePhoto")) {
            try {
                unlink(dirname(__FILE__) . $route . "$namePhoto");
            } catch (Exception $e) {echo $e->getMessage();}
        }
        move_uploaded_file($dataFile["$nameArray"]['tmp_name'], dirname(__FILE__) . $route . "$namePhoto");
    }
    return $namePhoto;
}

/**
 * Se carga el id correspondiente a un puesto de trabajo asociado al registro de insumos del proceso determinado como
 * parametro
 * @param $idProcess = Llave foranea que hace referencia al id de cualquier proceso de reencauche
 * @param $numberProcess = Valor numerico asociado al proceso tratado
 * @return Int = '$id' -> Valor int correspondiente al puesto de trabajo asociado al uso de insumos de un proceso determinado
 */
function getIdPuestoTrabajoProceso($idProcess, $numberProcess) {
    $id = null;
    if (validVal($idProcess) && validVal($numberProcess)) {
        $usoInsumoProcesoDetalle = Uso_Insumo_Proceso_Detalle::getListaEnObjetos("idusoinsumoproceso in (select id from uso_insumo_proceso where idproceso=$idProcess and proceso=$numberProcess)", "order by id desc limit 1");
        if (is_array($usoInsumoProcesoDetalle)) {
            if (count($usoInsumoProcesoDetalle)>0) {
                if ($usoInsumoProcesoDetalle[0]->getIdInsumoPt()!=null) $id = $usoInsumoProcesoDetalle[0]->getInsumoPt()->getIdPuestoTrabajo();
            }
        }
    }
    return $id;
}

function validResourcesVal($resources){
    /*
     * SE EVALUA CADA ELEMENTO DEL $resources, TENIENDO EN CUENTA QUE ESTE ES UN VECTOR, SI TODO LOS ELEMENTOS DEL VECTOR
     * SON DIFERENTES DE NULL SE RETORNARA TRUE EN CASO CONTRARIO FALSE
     * TRUE = ELEMENTOS NO NULOS
     * FALSE = ALGUNOS ELEMENTOS SON NULOS
     */
    $status = true;
    if (is_array($resources)){
        foreach ($resources as $resource => $val) {
            ${$resource} = $val;
            if (!validVal($resource)) {
                $status = false;
                break;
            }
        }
    } else $status = false;
    return $status;
}

/**
 * @param $asc -> TRUE = orden ascendente : FASSE = Orden descendente
 * @param $data -> VECTOR DE DATOS
 * @param $field -> CAMPO POR EL QUE SE VA A ORDENAR
 * @return $data -> ARREGLO ORDENADO
 */
function sortArray($asc, $data, $field){
    if (is_array($data) && validVal($field)){
        for ($i = 0; $i < count($data); $i++){
            for ($j = 0; $j < count($data); $j++){
                if (isset($data[$j+1])){
                    if ($asc){
                        if ($data[$j]["$field"] < $data[$j+1]["$field"]){
                            $aux = $data[$j];
                            $data[$j] = $data[$j+1];
                            $data[$j+1] = $aux;
                        }
                    } else {
                        if ($data[$j]["$field"] > $data[$j+1]["$field"]){
                            $aux = $data[$j];
                            $data[$j] = $data[$j+1];
                            $data[$j+1] = $aux;
                        }
                    }
                }
            }
        }
    }
    return $data;
}

/**
 * @param $asc -> TRUE = Orden ascendente - FALSE = Orden descendente
 * @param $data -> Array de objetos JSON
 * @param $field -> Nombre del campor por el cual se va a ordenar el Array
 * @return $data -> Misma variable pero ordenada si cumple con las condiciones
 */
function sortJSON($asc, $data, $field){
    if (validVal($field)){
        for ($i = 0; $i < count($data); $i++){
            for ($j = 0; $j < count($data); $j++){
                if (isset($data[$j+1])){
                    if ($asc){
                        if ($data[$j]->$field < $data[$j+1]->$field){
                            $aux = $data[$j];
                            $data[$j] = $data[$j+1];
                            $data[$j+1] = $aux;
                        }
                    } else {
                        if ($data[$j]->$field > $data[$j+1]->$field){
                            $aux = $data[$j];
                            $data[$j] = $data[$j+1];
                            $data[$j+1] = $aux;
                        }
                    }
                }
            }
        }
    }
    return $data;
}

/**
 * Se obtiene el estado de los usos de insumos asociados a un proceso en su id
 * @param $idProceso Llave primaria del proceso
 * @param $numeroProceso Valor asociado al numero de proceso tratado
 * @return bool '$status' => valor correspondiente al estado del uso de insumos
 */
function getStatusUsosProcces($idProceso, $numeroProceso) {
    $status = false;
    if (validVal($idProceso) && validVal($numeroProceso)){
        $sql = "select id from uso_insumo_proceso where idproceso=$idProceso and proceso=$numeroProceso";
        if (is_array($result = Conector::ejecutarQuery($sql, null)))
            if (count($result)>0)
                if ($result[0][0]!=null) $status = true;
    }
    return $status;
}

/**
 * Valida si la llanta determinada como parametro fue aprobada, posterior a esto se elimina cualquier registro de rechazo asociado a la misma
 * En caso contrario se registra el fin del proceso de reencauche asociado a la llanta.
 *
 * Para ejecutar esta función se requiere tener incluido en el archivo correspondiente los archivos:
 *
 * -RLlanta_Detalle.php
 * -Rechazo_Llanta.php
 * -Llanta.php
 * -Servicio_Fin.php
 * -Conector.php
 *
 * @param $idLlanta = Corresponde a la llave primaria de la llanta que presuntamente registro el rechazo del proceso de reencauche
 * @param $idProceso = Corresponde a la llave primaria del proceso de reencauche donde se registro el presunto rechazo de la llanta
 * @param $numeroProceso = Valor asociado al numero de proceso tratado
 * @param $resultadoProceso = Valor booleano PSQL True = 't' y FALSE = 'f' correspondiente al registrado en el proceso de reencauche tratado
 */
function validarRechazoProceso($idLlanta, $idProceso, $numeroProceso, $resultadoProceso){
    if (validVal($idLlanta) && validVal($idProceso) && validVal($numeroProceso)) {
        if ($resultadoProceso === 't') {//Si el proceso fue aprobado se debe eliminar cualquier registro de rechazo, para asi suprimir todos los registros residuales que se hayan hecho por error
            $rechazoLlanta = new Rechazo_Llanta('idLlanta', $idLlanta, " and idProceso=$idProceso and proceso=$numeroProceso", null);
            if (validVal($rechazoLlanta->getId())){
                $rechazoLlanta->eliminarDetalles();
                $rechazoLlanta->eliminar();
            }
        } else {
            $llanta = new Llanta('id', $idLlanta, null, null);
            if (validVal($llanta->getId())){
                $servicioFin = new Servicio_Fin(null, null, null, null);
                $servicioFin->setIdLlanta($llanta->getId());
                $servicioFin->setEstado('f');
                $servicioFin->setObservaciones('');
                $servicioFin->setFechaRegistro(date("Y-m-d H:i:s"));
                $servicioFin->grabar();
            }
        }
    }
}