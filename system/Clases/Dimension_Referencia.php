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
 * Descripcion de la clase Dimension_Referencia:
 *
 * Define las propiedades id, base, profundidad, peso, fechaRegistro las cuales permite identificar las dimensiones de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Dimension_Referencia {
    //Propiedades
    private $id;
    private $idReferenciaTipoLlanta;
    private $base;
    private $profundidad;
    private $peso;
    private $largo;
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
                $sql="select id, idReferenciaTipoLlanta, base, profundidad, peso, largo, observaciones, fechaRegistro from {$P}dimension_referencia where $campo=$valor $filtro $orden";
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
    	$this->idReferenciaTipoLlanta=$arreglo['idreferenciatipollanta'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdReferenciaTipoLlanta() {
        return $this->idReferenciaTipoLlanta;
    }

    function getBase() {
        return $this->base;
    }

    function getProfundidad() {
        return $this->profundidad;
    }

    function getPeso() {
        return $this->peso;
    }

    function getLargo() {
        return $this->largo;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function getReferenciaTipoLlanta() {
        if ($this->idReferenciaTipoLlanta!=null) return new Referencia_Tipo_Llanta ('id', $this->idReferenciaTipoLlanta, null, null);
        else return new Referencia_Tipo_Llanta (null, null, null, null);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdReferenciaTipoLlanta($idReferenciaTipoLlanta) {
        $this->idReferenciaTipoLlanta = $idReferenciaTipoLlanta;
    }

    function setBase($base) {
        $this->base = $base;
    }

    function setProfundidad($profundidad) {
        $this->profundidad = $profundidad;
    }

    function setPeso($peso) {
        $this->peso = $peso;
    }

    function setLargo($largo) {
        $this->largo = $largo;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
    
    public function grabar() {
        $P='';
        $sql="insert into {$P}dimension_referencia (idReferenciaTipoLlanta, base, profundidad, peso, largo, observaciones, fechaRegistro) values ($this->idReferenciaTipoLlanta, $this->base, $this->profundidad, $this->peso, $this->largo, '$this->observaciones', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}dimension_referencia set idReferenciaTipoLlanta=$this->idReferenciaTipoLlanta, base=$this->base, profundidad=$this->profundidad, peso=$this->peso, largo=$this->largo, observaciones='$this->observaciones' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}dimension_referencia where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idReferenciaTipoLlanta, base, profundidad, peso, largo, observaciones, fechaRegistro from {$P}dimension_referencia $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Dimension_Referencia::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Dimension_Referencia($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Dimension_Referencia::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            $options.="<option value='{$objeto->getId()}' $selected title='". rtrim($objeto->getObservaciones())."'>{$objeto->getBase()} - {$objeto->getProfundidad()} - {$objeto->getPeso()} - {$objeto->getLargo()}</option>";
        }
        return $options;
    }
    
    public static function getDatoJSON($campo, $valor, $filtro, $orden) {
        global $P, $BD;
        if ($campo!=null && $valor!=null){
            $sql="select id, idReferenciaTipoLlanta, base, profundidad, peso, largo, observaciones, fechaRegistro from {$P}dimension_referencia where $campo=$valor $filtro $orden";
            $resultado=Conector::ejecutarQuery($sql, null);
            $JSON=array();
            if (count($resultado)>0) {
                return json_encode($resultado, JSON_UNESCAPED_UNICODE);
            }
        } else return "[{'null': 'null'}]";
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Dimension_Referencia($campo, $valor, $filtro, $orden);
        else $objeto=new Dimension_Referencia(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idReferenciaTipoLlanta']=$objeto->getIdReferenciaTipoLlanta();
        $arreglo['base']=$objeto->getBase();
        $arreglo['profundidad']=$objeto->getProfundidad();
        $arreglo['peso']=$objeto->getPeso();
        $arreglo['largo']=$objeto->getLargo();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        //if ($objeto->getId()!='' && $objeto->getId()!=null) $arreglo['medidaCompleta']=$objeto->getBase()." - ".$objeto->getProfundidad()." - ".$objeto->getPeso() . " / " . $objeto->getLargo();
        if ($objeto->getId()!='' && $objeto->getId()!=null) $arreglo['medidaCompleta']=$objeto->getMedidaCompleta();
        else $arreglo['medidaCompleta']="Pendiente";
        $arreglo['referenciaTipoLlanta']= json_decode(Referencia_Tipo_Llanta::getObjetoJSON('id', $objeto->getIdReferenciaTipoLlanta(), null, null));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Dimension_Referencia::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idReferenciaTipoLlanta']=$objeto->getIdReferenciaTipoLlanta();
            $arreglo['base']=$objeto->getBase();
            $arreglo['profundidad']=$objeto->getProfundidad();
            $arreglo['peso']=$objeto->getPeso();
            $arreglo['largo']=$objeto->getLargo();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            //if ($objeto->getId()!='' && $objeto->getId()!=null) $arreglo['medidaCompleta']=$objeto->getBase()." - ".$objeto->getProfundidad()." - ".$objeto->getPeso() . " / " . $objeto->getLargo();
            if ($objeto->getId()!='' && $objeto->getId()!=null) $arreglo['medidaCompleta']=$objeto->getMedidaCompleta();
            else $arreglo['medidaCompleta']="Pendiente";
            $arreglo['referenciaTipoLlanta']= json_decode(Referencia_Tipo_Llanta::getObjetoJSON('id', $objeto->getIdReferenciaTipoLlanta(), null, null));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public function getMedidaCompleta() {
        //if ($this->id!=null && $this->id!='') return $this->getBase()." - ".$this->getProfundidad()." - ".$this->getPeso() . " / " . $this->getLargo();
        if ($this->id!=null && $this->id!='') return "B: " . $this->getBase()." - PR: ".$this->getProfundidad()." - PE: ".$this->getPeso() . " - LR: " . $this->getLargo();
        else return 'Pendiente';
    }
    
    public function getEstado() {
        /*
         * Si el id del objeto es vacio, significa que el estado es y esta
         * pendiente por ser registrado, en caso contrario sera true
         */
        if ($this->id!=null && $this->id!='') return true;
        else return false;
    }

    public static function getDataJSON($type, $field, $value, $filter, $order, $extras){
        $JSON=array();
        if ($type){
            if ($value!=null && $value!='') $objeto=new Dimension_Referencia($field, $value, $filter, $order);
            else $objeto=new Dimension_Referencia(null, null, null, null);
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idReferenciaTipoLlanta']=$objeto->getIdReferenciaTipoLlanta();
            $arreglo['base']=$objeto->getBase();
            $arreglo['profundidad']=$objeto->getProfundidad();
            $arreglo['peso']=$objeto->getPeso();
            $arreglo['largo']=$objeto->getLargo();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            if ($objeto->getId()!='' && $objeto->getId()!=null) $arreglo['medidaCompleta']=$objeto->getMedidaCompleta();
            else $arreglo['medidaCompleta']="Pendiente";
            if ($extras) $arreglo['referenciaTipoLlanta']= json_decode(Referencia_Tipo_Llanta::getObjetoJSON('id', $objeto->getIdReferenciaTipoLlanta(), null, null));
            array_push($JSON, $arreglo);
        } else {
            $datos= Dimension_Referencia::getListaEnObjetos($filter, $order);
            for ($i = 0; $i < count($datos); $i++) {
                $objeto=$datos[$i];
                $arreglo=array();
                $arreglo['id']=$objeto->getId();
                $arreglo['idReferenciaTipoLlanta']=$objeto->getIdReferenciaTipoLlanta();
                $arreglo['base']=$objeto->getBase();
                $arreglo['profundidad']=$objeto->getProfundidad();
                $arreglo['peso']=$objeto->getPeso();
                $arreglo['largo']=$objeto->getLargo();
                $arreglo['observaciones']=$objeto->getObservaciones();
                $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
                //if ($objeto->getId()!='' && $objeto->getId()!=null) $arreglo['medidaCompleta']=$objeto->getBase()." - ".$objeto->getProfundidad()." - ".$objeto->getPeso() . " / " . $objeto->getLargo();
                if ($objeto->getId()!='' && $objeto->getId()!=null) $arreglo['medidaCompleta']=$objeto->getMedidaCompleta();
                else $arreglo['medidaCompleta']="Pendiente";
                if ($extras) $arreglo['referenciaTipoLlanta']= json_decode(Referencia_Tipo_Llanta::getObjetoJSON('id', $objeto->getIdReferenciaTipoLlanta(), null, null));
                array_push($JSON, $arreglo);
            }
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }


}
