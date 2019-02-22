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
 * Descripcion de la clase Insumo_Terminacion:
 *
 * Define las propiedades id, cantidad, estado, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Insumo_Terminacion {
    //Propiedades
    private $id;
    private $idInsumoPT;
    private $idEmpleado;//Hace referencia al campo id de la tabla empleado.
    private $foto;
    private $observaciones;
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
                $sql="select id, idInsumoPT, idEmpleado, foto, observaciones, fechaRegistro from {$P}insumo_terminacion where $campo=$valor $filtro $orden";
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
    	$this->idInsumoPT=$arreglo['idinsumopt'];
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdInsumoPT() {
        return $this->idInsumoPT;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
    }
    
    function getFoto() {
        return $this->foto;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getInsumoPuestoTrabajo() {
        if ($this->idInsumoPT!=null) return new Insumo_Puesto_Trabajo ('id', $this->idInsumoPT, null, null);
        else return new Insumo_Puesto_Trabajo (null, null, null, null);
    }
    
    function getEmpleado() {
        if ($this->idEmpleado!=null) return new Empleado ('id', $this->idEmpleado, null, null);
        else return new Empleado (null, null, null, null);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdInsumoPT($idInsumoPT) {
        $this->idInsumoPT = $idInsumoPT;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }
    
    function setFoto($foto) {
        $this->foto = $foto;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
    
    public function grabar() {
        $P='';
        $sql="insert into {$P}insumo_terminacion (idInsumoPT, idEmpleado, foto, observaciones, fechaRegistro) values ($this->idInsumoPT, $this->idEmpleado, '$this->foto', '$this->observaciones', '$this->fechaRegistro')";
        //echo $sql;
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null) return true;
        else return false;
    }

    public function modificar() {
        $P='';
        $sql="update {$P}insumo_terminacion set idInsumoPT=$this->idInsumoPT, idEmpleado=$this->idEmpleado, foto='$this->foto', observaciones='$this->observaciones' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}insumo_terminacion where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idInsumoPT, idEmpleado, foto, observaciones, fechaRegistro from {$P}insumo_terminacion $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Insumo_Terminacion::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Insumo_Terminacion($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Insumo_Terminacion::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getInsumoPuestoTrabajo()->getPuc()->getNombre()) ."</option>";
        }
        return $options;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null || $valor!='') $objeto=new Insumo_Terminacion($campo, $valor, $filtro, $orden);
        else $objeto=new Insumo_Terminacion (null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idInsumoPT']=$objeto->getIdPuestoTrabajo();
        $arreglo['idEmpleado']=$objeto->getIdInsumo();
        $arreglo['foto']=$objeto->getFoto();
        $arreglo['observaciones']=$objeto->getUsuario();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['insumoPuestoTrabajo']= json_decode(Insumo_Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdInsumoPT(), null, null));
        $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Insumo_Terminacion::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idInsumoPT']=$objeto->getIdPuestoTrabajo();
            $arreglo['idEmpleado']=$objeto->getIdInsumo();
            $arreglo['foto']=$objeto->getFoto();
            $arreglo['observaciones']=$objeto->getUsuario();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['insumoPuestoTrabajo']= json_decode(Insumo_Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdInsumoPT(), null, null));
            $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNextId() {
        global $P, $BD;
        $sql="select max(id)+1 as id from {$P}insumo_terminacion";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result!=null){
            if ($result[0]['id']!=null) return $result[0]['id'];
            else return 1;
        } else return 1;
    }
    
}
