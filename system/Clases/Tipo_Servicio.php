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
 * Descripcion de la clase Tipo_Servicio:
 *
 * Define las propiedades id, nombre, observaciones, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Tipo_Servicio {
    //Propiedades
    private $id;
    private $nombre;
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
                $sql="select id, nombre, observaciones, fechaRegistro from {$P}tipo_servicio where $campo=$valor $filtro $orden";
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
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}tipo_servicio (nombre, observaciones, fechaRegistro) values ('$this->nombre', '$this->observaciones', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}tipo_servicio set nombre='$this->nombre', observaciones='$this->observaciones' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}tipo_servicio where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, nombre, observaciones, fechaRegistro from {$P}tipo_servicio $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Tipo_Servicio::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Tipo_Servicio($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Tipo_Servicio::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            $options.="<option value='{$objeto->getId()}' $selected title='". rtrim($objeto->getObservaciones())."'>". rtrim($objeto->getNombre()) ."</option>";
        }
        return $options;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Tipo_Servicio($campo, $valor, $filtro, $orden);
        else $objeto=new Tipo_Servicio(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['nombre']=$objeto->getNombre();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['statusDelete']=getStatusDelete($objeto->getId(), ['detalle_servicio'], 'idtiposervicio');
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Tipo_Servicio::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['nombre']=$objeto->getNombre();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['statusDelete']=getStatusDelete($objeto->getId(), ['detalle_servicio'], 'idtiposervicio');
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function getDataJSON($type, $field, $value, $filter, $order, $sql, $extras) {
        $JSON = array();
        switch ($type) {
            case 0:
                if ($field!=null && $value=!null) {
                    $object = new Tipo_Servicio($field, $value, $filter, $order);
                    foreach ($object as $item => $val) $JSON["$item"] = $val;
                    if ($extras) {
                        $JSON["statusDelete"] = getStatusDelete($object->getId(), ['detalle_servicio'], 'idtiposervicio');
                    }
                }
                break;
            case 1:
                $objects = Tipo_Servicio::getListaEnObjetos($filter, $order);
                for ($i=0; $i<count($objects); $i++) {
                    $data = array();
                    foreach ($objects[$i] as $object => $val) $data["$object"] = $val;
                    if ($extras) {
                        $JSON["statusDelete"] = getStatusDelete($objects[$i]->getId(), ['detalle_servicio'], 'idtiposervicio');
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
                        if ($extras) {
                            @$data["statusDelete"] = getStatusDelete($id, ['detalle_servicio'], 'idtiposervicio');
                        }
                        array_push($JSON, $data);
                    }
                }
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

}
