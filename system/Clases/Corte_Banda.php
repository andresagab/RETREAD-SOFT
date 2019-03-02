<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** Descripcion de la clase Corte_Banda:
 *
 * Define las propiedades id, idRelleno, IdEmpleado, empates, observaciones, checked, estado y fechaRegistro las cuales permite identificar el proceso de corte_banda de una llanta.
 *
 * El atributo idRelleno ayudara a relacionar el cementado con el proceso de corte_banda de una llanta.
 * El atributo idEmpleado nos permitira identificar al empleado de tipo operario el cual sera el responsable de realizar el proceso de corte_banda.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */

class Corte_Banda{
    //Propiedades
    private $id;
    private $idPreparacion;
    private $idRelleno;
    private $idPuestoTrabajo;
    private $idEmpleado;
    private $estado;
    private $empates;
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
                $sql="select id, idpreparacion, idRelleno, idPuestoTrabajo, idEmpleado, estado, empates, foto, observaciones, fechaRegistro from {$P}corte_banda where $campo=$valor $filtro $orden";
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
    	$this->idPreparacion=$arreglo['idpreparacion'];
    	$this->idRelleno=$arreglo['idrelleno'];
    	$this->idPuestoTrabajo=$arreglo['idpuestotrabajo'];
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdRelleno() {
        return $this->idRelleno;
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
        if ($this->observaciones!=null && $this->observaciones!="" && $this->observaciones!='-' && $this->observaciones!='---' && $this->observaciones!=' - ') return $this->observaciones;
        else return "Sin observaciones";
    }
    
    function getPreparacion() {
        if ($this->idPreparacion!=null) return new Preparacion('id', $this->idPreparacion, null, null);
        else return new Preparacion(null, null, null, null);
    }

    function getRelleno() {
        if ($this->idRelleno!=null) return new Relleno('id', $this->idRelleno, null, null);
        else return new Relleno(null, null, null, null);
    }

    function getPuestoTrabajo() {
        if ($this->idPuestoTrabajo!=null) return new Puesto_Trabajo('id', $this->idPuestoTrabajo, null, null);
        else return new Puesto_Trabajo(null, null, null, null);
    }
    
    function getEmpleado() {
        if ($this->idEmpleado!=null) return new Empleado('id', $this->idEmpleado, null, null);
        else return new Empleado(null, null, null, null);
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function setId($id) {
        $this->id = $id;
    }

    function setIdRelleno($idRelleno) {
        $this->idRelleno = $idRelleno;
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

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    /**
     * @return mixed
     */
    public function getIdPreparacion()
    {
        return $this->idPreparacion;
    }

    /**
     * @param mixed $idPreparacion
     */
    public function setIdPreparacion($idPreparacion)
    {
        $this->idPreparacion = $idPreparacion;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getEmpates()
    {
        if ($this->empates!=null && $this->empates!='null') return $this->empates;
        else return 'Pendiente';
    }

    /**
     * @param mixed $empates
     */
    public function setEmpates($empates)
    {
        $this->empates = $empates;
    }

    public function getNameEstado(){
        if ($this->estado) return "Corte registrado";
        else return "Corte pendiente";
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}corte_banda (idPreparacion ,idRelleno, idPuestoTrabajo, idEmpleado, estado, empates, foto, observaciones, fechaRegistro) values ($this->idPreparacion, $this->idRelleno, $this->idPuestoTrabajo, $this->idEmpleado, '$this->estado', $this->empates, '$this->foto', '$this->observaciones', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}corte_banda set idPreparacion=$this->idPreparacion, idRelleno=$this->idRelleno, idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, estado='$this->estado', empates='$this->empates', foto='$this->foto', observaciones='$this->observaciones' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public function continuarRegistro() {
        $P='';
        $sql="update {$P}corte_banda set idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, foto='$this->foto', observaciones='$this->observaciones', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function addCorteBanda() {
        $P='';
        $sql="update {$P}corte_banda set idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, foto='$this->foto', observaciones='$this->observaciones', estado='$this->estado', empates='$this->empates' where id=$this->id";
        if (Conector::ejecutarQuery($sql, null)!=null) return true;
        else return false;
    }

    public function updateOnlyEmpatesObs() {
        $P='';
        $sql="update {$P}corte_banda set empates=$this->empates, observaciones='$this->observaciones' where id=$this->id";
        if (Conector::ejecutarQuery($sql, null)!=null) return true;
        else return false;
    }

    public function addIdRelleno(){
        $P='';
        $sql="update {$P}corte_banda set idRelleno=$this->idRelleno where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}corte_banda where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idPreparacion, idRelleno, idPuestoTrabajo, idEmpleado, estado, empates, foto, observaciones, fechaRegistro from {$P}corte_banda $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Corte_Banda::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Corte_Banda($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Corte_Banda($campo, $valor, $filtro, $orden);
        else $objeto=new Corte_Banda(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idPreparacion']=$objeto->getIdPreparacion();
        $arreglo['idRelleno']=$objeto->getIdRelleno();
        $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
        $arreglo['idEmpleado']=$objeto->getIdEmpleado();
        if ($objeto->getFoto()==null || $objeto->getFoto()=='') $arreglo['notImage']=true;
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['nombreEstado']=$objeto->getNameEstado();
        $arreglo['empates']=$objeto->getEmpates();
        $arreglo['foto']=$objeto->getFoto();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
        //$relleno=$objeto->getRelleno();
        $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
        $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 6));
        $arreglo['relleno']= json_decode(Relleno::getObjetoJSON('id', $objeto->getIdRelleno(), null, null));
        //$arreglo['preparacion'] = json_decode(Preparacion::getObjetoJSON('id', $objeto->getIdPreparacion(), null, null));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Corte_Banda::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idPreparacion']=$objeto->getIdPreparacion();
            $arreglo['idRelleno']=$objeto->getIdRelleno();
            $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
            $arreglo['idEmpleado']=$objeto->getIdEmpleado();
            if ($objeto->getFoto()==null || $objeto->getFoto()=='') $arreglo['notImage']=true;
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['nombreEstado']=$objeto->getNameEstado();
            $arreglo['empates']=$objeto->getEmpates();
            $arreglo['foto']=$objeto->getFoto();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
            $relleno=$objeto->getRelleno();
            $arreglo['relleno']= json_decode($relleno->getObjetoJSON('id', $objeto->getIdRelleno(), null, null));
            $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
            $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 6));
            //$arreglo['preparacion'] = json_decode(Preparacion::getObjetoJSON('id', $objeto->getIdPreparacion(), null, null));
                $cementado=$relleno->getCementado();
                $arreglo['cementado']= json_decode($cementado->getObjetoJSON('id', $relleno->getIdCementado(), null, null));
                $reparacion=$cementado->getReparacion();
                    $arreglo['reparacion']=json_decode($reparacion->getObjetoJSON('id', $cementado->getIdReparacion(), null, null));
                        $preparacion=$reparacion->getPreparacion();
                            $arreglo['preparacion']=$reparacion->getPreparacion();
                            $raspado=$preparacion->getRaspado();
                            $arreglo['raspado']=json_decode($raspado->getObjetoJSON("id", $preparacion->getIdRaspado(), $filtro, $orden));
                                $inspeccion=$raspado->getInspeccion();
                                $arreglo['inspeccion']=json_decode($inspeccion->getObjetoJSON('id', $raspado->getIdInspeccion(), null, null));
                                    $servicio=$inspeccion->getServicio();
                                    $arreglo['servicio']=json_decode($servicio->getObjetoJSON('id', $inspeccion->getIdServicio(), null, null));
                                        $llanta=$servicio->getLlanta();
                                            $arreglo['llanta']=json_decode($llanta->getObjetoJSON('id', $llanta->getId(), null, null));
                                            $cliente=$llanta->getCliente();
                                                $arreglo['cliente']=json_decode($cliente->getObjetoJSON('id', $cliente->getId(), null, null));
                                            $tipo=$llanta->getTipo();
                                                $arreglo['tipo']=json_decode($tipo->getObjetoJSON('id', $tipo->getId(), null, null));
                                            $marca=$llanta->getMarca();
                                                $arreglo['marca']=json_decode($marca->getObjetoJSON('id', $marca->getId(), null, null));
                                    $empleado=$inspeccion->getEmpleado();
                                    $arreglo['empleado']=json_decode($empleado->getObjetoJSON('id', $inspeccion->getIdEmpleado(), null, null));
                                        $persona=$empleado->getPersona();
                                        $arreglo['persona']=json_decode($persona->getObjetoJSON('identificacion', "'{$persona->getIdentificacion()}'", null, null));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNextId() {
        global $P, $BD;
        $sql="select max(id)+1 as id from {$P}corte_banda";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result!=null){
            if ($result[0]['id']!=null) return $result[0]['id'];
            else return 1;
        } else return 1;
    }

    public function getColorEstado(){
        $color='';
        if ($this->id!=null) {
            if ($this->estado){
                /*if ($this->empates!=null && $this->idPuestoTrabajo!=null) {
                    $color='#b7e087';
                }*/
                $color='#b7e087';
                //else $color="#e47870";
            } else $color='#e47870';
        }
        return $color;
    }

    public static function getDataJSON($sql){
        $JSON=array();
        if ($sql!=null){
            $result=Conector::ejecutarQuery($sql, null);
            //print_r($result);die();
            for ($i=0; $i<count($result); $i++){
                $array=array();
                foreach ($result[$i] as $key => $value) {
                    $array["$key"]=$value;
                    ${$key}=$value;
                }
                $object=new Corte_Banda(null, null, null, null);
                @$object->setId($id);
                @$object->setIdPreparacion($idpreparacion);
                @$object->setIdPuestoTrabajo($idpuestotrabajo);
                @$object->setEstado($estado);
                @$object->setEmpates($empates);
                $llanta=new Llanta(null, null, null, null);
                @$llanta->setId($idllanta);
                @$llanta->setUrgente($urgente);
                $array["nombreEstado"]=$object->getNameEstado();
                $array["nombreEstado"]=$object->getNameEstado();
                $array["colorEstado"]=$object->getColorEstado();
                $array["nombreEmpates"]=$object->getEmpates();
                //$array["nombreEstadoLlanta"]=$llanta->getNombreEstadoRencauche();
                $array["nombreUrgente"]=$llanta->getNombreUrgente();
                $os=new Servicio(null, null, null, null);
                @$os->setId($idos);
                @$os->setEstado($estadoos);
                $array["nombreEstadoOs"]=$os->getNombreEstado();
                $inspeccion=new Inspeccion_Inicial(null, null, null, null);
                @$inspeccion->setChecked($chkii);
                $array["nombreCheckedInspeccionInicial"]=$inspeccion->getNombreChecked();
                @$raspado=new Raspado(null, null, null, null);
                @$raspado->setCinturon($cinturon);
                @$raspado->setChecked($chkraspado);
                $array["nombreCinturon"]=$raspado->getNombreCinturon();
                $array["nombreCheckedRaspado"]=$raspado->getNombreChecked();
                @$preparacion=new Preparacion(null, null, null, null);
                @$raspado->setChecked($chkpreparacion);
                $array["nombreCheckedPreparacion"]=$preparacion->getNombreChecked();
                //Line insert in 25/08/2018
                //$array["disenoSolicitado"] = $llanta->getReferenciaSolicitada();
                array_push($JSON, $array);
            }
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function getNumeroCortesPedientes(){
        $sql="select count(id) as total from corte_banda where estado='f'";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null){
            if ($r[0]['total']) return $r[0]['total'];
            else return 0;
        } else return 0;
    }

    /*LINE INSERT SINCE 2019-02-27 23:34*/
    public static function getData($type, $field, $value, $filter, $order, $sql, $extras) {
        $JSON = array();
        switch ($type) {
            case 0:
                if ($field!=null && $value!=null) {
                    foreach ($object = new Corte_Banda($field, $value, $filter, $order) as $item => $val) {
                        $JSON["$item"] = $val;
                        ${$item} = $val;
                    }
                    $JSON['nombreEstado']=$object->getNameEstado();
                    if ($object->getFoto()==null || $object->getFoto()=='') {
                        $JSON['notImage']=true;
                    }
                    $JSON['usosRegistrados'] = $object->getStatusUsos();
                    if ($extras) {
                        $JSON['puestoTrabajo'] = json_decode(Puesto_Trabajo::getObjetoJSON('id', $object->getIdPuestoTrabajo(), null, null));
                        $JSON['empleado'] = json_decode(Empleado::getObjetoJSON('id', $object->getIdEmpleado(), null, null));
                        $JSON['usosInsumos'] = json_decode(Uso_Insumo_Proceso::getUsosInforme($object->getId(), 6));
                        $JSON['relleno'] = json_decode(Relleno::getObjetoJSON('id', $object->getIdRelleno(), null, null));
                    }
                }
                break;
            case 1:
                $objects = Corte_Banda::getListaEnObjetos($filter, $order);
                for ($i=0; $i<count($objects); $i++) {
                    $data = array();
                    $object = $objects[$i];
                    foreach ($objects[$i] as $item => $val) {
                        $data["$item"] = $val;
                        ${$item} = $val;
                    }
                    if ($object->getFoto()==null || $object->getFoto()=='') {
                        $data['notImage']=true;
                        $data['nombreEstado']=$object->getNameEstado();
                    }
                    if ($extras) {
                        $data['puestoTrabajo'] = json_decode(Puesto_Trabajo::getObjetoJSON('id', $object->getIdPuestoTrabajo(), null, null));
                        $data['empleado'] = json_decode(Empleado::getObjetoJSON('id', $object->getIdEmpleado(), null, null));
                        $data['usosInsumos'] = json_decode(Uso_Insumo_Proceso::getUsosInforme($object->getId(), 6));
                        $data['relleno'] = json_decode(Relleno::getObjetoJSON('id', $object->getIdRelleno(), null, null));
                    }
                    array_push($JSON, $data);
                }
                break;
            case 2:
                if ($sql!=null) {
                    $result = Conector::ejecutarQuery($sql, null);
                    for ($i=0; $i<count($result); $i++) {
                        $data = array();
                        foreach ($result[$i] as $item => $val) {
                            $data["$item"] = $val;
                            ${$item} = $val;
                        }
                        $object = new Corte_Banda(null, null, null, null);
                        $object->setId(@$id);
                        $object->setFoto(@$foto);
                        $object->setEstado(@$estado);
                        if ($object->getFoto()==null || $object->getFoto()=='') {
                            $data['notImage']=true;
                            $data['nombreEstado']=$object->getNameEstado();
                        }
                        if ($extras) {
                            $data['puestoTrabajo'] = json_decode(Puesto_Trabajo::getObjetoJSON('id', @$idpuestotrabajo, null, null));
                            $data['empleado'] = json_decode(Empleado::getObjetoJSON('id', @$idempleado, null, null));
                            $data['usosInsumos'] = json_decode(Uso_Insumo_Proceso::getUsosInforme(@$id, 6));
                            $data['relleno'] = json_decode(Relleno::getObjetoJSON('id', @$idrelleno(), null, null));
                        }
                        array_push($JSON, $data);
                    }
                }
                break;
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    /*LINE INSERT SINCE 2019-02-27 23:34*/

    public function getStatusUsos() {
        $status = false;
        $sql = "select id from uso_insumo_proceso where idproceso=$this->id and proceso=6";
        if (is_array($result = Conector::ejecutarQuery($sql, null))) {
            if (count($result)>0) {
                if ($result[0][0]!=null) $status = true;
            }
        }
        return $status;
    }

}
