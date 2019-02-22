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
 * Descripcion de la clase Dimension_Llanta:
 *
 * Define las propiedades id, dimension, fechaRegistro las cuales permite identificar las dimensiones de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Dimension_Llanta {

    private $id;
    private $dimension;
    private $descripcion;
    private $fechaRegistro;

    function __construct($campo, $valor, $filtro, $orden){
    	$BD='';
    	$P='';
    	if ($campo!=null) {
            if (is_array($campo)){
                foreach ($campo as $key => $value) $this->$key=$value;
                $this->cargarAtributos($campo);
            } else {
                $sql="select id, dimension, descripcion, fechaRegistro from {$P}dimension_llanta where $campo=$valor $filtro $orden";
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

    function getDimension() {
        if ($this->dimension!=null) return $this->dimension;
        else {
            if ($this->id!=null) return 'No registrada';
            else return null;
        }
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getMedidaCompleta() {
        return $this->getDimension();
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDimension($dimension) {
        $this->dimension = $dimension;
    }
    
    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
    
    public function grabar() {
        $P='';
        $sql="insert into {$P}dimension_llanta (dimension, descripcion, fechaRegistro) values ('$this->dimension', '$this->descripcion', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}dimension_llanta set dimension='$this->dimension', descripcion='$this->descripcion' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}dimension_llanta where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, dimension, descripcion, fechaRegistro from {$P}dimension_llanta $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Dimension_Llanta::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Dimension_Llanta($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Dimension_Llanta::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            $options.="<option value='{$objeto->getId()}' $selected title='". rtrim($objeto->getDescripcion())."'>{$objeto->getDimension()}</option>";
        }
        return $options;
    }
    
    public static function getDatoJSON($campo, $valor, $filtro, $orden) {
        global $P, $BD;
        if ($campo!=null && $valor!=null){
            $sql="select id, dimension, descripcion, fechaRegistro from {$P}dimension_llanta where $campo=$valor $filtro $orden";
            $resultado=Conector::ejecutarQuery($sql, null);
            $JSON=array();
            if (count($resultado)>0) {
                return json_encode($resultado, JSON_UNESCAPED_UNICODE);
            }
        } else return "[{'null': 'null'}]";
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null) $objeto=new Dimension_Llanta($campo, $valor, $filtro, $orden);
        else $objeto=new Dimension_Llanta(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['dimension']=$objeto->getDimension();
        $arreglo['descripcion']=$objeto->getDescripcion();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['medidaCompleta']=$objeto->getDimension();
        $arreglo['statusDelete']=getStatusDelete($objeto->getId(), ['llanta', 'vehiculo'], 'iddimension');
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Dimension_Llanta::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['dimension']=$objeto->getDimension();
            $arreglo['descripcion']=$objeto->getDescripcion();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['medidaCompleta']=$objeto->getDimension();
            $arreglo['statusDelete']=getStatusDelete($objeto->getId(), ['llanta', 'vehiculo'], 'iddimension');
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function getDimensionesAutocompleteJSON($filter, $order){
        $datos=Dimension_Llanta::getListaEnObjetos($filter, $order);
        $JSON=array();
        for ($i=0; $i<count($datos); $i++){
            $JSON[]=$datos[$i]->getId() . "* " . rtrim($datos[$i]->getDimension());
        }
        return json_encode($JSON);
    }

    

}
