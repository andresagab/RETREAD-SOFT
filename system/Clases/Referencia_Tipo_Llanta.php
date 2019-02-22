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
 * Observaciones de la clase Referencia_Tipo_Llanta:
 *
 * Define las propiedades id, referencia, observaciones, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Referencia_Tipo_Llanta {
    //Propiedades
    private $id;
    private $idTipoLlanta;
    private $referencia;
    private $observaciones;
    private $fechaRegistro;
    //Fin propiedades

    //Constructor
    function __construct($campo, $valor, $filtro, $orden){
    	//$BD='panam';
    	$P='';
    	if ($campo!=null) {
            if (is_array($campo)){
                foreach ($campo as $key => $value) $this->$key=$value;
                $this->cargarAtributos($campo);
            } else {
                $sql="select id, idTipoLlanta, referencia, observaciones, fechaRegistro from {$P}referencia_tipo_llanta where $campo=$valor $filtro $orden";
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
    	$this->idTipoLlanta=$arreglo['idtipollanta'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }
    
    function getIdTipoLlanta() {
        return $this->idTipoLlanta;
    }

    function getReferencia() {
        //echo $this->referencia;die();
        if ($this->referencia!=null) return $this->referencia;
        else {
            if ($this->id!=null) return "No registrado";
            else return null;
        }
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function getTipoLlanta() {
        if ($this->idTipoLlanta!=null) return new Tipo_Llanta ('id', $this->idTipoLlanta, null, null);
        else return new Tipo_Llanta (null, null, null, null);
    }

    function setId($id) {
        $this->id = $id;
    }
    
    function setIdTipoLlanta($idTipoLlanta) {
        $this->idTipoLlanta = $idTipoLlanta;
    }

    function setReferencia($referencia) {
        $this->referencia = $referencia;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}referencia_tipo_llanta (idTipoLlanta, referencia, observaciones, fechaRegistro) values ($this->idTipoLlanta, '$this->referencia', '$this->observaciones', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}referencia_tipo_llanta set idTipoLlanta=$this->idTipoLlanta, referencia='$this->referencia', observaciones='$this->observaciones' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}referencia_tipo_llanta where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idTipoLlanta, referencia, observaciones, fechaRegistro from {$P}referencia_tipo_llanta $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Referencia_Tipo_Llanta::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Referencia_Tipo_Llanta($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Referencia_Tipo_Llanta::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getReferencia()) ."</option>";
        }
        return $options;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Referencia_Tipo_Llanta($campo, $valor, $filtro, $orden);
        else $objeto=new Referencia_Tipo_Llanta (null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idTipoLlanta']=$objeto->getIdTipoLlanta();
        $arreglo['referencia']=$objeto->getReferencia();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['tipoLlanta']= json_decode(Tipo_Llanta::getObjetoJSON('id', $objeto->getIdTipoLlanta(), null, null));
        $arreglo['numeroMedidas']= $objeto->getNumeroMedidas();
        $arreglo['statusDelete'] = $objeto->getOwnStatusDelete();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Referencia_Tipo_Llanta::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idTipoLlanta']=$objeto->getIdTipoLlanta();
            $arreglo['referencia']=$objeto->getReferencia();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['tipoLlanta']= json_decode(Tipo_Llanta::getObjetoJSON('id', $objeto->getIdTipoLlanta(), null, null));
            $arreglo['numeroMedidas']= $objeto->getNumeroMedidas();
            $arreglo['statusDelete'] = $objeto->getOwnStatusDelete();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public function getNumeroMedidas() {
        global $P, $BD;
        if ($this->id!=null && $this->id!=''){
            $sql="select count(id) as total from {$P}dimension_referencia where idReferenciaTipoLlanta=$this->id";
            $result= Conector::ejecutarQuery($sql, null);
            if ($result!=null){
                if ($result[0]['total']!=null) return $result[0]['total'];
                else return 0;
            } else return 0;
        } else return 0;
    }

    public static function getDataJSON($type, $field, $value, $filter, $order, $extras){
        $JSON=array();
        if ($type){
            if ($value!=null && $value!='') $objeto=new Referencia_Tipo_Llanta($field, $value, $filter, $order);
            else $objeto=new Referencia_Tipo_Llanta (null, null, null, null);
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idTipoLlanta']=$objeto->getIdTipoLlanta();
            $arreglo['referencia']=$objeto->getReferencia();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            if ($extras) $arreglo['tipoLlanta']= json_decode(Tipo_Llanta::getObjetoJSON('id', $objeto->getIdTipoLlanta(), null, null));
            $arreglo['numeroMedidas']= $objeto->getNumeroMedidas();
            array_push($JSON, $arreglo);
        } else {
            $datos= Referencia_Tipo_Llanta::getListaEnObjetos($filter, $order);
            for ($i = 0; $i < count($datos); $i++) {
                $objeto=$datos[$i];
                $arreglo=array();
                $arreglo['id']=$objeto->getId();
                $arreglo['idTipoLlanta']=$objeto->getIdTipoLlanta();
                $arreglo['referencia']=$objeto->getReferencia();
                $arreglo['observaciones']=$objeto->getObservaciones();
                $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
                if ($extras) $arreglo['tipoLlanta']= json_decode(Tipo_Llanta::getObjetoJSON('id', $objeto->getIdTipoLlanta(), null, null));
                $arreglo['numeroMedidas']= $objeto->getNumeroMedidas();
                array_push($JSON, $arreglo);
            }
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public function getOwnStatusDelete() {
        $ids = ['idreferenciatipollanta', 'idreferenciaoriginal', 'idreferenciasolicitada'];
        $tables = ['dimension_referencia', 'llanta', 'llanta'];
        $status = true;
        if ($this->id!=null) {
            $status = getStatusDelete($this->id, ["$tables[0]"], $ids[0]);
            if ($status) {
                $status = getStatusDelete($this->id, ["$tables[1]"], $ids[1]);
                if ($status) {
                    $status = getStatusDelete($this->id, ["$tables[1]"], $ids[2]);
                }
            }
        }
        return $status;
    }

}
