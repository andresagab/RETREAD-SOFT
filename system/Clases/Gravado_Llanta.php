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
 * Descripcion de la clase Gravado_Llanta:
 *
 * Define las propiedades id, nombre, descripcion, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Gravado_Llanta {
    //Propiedades
    private $id;
    private $nombre;
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
                $sql="select id, nombre, descripcion, fechaRegistro from {$P}gravado_llanta where $campo=$valor $filtro $orden";
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
        if ($this->nombre!=null) return $this->nombre;
        else {
            if ($this->id!=null) return "No registrado";
            else return null;
        }
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
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
        $sql="insert into {$P}gravado_llanta (nombre, descripcion, fechaRegistro) values ('$this->nombre', '$this->descripcion', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}gravado_llanta set nombre='$this->nombre', descripcion='$this->descripcion' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}gravado_llanta where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, nombre, descripcion, fechaRegistro from {$P}gravado_llanta $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Gravado_Llanta::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Gravado_Llanta($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Gravado_Llanta::getListaEnObjetos($filtro, $orden);
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
        if ($valor!=null && $valor!='') $objeto=new Gravado_Llanta($campo, $valor, $filtro, $orden);
        else $objeto=new Gravado_Llanta(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['nombre']=$objeto->getNombre();
        $arreglo['descripcion']=$objeto->getDescripcion();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['statusDelete']=$objeto->getStatusDelete();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Gravado_Llanta::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['nombre']=$objeto->getNombre();
            $arreglo['descripcion']=$objeto->getDescripcion();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['statusDelete']=$objeto->getStatusDelete();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public function getNumeroReferencias() {
        global $P, $BD;
        $sql="select count(id) as total from {$P}referencia_gravado where idGravadoLlanta=$this->id";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result!=null){
            if ($result[0]['total']!=null) return $result[0]['total'];
            else return 0;
        } else return 0;
    }

    public function getStatusDelete() {
        $status=true;
        $tables = ['llanta', 'embandado', 'registro_banda'];
        if ($this->id!=null) {
            for ($i=0; $i<count($tables); $i++) {
                $sql = "select idgravado from $tables[$i] where idgravado=$this->id";
                $r = Conector::ejecutarQuery($sql, null);
                if ($r!=null) {
                    if ($r[0]['idgravado']==$this->id) {
                        $i = count($tables);
                        $status=false;
                    }
                }
            }
        }
        return $status;
    }

}
