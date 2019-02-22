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
 * Descripcion de la clase Contacto_Persona:
 *
 * Define las propiedades id, identificacion, numero, extension, tipo, fechaRegistro las cuales permiten relacionar uno o varios telefonos x con una persona y, 
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Contacto_Persona {
    //Propiedades
    private $id;
    private $identificacionPersona;
    private $nombres;
    private $apellidos;
    private $telefono;
    private $celular;
    private $direccion;
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
                $sql="select id, identificacionPersona, nombres, apellidos, telefono, celular, direccion, fechaRegistro from {$P}contacto_persona where $campo=$valor $filtro $orden";
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
    	$this->identificacionPersona=$arreglo['identificacionpersona'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdentificacionPersona() {
        return $this->identificacionPersona;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getCelular() {
        return $this->celular;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdentificacionPersona($identificacionPersona) {
        $this->identificacionPersona = $identificacionPersona;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
    
    function getPersona() {
        if ($this->identificacionPersona!=null) return new Persona ('identificacion', "'$this->identificacionPersona'", null, null);
        else return new Persona (null, null, null, null);
    }
    
    function getNombresCompletos() {
        if ($this->nombres && $this->apellidos !=null) return rtrim ($this->nombres)." ".rtrim ($this->apellidos);
        else return null;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}contacto_persona (identificacionPersona, nombres, apellidos, telefono, celular, direccion, fechaRegistro) values ('$this->identificacionPersona', '$this->nombres', '$this->apellidos', '$this->telefono', '$this->celular', '$this->direccion', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}contacto_persona set nombres='$this->nombres', apellidos='$this->apellidos', telefono='$this->telefono', celular='$this->celular', direccion='$this->direccion', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}contacto_persona where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, identificacionPersona, nombres, apellidos, telefono, celular, direccion, fechaRegistro from {$P}contacto_persona $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Contacto_Persona::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Contacto_Persona($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        $objeto=new Contacto_Persona($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['identificacionPersona']=$objeto->getIdentificacionPersona();
        $arreglo['nombresContacto']= rtrim($objeto->getNombres());
        $arreglo['apellidosContacto']= rtrim($objeto->getApellidos());
        $arreglo['nombreCompletosContacto']= $objeto->getNombresCompletos();
        $arreglo['telefonoContacto']= rtrim($objeto->getTelefono());
        $arreglo['celularContacto']= rtrim($objeto->getCelular());
        $arreglo['direccionContacto']= rtrim($objeto->getDireccion());
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $persona=$objeto->getPersona();
        $arreglo['nombresPersona']=$persona->getNombres();
        $arreglo['apellidosPersona']=$persona->getApellidos();
        $arreglo['nombresCompletosPersona']=$persona->getNombresCompletos();
        $arreglo['celularPersona']=$persona->getCelular();
        $arreglo['direccionrsona']=$persona->getDireccion();
        $arreglo['emailPersona']=$persona->getEmail();
        $arreglo['fechaNacimientoPersona']=$persona->getFechaNacimiento();
        $arreglo['fechaRegistroPersona']=$persona->getFechaRegistro();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Contacto_Persona::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['identificacionPersona']=$objeto->getIdentificacionPersona();
            $arreglo['nombresContacto']= rtrim($objeto->getNombres());
            $arreglo['apellidosContacto']= rtrim($objeto->getApellidos());
            $arreglo['nombresCompletosContacto']= $objeto->getNombresCompletos();
            $arreglo['telefonoContacto']= rtrim($objeto->getTelefono());
            $arreglo['celularContacto']= rtrim($objeto->getCelular());
            $arreglo['direccionContacto']= rtrim($objeto->getDireccion());
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $persona=$objeto->getPersona();
            $arreglo['nombresPersona']=$persona->getNombres();
            $arreglo['apellidosPersona']=$persona->getApellidos();
            $arreglo['nombresCompletosPersona']=$persona->getNombresCompletos();
            $arreglo['celularPersona']=$persona->getCelular();
            $arreglo['direccionrsona']=$persona->getDireccion();
            $arreglo['emailPersona']=$persona->getEmail();
            $arreglo['fechaNacimientoPersona']=$persona->getFechaNacimiento();
            $arreglo['fechaRegistroPersona']=$persona->getFechaRegistro();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
}
