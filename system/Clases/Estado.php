<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */

/**
 * Descripcion de la clase Estado:
 *
 * Esta clase sirve para cargar funciones relacionadas con nombres de estados booleanos
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */
class Estado {
    private $estado;
    
    function __construct($estado) {
        $this->estado = $estado;
    }

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function getNombreEstadoBoolean() {
        if ($this->estado) return 'Activo';
        else return 'Inactivo';
    }
    
}
