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
 * Descripcion de la clase Tercero:
 *
 * Define las propiedades id, codPuc. idCliente, fecha de registro, las cuales permiten relacionar un cliente a una cuenta puc, esta clase tambien es llamada por la clase producto
 * permitiendo acceder a los datos de un cliente definiendolo como proveedor. 
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Tercero {
    //Propiedades
    private $id;
    private $codPuc;
    private $idCliente;
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
                $sql="select id, codPuc, idCliente, fechaRegistro from {$P}tercero where $campo=$valor $filtro $orden";
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
    	$this->codPuc=$arreglo['codpuc'];
    	$this->idCliente=$arreglo['idcliente'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getCodPuc() {
        return $this->codPuc;
    }

    function getIdCliente() {
        return $this->idCliente;
    }
    
    function getPuc() {
        if ($this->codPuc!=null) return new Puc('codigo', "'$this->codPuc'", null, null); 
        else return new Puc (null, null, null, null);
    }

    function getCliente() {
        if ($this->idCliente!=null) return new Cliente ('id', $this->idCliente, null, null);
        else return new Cliente (null, null, null, null);
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodPuc($codPuc) {
        $this->codPuc = $codPuc;
    }

    function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
    
    public function grabar() {
        $P='';
        $sql="insert into {$P}tercero (codPuc, idCliente, fechaRegistro) values ('$this->codPuc', $this->idCliente, '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}tercero set codPuc='$this->codPuc', idCliente=$this->idCliente where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}tercero where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, codPuc, idCliente, fechaRegistro from {$P}tercero $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Tercero::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Tercero($datos[$i], null, null, null);
        }
        return $objetos;
    }
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        $objeto=new Tercero($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['codPuc']=$objeto->getCodPuc();
        $arreglo['idCliente']=$objeto->getIdCliente();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Tercero::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['codPuc']=$objeto->getCodPuc();
            $arreglo['idCliente']=$objeto->getIdCliente();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Tercero::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            /*if ($objeto->getCliente()->getRazonSocial()!='') $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getCliente()->getRazonSocial())."</option>";
            else if ($objeto->getCliente()->getRazonSocial()!='' && $objeto->getCliente()->getPersona()->getApellidos()!='') $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getCliente()->getPersona()->getNombresCompletos()) ." (". rtrim($objeto->getCliente()->getRazonSocial()).") </option>";
            else $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getCliente()->getPersona()->getNombresCompletos())."</option>";*/
            $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getCliente()->getPersona()->getNombresCompletos()) ." (". rtrim($objeto->getCliente()->getRazonSocial()).") </option>";
        }
        return $options;
    }

    public static function getDatosEnOptionsSQL($predeterminado) {
        $sql = "select t.id, c.razonsocial, p.nombres || ' ' || p.apellidos as nombresCompletos
                from tercero as t, cliente as c, persona as p
                where c.id=t.idcliente
                and p.identificacion=c.identificacion
                order by p.nombres, c.razonsocial asc;";
        $datos = Conector::ejecutarQuery($sql, null);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $dato = $datos[$i];
            if ($predeterminado==$dato[0]) $selected="selected";
            else $selected='';
            /*if ($objeto->getCliente()->getRazonSocial()!='') $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getCliente()->getRazonSocial())."</option>";
            else if ($objeto->getCliente()->getRazonSocial()!='' && $objeto->getCliente()->getPersona()->getApellidos()!='') $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getCliente()->getPersona()->getNombresCompletos()) ." (". rtrim($objeto->getCliente()->getRazonSocial()).") </option>";
            else $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getCliente()->getPersona()->getNombresCompletos())."</option>";*/
            if (trim($dato[1])!=null && trim($dato[2])!=null) $options.= "<option value='{$dato[0]}' $selected>" . rtrim($dato[1]) . " (" . rtrim($dato[2]) . ") </option>";
            else if (trim($dato[1])!=null && trim($dato[2])==null) $options.="<option value='{$dato[0]}' $selected>" . rtrim($dato[1]) . "</option>";
            else if (trim($dato[1])==null && trim($dato[2]!=null)) $options.="<option value='{$dato[0]}' $selected>" . rtrim($dato[2]) . "</option>";
            //$options.="<option value='{$dato[0]}' $selected>". rtrim($dato[1]) ." (". rtrim($dato[2]).") </option>";
        }
        return $options;
    }
    
}
