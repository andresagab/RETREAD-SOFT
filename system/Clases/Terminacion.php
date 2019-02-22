<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** Descripcion de la clase Terminacion:
 *
 * Define las propiedades id, idInspeccionFinal, idEmpleadoEnrinador, IdEmpleado, observaciones, checked, estado y fechaRegistro las cuales permite identificar el proceso de terminacion de una llanta.
 *
 * El atributo idInspeccionFinal ayudara a relacionar el proceso de vulcanizado de una llanta con el proceso de inspeccion final.
 * El atributo idEmpleado nos permitira identificar al empleado de tipo operario el cual sera el responsable de realizar el proceso denominado terminacion.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */

class Terminacion {
    //Propiedades
    private $id;
    private $idInspeccionFinal;
    private $idEmpleado;
    private $foto;
    private $observaciones;
    private $estado;
    private $checked;
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
                $sql="select id, idInspeccion_Final, idEmpleado, foto, observaciones, checked, estado, fechaRegistro from {$P}terminacion where $campo=$valor $filtro $orden";
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
    	$this->idInspeccionFinal=$arreglo['idinspeccion_final'];
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdInspeccionFinal() {
        return $this->idInspeccionFinal;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
    }
    
    function getFoto() {
        return $this->foto;
    }

    function getObservaciones() {
        if ($this->observaciones!=null && $this->observaciones!="" && $this->observaciones!='-' && $this->observaciones!='---' && $this->observaciones!=' - ' && $this->observaciones!='  ') return $this->observaciones;
        else return "Sin observaciones";
    }

    function getChecked() {
        return $this->checked;
    }

    function getEstado() {
        return $this->estado;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function getEmpleado() {
        if ($this->idEmpleado!=NULL) return new Empleado ('id', $this->idEmpleado, null, NULL);
        else return new Empleado (null, null, null, null);
    }

    function getInspeccionFinal() {
        if ($this->idInspeccionFinal!=NULL) return new Inspeccion_Final('id', $this->idInspeccionFinal, null, NULL);
        else return new Inspeccion_Final(null, null, null, null);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdInspeccionFinal($idInspeccionFinal) {
        $this->idInspeccionFinal = $idInspeccionFinal;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setChecked($checked) {
        $this->checked = $checked;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }
       
    function getNombreChecked() {
        if ($this->checked) return 'Aprobado';
        else return 'Reprobado';
    }
    
    function getNombreEstado() {
        switch ($this->estado){
            case 'spr':
                return 'Sin procesar';
                break;
            case 'prs':
                return 'Procesando';
                break;
            case 'prf':
                return 'Procesado';
                break;
            default :
                return 'Desconocido';
                break;
        }
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
    
    public function grabar() {
        $P='';
        $sql="insert into {$P}terminacion (idInspeccion_Final, idEmpleado, foto, observaciones, checked, estado, fechaRegistro) values ($this->idInspeccionFinal, $this->idEmpleado, '$this->foto', '$this->observaciones', '$this->checked', '$this->estado', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        //$sql="update {$P}terminacion set idInspeccion_Final=$this->idInspeccionFinal, idEmpleadoEnrinador=$this->idEmpleadoEnrinador, idEmpleado=$this->idEmpleado, observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}terminacion where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idInspeccionFinal, idEmpleado, foto, observaciones, checked, estado, fechaRegistro from {$P}terminacion $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Terminacion::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Terminacion($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null) $objeto=new Terminacion($campo, $valor, $filtro, $orden);
        else $objeto=new Terminacion (null, null, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idInspeccionFinal']=$objeto->getIdInspeccionFinal();
        $arreglo['idEmpleado']=$objeto->getIdEmpleado();
        $arreglo['foto']=$objeto->getFoto();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['checked']=$objeto->getChecked();
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['nombreEstado']=$objeto->getNombreEstado();
        $arreglo['checkedEstado']=$objeto->getNombreChecked();
        $arreglo['inspeccionFinal']= json_decode(Inspeccion_Final::getObjetoJSON('id', $objeto->getIdInspeccionFinal(), null, null));
        $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Terminacion::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idInspeccionFinal']=$objeto->getIdInspeccionFinal();
            $arreglo['idEmpleado']=$objeto->getIdEmpleado();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['foto']=$objeto->getFoto();
            $arreglo['checked']=$objeto->getChecked();
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['nombreEstado']=$objeto->getNombreEstado();
            $arreglo['checkedEstado']=$objeto->getNombreChecked();
            $arreglo['inspeccionFinal']= json_decode(Inspeccion_Final::getObjetoJSON('id', $objeto->getIdInspeccionFinal(), null, null));
            $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNextId() {
        global $P, $BD;
        $sql="select max(id)+1 as id from {$P}terminacion";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result!=null){
            if ($result[0]['id']!=null) return $result[0]['id'];
            else return 1;
        } else return 1;
    }
}
