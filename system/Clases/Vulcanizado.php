<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** Descripcion de la clase Vulcanizado:
 *
 * Define las propiedades id, idCementado, idEmpleadoEnrinador, IdEmpleado, observaciones, checked, estado y fechaRegistro las cuales permite identificar el proceso de vulcanizado de una llanta.
 *
 * El atributo idEmbandado ayudara a relacionar el proceso de embandado con el proceso de vulcanizado de la llanta.
 * El atributo idEmpleadoEnrinador nos permitira identificar al empleado de tipo operario el cual sera el responsable de realizar el proceso de enrinazion.
 * El atributo idEmpleado nos permitira identificar al empleado de tipo operario el cual sera el responsable de realizar el proceso de vulcanizado.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */

class Vulcanizado {
    //Propiedades
    private $id;
    private $idEmbandado;
    private $idPuestoTrabajo;
    private $idEmpleado;
    private $idEnvelope;
    private $metodo;
    private $idTubo;
    private $idNeumatico;
    private $camaras;
    private $foto;
    private $observaciones;
    private $checked;
    private $estado;
    private $fechaRegistro;
    private $fechaFinalizacion;
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
                $sql="select id, idEmbandado, idPuestoTrabajo, idEmpleado, idEnvelope, metodo, idTubo, idNeumatico, camaras, foto, observaciones, checked, estado, fechaRegistro, fechaFinalizacion from {$P}vulcanizado where $campo=$valor $filtro $orden";
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
    	$this->idEmbandado=$arreglo['idembandado'];
    	$this->idPuestoTrabajo=$arreglo['idpuestotrabajo'];
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->idEnvelope=$arreglo['idenvelope'];
    	$this->idTubo=$arreglo['idtubo'];
    	$this->idNeumatico=$arreglo['idneumatico'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    	$this->fechaFinalizacion=$arreglo['fechafinalizacion'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdEmbandado() {
        return $this->idEmbandado;
    }

    function getIdPuestoTrabajo() {
        return $this->idPuestoTrabajo;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
    }

    function getIdEnvelope() {
        return $this->idEnvelope;
    }

    function getMetodo() {
        return $this->metodo;
    }

    function getIdTubo() {
        return $this->idTubo;
    }

    function getIdNeumatico() {
        return $this->idNeumatico;
    }
    
    function getCamaras() {
        return $this->camaras;
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

    function getFechaFinalizacion() {
        return $this->fechaFinalizacion;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdEmbandado($idEmbandado) {
        $this->idEmbandado = $idEmbandado;
    }

    function setIdPuestoTrabajo($idPuestoTrabajo) {
        $this->idPuestoTrabajo = $idPuestoTrabajo;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    function setIdEnvelope($idEnvelope) {
        $this->idEnvelope = $idEnvelope;
    }

    function setMetodo($metodo) {
        $this->metodo = $metodo;
    }

    function setIdTubo($idTubo) {
        $this->idTubo = $idTubo;
    }

    function setIdNeumatico($idNeumatico) {
        $this->idNeumatico = $idNeumatico;
    }
    
    function setCamaras($camaras) {
        $this->camaras = $camaras;
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

    function setFechaFinalizacion($fechaFinalizacion) {
        $this->fechaFinalizacion = $fechaFinalizacion;
    }

    function getEmbandado() {
        if ($this->idEmbandado!=NULL) return new Embandado ('id', $this->idEmbandado, null, NULL);
        else return new Embandado (null, null, null, null);
    }
    
    function getPuestoTrabajo() {
        if ($this->idPuestoTrabajo!=null) return new Puesto_Trabajo('id', $this->idPuestoTrabajo, null, null);
        else return new Puesto_Trabajo(null, null, null, null);
    }
    
    function getEmpleado() {
        if ($this->idEmpleado!=NULL) return new Empleado ('id', $this->idEmpleado, null, NULL);
        else return new Empleado (null, null, null, null);
    }
    
    function getEvelope() {
        if ($this->idEnvelope!=NULL && $this->idEnvelope!='') return new Producto ('id', $this->idEnvelope, null, NULL);
        else return new Producto (null, null, null, null);
    }
    
    function getTubo() {
        if ($this->idTubo!=NULL && $this->idTubo!='') return new Producto ('id', $this->idTubo, null, NULL);
        else return new Producto (null, null, null, null);
    }
    
    function getNeumatico() {
        if ($this->idNeumatico!=NULL && $this->idNeumatico!='') return new Producto ('id', $this->idNeumatico, null, NULL);
        else return new Producto (null, null, null, null);
    }
    
    function getNombreMetodo() {
        switch ($this->metodo){
            case 0:
                return 'Innerlop';
                break;
            case 1:
                return 'Rin';
                break;
            default :
                return 'Desconocido';
                break;
        }
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
        $sql="insert into {$P}vulcanizado (idEmbandado, idPuestoTrabajo, idEmpleado, idEnvelope, metodo, idTubo, idNeumatico, camaras, foto, observaciones, estado, checked, fechaRegistro, fechaFinalizacion) values ($this->idEmbandado, $this->idPuestoTrabajo, $this->idEmpleado, $this->idEnvelope, $this->metodo, $this->idTubo, $this->idNeumatico, 3, '$this->foto', '$this->observaciones', '$this->estado', '$this->checked', '$this->fechaRegistro', null)";
        Conector::ejecutarQuery($sql, null);
    }
    
    
    public function continuarRegistro() {
        $P='';
        $sql="update {$P}vulcanizado set idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, metodo=$this->metodo, foto='$this->foto', observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public static function modificar() {
        //$P='';
        //$sql="update {$P}vulcanizaddo set idEmbandado=$this->idEmbandado, idEmpleadoEnrinador=$this->idEmpleadoEnrinador, idEmpleado=$this->idEmpleado, observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        //Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}vulcanizado where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public function finalizar($observaciones) {
        $P='';
        if ($observaciones!='' && $observaciones!=null) $aux=" - ";
        else $aux='';
        $sql="update {$P}vulcanizado set observaciones='".rtrim($this->observaciones)." $aux $observaciones', checked='$this->checked', estado='$this->estado', fechaFinalizacion='$this->fechaFinalizacion' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idEmbandado, idPuestoTrabajo, idEmpleado, idEnvelope, metodo, idTubo, idNeumatico, camaras, foto, observaciones, checked, estado, fechaRegistro, fechaFinalizacion from {$P}vulcanizado $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Vulcanizado::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Vulcanizado($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!='' && $valor!=null) $objeto=new Vulcanizado($campo, $valor, $filtro, $orden);
        else $objeto=new Vulcanizado(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idEmbandado']=$objeto->getIdEmbandado();
        $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
        $arreglo['idEmpleado']=$objeto->getIdEmpleado();
        $arreglo['idEnvelope']=$objeto->getIdEnvelope();
        $arreglo['metodo']=$objeto->getMetodo();
        $arreglo['idTubo']=$objeto->getIdTubo();
        $arreglo['idNeumatico']=$objeto->getIdNeumatico();
        $arreglo['camaras']=$objeto->getCamaras();
        $arreglo['camarasRegistradas']=$objeto->getPCRegistradas();
        $arreglo['foto']=$objeto->getFoto();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['checked']=$objeto->getChecked();
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['fechaFinalizacion']=$objeto->getFechaFinalizacion();
        $arreglo['nombreMetodo']=$objeto->getNombreMetodo();
        $arreglo['nombreChecked']=$objeto->getNombreChecked();
        $arreglo['nombreEstado']=$objeto->getNombreEstado();
        $arreglo['embandado']= json_decode(Embandado::getObjetoJSON('id', $objeto->getIdEmbandado(), null, null));
        $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
        $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
        $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 8));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Vulcanizado::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idEmbandado']=$objeto->getIdEmbandado();
            $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
            $arreglo['idEmpleado']=$objeto->getIdEmpleado();
            $arreglo['idEnvelope']=$objeto->getIdEnvelope();
            $arreglo['metodo']=$objeto->getMetodo();
            $arreglo['idTubo']=$objeto->getIdTubo();
            $arreglo['idNeumatico']=$objeto->getIdNeumatico();
            $arreglo['camaras']=$objeto->getCamaras();
            $arreglo['camarasRegistradas']=$objeto->getPCRegistradas();
            $arreglo['foto']=$objeto->getFoto();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['checked']=$objeto->getChecked();
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['fechaFinalizacion']=$objeto->getFechaFinalizacion();
            $arreglo['nombreMetodo']=$objeto->getNombreMetodo();
            $arreglo['nombreChecked']=$objeto->getNombreChecked();
            $arreglo['nombreEstado']=$objeto->getNombreEstado();
            $arreglo['embandado']= json_decode(Embandado::getObjetoJSON('id', $objeto->getIdEmbandado(), null, null));
            $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
            $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
            $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 8));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNextId() {
        global $P, $BD;
        $sql="select max(id)+1 as id from {$P}vulcanizado";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result!=null){
            if ($result[0]['id']!=null) return $result[0]['id'];
            else return 1;
        } else return 1;
    }
    
    public function getEstadoPosicionesCamaras() {
        if ($this->id!=null && $this->id!=''){
            $datos= Posicion_Camara::getListaEnObjetos("idVulcanizado=$this->id", null);
            if (count($datos)<$this->camaras) return false;
            else return true;
        } else return false;
    }
    
    public function getMaxPC() {
        $sql="select camaras from vulcanizado where id=$this->id";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null){
            if ($r[0]['camaras']!=null) return $r[0]['camaras'];
            else return null;
        } else return null;
    }
    
    public function setCamarasConfiguracion($valor) {
        $sql="update vulcanizado set camaras=$valor where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }


    public static function getObjetoJSONSimple($campo, $valor, $filtro, $orden) {
        if ($valor!='' && $valor!=null) $objeto=new Vulcanizado($campo, $valor, $filtro, $orden);
        else $objeto=new Vulcanizado(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idEmbandado']=$objeto->getIdEmbandado();
        $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
        $arreglo['idEmpleado']=$objeto->getIdEmpleado();
        $arreglo['idEnvelope']=$objeto->getIdEnvelope();
        $arreglo['metodo']=$objeto->getMetodo();
        $arreglo['idTubo']=$objeto->getIdTubo();
        $arreglo['idNeumatico']=$objeto->getIdNeumatico();
        $arreglo['foto']=$objeto->getFoto();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['checked']=$objeto->getChecked();
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['fechaFinalizacion']=$objeto->getFechaFinalizacion();
        $arreglo['nombreMetodo']=$objeto->getNombreMetodo();
        $arreglo['nombreChecked']=$objeto->getNombreChecked();
        $arreglo['nombreEstado']=$objeto->getNombreEstado();
        $arreglo['camaras']=$objeto->getCamaras();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public function getPCRegistradas() {
        /*
         * Esta funcion retorna el valor maximo de pociciones de camaras regist-
         * radas por parte de un vulcanizado.
         */
        $total=0;
        $sql="select count(id) as total from posicion_camara where idVulcanizado=$this->id";
        $r= Conector::ejecutarQuery($sql, null);
        if ($r!=null){
            if ($r[0]['total']!=null) $total=$r[0]['total'];
        }
        return $total;
    }
}
