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
 * Descripcion de la clase Usuario:
 *
 * Define las propiedades id, usuario. clave, idRol, estado y fechaRegistro las cuales permite identificar los usuarios que usan el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Usuario {
    //Propiedades
    private $id;
    private $usuario;
    private $clave;
    private $idRol;
    private $estado;
    private $fechaRegistro;
    //Fin propiedades

    //Constructor
    function __construct($campo, $valor, $filtro, $orden){
    	//$BD='panam';
    	$P='';
    	if ($campo!=null) {
            if (is_array($campo)){
                foreach ($campo as $key => $value) $this->$key=$value;
                $this->setClave($this->clave);
                $this->cargarAtributos($campo);
            } else {
                $sql="select id, usuario, clave, idRol, estado, fechaRegistro from {$P}usuario where $campo=$valor $filtro $orden";
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
    	$this->idRol=$arreglo['idrol'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getClave() {
        return $this->clave;
    }

    function getIdRol() {
        return $this->idRol;
    }

    function getEstado() {
        return $this->estado;
    }
    
    function getNombreEstado() {
        if ($this->estado){
            return 'Activo';
        } else return 'Bloqueado';
    }
    
    function getRol() {
        if ($this->idRol!=null) return new Rol('id', $this->idRol, null, null);
        else return new Rol (null, null, null, null);
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setClave($clave) {
        if (strlen($clave)<=30) $clave= md5($clave);
        $this->clave = $clave;
    }

    function setIdRol($idRol) {
        $this->idRol = $idRol;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}usuario (usuario, clave, idRol, estado, fechaRegistro) values ('$this->usuario', '$this->clave', $this->idRol, '$this->estado', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}usuario set usuario='$this->usuario', clave='$this->clave', idRol=$this->idRol, estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificarUsuario() {
        $P='';
        $sql="update {$P}usuario set usuario='$this->usuario' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function cambiarClave() {
        $P='';
        $sql="update {$P}usuario set clave='$this->clave' where id=$this->id";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null) return true;
        else return false;
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}usuario where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, usuario, clave, idRol, estado, fechaRegistro from {$P}usuario $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Usuario::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Usuario($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Usuario($campo, $valor, $filtro, $orden);
        else $objeto=new Usuario(null, null, null, null);
        $objeto=new Usuario($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['usuario']=$objeto->getUsuario();
        $arreglo['clave']=$objeto->getClave();
        $arreglo['idRol']=$objeto->getIdRol();
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['nombreEstado']=$objeto->getNombreEstado();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['nombreRol']=$objeto->getRol()->getNombre();
        $arreglo['estadoRol']=$objeto->getRol()->getEstado();
        $arreglo['nombreEstadoRol']=$objeto->getRol()->getNombreEstado();
        $arreglo['statusDelete']=$objeto->getStatusDelete();
        $rol=$objeto->getRol();
        if ($rol->getId()!=null) $arreglo['rol']=json_decode($rol->getRolJSON('id', $objeto->getIdRol(), null, null));
        else $arreglo['rol']=json_decode($rol->getRolJSON(null, null, null, null));
        $arreglo['empleadoUsuario']=json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleadoUsuario(), null, null));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Usuario::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['usuario']=$objeto->getUsuario();
            $arreglo['clave']=$objeto->getClave();
            $arreglo['idRol']=$objeto->getIdRol();
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['nombreEstado']=$objeto->getNombreEstado();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['nombreRol']=$objeto->getRol()->getNombre();
            $arreglo['estadoRol']=$objeto->getRol()->getEstado();
            $arreglo['nombreEstadoRol']=$objeto->getRol()->getNombreEstado();
            $arreglo['statusDelete']=$objeto->getStatusDelete();
            $rol=$objeto->getRol();
            if ($rol->getId()!=null) $arreglo['rol']=json_decode($rol->getRolJSON('id', $objeto->getIdRol(), null, null));
            else $arreglo['rol']=json_decode($rol->getRolJSON(null, null, null, null));
            $arreglo['empleadoUsuario']=json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleadoUsuario(), null, null));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function validar($usuario, $clave){
        //return false;
        $user=new Usuario('usuario', "'$usuario'", null, null);
        if ($user->getUsuario()!=null){
            if ($user->getClave()== md5($clave)) {
                if ($user->getEstado()) return true;
                else return false;
            } else return false;
        } else return false;
    }
    
    public function getIdEmpleadoUsuario() {
        global $P, $BD;
        $sql="select e.id from {$P}usuario u, {$P}usuario_persona up, {$P}empleado e where u.id=up.idUsuario and up.identificacion=e.identificacion and u.id=$this->id";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result[0]['id']!=null) return $result[0]['id'];
        else return 0;
    }

    public function getStatusDelete (){
        $valid=true;
        if ($this->usuario!=null) {
            if ($this->getClave()!=md5('usuariopanam')) $valid=false;
        }
        return $valid;
    }

}
