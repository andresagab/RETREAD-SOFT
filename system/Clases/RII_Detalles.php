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
 * Descripcion de la clase RII_Detalles:
 *
 * Define las propiedades id, idRii, idRechazo, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class RII_Detalles {
    //Propiedades
    private $id;
    private $idRii;
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
                $sql="select id, idRii, idRechazo, fechaRegistro from {$P}RII_Detalles where $campo=$valor $filtro $orden";
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
    	$this->idRii=$arreglo['idrii'];
    	$this->idRechazo=$arreglo['idrechazo'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdRii() {
        return $this->idRii;
    }

    function getIdRechazo() {
        return $this->idRechazo;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getRechazo_Inspeccion_Inicial() {
        if ($this->idRii!=null) return new Rechazo_Inspeccion_Inicial ('id', $this->idRii, null, null);
        else return new Rechazo_Inspeccion_Inicial (null, null, null, null);
    }
    
    function getRechazo() {
        if ($this->idRechazo!=null) return new Rechazo ('id', $this->idRechazo, null, null);
        else return new Rechazo (null, null, null, null);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdRii($idRii) {
        $this->idRii = $idRii;
    }

    function setIdRechazo($idRechazo) {
        $this->idRechazo = $idRechazo;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}RII_Detalles (idRii, idRechazo, fechaRegistro) values ($this->idRii, $this->idRechazo, '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}RII_Detalles set idRii=$this->idRii, idRechazo=$this->idRechazo where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}RII_Detalles where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idRii, idRechazo, fechaRegistro from {$P}RII_Detalles $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= RII_Detalles::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new RII_Detalles($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= RII_Detalles::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            $options.="<option value='{$objeto->getId()}' $selected title='". rtrim($objeto->getIdRechazo())."'>". rtrim($objeto->getIdRii()) ."</option>";
        }
        return $options;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        $objeto=new RII_Detalles($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idRii']=$objeto->getIdRii();
        $arreglo['idRechazo']=$objeto->getIdRechazo();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['rechazo_Inspeccion_Inicial']= json_decode(Rechazo_Inspeccion_Inicial::getObjetoJSON('id', $objeto->getIdRii(), null, null));
        $arreglo['rechazo']= json_decode(Rechazo::getObjetoJSON('id', $objeto->getIdRechazo(), null, null));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= RII_Detalles::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idRii']=$objeto->getIdRii();
            $arreglo['idRechazo']=$objeto->getIdRechazo();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['rechazo_Inspeccion_Inicial']= json_decode(Rechazo_Inspeccion_Inicial::getObjetoJSON('id', $objeto->getIdRii(), null, null));
            $arreglo['rechazo']= json_decode(Rechazo::getObjetoJSON('id', $objeto->getIdRechazo(), null, null));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
}
