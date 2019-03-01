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
 * Descripcion de la clase Uso_Insumo_Proceso_Detalle:
 *
 * Define las propiedades id, idUsoInsumoProceso, idInsumoPt, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Uso_Insumo_Proceso_Detalle {
    //Propiedades
    private $id;
    private $idUsoInsumoProceso;
    private $idInsumoPt;
    private $cantidad;
    private $terminado;
    private $usado;
    private $idEmpleado;
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
                $sql="select id, idUsoInsumoProceso, idInsumoPt, cantidad, terminado, usado, idEmpleado, fechaRegistro from {$P}Uso_Insumo_Proceso_Detalle where $campo=$valor $filtro $orden";
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
    	$this->idUsoInsumoProceso=$arreglo['idusoinsumoproceso'];
    	$this->idInsumoPt=$arreglo['idinsumopt'];
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdUsoInsumoProceso() {
        return $this->idUsoInsumoProceso;
    }

    function getIdInsumoPt() {
        return $this->idInsumoPt;
    }
    
    function getTerminado() {
        return $this->terminado;
    }
    
    function getUsado() {
        return $this->usado;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getUsoInsumoProceso() {
        if ($this->idUsoInsumoProceso!=null) return new Uso_Insumo_Proceso ('id', $this->idUsoInsumoProceso, null, null);
        else return new Uso_Insumo_Proceso (null, null, null, null);
    }
    
    function getInsumoPt() {
        if ($this->idInsumoPt!=null) return new Insumo_Puesto_Trabajo ('id', $this->idInsumoPt, null, null);
        else return new Insumo_Puesto_Trabajo (null, null, null, null);
    }
    
    function getEmpleado() {
        if ($this->idEmpleado!=null) return new Empleado ('id', $this->idEmpleado, null, null);
        else return new Empleado (null, null, null, null);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdUsoInsumoProceso($idUsoInsumoProceso) {
        $this->idUsoInsumoProceso = $idUsoInsumoProceso;
    }

    function setIdInsumoPt($idInsumoPt) {
        $this->idInsumoPt = $idInsumoPt;
    }
    
    function setTerminado($terminado) {
        $this->terminado = $terminado;
    }
    
    function setUsado($usado) {
        $this->usado = $usado;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    function getNombreTerminado() {
        if ($this->terminado) return 'Si';
        else return 'No';
    }

    function getNombreUsado() {
        if ($this->usado) return 'Si';
        else return 'No';
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}Uso_Insumo_Proceso_Detalle (idUsoInsumoProceso, idInsumoPt, cantidad, usado,terminado, idEmpleado, fechaRegistro) values ($this->idUsoInsumoProceso, $this->idInsumoPt, $this->cantidad, '$this->usado', '$this->terminado', $this->idEmpleado, '$this->fechaRegistro')";
        $res=Conector::ejecutarQuery($sql, null);
        if ($res!=null) return true;
        else return false;
    }

    public function modificar() {
        $P='';
        $sql="update {$P}Uso_Insumo_Proceso_Detalle set idUsoInsumoProceso=$this->idUsoInsumoProceso, idInsumoPt=$this->idInsumoPt, cantidad=$this->cantidad, terminado='$this->terminado', usado='$this->usado', idEmpleado=$this->idEmpleado where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}Uso_Insumo_Proceso_Detalle where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idUsoInsumoProceso, idInsumoPt, cantidad, terminado, usado, idEmpleado, fechaRegistro from {$P}Uso_Insumo_Proceso_Detalle $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Uso_Insumo_Proceso_Detalle::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Uso_Insumo_Proceso_Detalle($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Uso_Insumo_Proceso_Detalle($campo, $valor, $filtro, $orden);
        else $objeto=new Uso_Insumo_Proceso_Detalle (null, null, null, null);
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idUsoInsumoProceso']=$objeto->getIdUsoInsumoProceso();
        $arreglo['idInsumoPt']=$objeto->getIdInsumoPt();
        $arreglo['cantidad']=$objeto->getCantidad();
        $arreglo['terminado']=$objeto->getTerminado();
        $arreglo['usado']=$objeto->getUsado();
        $arreglo['idEmpleado']=$objeto->getIdEmpleado();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['usoInsumoProceso']= json_decode(Uso_Insumo_Proceso::getObjetoJSON('id', $objeto->getIdUsoInsumoProceso(), null, null));
        $arreglo['insumoPT']= json_decode(Insumo_Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdInsumoPt(), null, null));
        $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
        $arreglo['nombreTerminado']= $objeto->getNombreTerminado();
        $arreglo['nombreUsado']= $objeto->getNombreUsado();
        return json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Uso_Insumo_Proceso_Detalle::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idUsoInsumoProceso']=$objeto->getIdUsoInsumoProceso();
            $arreglo['idInsumoPt']=$objeto->getIdInsumoPt();
            $arreglo['cantidad']=$objeto->getCantidad();
            $arreglo['terminado']=$objeto->getTerminado();
            $arreglo['usado']=$objeto->getUsado();
            $arreglo['idEmpleado']=$objeto->getIdEmpleado();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['usoInsumoProceso']= json_decode(Uso_Insumo_Proceso::getObjetoJSON('id', $objeto->getIdUsoInsumoProceso(), null, null));
            $arreglo['insumoPT']= json_decode(Insumo_Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdInsumoPt(), null, null));
            $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
            $arreglo['nombreTerminado']= $objeto->getNombreTerminado();
            $arreglo['nombreUsado']= $objeto->getNombreUsado();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function registrarUsos($idUsoInsumoProceso, $idEmpleado, $datos) {
        $valid=false;
        if ($idUsoInsumoProceso!=null && $idUsoInsumoProceso!='' && $datos!=null && $datos!='' && $idEmpleado!=null && $idEmpleado!=''){
            $sql="select registrarUsosInsumosProcesoDetalle($idUsoInsumoProceso, $idEmpleado, '$datos')";
            $r= Conector::ejecutarQuery($sql, null);
            if ($r!=null) $valid=true;
        }
        return $valid;
    }

    public static function getDataJSON($type, $field, $value, $filter, $order, $sql, $extras) {
        $JSON = array();
        switch ($type) {
            case 0:
                if ($field!=null && $value!=null) {
                    foreach ($object = new Uso_Insumo_Proceso_Detalle($field, $value, $filter, $order) as $item => $val) {
                        $JSON["$item"] = $val;
                        ${$item} = $val;
                    }
                    $JSON['nombreTerminado']= $object->getNombreTerminado();
                    $JSON['nombreUsado']= $object->getNombreUsado();
                    if ($extras) {
                        $JSON['usoInsumoProceso'] = json_decode(Uso_Insumo_Proceso::getObjetoJSON('id', $object->getIdUsoInsumoProceso(), null, null));
                        $JSON['insumoPT']= json_decode(Insumo_Puesto_Trabajo::getObjetoJSON('id', $object->getIdInsumoPt(), null, null));
                        $JSON['empleado']= json_decode(Empleado::getObjetoJSON('id', $object->getIdEmpleado(), null, null));
                    }
                }
                break;
            case 1:
                $objects = Uso_Insumo_Proceso_Detalle::getListaEnObjetos($filter, $order);
                for ($i=0; $i<count($objects); $i++) {
                    $data = array();
                    $object = $objects[$i];
                    foreach ($objects[$i] as $item => $val) {
                        $data["$item"] = $val;
                        ${$item} = $val;
                    }
                    $data['nombreTerminado']= $object->getNombreTerminado();
                    $data['nombreUsado']= $object->getNombreUsado();
                    if ($extras) {
                        $data['usoInsumoProceso'] = json_decode(Uso_Insumo_Proceso::getObjetoJSON('id', $object->getIdUsoInsumoProceso(), null, null));
                        $data['insumoPT']= json_decode(Insumo_Puesto_Trabajo::getObjetoJSON('id', $object->getIdInsumoPt(), null, null));
                        $data['empleado']= json_decode(Empleado::getObjetoJSON('id', $object->getIdEmpleado(), null, null));
                    }
                    array_push($JSON, $data);
                }
                break;
            case 2:
                if ($sql!=null) {
                    $result = Conector::ejecutarQuery($sql, null);
                    for ($i=0; $i<count($result); $i++) {
                        $data = array();
                        foreach ($result[$i] as $item => $val) {
                            $data["$item"] = $val;
                            ${$item} = $val;
                        }
                        $object = new Uso_Insumo_Proceso_Detalle(null, null, null, null);
                        $object->setId(@$id);
                        $object->setTerminado(@$terminado);
                        $object->setUsado(@$usado);
                        $data['nombreTerminado']= $object->getNombreTerminado();
                        $data['nombreUsado']= $object->getNombreUsado();
                        if ($extras) {
                            $data['usoInsumoProceso'] = json_decode(Uso_Insumo_Proceso::getObjetoJSON('id', $object->getIdUsoInsumoProceso(), null, null));
                            $data['insumoPT']= json_decode(Insumo_Puesto_Trabajo::getObjetoJSON('id', $object->getIdInsumoPt(), null, null));
                            $data['empleado']= json_decode(Empleado::getObjetoJSON('id', $object->getIdEmpleado(), null, null));
                        }
                        array_push($JSON, $data);
                    }
                }
                break;
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
}
