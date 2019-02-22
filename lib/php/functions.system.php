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