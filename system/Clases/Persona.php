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
 * Descripcion de la clase Persona:
 *
 * Define las propiedades identificacion, nombres, apellidos, email, fechaNacimiento y fechaRegistro las cuales permite identificar a las personas que usan y/o pertenecen el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Persona {
    //Propiedades
    private $identificacion;
    private $nombres;
    private $apellidos;
    private $celular;
    private $email;
    private $direccion;
    private $fechaNacimiento;
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
                $sql="select identificacion, nombres, apellidos, celular, email, direccion, fechaNacimiento, fechaRegistro from {$P}persona where $campo=$valor $filtro $orden";
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
    	$this->fechaNacimiento=$arreglo['fechanacimiento'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getIdentificacion() {
        return $this->identificacion;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getEmail() {
        return $this->email;
    }

    function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function getNombresCompletos() {
        return "".rtrim($this->nombres)." ".rtrim($this->apellidos);
    }
    
    function getCelular() {
        return $this->celular;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setIdentificacion($identificacion) {
        $this->identificacion = $identificacion;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}persona (identificacion, nombres, apellidos, celular, email, direccion, fechaNacimiento, fechaRegistro) values ('$this->identificacion', '$this->nombres', '$this->apellidos', '$this->celular', '$this->email', '$this->direccion', '$this->fechaNacimiento', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar($identificacionAnterior) {
        $P='';
        $sql="update {$P}persona set identificacion='$this->identificacion', nombres='$this->nombres', apellidos='$this->apellidos', celular='$this->celular', email='$this->email', direccion='$this->direccion',fechaNacimiento='$this->fechaNacimiento', fechaRegistro='$this->fechaRegistro' where identificacion='$identificacionAnterior'";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}persona where identificacion='$this->identificacion'";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select identificacion, nombres, apellidos, celular, email, direccion, fechaNacimiento, fechaRegistro from {$P}persona $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Persona::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Persona($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        $objeto=new Persona($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['identificacion']=$objeto->getIdentificacion();
        $arreglo['nombres']=$objeto->getNombres();
        $arreglo['apellidos']=$objeto->getApellidos();
        $arreglo['nombresCompletos']=$objeto->getNombresCompletos();
        $arreglo['celular']=$objeto->getCelular();
        $arreglo['email']=$objeto->getEmail();
        $arreglo['direccion']=$objeto->getDireccion();
        $arreglo['fechaNacimiento']=$objeto->getFechaNacimiento();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Persona::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['identificacion']=$objeto->getIdentificacion();
            $arreglo['nombres']=$objeto->getNombres();
            $arreglo['apellidos']=$objeto->getApellidos();
            $arreglo['nombresCompletos']=$objeto->getNombresCompletos();
            $arreglo['celular']= rtrim($objeto->getCelular());
            $arreglo['email']=$objeto->getEmail();
            $arreglo['direccion']= rtrim($objeto->getDireccion());
            $arreglo['fechaNacimiento']=$objeto->getFechaNacimiento();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
}
