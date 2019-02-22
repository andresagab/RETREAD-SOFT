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
 * Descripcion de la clase Reparacion_Llanta:
 *
 * Define las propiedades id, idReparacion, idParche, cantidad, fechaRegistro las cuales permite identificar la cantidad de parches que se utilizo en un proceso de reparacion.
 * Mediante el campo idReparacion se relaciona el parche usado con su cantidad hacia el proceso de reparacion de una llanta.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Reparacion_Parche {
    //Propiedades
    private $id;
    private $idReparacion;
    private $idParche;
    private $cantidad;
    private $fechaRegistro;
    //Fin propiedades

    //Constructor
    function __construct($campo, $valor, $filtro, $orden){
    	$BD='panam';
    	$P='';
    	if ($campo!=null) {
            if (is_array($campo)){
                foreach ($campo as $key => $value) $this->$key=$value;
                $this->setClave($this->clave);
                $this->cargarAtributos($campo);
            } else {
                $sql="select id, idReparacion, idParche, cantidad, fechaRegistro from {$P}reparacion_llanta where $campo=$valor $filtro $orden";
                $resultado=Conector::ejecutarQuery($sql, $bd);
                if (count($resultado>0)) {
                    foreach ($resultado[0] as $key => $value) $this->$key=$value;
                    $this->cargarAtributos($resultado[0]);
                }
            }
    	} else return null;
    }
    //Fin constructor

    private function cargarAtributos($arreglo){
    	$this->idReparacion=$arreglo['idreparacion'];
    	$this->idParche=$arreglo['idparche'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdReparacion() {
        return $this->idReparacion;
    }

    function getIdParche() {
        return $this->idParche;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function getReparacion() {
        if ($this->idReparacion!=null) return new Reparacion('id', $this->idReparacion, null, null);
        else return new Reparacion (null, null, null, null);
    }

    function getParche() {
        if ($this->idParche!=null) return new Parche_Llanta('id', $this->idParche, null, null);
        else return new Parche_Llanta (null, null, null, null);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdReparacion($idReparacion) {
        $this->idReparacion = $idReparacion;
    }

    function setIdParche($idParche) {
        $this->idParche = $idParche;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public static function grabar() {
        $P='';
        $sql="insert into {$P}reparacion_llanta (idReparacion, idParche, cantidad, fechaRegistro) values ($this->idReparacion, $this->idParche, $this->cantidad, '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public static function modificar() {
        $P='';
        $sql="update {$P}reparacion_llanta set idReparacion=$this->idReparacion, idParche=$this->idParche, cantidad=$this->cantidad, fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public static function eliminar() {
        $P='';
        $sql="delete {$P}reparacion_llanta where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idReparacion, idParche, cantidad, fechaRegistro from {$P}reparacion_llanta $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Reparacion_Parche::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Reparacion_Parche($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        $objeto=new Reparacion_Parche($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idReparacion']=$objeto->getIdReparacion();
        $arreglo['idParche']=$objeto->getIdParche();
        $arreglo['cantidad']=$objeto->getCantidad();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $reparacion=$objeto->getReparacion();
        $parche=$objeto->getParche();
        $arreglo['reparacion']=$reparacion->getObjetoJSON('id', $objeto->getIdReparacion(), null, null);
            $preparacion=$reparacion->getPreparacion();
            $raspado=$preparacion->getRaspado();
            $inspeccion=$raspado->getInspeccion();
            $servicio=$inspeccion->getServicio();
            $llanta=$servicio->getLlanta();
            $arreglo['preparacion']=$preparacion->getObjetoJSON('id', $reparacion->getIdPreparacion(), null, null);
            $arreglo['raspado']=$raspado->getObjetoJSON('id', $preparacion->getIdRaspado(), null, null);
            $arreglo['inspeccion']=$inspeccion->getObjetoJSON('id', $raspado->getIdInspeccion(), null, null);
            $arreglo['servicio']=$servicio->getObjetoJSON('id', $inspeccion->getIdServicio(), null, null);
            $arreglo['llanta']=$llanta->getObjetoJSON('id', $servicio->getIdLlanta(), null, null);
        $arreglo['parche']=$parche->getObjetoJSON('id', $objeto->getIdParche(), null, null);
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Reparacion_Parche::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idReparacion']=$objeto->getIdReparacion();
            $arreglo['idParche']=$objeto->getIdParche();
            $arreglo['cantidad']=$objeto->getCantidad();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $reparacion=$objeto->getReparacion();
            $parche=$objeto->getParche();
            $arreglo['reparacion']=$reparacion->getObjetoJSON('id', $objeto->getIdReparacion(), null, null);
                $preparacion=$reparacion->getPreparacion();
                $raspado=$preparacion->getRaspado();
                $inspeccion=$raspado->getInspeccion();
                $servicio=$inspeccion->getServicio();
                $llanta=$servicio->getLlanta();
                $arreglo['preparacion']=$preparacion->getObjetoJSON('id', $reparacion->getIdPreparacion(), null, null);
                $arreglo['raspado']=$raspado->getObjetoJSON('id', $preparacion->getIdRaspado(), null, null);
                $arreglo['inspeccion']=$inspeccion->getObjetoJSON('id', $raspado->getIdInspeccion(), null, null);
                $arreglo['servicio']=$servicio->getObjetoJSON('id', $inspeccion->getIdServicio(), null, null);
                $arreglo['llanta']=$llanta->getObjetoJSON('id', $servicio->getIdLlanta(), null, null);
            $arreglo['parche']=$parche->getObjetoJSON('id', $objeto->getIdParche(), null, null);
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
}
