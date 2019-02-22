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
 * Descripcion de la clase Telefono_Persona:
 *
 * Define las propiedades id, identificacion, numero, extension, tipo, fechaRegistro las cuales permiten relacionar uno o varios telefonos x con una persona y, 
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Telefono_Persona {
    //Propiedades
    private $id;
    private $identificacion;
    private $numero;
    private $extension;
    private $tipo;
    private $fechaRegistro;
    //Fin propiedades

    //Constructor
    function __construct($campo, $valor, $filtro, $orden){
    	$BD='panam';
    	$P='';
    	if ($campo!=null) {
            if (is_array($campo)){
                foreach ($campo as $key => $value) $this->$key=$value;
                $this->setClave($this->clave);
                $this->cargarAtributos($campo);
            } else {
                $sql="select id, identificacion, numero, extension, tipo, fechaRegistro from {$P}telefono_persona where $campo=$valor $filtro $orden";
                $resultado=Conector::ejecutarQuery($sql, $bd);
                if (count($resultado>0)) {
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

    function getIdentificacion() {
        return $this->identificacion;
    }

    function getNumero() {
        return $this->numero;
    }

    function getExtension() {
        return $this->extension;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getPersona() {
        if ($this->identificacion!=null) return new Persona ('identificacion', "'$this->identificacion'", null, null);
        else return new Persona (null, null, null, null);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdentificacion($identificacion) {
        $this->identificacion = $identificacion;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setExtension($extension) {
        $this->extension = $extension;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public static function grabar() {
        $P='';
        $sql="insert into {$P}telefono_persona (identificacion, numero, extension, tipo, fechaRegistro) values ('$this->identificacion', '$this->numero', '$this->extension', '$this->tipo', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public static function modificar() {
        $P='';
        $sql="update {$P}telefono_persona set identificacion='$this->identificacion', numero='$this->numero', extension='$this->extension', tipo='$this->tipo', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public static function eliminar() {
        $P='';
        $sql="delete from {$P}telefono_persona where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, identificacion, numero, extension, tipo, fechaRegistro from {$P}telefono_persona $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Telefono_Persona::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Telefono_Persona($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        $objeto=new Telefono_Persona($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['identificacion']=$objeto->getIdentificacion();
        $arreglo['numero']=$objeto->getNumero();
        $arreglo['extension']=$objeto->getExtension();
        $arreglo['tipo']=$objeto->getTipo();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $persona=$objeto->getPersona();
        $arreglo['nombresPersona']=$persona->getNombres();
        $arreglo['apellidosPersona']=$persona->getApellidos();
        $arreglo['nombresCompletosPersona']=$persona->getNombresCompletos();
        $arreglo['emailPersona']=$persona->getEmail();
        $arreglo['fechaNacimientoPersona']=$persona->getFechaNacimiento();
        $arreglo['fechaRegistroPersona']=$persona->getFechaRegistro();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Telefono_Persona::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['identificacion']=$objeto->getIdentificacion();
            $arreglo['numero']=$objeto->getNumero();
            $arreglo['extension']=$objeto->getExtension();
            $arreglo['tipo']=$objeto->getTipo();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $persona=$objeto->getPersona();
            $arreglo['nombresPersona']=$persona->getNombres();
            $arreglo['apellidosPersona']=$persona->getApellidos();
            $arreglo['nombresCompletosPersona']=$persona->getNombresCompletos();
            $arreglo['emailPersona']=$persona->getEmail();
            $arreglo['fechaNacimientoPersona']=$persona->getFechaNacimiento();
            $arreglo['fechaRegistroPersona']=$persona->getFechaRegistro();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
}
