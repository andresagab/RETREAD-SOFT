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
 * Descripcion de la clase Empleado:
 *
 * Define las propiedades id, identificacion, idCargo, fechaRegistro las cuales permiten relacionar a una persona x con una cargo, 
 * proporcionandole a dicha persona un perfil de tipo empleado con un cargo determinado atravez del atributo idCargo.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Empleado {
    //Propiedades
    private $id;
    private $identificacion;
    private $idCargo;
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
                $sql="select id, identificacion, idCargo, fechaRegistro from {$P}empleado where $campo=$valor $filtro $orden";
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
    	$this->idCargo=$arreglo['idcargo'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdentificacion() {
        return $this->identificacion;
    }

    function getIdCargo() {
        return $this->idCargo;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getPersona() {
        if ($this->identificacion!=null) return new Persona ('identificacion', "'$this->identificacion'", null, null);
        else return new Persona (null, null, null, null);
    }
//    
//    function getCargo() {
//        if ($this->idCargo!=null) return new Cargo_Empleado('id', $this->idCargo, null, null);
//        else return new Cargo_Empleado (null, null, null, null);
//    }
//    
    function getCargo() {
        if ($this->idCargo!=null) return new Rol('id', $this->idCargo, null, null);
        else return new Rol(null, null, null, null);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdentificacion($identificacion) {
        $this->identificacion = $identificacion;
    }

    function setIdCargo($idCargo) {
        $this->idCargo = $idCargo;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}empleado (identificacion, idCargo, fechaRegistro) values ('$this->identificacion', $this->idCargo, '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}empleado set identificacion='$this->identificacion', idCargo=$this->idCargo, fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}empleado where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, identificacion, idCargo, fechaRegistro from {$P}empleado $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Empleado::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Empleado($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Empleado::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getPersona()->getNombresCompletos()) ."</option>";
        }
        return $options;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Empleado($campo, $valor, $filtro, $orden);
        else $objeto=new Empleado (null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['identificacion']=$objeto->getIdentificacion();
        $arreglo['idCargo']=$objeto->getIdCargo();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $persona=$objeto->getPersona();
        $arreglo['nombresPersona']=$persona->getNombres();
        $arreglo['apellidosPersona']=$persona->getApellidos();
        $arreglo['nombresCompletosPersona']=$persona->getNombresCompletos();
        $arreglo['celular']=$persona->getCelular();
        $arreglo['emailPersona']=$persona->getEmail();
        $arreglo['direccion']=$persona->getDireccion();
        $arreglo['fechaNacimientoPersona']=$persona->getFechaNacimiento();
        $arreglo['fechaRegistroPersona']=$persona->getFechaRegistro();
        $cargo=$objeto->getCargo();
        $arreglo['nombreCargo']=$cargo->getNombre();
        //$arreglo['descripcionCargo']=$cargo->getDescripcion();
        $arreglo['fechaRegistroCargo']=$cargo->getFechaRegistro();
        $arreglo['statusDelete']=$objeto->getStatusDelete();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Empleado::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['identificacion']=$objeto->getIdentificacion();
            $arreglo['idCargo']=$objeto->getIdCargo();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $persona=$objeto->getPersona();
            $arreglo['nombresPersona']=$persona->getNombres();
            $arreglo['apellidosPersona']=$persona->getApellidos();
            $arreglo['nombresCompletosPersona']=$persona->getNombresCompletos();
            $arreglo['celular']=$persona->getCelular();
            $arreglo['emailPersona']=$persona->getEmail();
            $arreglo['direccion']=$persona->getDireccion();
            $arreglo['fechaNacimientoPersona']=$persona->getFechaNacimiento();
            $arreglo['fechaRegistroPersona']=$persona->getFechaRegistro();
            $cargo=$objeto->getCargo();
            $arreglo['nombreCargo']=$cargo->getNombre();
            //$arreglo['descripcionCargo']=$cargo->getDescripcion();
            $arreglo['fechaRegistroCargo']=$cargo->getFechaRegistro();
            $arreglo['statusDelete']=$objeto->getStatusDelete();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getIdentificacionesJSON($filtro, $orden) {
        $datos= Empleado::getListaEnObjetos($filtro, $orden);
        $json=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $json[]= rtrim($objeto->getIdentificacion()) . " (" . $objeto->getPersona()->getNombresCompletos() . ")";
        }
        return json_encode($json);
    }

    public static function getDataJSON($type, $field, $value, $filter, $order, $sql, $extras){
        $JSON=array();
        switch ($type) {
            case 0:
                if ($field!=null && $value!=null) {
                    foreach (new Empleado($field, $value, $field, $order) as $key => $val) {
                        $JSON["$key"]=$value;
                        ${$key}=$value;
                    }
                    if ($extras) {
                        @$JSON['objectPersona'] = json_decode(Persona::getObjetoJSON('identificacion', $identificacion, null, null));
                    }
                }
                break;
            case 1:
                $objects = Empleado::getListaEnObjetos($filter, $order);
                for ($i=0; $i<count($objects); $i++) {
                    $array=array();
                    foreach ($objects[$i] as $key => $val) {
                        $array["$key"]=$val;
                        ${$key}=$val;
                    }
                    if ($extras) {
                        @$JSON['objectPersona'] = json_decode(Persona::getObjetoJSON('identificacion', $identificacion, null, null));
                    }
                    array_push($JSON, $array);
                }
                break;
            case 2:
                if ($sql!=null) {
                    $r = Conector::ejecutarQuery($sql, null);
                    for ($i=0; $i<count($r); $i++) {
                        $array=array();
                        foreach ($r[$i] as $key => $val) {
                            $array["$key"]=$val;
                            ${$key}=$val;
                        }
                        if ($extras) {
                            @$JSON['objectPersona'] = json_decode(Persona::getObjetoJSON('identificacion', $identificacion, null, null));
                        }
                        array_push($JSON, $array);
                    }
                }
                break;
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public function getStatusDelete (){
        /*
         * true => puede eliminarse
         * false => no se puede eliminar
         */
        $valid=true;
        if ($this->id!=null) {

            $tables = ["carga_producto", "carga_producto_puesto_trabajo", "cementado", "corte_banda", "embandado", "inspeccion_final", "inspeccion_inicial", "insumo_terminacion", "novedad_puesto_trabajo", "preparacion", "raspado", "relleno", "reparacion", "servicio", "terminacion", "uso_insumo_proceso", "uso_insumo_proceso_detalle", "vulcanizado"];

            for ($i=0; $i<count($tables); $i++) {
                if ($tables[$i]=='servicio') $sql = "select id from {$tables[$i]} where idvendedor={$this->id}";
                else $sql = "select id from {$tables[$i]} where idempleado={$this->id}";
                $r = Conector::ejecutarQuery($sql, null);
                if ($r!=null) {
                    if ($r[0][0]!=null) {
                        $i=count($tables);
                        $valid=false;
                    }
                }
            }

        }
        return $valid;
    }
}
