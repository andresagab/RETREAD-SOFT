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
 * Descripcion de la clase RLlanta_Detalle:
 *
 * Define las propiedades id, idRechazoLlanta, idRechazo, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class RLlanta_Detalle {
    //Propiedades
    private $id;
    private $idRechazoLlanta;
    private $idRechazo;
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
                $sql="select id, idRechazoLlanta, idRechazo, fechaRegistro from {$P}RLlanta_Detalle where $campo=$valor $filtro $orden";
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
    	$this->idRechazoLlanta=$arreglo['idrechazollanta'];
    	$this->idRechazo=$arreglo['idrechazo'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdRechazoLlanta() {
        return $this->idRechazoLlanta;
    }

    function getIdRechazo() {
        return $this->idRechazo;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getRechazoLlanta() {
        if ($this->idRechazoLlanta!=null) return new Rechazo_Llanta ('id', $this->idRechazoLlanta, null, null);
        else return new Rechazo_Llanta (null, null, null, null);
    }
    
    function getRechazo() {
        if ($this->idRechazo!=null) return new Rechazo ('id', $this->idRechazo, null, null);
        else return new Rechazo (null, null, null, null);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdRechazoLlanta($idRechazoLlanta) {
        $this->idRechazoLlanta = $idRechazoLlanta;
    }

    function setIdRechazo($idRechazo) {
        $this->idRechazo = $idRechazo;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}RLlanta_Detalle (idRechazoLlanta, idRechazo, fechaRegistro) values ($this->idRechazoLlanta, $this->idRechazo, '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}RLlanta_Detalle set idRechazoLlanta=$this->idRechazoLlanta, idRechazo=$this->idRechazo where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}RLlanta_Detalle where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idRechazoLlanta, idRechazo, fechaRegistro from {$P}RLlanta_Detalle $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= RLlanta_Detalle::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new RLlanta_Detalle($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new RLlanta_Detalle($campo, $valor, $filtro, $orden);
        else $objeto=new RLlanta_Detalle (null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idRechazoLlanta']=$objeto->getIdRechazoLlanta();
        $arreglo['idRechazo']=$objeto->getIdRechazo();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['rechazoLlanta']= json_decode(Rechazo_Llanta::getObjetoJSON('id', $objeto->getIdRechazoLlanta(), null, null));
        $arreglo['rechazo']= json_decode(Rechazo::getObjetoJSON('id', $objeto->getIdRechazo(), null, null));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= RLlanta_Detalle::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idRechazoLlanta']=$objeto->getIdRechazoLlanta();
            $arreglo['idRechazo']=$objeto->getIdRechazo();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['rechazoLlanta']= json_decode(Rechazo_Llanta::getObjetoJSON('id', $objeto->getIdRechazoLlanta(), null, null));
            $arreglo['rechazo']= json_decode(Rechazo::getObjetoJSON('id', $objeto->getIdRechazo(), null, null));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
}
