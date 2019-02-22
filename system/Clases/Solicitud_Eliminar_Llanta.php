<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** Descripcion de la clase Solicitud_Eliminar_Llanta:
 *
 * Define las propiedades id, idLlanta, motivo, os, fechaRegistro las cuales permite identificar el solicitud_eliminar_llanta de una llanta.
 *
 * El atributo idLlanta ayudara a relacionar una llanta ya registrada con un nuevo solicitud_eliminar_llanta de rencauche.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */

class Solicitud_Eliminar_Llanta {
    //Propiedades
    private $id;
    private $idLlanta;
    private $idEmpleado;
    private $motivo;
    private $estado;
    private $llantaJSON;
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
                $sql="select id, idLlanta, idEmpleado, motivo, estado, llantaJSON, fechaRegistro from {$P}solicitud_eliminar_llanta where $campo=$valor $filtro $orden";
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
    	$this->idLlanta=$arreglo['idllanta'];
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->llantaJSON=$arreglo['llantajson'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdLlanta() {
        return $this->idLlanta;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
    }

    function getMotivo() {
        return $this->motivo;
    }

    function getEstado() {
        return $this->estado;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function getLlantaJSON() {
        return $this->llantaJSON;
    }

    function setLlantaJSON($llantaJSON) {
        $this->llantaJSON = $llantaJSON;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdLlanta($idLlanta) {
        $this->idLlanta = $idLlanta;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    function setMotivo($motivo) {
        $this->motivo = $motivo;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    function getLlanta() {
        if ($this->idLlanta!=null) return new Llanta ('id', $this->idLlanta, null, null);
        else return new Llanta (null, null, null, null);
    }

    function getEmpleado() {
        if ($this->idEmpleado!=null) return new Empleado ('id', $this->idEmpleado, null, null);
        else return new Empleado (null, null, null, null);
    }
    
    function getNombreEstado() {
        if ($this->estado) return 'Aprobado';
        else return 'Rechazado';
    }
    
    public function grabar() {
        $P='';
        $sql="insert into {$P}solicitud_eliminar_llanta (idLlanta, idEmpleado, motivo, estado, llantaJSON, fechaRegistro) values ($this->idLlanta, $this->idEmpleado, '$this->motivo', '$this->estado', '$this->llantaJSON', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}solicitud_eliminar_llanta set idLlanta=$this->idLlanta, idEmpleado=$this->idEmpleado, motivo='$this->motivo', llantaJSON='$this->llantaJSON' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}solicitud_eliminar_llanta where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public function aprobar() {
        global $P, $BD;
        $sql="update {$P}solicitud_eliminar_llanta set estado='t' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idLlanta, idEmpleado, motivo, estado, llantaJSON, fechaRegistro from {$P}solicitud_eliminar_llanta $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Solicitud_Eliminar_Llanta::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Solicitud_Eliminar_Llanta($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        $objeto=new Solicitud_Eliminar_Llanta($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idLlanta']=$objeto->getIdLlanta();
        $arreglo['idEmpleado']=$objeto->getIdEmpleado();
        $arreglo['motivo']= rtrim($objeto->getMotivo());
        $arreglo['estado']= rtrim($objeto->getEstado());
        $arreglo['nombreEstado']= rtrim($objeto->getNombreEstado());
        $arreglo['llantaJSON']= json_decode($objeto->getLlantaJSON());
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['llanta']=$objeto->getLlanta();
        $arreglo['empleado']=$objeto->getEmpleado();
            $arreglo['personaEmpleado']=$objeto->getEmpleado()->getPersona();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Solicitud_Eliminar_Llanta::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idLlanta']=$objeto->getIdLlanta();
            $arreglo['idEmpleado']=$objeto->getIdEmpleado();
            $arreglo['motivo']= rtrim($objeto->getMotivo());
            $arreglo['estado']= rtrim($objeto->getEstado());
            $arreglo['nombreEstado']= rtrim($objeto->getNombreEstado());
            $arreglo['llantaJSON']= json_decode($objeto->getLlantaJSON());
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['llanta']=$objeto->getLlanta();
            $arreglo['empleado']=$objeto->getEmpleado();
                $arreglo['personaEmpleado']=$objeto->getEmpleado()->getPersona();
            if ($objeto->getEstado()) $btnAprobar='hidden disabled';
            else $btnAprobar='';
            $arreglo['btnAprobar']=$btnAprobar;
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNumeroSolicitudesPendientes() {
        global $P, $BD;
        $sql="select count(id) as cantidad from {$P}solicitud_eliminar_llanta where estado='f'";
        $result= Conector::ejecutarQuery($sql, null);
        if (count($result)>0){
            if ($result[0]['cantidad']!=null) return $result[0]['cantidad'];
            else return 0;
        } else return 0;
    }
    
}
