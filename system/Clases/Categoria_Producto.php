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
 * Descripcion de la clase Categoria_Producto:
 *
 * Define las propiedades id, nombre, idCategoria, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Categoria_Producto {
    //Propiedades
    private $id;
    private $idCategoria;
    private $nombre;
    private $descripcion;
    private $imagen;
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
                $sql="select id, idCategoria, nombre, descripcion, imagen, fechaRegistro from {$P}categoria_producto where $campo=$valor $filtro $orden";
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
    	$this->idCategoria=$arreglo['idcategoria'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getIdCategoria() {
        return $this->idCategoria;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getDescripcion() {
        return $this->descripcion;
    }
    
    function getImagen() {
        return $this->imagen;
    }
    
    function getCategoria() {
        if ($this->idCategoria!=NULL) return new Categoria_Producto ('id', $this->idCategoria, NULL, NULL);
        else return new Categoria_Producto (null, null, null, null);
    }
    
    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }
    
    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    
    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}categoria_producto (nombre, idCategoria, descripcion, imagen, fechaRegistro) values ('$this->nombre', $this->idCategoria, '$this->descripcion', '$this->imagen', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}categoria_producto set nombre='$this->nombre', idCategoria=$this->idCategoria, descripcion='$this->descripcion', imagen='$this->imagen' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}categoria_producto where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idCategoria, nombre, descripcion, imagen, fechaRegistro from {$P}categoria_producto $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Categoria_Producto::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Categoria_Producto($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Categoria_Producto::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getNombre()) ."</option>";
        }
        return $options;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null){
            $objeto=new Categoria_Producto($campo, $valor, $filtro, $orden);
            $JSON=array();
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idCategoria']=$objeto->getIdCategoria();
            $arreglo['nombre']= rtrim($objeto->getNombre());
            $arreglo['descripcion']= rtrim($objeto->getDescripcion());
            $arreglo['imagen']= rtrim($objeto->getImagen());
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['categoria']= json_decode(Categoria_Producto::getObjetoJSON('id', $objeto->getIdCategoria(), null, null));
            $arreglo['statusDelete'] = getStatusDelete($objeto->getId(), ['producto'], 'idcategoria');
            array_push($JSON, $arreglo);
            return json_encode($JSON, JSON_UNESCAPED_UNICODE);
        } else return null;
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Categoria_Producto::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idCategoria']=$objeto->getIdCategoria();
            $arreglo['nombre']= rtrim($objeto->getNombre());
            $arreglo['descripcion']= rtrim($objeto->getDescripcion());
            $arreglo['imagen']= rtrim($objeto->getImagen());
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['categoria']= json_decode(Categoria_Producto::getObjetoJSON('id', $objeto->getIdCategoria(), null, null));
            $arreglo['statusDelete'] = getStatusDelete($objeto->getId(), ['producto'], 'idcategoria');
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNextId() {
        global $P, $BD;
        $sql="select max(id)+1 as id from {$P}categoria_producto";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result!=null){
            if ($result[0]['id']!=null) return $result[0]['id'];
            else return 1;
        } else return 1;
    }
}
