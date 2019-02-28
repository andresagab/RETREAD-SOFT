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
 * Descripcion de la clase Cliente:
 *
 * Define las propiedades id, identificacion, nit, razonSocial,  y fechaRegistro las cuales permite identificar a las personas de tipo cliente que pertenecen el sistema de informacion.
 * Por medio de la propiedad identificacion, podemos relacionar los atributos de la tabla (clase) Persona con los de la mensionada en este archivo.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Cliente {
    //Propiedades
    private $id;
    private $identificacion;
    private $nit;
    private $razonSocial;
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
                $sql="select id, identificacion, nit, razonSocial, fechaRegistro from {$P}cliente where $campo=$valor $filtro $orden";
                //echo $sql;
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
    	$this->razonSocial=$arreglo['razonsocial'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdentificacion() {
        return $this->identificacion;
    }

    function getNit() {
        return $this->nit;
    }

    function getRazonSocial() {
        return $this->razonSocial;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function getPersona() {
        if ($this->identificacion!=null) return new Persona('identificacion', "'$this->identificacion'", null, null);
        else return new Persona (null, null, null, null);
    }
    
    function getDatoCliente() {
        $datoCliente='';
        if ($this->getPersona()->getNombresCompletos()!='') $datoCliente.=$this->getPersona()->getNombresCompletos()." ";
        if ($this->getRazonSocial()!='') $datoCliente.="".rtrim($this->getRazonSocial())."";
        return $datoCliente;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdentificacion($identificacion) {
        $this->identificacion = $identificacion;
    }

    function setNit($nit) {
        $this->nit = $nit;
    }

    function setRazonSocial($razonSocial) {
        $this->razonSocial = $razonSocial;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}cliente (identificacion, nit, razonSocial, fechaRegistro) values ('$this->identificacion', '$this->nit', '$this->razonSocial', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}cliente set identificacion='$this->identificacion', nit='$this->nit', razonSocial='$this->razonSocial' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}cliente where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, identificacion, nit, razonSocial, fechaRegistro from {$P}cliente $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Cliente::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Cliente($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public function getNombreEmpresa() {
        if ($this->razonSocial!=NULL && $this->razonSocial!='') $nameEnterprise= $this->razonSocial;
        else $nameEnterprise= $this->getPersona()->getNombresCompletos();
        return $nameEnterprise;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!=''){
            $objeto=new Cliente($campo, $valor, $filtro, $orden);
        } else {
            $objeto=new Cliente(null, null, null, null);
        }
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['identificacion']=$objeto->getIdentificacion();
        $arreglo['nit']=$objeto->getNit();
        $arreglo['razonSocial']=$objeto->getRazonSocial();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $persona=$objeto->getPersona();
        $arreglo['nombresPersona']=$persona->getNombres();
        $arreglo['apellidosPersona']=$persona->getApellidos();
        $arreglo['nombresCompletosPersona']=$persona->getNombresCompletos();
        $arreglo['celularPersona']= rtrim($persona->getCelular());
        $arreglo['direccionPersona']= rtrim($persona->getDireccion());
        $arreglo['emailPersona']=$persona->getEmail();
        $arreglo['fechaNacimientoPersona']=$persona->getFechaNacimiento();
        $arreglo['fechaRegistroPersona']=$persona->getFechaRegistro();
        $arreglo['nombreEmpresa']=$objeto->getNombreEmpresa();
        $arreglo['statusDelete']=getStatusDelete($objeto->getId(), ['servicio', 'tercero'], 'idcliente');
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Cliente::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['identificacion']=$objeto->getIdentificacion();
            $arreglo['nit']=$objeto->getNit();
            $arreglo['razonSocial']=$objeto->getRazonSocial();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $persona=$objeto->getPersona();
            $arreglo['nombresPersona']=$persona->getNombres();
            $arreglo['apellidosPersona']=$persona->getApellidos();
            $arreglo['nombresCompletosPersona']=$persona->getNombresCompletos();
            $arreglo['celularPersona']= rtrim($persona->getCelular());
            $arreglo['direccionPersona']= rtrim($persona->getDireccion());
            $arreglo['emailPersona']=$persona->getEmail();
            $arreglo['fechaNacimientoPersona']=$persona->getFechaNacimiento();
            $arreglo['fechaRegistroPersona']=$persona->getFechaRegistro();
            $arreglo['nombreEmpresa']=$objeto->getNombreEmpresa();
            $arreglo['statusDelete']=getStatusDelete($objeto->getId(), ['servicio'], 'idcliente');
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Cliente::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            $datoCliente='';
            if ($objeto->getPersona()->getNombresCompletos()!='') $datoCliente.=$objeto->getPersona()->getNombresCompletos()." ";
            if ($objeto->getRazonSocial()!='') $datoCliente.="<i>".rtrim($objeto->getRazonSocial())."</i>";
            $options.="<option value='{$objeto->getId()}' $selected>$datoCliente (". rtrim($objeto->getIdentificacion()).")</option>";
        }
        return $options;
    }
    
    public static function getIdentificacionesJSON($filtro, $orden) {
        $datos= Cliente::getListaEnObjetos($filtro, $orden);
        $json=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $json[]= rtrim($objeto->getIdentificacion()) . " (" . $objeto->getNombreEmpresa() . ")";
        }
        return json_encode($json);
    }

    public static function getNameEnterprise($nameClient, $nameEnterprise) {
        $finalName = "";
        if ($nameClient!=null && $nameEnterprise!=null) $finalName = "$nameClient ($nameEnterprise)";
        elseif ($nameClient!=null && $nameEnterprise==null) $finalName = "$nameClient";
        else $finalName = $nameEnterprise;
        return $finalName;
    }

}
