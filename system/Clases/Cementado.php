<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** Descripcion de la clase Cementado:
 *
 * Define las propiedades id, idReparacion, IdEmpleado, observaciones, checked, estado y fechaRegistro las cuales permite identificar el proceso de cementado de una llanta.
 *
 * El atributo idReparacion ayudara a relacionar la reparacion con el proceso de cementado de la llanta.
 * El atributo idEmpleado nos permitira identificar al empleado de tipo operario el cual sera el responsable de realizar el proceso de cementado.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */

class Cementado {
    //Propiedades
    private $id;
    private $idReparacion;
    private $idPuestoTrabajo;
    private $idEmpleado;
    private $foto;
    private $observaciones;
    private $checked;
    private $estado;
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
                $sql="select id, idReparacion, idPuestoTrabajo, idEmpleado, foto, observaciones, checked, estado, fechaRegistro from {$P}cementado where $campo=$valor $filtro $orden";
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
    	$this->idReparacion=$arreglo['idreparacion'];
        $this->idPuestoTrabajo=$arreglo['idpuestotrabajo'];
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdReparacion() {
        return $this->idReparacion;
    }

    function getIdPuestoTrabajo() {
        return $this->idPuestoTrabajo;
    }
    
    function getIdEmpleado() {
        return $this->idEmpleado;
    }
    
    function getReparacion() {
        if ($this->idReparacion!=null) return new Reparacion('id', $this->idReparacion, null, null);
        else return new Reparacion(null, null, null, null);
    }
    
    function getPuestoTrabajo() {
        if ($this->idPuestoTrabajo!=null) return new Puesto_Trabajo('id', $this->idPuestoTrabajo, null, null);
        else return new Puesto_Trabajo(null, null, null, null);
    }
    
    function getEmpleado() {
        if ($this->idEmpleado!=null) return new Empleado('id', $this->idEmpleado, null, null);
        else return new Empleado(null, null, null, null);
    }

    function getFoto() {
        return $this->foto;
    }
    
    function getObservaciones() {
        return $this->observaciones;
    }

    function getChecked() {
        return $this->checked;
    }

    function getEstado() {
        return $this->estado;
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

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdReparacion($idReparacion) {
        $this->idReparacion = $idReparacion;
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
        if ($this->observaciones!=null && $this->observaciones!="" && $this->observaciones!='-' && $this->observaciones!='---' && $this->observaciones!=' - ') return $this->observaciones;
        else return "Sin observaciones";
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

    public function grabar() {
        $P='';
        $sql="insert into {$P}cementado (idReparacion, idPuestoTrabajo, idEmpleado, foto, observaciones, checked, estado, fechaRegistro) values ($this->idReparacion, $this->idPuestoTrabajo, $this->idEmpleado, '$this->foto', '$this->observaciones', '$this->checked', '$this->estado', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }
    
    public function continuarRegistro() {
        $P='';
        $sql="update {$P}cementado set idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, foto='$this->foto', observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}cementado set idReparacion=$this->idReparacion, idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, foto='$this->foto', observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}cementado where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public function finalizar($observaciones) {
        $P='';
        $sql="update {$P}cementado set observaciones='".rtrim($this->observaciones)." - $observaciones', checked='$this->checked', estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idReparacion, idPuestoTrabajo, idEmpleado, foto, observaciones, checked, estado, fechaRegistro from {$P}cementado $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Cementado::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Cementado($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Cementado($campo, $valor, $filtro, $orden);
        else $objeto=new Cementado(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idReparacion']=$objeto->getIdReparacion();
        $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
        $arreglo['idEmpleado']=$objeto->getIdEmpleado();
        if ($objeto->getFoto()==null || $objeto->getFoto()=='') $arreglo['notImage']=true;
        $arreglo['foto']=$objeto->getFoto();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['checked']=$objeto->getChecked();
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['nombreEstado']=$objeto->getNombreEstado();
        $arreglo['nombreChecked']=$objeto->getNombreChecked();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
        $reparacion=$objeto->getReparacion();
        $arreglo['reparacion']= json_decode(Reparacion::getObjetoJSON('id', $objeto->getIdReparacion(), null, null));
        $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
        $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 4));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Cementado::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idReparacion']=$objeto->getIdReparacion();
            $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
            $arreglo['idEmpleado']=$objeto->getIdEmpleado();
            if ($objeto->getFoto()==null || $objeto->getFoto()=='') $arreglo['notImage']=true;
            $arreglo['foto']=$objeto->getFoto();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['checked']=$objeto->getChecked();
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['nombreEstado']=$objeto->getNombreEstado();
            $arreglo['nombreChecked']=$objeto->getNombreChecked();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
            $reparacion=$objeto->getReparacion();
            $arreglo['reparacion']=$reparacion->getObjetoJSON('id', $objeto->getId(), null, null);
                $preparacion=$reparacion->getPreparacion();
                    $arreglo['preparacion']=$objeto->getPreparacion();
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
                    $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 4));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNextId() {
        global $P, $BD;
        $sql="select max(id)+1 as id from {$P}cementado";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result!=null){
            if ($result[0]['id']!=null) return $result[0]['id'];
            else return 1;
        } else return 1;
    }
}
