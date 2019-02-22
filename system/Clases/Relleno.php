<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** Descripcion de la clase Relleno:
 *
 * Define las propiedades id, idCementado, IdEmpleado, empates, observaciones, checked, estado y fechaRegistro las cuales permite identificar el proceso de relleno de una llanta.
 *
 * El atributo idCementado ayudara a relacionar el cementado con el proceso de relleno de una llanta.
 * El atributo idEmpleado nos permitira identificar al empleado de tipo operario el cual sera el responsable de realizar el proceso de relleno.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */

class Relleno{
    //Propiedades
    private $id;
    private $idCementado;
    private $idPuestoTrabajo;
    private $idEmpleado;
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
                $sql="select id, idCementado, idPuestoTrabajo, idEmpleado, empates, foto, observaciones, estado, checked, fechaRegistro from {$P}relleno where $campo=$valor $filtro $orden";
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
    	$this->idCementado=$arreglo['idcementado'];
    	$this->idPuestoTrabajo=$arreglo['idpuestotrabajo'];
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdCementado() {
        return $this->idCementado;
    }

    function getIdPuestoTrabajo() {
        return $this->idPuestoTrabajo;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
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
    
    function getCementado() {
        if ($this->idCementado!=null) return new Cementado('id', $this->idCementado, null, null);
        else return new Cementado(null, null, null, null);
    }
    
    function getPuestoTrabajo() {
        if ($this->idPuestoTrabajo!=null) return new Puesto_Trabajo('id', $this->idPuestoTrabajo, null, null);
        else return new Puesto_Trabajo(null, null, null, null);
    }
    
    function getEmpleado() {
        if ($this->idEmpleado!=null) return new Empleado('id', $this->idEmpleado, null, null);
        else return new Empleado(null, null, null, null);
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
    
    function setId($id) {
        $this->id = $id;
    }

    function setIdCementado($idCementado) {
        $this->idCementado = $idCementado;
    }

    function setIdPuestoTrabajo($idPuestoTrabajo) {
        $this->idPuestoTrabajo = $idPuestoTrabajo;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
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

    public function grabar() {
        $P='';
        $sql="insert into {$P}relleno (idCementado, idPuestoTrabajo, idEmpleado, empates, foto, observaciones, checked, estado, fechaRegistro) values ($this->idCementado, $this->idPuestoTrabajo, $this->idEmpleado, $this->empates, '$this->foto', '$this->observaciones', '$this->checked', '$this->estado', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }
    
    public function continuarRegistro() {
        $P='';
        $sql="update {$P}relleno set idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, empates=$this->empates, foto='$this->foto', observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}relleno set idCementado=$this->idCementado, idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, empates=$this->empates, foto='$this->foto', observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}relleno where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public function finalizar($observaciones) {
        $P='';
        if ($observaciones!='' && $observaciones!=null) $aux=" - ";
        else $aux='';
        $sql="update {$P}relleno set observaciones='".rtrim($this->observaciones)." $aux $observaciones', checked='$this->checked', estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idCementado, idPuestoTrabajo, idEmpleado, empates, foto, observaciones, checked, estado, fechaRegistro from {$P}relleno $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Relleno::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Relleno($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Relleno($campo, $valor, $filtro, $orden);
        else $objeto=new Relleno(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idCementado']=$objeto->getIdCementado();
        $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
        $arreglo['idEmpleado']=$objeto->getIdEmpleado();
        $arreglo['empates']=$objeto->getEmpates();
        if ($objeto->getFoto()==null || $objeto->getFoto()=='') $arreglo['notImage']=true;
        $arreglo['foto']=$objeto->getFoto();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['checked']=$objeto->getChecked();
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['nombreEstado']=$objeto->getNombreEstado();
        $arreglo['nombreChecked']=$objeto->getNombreChecked();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
        $arreglo['cementado']= json_decode(Cementado::getObjetoJSON('id', $objeto->getIdCementado(), null, null));
        $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
        $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 5));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Relleno::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idCementado']=$objeto->getIdCementado();
            $arreglo['idEmpleado']=$objeto->getIdEmpleado();
            $arreglo['empates']=$objeto->getEmpates();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['checked']=$objeto->getChecked();
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['nombreEstado']=$objeto->getNombreEstado();
            $arreglo['nombreChecked']=$objeto->getNombreChecked();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $cementado=$objeto->getCementado();
            $arreglo['cementado']=$cementado->getObjetoJSON('id', $objeto->getIdCementado(), null, null);
            $reparacion=$cementado->getReparacion();
                $arreglo['reparacion']=$reparacion->getObjetoJSON('id', $cementado->getIdReparacion(), null, null);
                    $preparacion=$reparacion->getPreparacion();
                        $arreglo['preparacion']=$reparacion->getPreparacion();
                        $raspado=$preparacion->getRaspado();
                        $arreglo['raspado']=$raspado->getObjetoJSON("id", $preparacion->getIdRaspado(), $filtro, $orden);
                            $inspeccion=$raspado->getInspeccion();
                            $arreglo['inspeccion']=$inspeccion->getObjetoJSON('id', $raspado->getIdInspeccion(), null, null);
                                $servicio=$inspeccion->getServicio();
                                $arreglo['servicio']=$servicio->getObjetoJSON('id', $inspeccion->getIdServicio(), null, null);
                                    $llanta=$servicio->getLlanta();
                                        $arreglo['llanta']=$llanta->getObjetoJSON('id', $llanta->getId(), null, null);
                                        $cliente=$llanta->getCliente();
                                            $arreglo['cliente']=$cliente->getObjetoJSON('id', $cliente->getId(), null, null);
                                        $tipo=$llanta->getTipo();
                                            $arreglo['tipo']=$tipo->getObjetoJSON('id', $tipo->getId(), null, null);
                                        $marca=$llanta->getMarca();
                                            $arreglo['marca']=$marca->getObjetoJSON('id', $marca->getId(), null, null);
                                $empleado=$inspeccion->getEmpleado();
                                $arreglo['empleado']=$empleado->getObjetoJSON('id', $inspeccion->getIdEmpleado(), null, null);
                                    $persona=$empleado->getPersona();
                                    $arreglo['persona']=$persona->getObjetoJSON('identificacion', "'{$persona->getIdentificacion()}'", null, null);
            $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
            $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 5));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNextId() {
        global $P, $BD;
        $sql="select max(id)+1 as id from {$P}relleno";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result!=null){
            if ($result[0]['id']!=null) return $result[0]['id'];
            else return 1;
        } else return 1;
    }
}
