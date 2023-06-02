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
 * Descripcion de la clase Opcion:
 *
 * Define las propiedades id, nombre. ruta, descripcion y fecha de registro, las cuales permiten identificar el tipo de menu, opcion u opcion de menu que hay en el sistema de
 * informacion. La opcion del sistema de informacion podra visualizarse de acuedo a los roles del sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Opcion {
    //Propiedades
    private $id;
    private $idMenu;
    private $nombre;
    private $ruta;
    private $descripcion;
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
                $sql="select id, idMenu, nombre, ruta, descripcion, fechaRegistro from {$P}opcion where $campo=$valor $filtro $orden";
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
    	$this->idMenu=$arreglo['idmenu'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getRuta() {
        return $this->ruta;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getIdMenu() {
        return $this->idMenu;
    }
    
    function getMenu() {
        if ($this->idMenu!=null) return new Opcion ('id', $this->idMenu, null, null);
        else return new Opcion (null, null, null, null);
    }

    function setIdMenu($idMenu) {
        $this->idMenu = $idMenu;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setRuta($ruta) {
        $this->ruta = $ruta;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}opcion (idmenu, nombre, ruta, descripcion, fechaRegistro) values ($this->idMenu, '$this->nombre', '$this->ruta', '$this->descripcion', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function grabarMenu() {
        $P='';
        $sql="insert into {$P}opcion (nombre, descripcion, fechaRegistro) values ('$this->nombre', '$this->descripcion', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function grabarOpcionMenu() {
        $P='';
        $sql="insert into {$P}opcion (idMenu, nombre, descripcion, ruta, fechaRegistro) values ($this->idMenu, '$this->nombre', '$this->descripcion', '$this->ruta', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function grabarOpcion() {
        $P='';
        $sql="insert into {$P}opcion (nombre, descripcion, ruta, fechaRegistro) values ('$this->nombre', '$this->descripcion', '$this->ruta', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificarOpcion() {
        $P='';
        $sql="update {$P}opcion set nombre='$this->nombre', ruta='$this->ruta', descripcion='$this->descripcion' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificarOpcionMenu() {
        $P='';
        $sql="update {$P}opcion set nombre='$this->nombre', ruta='$this->ruta', descripcion='$this->descripcion', idmenu=$this->idMenu where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificarMenu() {
        $P='';
        $sql="update {$P}opcion set nombre='$this->nombre', descripcion='$this->descripcion' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}opcion where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idmenu, nombre, ruta, descripcion, fechaRegistro from {$P}opcion $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Opcion::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Opcion($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        $objeto=new Opcion($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idmenu']=$objeto->getIdMenu();
        $arreglo['nombre']=$objeto->getNombre();
        $arreglo['ruta']=$objeto->getRuta();
        $arreglo['descripcion']=$objeto->getDescripcion();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $menu=$objeto->getMenu();
        $arreglo['nombreMenu']=$objeto->getNombre();
        $arreglo['descripcionMenu']=$objeto->getDescripcion();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Opcion::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['nombre']=$objeto->getNombre();
            $arreglo['ruta']=$objeto->getRuta();
            $arreglo['descripcion']=$objeto->getDescripcion();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $menu=$objeto->getMenu();
            $arreglo['nombreMenu']=$objeto->getNombre();
            $arreglo['descripcionMenu']=$objeto->getDescripcion();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getMenusOpcionesJSON($filtro, $orden) {
        $datos= Opcion::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['nombre']=$objeto->getNombre();
            $arreglo['descripcion']=$objeto->getDescripcion();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $datosOpcionesMenu= Opcion::getListaEnObjetos("idMenu={$objeto->getId()} and ruta is not null", $orden);
            for ($j = 0; $j < count($datosOpcionesMenu); $j++) {
                $objetoOpcion=$datosOpcionesMenu[$j];
                $array=array();
                $array['idOpcion']=$objeto->getId();
                $array['idMenu']=$objeto->getIdMenu();
                $array['nombreOpcion']=$objeto->getNombre();
                $array['DescripcionOpcion']=$objeto->getDescripcion();
                $array['rutaOpcion']=$objeto->getRuta();
                array_push($JSON, $array);
            }
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNumeroOpciones() {
        $sql="select count(id) as cantidad from opcion where ruta<>null";
        $resultado= Conector::ejecutarQuery($sql, null);
    }
}
