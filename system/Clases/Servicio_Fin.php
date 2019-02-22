<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** Descripcion de la clase Llanta_Fin:
 *
 * Define las propiedades id, idLlanta, estado, observaciones, fechaRegistro las cuales permite identificar el servicio_fin ya finalizado de una llanta.
 *
 * El atributo idLlanta ayudara a cerrar todo el proceso de rencauche de una llanta que pertenece a dicho idLlanta.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */

class Servicio_Fin {
    //Propiedades
    private $id;
    private $idLlanta;
    private $estado;
    private $observaciones;
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
                $sql="select id, idLlanta, estado, observaciones, fechaRegistro from {$P}servicio_fin where $campo=$valor $filtro $orden";
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
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdLlanta() {
        return $this->idLlanta;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getEstado() {
        return $this->estado;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function getLlanta() {
        if ($this->idLlanta!=null) return new Llanta('id', $this->idLlanta, null, null);
        else return new Llanta (null, null, null, null);
    }

    function getNombreEstado() {
        if ($this->estado) return "Aprobado";
        else return "Rechazado";
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdLlanta($idLlanta) {
        $this->idLlanta = $idLlanta;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}servicio_fin (idLlanta, estado, observaciones, fechaRegistro) values ($this->idLlanta, '$this->estado', '$this->observaciones', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}servicio_fin set idLlanta=$this->idLlanta, observaciones='$this->observaciones', estado='$this->estado', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}servicio_fin where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idLlanta, estado, observaciones, fechaRegistro from {$P}servicio_fin $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Servicio_Fin::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Servicio_Fin($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Servicio_Fin($campo, $valor, $filtro, $orden);
        else $objeto=new Servicio_Fin(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idLlanta']=$objeto->getIdLlanta();
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['estadoNombre']=$objeto->getNombreEstado();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['llanta']= json_decode(Llanta::getObjetoJSON('id', $objeto->getIdLlanta(), null, null));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Servicio_Fin::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idLlanta']=$objeto->getIdLlanta();
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['estadoNombre']=$objeto->getNombreEstado();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['llanta']= json_decode(Llanta::getObjetoJSON('id', $objeto->getIdLlanta(), null, null));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
}
