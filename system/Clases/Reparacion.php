<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** Descripcion de la clase Preparacion:
 *
 * Define las propiedades id, idPreparacion, IdEmpleado, observaciones, checked, estado y fechaRegistro las cuales permite identificar el proceso de reparacion de una llanta.
 *
 * El atributo idPreparacion ayudara a relacionar la reparacion con el proceso de preparacion de la llanta.
 * El atributo idEmpleado nos permitira identificar al empleado de tipo operario el cual sera el responsable de realizar el proceso de preparacion.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */

class Reparacion {
    //Propiedades
    private $id;
    private $idPreparacion;
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
                $this->setClave($this->clave);
                $this->cargarAtributos($campo);
            } else {
                $sql="select id, idPreparacion, idPuestoTrabajo, idEmpleado, foto, observaciones, estado, checked, fechaRegistro from {$P}reparacion where $campo=$valor $filtro $orden";
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
    	$this->idPuestoTrabajo=$arreglo['idpuestotrabajo'];
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdPreparacion() {
        return $this->idPreparacion;
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
    
    function getPreparacion() {
        if ($this->idPreparacion!=null) return new Preparacion('id', $this->idPreparacion, null, null);
        else return new Preparacion(null, null, null, null);
    }
    
    function getPuestoTrabajo() {
        if ($this->idPuestoTrabajo!=null) return new Puesto_Trabajo('id', $this->idPuestoTrabajo, null, null);
        else return new Puesto_Trabajo(null, null, null, null);
    }
    
    function getEmpleado() {
        if ($this->idEmpleado!=null) return new Empleado('id', $this->idEmpleado, null, null);
        else return new Empleado(null, null, null, null);
    }

    function getObservaciones() {
        if ($this->observaciones!=null && $this->observaciones!="" && $this->observaciones!='-' && $this->observaciones!='---' && $this->observaciones!=' - ') return $this->observaciones;
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

    function setIdPreparacion($idPreparacion) {
        $this->idPreparacion = $idPreparacion;
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

    public function grabar() {
        $P='';
        $sql="insert into {$P}reparacion (idPreparacion, idPuestoTrabajo, idEmpleado, foto, observaciones, estado, checked, fechaRegistro) values ($this->idPreparacion, $this->idPuestoTrabajo, $this->idEmpleado, '$this->foto', '$this->observaciones', '$this->estado', '$this->checked', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}reparacion set idPreparacion=$this->idPreparacion, idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, foto='$this->foto', observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public function continuarRegistro() {
        $P='';
        $sql="update {$P}reparacion set idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, foto='$this->foto', observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function finalizar($observaciones) {
        $P='';
        $sql="update {$P}reparacion set observaciones='".rtrim($this->observaciones)." - $observaciones', checked='$this->checked', estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}reparacion where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idPreparacion, idPuestoTrabajo, idEmpleado, foto, observaciones, estado, checked, fechaRegistro from {$P}reparacion where $campo=$valor $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Reparacion::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Reparacion($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Reparacion($campo, $valor, $filtro, $orden);
        else $objeto=new Reparacion(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idPreparacion']=$objeto->getIdPreparacion();
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
        $arreglo['preparacion']= json_decode(Preparacion::getObjetoJSON('id', $objeto->getIdPreparacion(), null, null));
        $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
        $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 3));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Reparacion::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idPreparacion']=$objeto->getIdPreparacion();
            $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
            $arreglo['idEmpleado']=$objeto->getIdEmpleado();
            if ($objeto->getFoto()==null || $objeto->getFoto()=='') $arreglo['notImage']=true;
            $arreglo['foto']=$objeto->getFoto();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['checked']=$objeto->getChecked();
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
            $preparacion=$objeto->getPreparacion();
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
            $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 3));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNextId() {
        global $P, $BD;
        $sql="select max(id)+1 as id from {$P}reparacion";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result!=null){
            if ($result[0]['id']!=null) return $result[0]['id'];
            else return 1;
        } else return 1;
    }
}
