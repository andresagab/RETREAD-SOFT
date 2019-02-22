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
 * Descripcion de la clase Rol_accesos:
 *
 * Define las propiedades id, idOpcion. idRol, fecha de registro, las cuales permiten relacionar las diferentes opciones con los diferentes roles del sistema de informacion.
 * Esta clase ayuda a determinar que rol puede acceder a x opcion. 
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Rol_Accesos {
    //Propiedades
    private $id;
    private $idOpcion;
    private $idRol;
    private $orden;
    private $fechaRegistro;
    //Fin propiedades

    //Constructor
    function __construct($campo, $valor, $filtro, $orden){
    	$BD='';
    	$P='';
    	if ($campo!=null) {
            if (is_array($campo)){
                foreach ($campo as $key => $value) $this->$key=$value;
                $this->cargarAtributos($campo);
            } else {
                $sql="select id, idOpcion, idRol, orden, fechaRegistro from {$P}rol_accesos where $campo=$valor $filtro $orden";
                $resultado=Conector::ejecutarQuery($sql, null);
                if (count($resultado>0)) {
                    foreach ($resultado[0] as $key => $value) $this->$key=$value;
                    $this->cargarAtributos($resultado[0]);
                }
            }
    	} else return null;
    }
    //Fin constructor

    private function cargarAtributos($arreglo){
    	$this->idOpcion=$arreglo['idopcion'];
    	$this->idRol=$arreglo['idrol'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdOpcion() {
        return $this->idOpcion;
    }

    function getIdRol() {
        return $this->idRol;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getOpcion() {
        if ($this->idOpcion!=null) return new Opcion ('id', $this->idOpcion, null, null);
        else return new Opcion (null, null, null, null);
    }
    
    function getRol() {
        if ($this->idRol!=null) return new Rol('id', $this->idRol, null, null);
        else return new Rol (null, null, null, null);
    }
    
    function getOrden() {
        return $this->orden;
    }

    function setOrden($orden) {
        $this->orden = $orden;
    }
    
    function setId($id) {
        $this->id = $id;
    }

    function setIdOpcion($idOpcion) {
        $this->idOpcion = $idOpcion;
    }

    function setIdRol($idRol) {
        $this->idRol = $idRol;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public static function grabar() {
        $P='';
        $sql="insert into {$P}rol_accesos (idOpcion, idRol, orden, fechaRegistro) values ($this->idOpcion, $this->idRol, $this->orden, '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public static function modificar() {
        $P='';
        $sql="update {$P}rol_accesos set idOpcion=$this->idOpcion, idRol=$this->idRol, orden=$this->orden where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public static function eliminar() {
        $P='';
        $sql="delete from {$P}rol_accesos where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idOpcion, idRol, orden, fechaRegistro from {$P}rol_accesos $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Rol_Accesos::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Rol_Accesos($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getAccesosEnId($idRol){
        $datos= Rol_Accesos::getListaEnObjetos("idRol=$idRol", "order by idopcion asc");
        $vector=array();
        for ($i = 0; $i < count($datos); $i++) {
            $vector[$i]=$datos[$i]->getIdOpcion();
        }
        return $vector;
    }    
    public static function actualizarAccesos($opciones, $idRol){
        $BD=null;$P='';        
        $cadenaSQL="delete from {$P}rol_accesos where idRol=$idRol;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
        for ($i = 0; $i < count($opciones); $i++) {
            $cadenaSQL="insert into {$P}rol_accesos (idRol, idOpcion, fechaRegistro) values "
            . "($idRol,{$opciones[$i]}, now());";
            Conector::ejecutarQuery($cadenaSQL, $BD);            
        }        
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        $objeto=new Rol_Accesos($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idOpcion']=$objeto->getIdOpcion();
        $arreglo['idRol']=$objeto->getIdRol();
        $arreglo['orden']=$objeto->getOrden();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['nombreOpcion']=$objeto->getOpcion()->getNombre();
        $arreglo['rutaOpcion']=$objeto->getOpcion()->getRuta();
        $arreglo['descripcionOpcion']=$objeto->getOpcion()->getDescripcion();
        $arreglo['nombreRol']=$objeto->getRol()->getNombre();
        $arreglo['estadoRol']=$objeto->getRol()->getEstado();
        $arreglo['nombreEstadoRol']=$objeto->getRol()->getNombreEstado();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Rol_Accesos::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idOpcion']=$objeto->getIdOpcion();
            $arreglo['idRol']=$objeto->getIdRol();
            $arreglo['orden']=$objeto->getOrden();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['nombreOpcion']=$objeto->getOpcion()->getNombre();
            $arreglo['rutaOpcion']=$objeto->getOpcion()->getRuta();
            $arreglo['descripcionOpcion']=$objeto->getOpcion()->getDescripcion();
            $arreglo['nombreRol']=$objeto->getRol()->getNombre();
            $arreglo['estadoRol']=$objeto->getRol()->getEstado();
            $arreglo['nombreEstadoRol']=$objeto->getRol()->getNombreEstado();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
}
