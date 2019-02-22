<?php
/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
define("RUTA_BASE", dirname(realpath(__FILE__))."/../../");
require_once dirname(__FILE__) . '/../../lib/php/functions.system.php';
include dirname(__FILE__)."\..\..\lib\php\core.php";
switch ($_GET['metodo']){
    case 'ValidarUsuarioYClave':
        require_once SYSTEM_RUTA."\Tools\Conector.php";
        require_once SYSTEM_RUTA."\Clases\Usuario.php";
        $JSON=array();
        if (Usuario::validar($_GET['usuario'], $_GET['clave'])){
            $arreglo=array();
            $arreglo['validar']=true;
            $arreglo['direccion']='principal.php';
            $mensaje['mjs']=null;
            array_push($JSON, $arreglo);
            echo json_encode($JSON);
        } else {
            $arreglo=array();
            $arreglo['validar']=false;
            $arreglo['direccion']='index.php';
            $arreglo['mjs']="Usuario o contrasena incorrecta";
            array_push($JSON, $arreglo);
            echo json_encode($JSON);
        }
        break;
}