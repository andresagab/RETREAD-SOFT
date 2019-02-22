<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** Descripcion de la clase Inspeccion_Final:
 *
 * Define las propiedades id, idVulcanizado, idEmpleadoEnrinador, IdEmpleado, observaciones, checked, estado y fechaRegistro las cuales permite identificar el proceso de inspeccion final de una llanta.
 *
 * El atributo idVulcanizado ayudara a relacionar el proceso de vulcanizado de una llanta con el proceso de inspeccion final.
 * El atributo idEmpleado nos permitira identificar al empleado de tipo operario el cual sera el responsable de realizar el proceso denominado inspeccion_final.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */

class Inspeccion_Final {
    //Propiedades
    private $id;
    private $idVulcanizado;
    private $idPuestoTrabajo;
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
                $sql="select id, idVulcanizado, idPuestoTrabajo, idEmpleado, foto, observaciones, estado, checked, fechaRegistro from {$P}inspeccion_final where $campo=$valor $filtro $orden";
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
    	$this->idVulcanizado=$arreglo['idvulcanizado'];
    	$this->idPuestoTrabajo=$arreglo['idpuestotrabajo'];
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdVulcanizado() {
        return $this->idVulcanizado;
    }
    
    function getIdPuestoTrabajo() {
        return $this->idPuestoTrabajo;
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

    function getVulcanizado() {
        if ($this->idVulcanizado!=NULL) return new Vulcanizado('id', $this->idVulcanizado, null, NULL);
        else return new Vulcanizado (null, null, null, null);
    }
       
    function getPuestoTrabajo() {
        if ($this->idPuestoTrabajo!=null) return new Puesto_Trabajo('id', $this->idPuestoTrabajo, null, null);
        else return new Puesto_Trabajo(null, null, null, null);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdVulcanizado($idVulcanizado) {
        $this->idVulcanizado = $idVulcanizado;
    }

    function setIdPuestoTrabajo($idPuestoTrabajo) {
        $this->idPuestoTrabajo = $idPuestoTrabajo;
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

    function setChecked($checked) {
        $this->checked = $checked;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
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
    
    public function grabar() {
        $P='';
        $sql="insert into {$P}inspeccion_final (idVulcanizado, idPuestoTrabajo, idEmpleado, foto, observaciones, checked, estado, fechaRegistro) values ($this->idVulcanizado, $this->idPuestoTrabajo, $this->idEmpleado, '$this->foto', '$this->observaciones', '$this->checked', '$this->estado', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}inspeccion_final set idVulcanizado=$this->idVulcanizado, idEmpleado=$this->idEmpleado, foto='$this->foto', observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function continuarRegistro() {
        $P='';
        $sql="update {$P}inspeccion_final set idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, foto='$this->foto', observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
       
    public function finalizar($observaciones) {
        $P='';
        if ($observaciones!='' && $observaciones!=null) $aux=" - ";
        else $aux='';
        $sql="update {$P}inspeccion_final set observaciones='".rtrim($this->observaciones)." $aux $observaciones', checked='$this->checked', estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}inspeccion_final where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idVulcanizado, idEmpleado, foto, observaciones, checked, estado, fechaRegistro from {$P}inspeccion_final $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Inspeccion_Final::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Inspeccion_Final($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Inspeccion_Final($campo, $valor, $filtro, $orden);
        else $objeto=new Inspeccion_Final(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idVulcanizado']=$objeto->getIdVulcanizado();
        $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
        $arreglo['idEmpleado']=$objeto->getIdEmpleado();
        $arreglo['foto']=$objeto->getFoto();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['checked']=$objeto->getChecked();
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['nombreChecked']=$objeto->getNombreChecked();
        $arreglo['nombreEstado']=$objeto->getNombreEstado();
        $arreglo['vulcanizado']= json_decode(Vulcanizado::getObjetoJSON('id', $objeto->getIdVulcanizado(), null, null));
        $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
        $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
        $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 9));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Inspeccion_Final::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idVulcanizado']=$objeto->getIdVulcanizado();
            $arreglo['idEmpleado']=$objeto->getIdEmpleado();
            $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
            $arreglo['foto']=$objeto->getFoto();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['checked']=$objeto->getChecked();
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['nombreChecked']=$objeto->getNombreChecked();
            $arreglo['nombreEstado']=$objeto->getNombreEstado();
            $arreglo['vulcanizado']= json_decode(Vulcanizado::getObjetoJSON('id', $objeto->getIdVulcanizado(), null, null));
            $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
            $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
            $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 9));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNextId() {
        global $P, $BD;
        $sql="select max(id)+1 as id from {$P}inspeccion_final";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result!=null){
            if ($result[0]['id']!=null) return $result[0]['id'];
            else return 1;
        } else return 1;
    }
}
