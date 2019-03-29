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