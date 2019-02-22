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
 * Descripcion de la clase Posicion_Camara:
 *
 * Define las propiedades id, foto, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Posicion_Camara {
    //Propiedades
    private $id;
    private $idVulcanizado;
    private $idServicio;
    private $posicion;
    private $foto;
    private $fechaRegistro;
    //Fin propiedades

    //Constructor
    function __construct($campo, $valor, $filtro, $orden){
    	$BD='panam';
    	$P='';
    	if ($campo!=null) {
            if (is_array($campo)){
                foreach ($campo as $key => $value) $this->$key=$value;
                $this->cargarAtributos($campo);
            } else {
                $sql="select id, idVulcanizado, idServicio, posicion, foto, fechaRegistro from {$P}posicion_camara where $campo=$valor $filtro $orden";
                $resultado=Conector::ejecutarQuery($sql, null);
                if (count($resultado)>0) {
                    foreach ($resultado[0] as $key => $value) $this->$key=$value;
                    $this->cargarAtributos($resultado[0]);
                }
            }
    	} else return null;
    }
    //Fin constructor

    private function cargarAtributos($arreglo){
    	$this->idVulcanizado=$arreglo['idvulcanizado'];
    	$this->idServicio=$arreglo['idservicio'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdVulcanizado() {
        return $this->idVulcanizado;
    }

    function getIdServicio() {
        return $this->idServicio;
    }

    function getPosicion() {
        return $this->posicion;
    }

    function getFoto() {
        return $this->foto;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdVulcanizado($idVulcanizado) {
        $this->idVulcanizado = $idVulcanizado;
    }

    function setIdServicio($idServicio) {
        $this->idServicio = $idServicio;
    }

    function setPosicion($posicion) {
        $this->posicion = $posicion;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    function getVulcanizado() {
        if ($this->idVulcanizado!=null && $this->idVulcanizado!='') return new Vulcanizado ('id', $this->idVulcanizado, null, null);
        else return new Vulcanizado (null, null, null, null);
    }

    function getServicio() {
        if ($this->idServicio!=null && $this->idServicio!='') return new Servicio ('id', $this->idServicio, null, null);
        else return new Servicio (null, null, null, null);
    }
    
    public function grabar() {
        $P='';
        $sql="insert into {$P}posicion_camara (idVulcanizado, idServicio, posicion, foto, fechaRegistro) values ($this->idVulcanizado, $this->idServicio, '$this->posicion', '$this->foto', '$this->fechaRegistro')";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null) return true;
        else false;
    }

    public function modificar() {
        $P='';
        $sql="update {$P}posicion_camara set idVulcanizado=$this->idVulcanizado, idServicio=$this->idServicio, posicion='$this->posicion', foto='$this->foto' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}posicion_camara where id=$this->id";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null) return true;
        else return false;
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idVulcanizado, idServicio, posicion, foto, fechaRegistro from {$P}posicion_camara $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Posicion_Camara::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Posicion_Camara($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Posicion_Camara($campo, $valor, $filtro, $orden);
        else $objeto=new Posicion_Camara (null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idVulcanizado']=$objeto->getIdVulcanizado();
        $arreglo['idServicio']=$objeto->getIdServicio();
        $arreglo['posicion']= rtrim($objeto->getPosicion());
        $arreglo['foto']= $objeto->getFoto();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['vulcanizado']= json_decode(Vulcanizado::getObjetoJSON('id', $objeto->getIdVulcanizado(), null, null));
        $arreglo['servicio']= json_decode(Servicio::getObjetoJSON('id', $objeto->getIdServicio(), null, null));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Posicion_Camara::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idVulcanizado']=$objeto->getIdVulcanizado();
            $arreglo['idServicio']=$objeto->getIdServicio();
            $arreglo['posicion']= rtrim($objeto->getPosicion());
            $arreglo['foto']= $objeto->getFoto();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['vulcanizado']= json_decode(Vulcanizado::getObjetoJSON('id', $objeto->getIdVulcanizado(), null, null));
            $arreglo['servicio']= json_decode(Servicio::getObjetoJSON('id', $objeto->getIdServicio(), null, null));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNextId() {
        global $P, $BD;
        $sql="select max(id)+1 as id from {$P}posicion_camara";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result!=null){
            if ($result[0]['id']!=null) return $result[0]['id'];
            else return 1;
        } else return 1;
    }
    
    public static function getObjetosJSONSimple($filtro, $orden) {
        $datos= Posicion_Camara::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idVulcanizado']=$objeto->getIdVulcanizado();
            $arreglo['idServicio']=$objeto->getIdServicio();
            $arreglo['posicion']= rtrim($objeto->getPosicion());
            $arreglo['foto']= $objeto->getFoto();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            //$arreglo['servicio']= json_decode(Servicio::getObjetoJSON('id', $objeto->getIdServicio(), null, null));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
}
