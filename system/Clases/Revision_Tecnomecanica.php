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
 * Descripcion de la clase Revision_Tecnomecanica:
 *
 * Define las propiedades id, identificacion, nit, razonSocial,  y fechaRegistro las cuales permite identificar a las personas de tipo revision_tecnomecanica que pertenecen el sistema de informacion.
 * Por medio de la propiedad identificacion, podemos relacionar los atributos de la tabla (clase) Persona con los de la mensionada en este archivo.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Revision_Tecnomecanica {
    //Propiedades
    private $id;
    private $idVehiculo;
    private $fechaExpedicion;
    private $fechaFinVigencia;
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
                $sql="select id, idVehiculo, fechaExpedicion, fechaFinVigencia, fechaRegistro from {$P}revision_tecnomecanica where $campo=$valor $filtro $orden";
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
    	$this->idVehiculo=$arreglo['idvehiculo'];
    	$this->fechaExpedicion=$arreglo['fechaexpedicion'];
    	$this->fechaFinVigencia=$arreglo['fechafinvigencia'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    function getId() {
        return $this->id;
    }

    function getIdVehiculo() {
        return $this->idVehiculo;
    }

    function getFechaExpedicion() {
        return $this->fechaExpedicion;
    }

    function getFechaFinVigencia() {
        return $this->fechaFinVigencia;
    }
    
    function getVehiculo() {
        if ($this->idVehiculo!=null) return new Vehiculo ('id', $this->idVehiculo, null, null);
        else return new Vehiculo (null, null, null, null);
    }
    
    function getEstado() {
        global $P, $BD;
        date_default_timezone_set("America/Bogota");
        $fecha= date("Y-m-d");
        if ($fecha<= $this->fechaFinVigencia) return 'Vigente';
        else return 'Vencido';
    }
    
    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdVehiculo($idVehiculo) {
        $this->idVehiculo = $idVehiculo;
    }

    function setFechaExpedicion($fechaExpedicion) {
        $this->fechaExpedicion = $fechaExpedicion;
    }

    function setFechaFinVigencia($fechaFinVigencia) {
        $this->fechaFinVigencia = $fechaFinVigencia;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
    
    public function grabar() {
        $P='';
        $sql="insert into {$P}revision_tecnomecanica (idVehiculo, fechaExpedicion, fechaFinVigencia, fechaRegistro) values ($this->idVehiculo, '$this->fechaExpedicion', '$this->fechaFinVigencia', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}revision_tecnomecanica set fechaExpedicion='$this->fechaExpedicion', fechaFinVigencia='$this->fechaFinVigencia' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}revision_tecnomecanica where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idVehiculo, fechaExpedicion, fechaFinVigencia, fechaRegistro from {$P}revision_tecnomecanica $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Revision_Tecnomecanica::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Revision_Tecnomecanica($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        $objeto=new Revision_Tecnomecanica($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idVehiculo']=$objeto->getIdVehiculo();
        $arreglo['fechaExpedicion']=$objeto->getFechaExpedicion();
        $arreglo['fechaFinVigencia']=$objeto->getFechaFinVigencia();
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $vehiculo=$objeto->getVehiculo();
        $arreglo['identificacionPersona']= rtrim($vehiculo->getIdentificacion());
        $arreglo['idMarca']= $vehiculo->getIdMarcaVehiulo();
        $arreglo['nombreMarca']= rtrim($vehiculo->getMarcaVehiculo()->getNombre());
        $arreglo['descripcionMarca']= rtrim($vehiculo->getMarcaVehiculo()->getDescripcion());
        $arreglo['placa']= rtrim($vehiculo->getPlaca());
        $arreglo['linea']= rtrim($vehiculo->getLinea());
        $arreglo['modelo']= rtrim($vehiculo->getModelo());
        $arreglo['clase']= rtrim($vehiculo->getClase());
        $arreglo['combustible']= rtrim($vehiculo->getCombustible());
        $arreglo['nombreCombustible']= rtrim($vehiculo->getNombreCombustible());
        $arreglo['numeroLlantas']= rtrim($vehiculo->getNumeroLlantas());
        $arreglo['idDimension']= rtrim($vehiculo->getIdDimension());
        $arreglo['medidaDimension']= $vehiculo->getDimensionLlanta()->getMedidaCompleta();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Revision_Tecnomecanica::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idVehiculo']=$objeto->getIdVehiculo();
            $arreglo['fechaExpedicion']=$objeto->getFechaExpedicion();
            $arreglo['fechaFinVigencia']=$objeto->getFechaFinVigencia();
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $vehiculo=$objeto->getVehiculo();
            $arreglo['identificacionPersona']= rtrim($vehiculo->getIdentificacion());
            $arreglo['idMarca']= $vehiculo->getIdMarcaVehiulo();
            $arreglo['nombreMarca']= rtrim($vehiculo->getMarcaVehiculo()->getNombre());
            $arreglo['descripcionMarca']= rtrim($vehiculo->getMarcaVehiculo()->getDescripcion());
            $arreglo['placa']= rtrim($vehiculo->getPlaca());
            $arreglo['linea']= rtrim($vehiculo->getLinea());
            $arreglo['modelo']= rtrim($vehiculo->getModelo());
            $arreglo['clase']= rtrim($vehiculo->getClase());
            $arreglo['combustible']= rtrim($vehiculo->getCombustible());
            $arreglo['nombreCombustible']= rtrim($vehiculo->getNombreCombustible());
            $arreglo['numeroLlantas']= rtrim($vehiculo->getNumeroLlantas());
            $arreglo['idDimension']= rtrim($vehiculo->getIdDimension());
            $arreglo['medidaDimension']= $vehiculo->getDimensionLlanta()->getMedidaCompleta();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
}
