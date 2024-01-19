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
 * @version Carga y verifica los datos enviado por peticiones http (GET - POST)
 * @return array Retorna un arreglo con la data recibida en la petición y una variable de estado (status), true: si se recibió una petición http, false: no se recibio una petición http
 */
function getDataPOST_GET(){
    header("Access-control-Allow-Origin: *");
    header("Access-control-Allow-Methods: GET, POST");
    header("Access-control-Allow-Headers: X-Requested-with");
    header("Content-type: text/html; charset=utf-8");
    //Definimos el arreglo por defecto, status y data, status false para decir que no hay peticiones POST o GET
    $data = array();
    $data['status'] = false;
    $data['data'] = json_decode(null);
    //Cargamos los datos recibidos por AJAX
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    if ($request)
    {
        if (count($request) > 0) {
            //Hay datos en POST o GET
            $data['status'] = true;
            $data['data'] = $request;
        }
    }
    return $data;
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