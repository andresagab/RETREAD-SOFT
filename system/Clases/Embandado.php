<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** Descripcion de la clase Embandado:
 *
 * Define las propiedades id, idEmbandado, IdEmpleado, empates, observaciones, checked, estado y fechaRegistro las cuales permite identificar el proceso de embandado de una llanta.
 *
 * El atributo idEmbandado ayudara a relacionar el cementado con el proceso de embandado de una llanta.
 * El atributo idEmpleado nos permitira identificar al empleado de tipo operario el cual sera el responsable de realizar el proceso de embandado.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */

class Embandado{
    //Propiedades
    private $id;
    private $idCorteBanda;
    private $idPuestoTrabajo;
    private $idEmpleado;
    private $idGravado;
    private $anchoBanda;
    private $largoBanda;
    private $empates;
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
                $this->setClave($this->clave);
                $this->cargarAtributos($campo);
            } else {
                $sql="select id, idCorteBanda, idPuestoTrabajo, idEmpleado, idGravado, anchoBanda, largoBanda, empates, foto, observaciones, checked, estado, fechaRegistro from {$P}embandado where $campo=$valor $filtro $orden";
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
    	$this->idPuestoTrabajo=$arreglo['idpuestotrabajo'];
    	$this->idCorteBanda=$arreglo['idcortebanda'];
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->idGravado=$arreglo['idgravado'];
    	$this->anchoBanda=$arreglo['anchobanda'];
    	$this->largoBanda=$arreglo['largobanda'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdCorteBanda() {
        return $this->idCorteBanda;
    }

    function getIdPuestoTrabajo() {
        return $this->idPuestoTrabajo;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
    }

    function getIdGravado() {
        return $this->idGravado;
    }

    function getAnchoBanda() {
        return $this->anchoBanda;
    }

    function getLargoBanda() {
        return $this->largoBanda;
    }

    function getEmpates() {
        return $this->empates;
    }

    function getFoto() {
        return $this->foto;
    }

    function getObservaciones() {
        if ($this->observaciones!=null && $this->observaciones!="" && $this->observaciones!='-' && $this->observaciones!='---' && $this->observaciones!=' - ') return $this->observaciones;
        else return "Sin observaciones";
    }

    function getEstado() {
        return $this->estado;
    }

    function getChecked() {
        return $this->checked;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdCorteBanda($idCorteBanda) {
        $this->idCorteBanda = $idCorteBanda;
    }

    function setIdPuestoTrabajo($idPuestoTrabajo) {
        $this->idPuestoTrabajo = $idPuestoTrabajo;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    function setIdGravado($idGravado) {
        $this->idGravado = $idGravado;
    }

    function setAnchoBanda($anchoBanda) {
        $this->anchoBanda = $anchoBanda;
    }

    function setLargoBanda($largoBanda) {
        $this->largoBanda = $largoBanda;
    }

    function setEmpates($empates) {
        $this->empates = $empates;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setChecked($checked) {
        $this->checked = $checked;
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
    
    function getCorteBanda(){
        if ($this->idCorteBanda!=null && $this->idCorteBanda!='') return new Corte_Banda ('id', $this->idCorteBanda, null, null);
        else return new Corte_Banda (null, null, null, null);
    }
    
    function getPuestoTrabajo(){
        if ($this->idPuestoTrabajo!=null && $this->idPuestoTrabajo!='') return new Puesto_Trabajo ('id', $this->idPuestoTrabajo, null, null);
        else return new Puesto_Trabajo (null, null, null, null);
    }
    
    function getEmpleado(){
        if ($this->idEmpleado!=null && $this->idEmpleado!='') return new Empleado ('id', $this->idEmpleado, null, null);
        else return new Empleado (null, null, null, null);
    }
    
    function getGravado(){
        if ($this->idGravado!=null && $this->idGravado!='') return new Gravado_Llanta ('id', $this->idGravado, null, null);
        else return new Gravado_Llanta (null, null, null, null);
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}embandado (idCorteBanda, idPuestoTrabajo, idEmpleado, idGravado, anchoBanda, largoBanda, empates, foto, observaciones, estado, checked, fechaRegistro) values ($this->idCorteBanda, $this->idPuestoTrabajo, $this->idEmpleado, $this->idGravado, $this->anchoBanda, $this->largoBanda, $this->empates, '$this->foto', '$this->observaciones', '$this->estado', '$this->checked', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }
    
    public function continuarRegistro() {
        $P='';
        $sql="update {$P}embandado set idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, idGravado=$this->idGravado, anchoBanda=$this->anchoBanda, largoBanda=$this->largoBanda, empates=$this->empates, foto='$this->foto', observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public static function modificar() {
        //$P='';
        //$sql="update {$P}embandado set idEmbandado=$this->idEmbandado, idEmpleado=$this->idEmpleado, empates=$this->empates, observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        //Conector::ejecutarQuery($sql, null);
    }

    public static function eliminar() {
        $P='';
        $sql="delete from {$P}embandado where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public function finalizar($observaciones) {
        $P='';
        if ($observaciones!='' && $observaciones!=null) $aux=" - ";
        else $aux='';
        $sql="update {$P}embandado set observaciones='".rtrim($this->observaciones)." $aux $observaciones', checked='$this->checked', estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idCorteBanda, idPuestoTrabajo, idEmpleado, idGravado, anchoBanda, largoBanda, empates, foto, observaciones, checked, estado, fechaRegistro from {$P}embandado $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Embandado::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Embandado($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Embandado($campo, $valor, $filtro, $orden);
        else $objeto=new Embandado (null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idCorteBanda']=$objeto->getIdCorteBanda();
        $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
        $arreglo['idEmpleado']=$objeto->getIdEmpleado();
        $arreglo['idGravado']=$objeto->getIdGravado();
        $arreglo['anchoBanda']=$objeto->getAnchoBanda();
        $arreglo['largoBanda']=$objeto->getLargoBanda();
        $arreglo['empates']=$objeto->getEmpates();
        $arreglo['foto']=$objeto->getFoto();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['checked']=$objeto->getChecked();
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['corteBanda']= json_decode(Corte_Banda::getObjetoJSON('id', $objeto->getIdCorteBanda(), null, null));
        $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
        $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
        $arreglo['gravado']= json_decode(Gravado_Llanta::getObjetoJSON('id', $objeto->getIdGravado(), null, null));
        $arreglo['nombreChecked']=$objeto->getNombreChecked();
        $arreglo['nombreEstado']=$objeto->getNombreEstado();
        $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 7));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Embandado::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idCorteBanda']=$objeto->getIdCorteBanda();
            $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
            $arreglo['idEmpleado']=$objeto->getIdEmpleado();
            $arreglo['idGravado']=$objeto->getIdGravado();
            $arreglo['anchoBanda']=$objeto->getAnchoBanda();
            $arreglo['largoBanda']=$objeto->getLargoBanda();
            $arreglo['empates']=$objeto->getEmpates();
            $arreglo['foto']=$objeto->getFoto();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['checked']=$objeto->getChecked();
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['corteBanda']= json_decode(Corte_Banda::getObjetoJSON('id', $objeto->getIdCorteBanda(), null, null));
            $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
            $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
            $arreglo['gravado']= json_decode(Gravado_Llanta::getObjetoJSON('id', $objeto->getIdGravado(), null, null));
            $arreglo['nombreChecked']=$objeto->getNombreChecked();
            $arreglo['nombreEstado']=$objeto->getNombreEstado();
            $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 7));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNextId() {
        global $P, $BD;
        $sql="select max(id)+1 as id from {$P}embandado";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result!=null){
            if ($result[0]['id']!=null) return $result[0]['id'];
            else return 1;
        } else return 1;
    }
}
