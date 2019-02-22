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
 * Define las propiedades id, idPreparacion, IdEmpleado, observaciones, checked, estado y fechaRegistro las cuales permite identificar el proceso de preparacion de una llanta.
 *
 * El atributo idRaspado ayudara a relacionar la preparacion con el proceso de raspado de la llanta, Teniendo en cuenta que solo se dara la aprobacion para este proceso si el raspado fue aprobado.
 * El atributo idEmpleado nos permitira identificar al empleado de tipo operario el cual sera el responsable de realizar el proceso de preparacion.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */

class Preparacion {
    //Propiedades
    private $id;
    private $idRaspado;
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
                $sql="select id, idRaspado, idPuestoTrabajo, idEmpleado, foto, observaciones, estado, checked, fechaRegistro from {$P}preparacion where $campo=$valor $filtro $orden";
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
    	$this->idRaspado=$arreglo['idraspado'];
    	$this->idPuestoTrabajo=$arreglo['idpuestotrabajo'];
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdRaspado() {
        return $this->idRaspado;
    }
    
    function getIdPuestoTrabajo() {
        return $this->idPuestoTrabajo;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
    }
    
    function getRaspado() {
        if ($this->idRaspado!=null) return new Raspado('id', $this->idRaspado, null, null);
        else return new Raspado(null, null, null, null);
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

    function getFoto() {
        return $this->foto;
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

    function setIdRaspado($idRaspado) {
        $this->idRaspado = $idRaspado;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }
    
    function setIdPuestoTrabajo($idPuestoTrabajo) {
        $this->idPuestoTrabajo = $idPuestoTrabajo;
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
        $sql="insert into {$P}preparacion (idRaspado, idPuestoTrabajo, idEmpleado, foto, observaciones, estado, checked, fechaRegistro) values ($this->idRaspado, $this->idPuestoTrabajo, $this->idEmpleado, '$this->foto', '$this->observaciones', '$this->estado', '$this->checked', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}preparacion set idRaspado=$this->idRaspado, idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, foto='$this->foto', observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function continuarRegistro() {
        $P='';
        $sql="update {$P}preparacion set idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, foto='$this->foto', observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function finalizar($observaciones) {
        $P='';
        $sql="update {$P}preparacion set observaciones='".rtrim($this->observaciones)." - $observaciones', checked='$this->checked', estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}preparacion where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idRaspado, idPuestoTrabajo, idEmpleado, foto, observaciones, checked, estado, fechaRegistro from {$P}preparacion $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Preparacion::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Preparacion($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null || $valor!='') $objeto=new Preparacion($campo, $valor, $filtro, $orden);
        else $objeto=new Preparacion(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idRaspado']=$objeto->getIdRaspado();
        $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
        $arreglo['idEmpleado']=$objeto->getIdEmpleado();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['foto']=$objeto->getFoto();
        $arreglo['checked']=$objeto->getChecked();
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['nombreEstado']= $objeto->getNombreEstado();
        $arreglo['nombreChecked']= $objeto->getNombreChecked();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $raspado=$objeto->getRaspado();
        $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
        $arreglo['raspado']= json_decode(Raspado::getObjetoJSON('id', $objeto->getIdRaspado(), null, null));
        $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
        $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 2));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Preparacion::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idRaspado']=$objeto->getIdRaspado();
            $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
            $arreglo['idEmpleado']=$objeto->getIdEmpleado();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['foto']=$objeto->getFoto();
            $arreglo['checked']=$objeto->getChecked();
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['nombreEstado']= $objeto->getNombreEstado();
            $arreglo['nombreChecked']= $objeto->getNombreChecked();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $raspado=$objeto->getRaspado();
            $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
            $arreglo['raspado']=$raspado->getObjetoJSON("id", $objeto->getIdRaspado(), $filtro, $orden);
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
            $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 2));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNextId() {
        global $P, $BD;
        $sql="select max(id)+1 as id from {$P}preparacion";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result!=null){
            if ($result[0]['id']!=null) return $result[0]['id'];
            else return 1;
        } else return 1;
    }
}
