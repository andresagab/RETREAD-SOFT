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
 * Descripcion de la clase Puc:
 *
 * Define las propiedades id, codigo, nombre, descripcion, nivel, fechaRegistro las cuales permite identificar a los productos u otros elementos o registros del sistema.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Puc{
    //Propiedades
    private $id;
    private $codigo;
    private $nombre;
    private $descripcion;
    private $nivel;
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
                $sql="select id, codigo, nombre, descripcion, nivel, fechaRegistro from {$P}puc where $campo=$valor $filtro $orden";
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

    function getDescripcion() {
        return $this->descripcion;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNivel() {
        return $this->nivel;
    }
        
    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNivel($nivel) {
        $this->nivel = $nivel;
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
        $sql="insert into {$P}puc (nombre, codigo, descripcion, nivel, fechaRegistro) values ('$this->nombre', '$this->codigo', '$this->descripcion', $this->nivel, '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}puc set nombre='$this->nombre', codigo='$this->codigo', descripcion='$this->descripcion', nivel=$this->nivel where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}puc where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, nombre, codigo, descripcion, nivel, fechaRegistro from {$P}puc $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Puc::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Puc($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        $objeto=new Puc($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['nombre']=$objeto->getNombre();
        $arreglo['codigo']=$objeto->getCodigo();
        $arreglo['descripcion']=$objeto->getDescripcion();
        $arreglo['nivel']=$objeto->getNivel();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Puc::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['nombre']=$objeto->getNombre();
            $arreglo['codigo']=$objeto->getCodigo();
            $arreglo['descripcion']=$objeto->getDescripcion();
            $arreglo['nivel']=$objeto->getNivel();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getMaxId() {
        $P='';
        $sql="select max(id) as max from {$P}puc";
        $resultado= Conector::ejecutarQuery($sql, null);
        if ($resultado!=null){
            if ($resultado[0]['max']!=null) {
                $codigo = $resultado[0]['max'];
                do {
                    $next=false;
                    $codigo++;
                    $sql="select codigo from puc where codigo='$codigo'";
                    $res = Conector::ejecutarQuery($sql, null);
                    if ($res!=null) {
                        if ($res[0]['codigo']!=null) $next=true;
                        else $next = false;
                    } else $next = false;
                } while ($next);
                return $codigo-1;
                //return $resultado[0]['max'];
            } else return 0;
        } else return 0;
    }
}
