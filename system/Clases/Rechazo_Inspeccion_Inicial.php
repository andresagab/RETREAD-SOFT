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
 * Descripcion de la clase Rechazo_Inspeccion_Inicial:
 *
 * Define las propiedades id, idInspeccionInicial, observaciones, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Rechazo_Inspeccion_Inicial {
    //Propiedades
    private $id;
    private $idInspeccionInicial;
    private $observaciones;
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
                $sql="select id, idInspeccionInicial, observaciones, fechaRegistro from {$P}Rechazo_Inspeccion_Inicial where $campo=$valor $filtro $orden";
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
    	$this->idInspeccionInicial=$arreglo['idinspeccioninicial'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdInspeccionInicial() {
        return $this->idInspeccionInicial;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdInspeccionInicial($idInspeccionInicial) {
        $this->idInspeccionInicial = $idInspeccionInicial;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}Rechazo_Inspeccion_Inicial (idInspeccionInicial, observaciones, fechaRegistro) values ($this->idInspeccionInicial, '$this->observaciones', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}Rechazo_Inspeccion_Inicial set idInspeccionInicial=$this->idInspeccionInicial, observaciones='$this->observaciones' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}Rechazo_Inspeccion_Inicial where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idInspeccionInicial, observaciones, fechaRegistro from {$P}Rechazo_Inspeccion_Inicial $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Rechazo_Inspeccion_Inicial::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Rechazo_Inspeccion_Inicial($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Rechazo_Inspeccion_Inicial::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            $options.="<option value='{$objeto->getId()}' $selected title='". rtrim($objeto->getObservaciones())."'>". rtrim($objeto->getIdInspeccionInicial()) ."</option>";
        }
        return $options;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        $objeto=new Rechazo_Inspeccion_Inicial($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idInspeccionInicial']=$objeto->getIdInspeccionInicial();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Rechazo_Inspeccion_Inicial::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idInspeccionInicial']=$objeto->getIdInspeccionInicial();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
}
