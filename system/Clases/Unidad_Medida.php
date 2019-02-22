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
 * Descripcion de la clase Unidad_Medida:
 *
 * Define las propiedades id, nombre, sigla, descripcion, fechaRegistro las cuales permite identificar las unidades de medida para los productos del sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Unidad_Medida {
    //Propiedades
    private $id;
    private $nombre;
    private $sigla;
    private $descripcion;
    private $fechaRegistro;
    //Fin propiedades

    //Constructor
    function __construct($campo, $valor, $filtro, $orden){
    	$BD='';
    	$P='';
    	if ($campo!=null) {
            if (is_array($campo)){
                foreach ($campo as $key => $value) $this->$key=$value;
                $this->cargarAtributos($campo);
            } else {
                $sql="select id, nombre, sigla, descripcion, fechaRegistro from {$P}unidad_medida where $campo=$valor $filtro $orden";
                $resultado=Conector::ejecutarQuery($sql, $BD);
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

    function getDescripcion() {
        return $this->descripcion;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getSigla() {
        return $this->sigla;
    }

    function setSigla($sigla) {
        $this->sigla = $sigla;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}unidad_medida (nombre, descripcion, sigla, fechaRegistro) values ('$this->nombre', '$this->descripcion', '$this->sigla', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}unidad_medida set nombre='$this->nombre', descripcion='$this->descripcion', sigla='$this->sigla' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}unidad_medida where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, nombre, sigla, descripcion, fechaRegistro from {$P}unidad_medida $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Unidad_Medida::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Unidad_Medida($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        $objeto=new Unidad_Medida($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['nombre']=$objeto->getNombre();
        $arreglo['sigla']=$objeto->getSigla();
        $arreglo['descripcion']=$objeto->getDescripcion();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['statusDelete']=getStatusDelete($objeto->getId(), ['producto'], 'idunidadmedida');
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Unidad_Medida::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['nombre']=$objeto->getNombre();
            $arreglo['sigla']=$objeto->getSigla();
            $arreglo['descripcion']=$objeto->getDescripcion();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['statusDelete']=getStatusDelete($objeto->getId(), ['producto'], 'idunidadmedida');
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Unidad_Medida::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            $options.="<option value='{$objeto->getId()}' title='". rtrim($objeto->getDescripcion())."' $selected>". rtrim($objeto->getNombre()) ." (". rtrim($objeto->getSigla()).") </option>";
        }
        return $options;
    }
}
