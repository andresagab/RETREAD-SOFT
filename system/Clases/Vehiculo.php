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
 * Descripcion de la clase Vehiculo:
 *
 * Define las propiedades id, nombre, descripcion, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Vehiculo {
    //Propiedades
    private $id;
    private $identificacion;
    private $idMarcaVehiulo;
    private $placa;
    private $linea;
    private $modelo;
    private $clase;
    private $combustible;
    private $numeroLlantas;
    private $idDimension;
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
                $sql="select id, identificacion, idMarcaVehiculo, placa, linea, modelo, clase, combustible, numeroLlantas, idDimension, fechaRegistro from {$P}vehiculo where $campo=$valor $filtro $orden";
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
    	$this->idMarcaVehiulo=$arreglo['idmarcavehiculo'];
    	$this->numeroLlantas=$arreglo['numerollantas'];
    	$this->idDimension=$arreglo['iddimension'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }    
    
    function getId() {
        return $this->id;
    }

    function getIdentificacion() {
        return $this->identificacion;
    }

    function getIdMarcaVehiulo() {
        return $this->idMarcaVehiulo;
    }

    function getPlaca() {
        return $this->placa;
    }

    function getLinea() {
        return $this->linea;
    }

    function getModelo() {
        return $this->modelo;
    }

    function getClase() {
        return $this->clase;
    }

    function getCombustible() {
        return $this->combustible;
    }

    function getNumeroLlantas() {
        return $this->numeroLlantas;
    }

    function getIdDimension() {
        return $this->idDimension;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getPersona() {
        if ($this->identificacion!=null) return new Persona('identificacion', "'$this->identificacion'", null, null);
        else return new Persona (null, null, null, null);
    }
    
    function getMarcaVehiculo() {
        if ($this->idMarcaVehiulo!=null) return new Marca_Vehiculo ('id', $this->idMarcaVehiulo, null, null);
        else return new Marca_Vehiculo (null, null, null, null);
    }
    
    function getDimensionLlanta() {
        if ($this->idDimension!=null) return new Dimension_Llanta('id', $this->idDimension, null, null);
        else return new Dimension_Llanta(null, null, null, null);
    }
    
    function getNombreCombustible() {
        switch ($this->combustible) {
            case 0:
                return 'Gasolina';
                break;
            case 1:
                return 'ACPM';
                break;
            default:
                return 'Desconocido';
                break;
        }
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdentificacion($identificacion) {
        $this->identificacion = $identificacion;
    }

    function setIdMarcaVehiulo($idMarcaVehiulo) {
        $this->idMarcaVehiulo = $idMarcaVehiulo;
    }

    function setPlaca($placa) {
        $this->placa = $placa;
    }

    function setLinea($linea) {
        $this->linea = $linea;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    function setClase($clase) {
        $this->clase = $clase;
    }

    function setCombustible($combustible) {
        $this->combustible = $combustible;
    }

    function setNumeroLlantas($numeroLlantas) {
        $this->numeroLlantas = $numeroLlantas;
    }

    function setIdDimension($idDimension) {
        $this->idDimension = $idDimension;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
    
    public function grabar() {
        $P='';
        $sql="insert into {$P}vehiculo (identificacion, idMarcaVehiculo, placa, linea, modelo, clase, combustible, numeroLlantas, idDimension, fechaRegistro) values "
        . "('$this->identificacion', $this->idMarcaVehiulo, '$this->placa', '$this->linea', '$this->modelo', '$this->clase', $this->combustible, $this->numeroLlantas, $this->idDimension, '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}vehiculo set idMarcaVehiculo=$this->idMarcaVehiulo, placa='$this->placa', linea='$this->linea', modelo='$this->modelo', clase='$this->clase', combustible=$this->combustible, numeroLlantas=$this->numeroLlantas, idDimension=$this->idDimension where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}vehiculo where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, identificacion, idMarcaVehiculo, placa, linea, modelo, clase, combustible, numeroLlantas, idDimension, fechaRegistro from {$P}vehiculo $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Vehiculo::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Vehiculo($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getCombustiblesOptions($default) {
        $options="<option value=''>Seleccione una opcion</option>";
        if ($default==0) $options.="<option value='0' selected>Gasolina</option><option value='1'>ACPM</option>";
        else $options.="<option value='0'>Gasolina</option><option value='1' selected>ACPM</option>";
        return $options;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        $objeto=new Vehiculo($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['identificacion']= rtrim($objeto->getIdentificacion());
        $arreglo['idMarcaVehiculo']=$objeto->getIdMarcaVehiulo();
        $arreglo['placa']= rtrim($objeto->getPlaca());
        $arreglo['linea']= rtrim($objeto->getLinea());
        $arreglo['modelo']= rtrim($objeto->getModelo());
        $arreglo['clase']= rtrim($objeto->getClase());
        $arreglo['combustible']= $objeto->getCombustible();
        $arreglo['nombreCombustible']= $objeto->getNombreCombustible();
        $arreglo['numeroLlantas']= $objeto->getNumeroLlantas();
        $arreglo['idDimension']= $objeto->getIdDimension();
        $marcaVehiculo=$objeto->getMarcaVehiculo();
        $arreglo['nombreMarca']= rtrim($marcaVehiculo->getNombre());
        $arreglo['descripcionMarca']= rtrim($marcaVehiculo->getDescripcion());
        $dimension=$objeto->getDimensionLlanta();
        $arreglo['medidaDimension']= $dimension->getMedidaCompleta();
        $arreglo['descripcionDimension']= $dimension->getDescripcion();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Vehiculo::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['identificacion']= rtrim($objeto->getIdentificacion());
            $arreglo['idMarcaVehiculo']=$objeto->getIdMarcaVehiulo();
            $arreglo['placa']= rtrim($objeto->getPlaca());
            $arreglo['linea']= rtrim($objeto->getLinea());
            $arreglo['modelo']= rtrim($objeto->getModelo());
            $arreglo['clase']= rtrim($objeto->getClase());
            $arreglo['combustible']= $objeto->getCombustible();
            $arreglo['nombreCombustible']= $objeto->getNombreCombustible();
            $arreglo['numeroLlantas']= $objeto->getNumeroLlantas();
            $arreglo['idDimension']= $objeto->getIdDimension();
            $marcaVehiculo=$objeto->getMarcaVehiculo();
            $arreglo['nombreMarca']= rtrim($marcaVehiculo->getNombre());
            $arreglo['descripcionMarca']= rtrim($marcaVehiculo->getDescripcion());
            $dimension=$objeto->getDimensionLlanta();
            $arreglo['medidaDimension']= $dimension->getMedidaCompleta();
            $arreglo['descripcionDimension']= $dimension->getDescripcion();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
}
