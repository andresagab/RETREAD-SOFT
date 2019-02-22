<?php

/*
* Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
* Este archivo fue desarrollado por Andres Geovanny Angulo Botina
* Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
* o llamar directamente al (+57) 3128293384
 */

/**
 * Description of Ruta
 * 
 * Esta clase esta echa para controlar las diferentes rutas del sistema de informacion
 *
 * @author Andres Geovanny Angulo Botina <sugrenecias a adrescabj981@gmail.com>
 */
class Ruta {
    private $controlador=array();
    
    public function controladores($controlador){
        $this->controlador[]=$controlador;
        self::submit();
    }
    
    public function submit() {
        //$uri=$_GET['uri'];
        //echo $uri;
    }
}
