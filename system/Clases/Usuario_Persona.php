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
 * Descripcion de la clase Usuario_Persona:
 *
 * Define las propiedades id, identificacion, idUsuario, fechaRegistro las cuales permiten relacionar un usuario x con una persona y, 
 * proporcionandole un acceso al sistema de acuerdo al rol del usuario.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Usuario_Persona {
    //Propiedades
    private $id;
    private $identificacion;
    private $idUsuario;
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
                $sql="select id, identificacion, idUsuario, fechaRegistro from {$P}usuario_persona where $campo=$valor $filtro $orden";
                $resultado=Conector::ejecutarQuery($sql, null);
                if (count($resultado>0)) {
                    foreach ($resultado[0] as $key => $value) $this->$key=$value;
                    $this->cargarAtributos($resultado[0]);
                }
            }
    	} else return null;
    }
    //Fin constructor

    private function cargarAtributos($arreglo){
    	$this->idUsuario=$arreglo['idusuario'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdentificacion() {
        return $this->identificacion;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getPersona() {
        if ($this->identificacion!=null) return new Persona ('identificacion', "'$this->identificacion'", null, null);
        else return new Persona (null, null, null, null);
    }
    
    function getUsuario() {
        if ($this->idUsuario!=null) return new Usuario('id', $this->idUsuario, null, null);
        else return new Usuario (null, null, null, null);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdentificacion($identificacion) {
        $this->identificacion = $identificacion;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}usuario_persona (identificacion, idUsuario, fechaRegistro) values ('$this->identificacion', $this->idUsuario, '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}usuario_persona set identificacion='$this->identificacion', idUsuario=$this->idUsuario, fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}usuario_persona where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, identificacion, idUsuario, fechaRegistro from {$P}usuario_persona $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Usuario_Persona::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Usuario_Persona($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        $objeto=new Usuario_Persona($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['identificacion']=$objeto->getIdentificacion();
        $arreglo['idUsuario']=$objeto->getIdUsuario();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $persona=$objeto->getPersona();
        $arreglo['nombresPersona']=$persona->getNombres();
        $arreglo['apellidosPersona']=$persona->getApellidos();
        $arreglo['nombresCompletosPersona']=$persona->getNombresCompletos();
        $arreglo['emailPersona']=$persona->getEmail();
        $arreglo['fechaNacimientoPersona']=$persona->getFechaNacimiento();
        $arreglo['fechaRegistroPersona']=$persona->getFechaRegistro();
        $usuario=$objeto->getUsuario();
        $arreglo['usuario']=$usuario->getUsuario();
        $arreglo['claveUsuario']=$usuario->getClave();
        $arreglo['estadoUsuario']=$usuario->getEstado();
        $arreglo['nombreEstadoUsuario']=$usuario->getNombreEstado();
        $arreglo['fechaRegistroUsuario']=$usuario->getFechaRegistro();
        $arreglo['idRol']=$usuario->getIdRol();
        $rol=$usuario->getRol();
        $arreglo['nombreRol']=$rol->getNombre();
        $arreglo['estadoRol']=$rol->getEstado();
        $arreglo['nombreEstadoRol']=$rol->getNombreEstado();
        $arreglo['fechaRegistroRol']=$rol->getFechaRegistro();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Usuario_Persona::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['identificacion']=$objeto->getIdentificacion();
            $arreglo['idUsuario']=$objeto->getIdUsuario();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $persona=$objeto->getPersona();
            $arreglo['nombresPersona']=$persona->getNombres();
            $arreglo['apellidosPersona']=$persona->getApellidos();
            $arreglo['nombresCompletosPersona']=$persona->getNombresCompletos();
            $arreglo['emailPersona']=$persona->getEmail();
            $arreglo['fechaNacimientoPersona']=$persona->getFechaNacimiento();
            $arreglo['fechaRegistroPersona']=$persona->getFechaRegistro();
            $usuario=$objeto->getUsuario();
            $arreglo['usuario']=$usuario->getUsuario();
            $arreglo['claveUsuario']=$usuario->getClave();
            $arreglo['estadoUsuario']=$usuario->getEstado();
            $arreglo['nombreEstadoUsuario']=$usuario->getNombreEstado();
            $arreglo['fechaRegistroUsuario']=$usuario->getFechaRegistro();
            $arreglo['idRol']=$usuario->getIdRol();
            $rol=$usuario->getRol();
            $arreglo['nombreRol']=$rol->getNombre();
            $arreglo['estadoRol']=$rol->getEstado();
            $arreglo['nombreEstadoRol']=$rol->getNombreEstado();
            $arreglo['fechaRegistroRol']=$rol->getFechaRegistro();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
}
