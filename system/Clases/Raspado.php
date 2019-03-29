<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** Descripcion de la clase Raspado:
 *
 * Define las propiedades id, idInspeccion, IdEmpleado, anchoBanda, largoBanda, observaciones, checked, estado y fechaRegistro, fechainicioproceso las cuales permite identificar el raspado de una llanta.
 *
 * El atributo idInspeccion ayudara a relacionar la inspeccion con el proceso de raspado de la llanta, Teniendo en cuenta que solo se dara la aprobacion para este raspado si la inspeccion fue aprobada.
 * El atributo idEmpleado nos permitira identificar al empleado de tipo operario el cual sera el responsable de realizar el proceso de raspado.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */

class Raspado {
    //Propiedades
    private $id;
    private $idInspeccion;
    private $idEmpleado;
    private $idPuestoTrabajo;
    private $anchoBanda;
    private $largoBanda;
    private $cinturon;
    private $cinturonCantidad;
    private $profundidad;
    private $radio;
    private $estado;
    private $checked;
    private $foto;
    private $fotoSerial;
    private $observaciones;
    private $fechaRegistro;
    private $fechaInicioProceso;
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
                $sql="select id, idInspeccion, idEmpleado, idPuestoTrabajo, anchoBanda, largoBanda, cinturon, cinturonCantidad, profundidad, radio, estado, checked, foto, fotoSerial, observaciones, fechaRegistro, fechainicioproceso from {$P}raspado where $campo=$valor $filtro $orden";
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
    	$this->idInspeccion=$arreglo['idinspeccion'];
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->idPuestoTrabajo=$arreglo['idpuestotrabajo'];
    	$this->anchoBanda=$arreglo['anchobanda'];
    	$this->largoBanda=$arreglo['largobanda'];
    	$this->cinturonCantidad=$arreglo['cinturoncantidad'];
    	$this->fotoSerial = $arreglo['fotoserial'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    	$this->fechaInicioProceso=$arreglo['fechainicioproceso'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdInspeccion() {
        return $this->idInspeccion;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
    }

    function getIdPuestoTrabajo() {
        return $this->idPuestoTrabajo;
    }
    
    function getAnchoBanda() {
        return $this->anchoBanda;
    }

    function getLargoBanda() {
        return $this->largoBanda;
    }

    function getCinturon() {
        return $this->cinturon;
    }

    function getCinturonCantidad() {
        return $this->cinturonCantidad;
    }

    function getProfundidad() {
        return $this->profundidad;
    }

    function getRadio() {
        return $this->radio;
    }

    function getFoto() {
        return $this->foto;
    }

    function getChecked() {
        return $this->checked;
    }

    function getEstado() {
        return $this->estado;
    }

    function getObservaciones() {
        if ($this->observaciones!=null && $this->observaciones!="" && $this->observaciones!='-' && $this->observaciones!='---' && $this->observaciones!=' - ') return $this->observaciones;
        else return "Sin observaciones";
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getInspeccion() {
        if ($this->idInspeccion!=null) return new Inspeccion_Inicial('id', $this->idInspeccion, null, null);
        else return new Inspeccion_Inicial(null, null, null, null);
    }
    
    function getEmpleado() {
        if ($this->idEmpleado!=null) return new Empleado('id', $this->idEmpleado, null, null);
        else return new Empleado(null, null, null, null);
    }
    
    function getPuestoTrabajo() {
        if ($this->idPuestoTrabajo!=null) return new Puesto_Trabajo('id', $this->idPuestoTrabajo, null, null);
        else return new Puesto_Trabajo(null, null, null, null);
    }
    
    function getNombreCinturon() {
        if ($this->cinturon) return 'Retirado';
        else return 'No retirado';
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

    function setIdInspeccion($idInspeccion) {
        $this->idInspeccion = $idInspeccion;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }
    
    function setIdPuestoTrabajo($idPuestoTrabajo) {
        $this->idPuestoTrabajo = $idPuestoTrabajo;
    }

    function setAnchoBanda($anchoBanda) {
        $this->anchoBanda = $anchoBanda;
    }

    function setLargoBanda($largoBanda) {
        $this->largoBanda = $largoBanda;
    }

    
    function setCinturon($cinturon) {
        $this->cinturon = $cinturon;
    }

    function setCinturonCantidad($cinturonCantidad) {
        $this->cinturonCantidad = $cinturonCantidad;
    }

    function setProfundidad($profundidad) {
        $this->profundidad = $profundidad;
    }

    function setRadio($radio) {
        $this->radio = $radio;
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

    /**
     * @return mixed
     */
    public function getFechaInicioProceso()
    {
        return $this->fechaInicioProceso;
    }

    /**
     * @param mixed $fechaInicioProceso
     */
    public function setFechaInicioProceso($fechaInicioProceso)
    {
        $this->fechaInicioProceso = $fechaInicioProceso;
    }

    /**
     * @return mixed
     */
    public function getFotoSerial()
    {
        return $this->fotoSerial;
    }

    /**
     * @param mixed $fotoSerial
     */
    public function setFotoSerial($fotoSerial)
    {
        $this->fotoSerial = $fotoSerial;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}raspado (idInspeccion, idEmpleado, anchoBanda, largoBanda, cinturon, cinturonCantidad, profundidad, radio, estado, checked, foto, fotoSerial, observaciones, fechaRegistro, fechainicioproceso) values ($this->idInspeccion, $this->idEmpleado, $this->anchoBanda, $this->largoBanda, '$this->cinturon', $this->cinturonCantidad, $this->profundidad, $this->radio, '$this->estado', '$this->checked', '$this->foto', '$this->fotoSerial', '$this->observaciones', '$this->fechaRegistro', '$this->fechaInicioProceso')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}raspado set idInspeccion=$this->idInspeccion, idEmpleado=$this->idEmpleado, anchoBanda=$this->anchoBanda, largoBanda=$this->largoBanda, cinturon='$this->cinturon', cinturonCantidad=$this->cinturonCantidad, profundidad=$this->profundidad, radio=$this->radio, estado='$this->estado', checked='$this->checked', foto='$this->foto', fotoSerial='$this->fotoSerial', observaciones='$this->observaciones' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function continuarRegistro() {
        $P='';
        $sql="update {$P}raspado set idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, anchoBanda=$this->anchoBanda, largoBanda=$this->largoBanda, cinturon='$this->cinturon', cinturonCantidad=$this->cinturonCantidad, profundidad=$this->profundidad, radio=$this->radio, observaciones='$this->observaciones', checked='$this->checked', estado='$this->estado', foto='$this->foto', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public function finalizar() {
        $P='';
        $sql="update {$P}raspado set idEmpleado=$this->idEmpleado, idPuestoTrabajo=$this->idPuestoTrabajo, anchoBanda=$this->anchoBanda, largoBanda=$this->largoBanda, cinturon='$this->cinturon', cinturonCantidad=$this->cinturonCantidad, profundidad=$this->profundidad, radio=$this->radio, estado='$this->estado', checked='$this->checked', foto='$this->foto', fotoSerial='$this->fotoSerial', observaciones='$this->observaciones', fechaRegistro='$this->fechaRegistro' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}raspado where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idInspeccion, idEmpleado, idPuestoTrabajo, anchoBanda, largoBanda, cinturon, cinturonCantidad, profundidad, radio, estado, checked, foto, fotoserial, observaciones, fechaRegistro, fechainicioproceso from {$P}raspado $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Raspado::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Raspado($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Raspado($campo, $valor, $filtro, $orden);
        else $objeto=new Raspado(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idInspeccion']=$objeto->getIdInspeccion();
        $arreglo['idEmpleado']=$objeto->getIdEmpleado();
        $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
        $arreglo['anchoBanda']=$objeto->getAnchoBanda();
        $arreglo['largoBanda']=$objeto->getLargoBanda();
        $arreglo['cinturon']=$objeto->getCinturon();
        $arreglo['cinturonCantidad']=$objeto->getCinturonCantidad();
        $arreglo['nombreCinturon']=$objeto->getNombreCinturon();
        $arreglo['profundidad']=$objeto->getProfundidad();
        $arreglo['radio']=$objeto->getRadio();
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['checked']=$objeto->getChecked();
        $arreglo['foto']=$objeto->getFoto();
        $arreglo['fotoSerial'] = $objeto->getFotoSerial();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['fechaInicioProceso']=$objeto->getFechaInicioProceso();
        $inspeccion=$objeto->getInspeccion();
        $arreglo['inspeccion']= json_decode(Inspeccion_Inicial::getObjetoJSON('id', $objeto->getIdInspeccion(), null, null));
        $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
        $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
        $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 1));
        $arreglo['nombreChecked']=$objeto->getNombreChecked();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Inspeccion_Inicial::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idInspeccion']=$objeto->getIdInspeccion();
            $arreglo['idEmpleado']=$objeto->getIdEmpleado();
            $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
            $arreglo['anchoBanda']=$objeto->getAnchoBanda();
            $arreglo['largoBanda']=$objeto->getLargoBanda();
            $arreglo['cinturon']=$objeto->getCinturon();
            $arreglo['cinturonCantidad']=$objeto->getCinturonCantidad();
            $arreglo['nombreCinturon']=$objeto->getNombreCinturon();
            $arreglo['profundidad']=$objeto->getProfundidad();
            $arreglo['radio']=$objeto->getRadio();
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['checked']=$objeto->getChecked();
            $arreglo['foto']=$objeto->getFoto();
            $arreglo['fotoSerial'] = $objeto->getFotoSerial();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['fechaInicioProceso']=$objeto->getFechaInicioProceso();
            $inspeccion=$objeto->getInspeccion();
            $arreglo['inspeccion']= json_decode(Inspeccion_Inicial::getObjetoJSON('id', $objeto->getIdInspeccion(), null, null));
            $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
            $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
            $arreglo['usosInsumos']= json_decode(Uso_Insumo_Proceso::getUsosInforme($objeto->getId(), 1));
            $arreglo['nombreChecked']=$objeto->getNombreChecked();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNextId() {
        global $P, $BD;
        $sql="select max(id)+1 as id from {$P}raspado";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result!=null){
            if ($result[0]['id']!=null) return $result[0]['id'];
            else return 1;
        } else return 1;
    }

    public static function getData($type, $field, $value, $filter, $order, $sql, $extras) {
        $JSON = array();
        switch ($type) {
            case 0:
                if ($field!=null && $value!=null) {
                    foreach ($object = new Raspado($field, $value, $filter, $order) as $item => $val) {
                        $JSON["$item"] = $val;
                        ${$item} = $val;
                    }
                    $JSON['nombreEstado'] = $object->getNombreEstado();
                    if ($object->getFoto()==null || $object->getFoto()=='') $JSON['notImage'] = true;
                    $JSON['usosRegistrados'] = $object->getStatusUsos();
                    if ($extras) {
                        $JSON['puestoTrabajo'] = json_decode(Puesto_Trabajo::getObjetoJSON('id', $object->getIdPuestoTrabajo(), null, null));
                        $JSON['empleado'] = json_decode(Empleado::getObjetoJSON('id', $object->getIdEmpleado(), null, null));
                        $JSON['usosInsumos'] = json_decode(Uso_Insumo_Proceso::getUsosInforme($object->getId(), 1));
                        $JSON['inspeccionInicial'] = json_decode(Inspeccion_Inicial::getObjetoJSON('id', $object->getIdRelleno(), null, null));
                    }
                }
                break;
            case 1:
                $objects = Raspado::getListaEnObjetos($filter, $order);
                for ($i=0; $i<count($objects); $i++) {
                    $data = array();
                    $object = $objects[$i];
                    foreach ($objects[$i] as $item => $val) {
                        $data["$item"] = $val;
                        ${$item} = $val;
                    }
                    $data['nombreEstado']=$object->getNombreEstado();
                    if ($object->getFoto()==null || $object->getFoto()=='') $data['notImage'] = true;
                    $JSON['usosRegistrados'] = $object->getStatusUsos();
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
                        $object = new Raspado(null, null, null, null);
                        $object->setId(@$id);
                        $object->setFoto(@$foto);
                        $object->setEstado(@$estado);
                        $data['nombreEstado']=$object->getNombreEstado();
                        if ($object->getFoto()==null || $object->getFoto()=='') $data['notImage']=true;
                        $JSON['usosRegistrados'] = $object->getStatusUsos();
                        if ($extras) {
                            $data['puestoTrabajo'] = json_decode(Puesto_Trabajo::getObjetoJSON('id', $object->getIdPuestoTrabajo(), null, null));
                            $data['empleado'] = json_decode(Empleado::getObjetoJSON('id', $object->getIdEmpleado(), null, null));
                            $data['usosInsumos'] = json_decode(Uso_Insumo_Proceso::getUsosInforme($object->getId(), 6));
                            $data['relleno'] = json_decode(Relleno::getObjetoJSON('id', $object->getIdRelleno(), null, null));
                        }
                        array_push($JSON, $data);
                    }
                }
                break;
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public function getStatusUsos() {
        $status = false;
        $sql = "select id from uso_insumo_proceso where idproceso=$this->id and proceso=1";
        if (is_array($result = Conector::ejecutarQuery($sql, null))) {
            if (count($result)>0) {
                if ($result[0][0]!=null) $status = true;
            }
        }
        return $status;
    }

}
