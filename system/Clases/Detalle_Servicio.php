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
 * Descripcion de la clase Detalle_Servicio:
 *
 * Define las propiedades id, idServicio, idTipoServicio, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Detalle_Servicio {
    //Propiedades
    private $id;
    private $idServicio;
    private $idTipoServicio;
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
                $sql="select id, idServicio, idTipoServicio, fechaRegistro from {$P}Detalle_Servicio where $campo=$valor $filtro $orden";
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
    	$this->idServicio=$arreglo['idservicio'];
    	$this->idTipoServicio=$arreglo['idtiposervicio'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdServicio() {
        return $this->idServicio;
    }

    function getIdTipoServicio() {
        return $this->idTipoServicio;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getServicio() {
        if ($this->idServicio!=null) return new Servicio ('id', $this->idServicio, null, null);
        else return new Servicio (null, null, null, null);
    }
    
    function getTipoServicio() {
        if ($this->idTipoServicio!=null) return new Tipo_Servicio ('id', $this->idTipoServicio, null, null);
        else return new Tipo_Servicio (null, null, null, null);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdServicio($idServicio) {
        $this->idServicio = $idServicio;
    }

    function setIdTipoServicio($idTipoServicio) {
        $this->idTipoServicio = $idTipoServicio;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}Detalle_Servicio (idServicio, idTipoServicio, fechaRegistro) values ($this->idServicio, $this->idTipoServicio, '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}Detalle_Servicio set idServicio=$this->idServicio, idTipoServicio=$this->idTipoServicio where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}Detalle_Servicio where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idServicio, idTipoServicio, fechaRegistro from {$P}Detalle_Servicio $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Detalle_Servicio::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Detalle_Servicio($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Detalle_Servicio($campo, $valor, $filtro, $orden);
        else $objeto=new Detalle_Servicio(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idServicio']=$objeto->getIdServicio();
        $arreglo['idTipoServicio']=$objeto->getIdTipoServicio();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['rechazo_Inspeccion_Inicial']= json_decode(Servicio::getObjetoJSON('id', $objeto->getIdServicio(), null, null));
        $arreglo['servicio']= json_decode(Servicio::getObjetoJSON('id', $objeto->getIdServicio(), null, null));
        $arreglo['tipoServicio']= json_decode(Tipo_Servicio::getObjetoJSON('id', $objeto->getIdTipoServicio(), null, null));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Detalle_Servicio::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idServicio']=$objeto->getIdServicio();
            $arreglo['idTipoServicio']=$objeto->getIdTipoServicio();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['rechazo_Inspeccion_Inicial']= json_decode(Servicio::getObjetoJSON('id', $objeto->getIdServicio(), null, null));
            $arreglo['servicio']= json_decode(Servicio::getObjetoJSON('id', $objeto->getIdServicio(), null, null));
            $arreglo['tipoServicio']= json_decode(Tipo_Servicio::getObjetoJSON('id', $objeto->getIdTipoServicio(), null, null));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public function getTiposServicio($json) {
        $response = null;
        if ($this->idServicio!=null) {
            if ($json) {
                $sql = "select ts.id, ts.nombre, ts.observaciones, ts.fecharegistro from tipo_servicio as ts, detalle_servicio as ds where ds.idservicio={$this->idServicio} and ts.id=ds.idtiposervicio";
                $response = Tipo_Servicio::getDataJSON(2, null, null, null, null, $sql, false);
            } else {
                $response = Tipo_Servicio::getListaEnObjetos("id in (select idtiposervicio from detalle_servicio where idservicio={$this->idServicio})", null);
            }
        }
        return $response;
    }

    public static function getDataJSON($type, $field, $value, $filter, $order, $sql, $extras) {
        $JSON = array();
        switch ($type) {
            case 0:
                if ($field!=null && $value!=null) {
                    $object = new Detalle_Servicio($field, $value, $filter, $order);
                    foreach ($object as $key => $val) $JSON["$key"] = $val;
                }
                break;
            case 1:
                $objects = Detalle_Servicio::getListaEnObjetos($filter, $order);
                for ($i=0; $i<count($objects); $i++) {
                    $data = array();
                    foreach ($objects[$i] as $key => $val) $data["$key"] = $val;
                    if ($extras) {
                        $data["tiposServicio"] = json_decode($objects[$i]->getTiposServicio(true));
                    }
                    array_push($JSON, $data);
                }
                break;
            case 2:
                if ($sql!=null) {
                    $response = Conector::ejecutarQuery($sql, null);
                    if (count($response)<=0) $JSON["status"] = false;
                    else $JSON["status"] = true;
                    if (count($response)==1) {
                        foreach ($response[0] as $item => $val) {
                            $JSON["$item"] = $val;
                            ${$item} = $val;
                        }
                        if ($extras) {
                            $object = new Detalle_Servicio(null, null, null, null);
                            @$object->setIdServicio($idservicio);
                            $JSON["tiposServicio"] = json_decode($object->getTiposServicio(true));
                        }
                    } else {
                        for ($i=0; $i<count($response); $i++) {
                            $data = array();
                            foreach ($response[$i] as $item => $val) {
                                $data["$item"] = $val;
                                ${$item} = $val;
                            }
                            if ($extras) {
                                $object = new Detalle_Servicio(null, null, null, null);
                                @$object->setIdServicio($idservicio);
                                $data["tiposServicio"] = json_decode($object->getTiposServicio(true));
                            }
                            array_push($JSON, $data);
                        }
                    }
                }
                break;
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
}
