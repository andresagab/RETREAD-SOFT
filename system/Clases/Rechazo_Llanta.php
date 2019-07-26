<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */

/**
 * Descripcion de la clase Rechazo_Llanta:
 *
 * Define las propiedades id, idLlanta, observaciones, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Rechazo_Llanta {
    //Propiedades
    private $id;
    private $idLlanta;
    private $proceso;
    private $idProceso;
    private $observaciones;
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
                $sql="select id, idLlanta, proceso, idProceso, observaciones, fechaRegistro from {$P}Rechazo_Llanta where $campo=$valor $filtro $orden";
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
    	$this->idLlanta=$arreglo['idllanta'];
    	$this->idProceso=$arreglo['idproceso'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdLlanta() {
        return $this->idLlanta;
    }

    function getProceso() {
        return $this->proceso;
    }

    function getIdProceso() {
        return $this->idProceso;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdLlanta($idLlanta) {
        $this->idLlanta = $idLlanta;
    }

    function setProceso($proceso) {
        $this->proceso = $proceso;
    }

    function setIdProceso($idProceso) {
        $this->idProceso = $idProceso;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
    
    function getLlanta(){
        if ($this->idLlanta!=null && $this->idLlanta!='') return new Llanta ('id', $this->idLlanta, null, null);
        else return new Llanta (null, null, null, null);
    }
    
    function getNombreProceso() {
        switch ($this->proceso) {
            case 0:
                return 'Inspeccion inicial';
                break;
            case 1:
                return 'Raspado';
                break;
            case 2:
                return 'Preparacion';
                break;
            case 3 :
                return 'Reparacion';
                break;
            case 4 :
                return 'Cementado';
                break;
            case 5 :
                return 'Relleno';
                break;
            case 6 :
                return 'Corte de banda';
                break;
            case 7 :
                return 'Embandado';
                break;
            case 8 :
                return 'Vulcanizado';
                break;
            case 9 :
                return 'Inspeccion final';
                break;
            case 10 :
                return 'Terminacion';
                break;
            default:
                return 'Desconocido';
                break;
        }
    }
    
    public function grabar() {
        $P='';
        $sql="insert into {$P}Rechazo_Llanta (idLlanta, proceso, idProceso, observaciones, fechaRegistro) values ($this->idLlanta, $this->proceso, $this->idProceso, '$this->observaciones', '$this->fechaRegistro')";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null) return true;
        else return false;
    }

    public function modificar() {
        $P='';
        $sql="update {$P}Rechazo_Llanta set idLlanta=$this->idLlanta, proceso=$this->proceso, idProceso=$this->idProceso, observaciones='$this->observaciones' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}Rechazo_Llanta where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idLlanta, proceso, idProceso, observaciones, fechaRegistro from {$P}Rechazo_Llanta $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Rechazo_Llanta::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Rechazo_Llanta($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Rechazo_Llanta($campo, $valor, $filtro, $orden);
        else $objeto=new Rechazo_Llanta(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idLlanta']=$objeto->getIdLlanta();
        $arreglo['proceso']=$objeto->getProceso();
        $arreglo['idProceso']=$objeto->getIdProceso();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['nombreProceso']=$objeto->getNombreProceso();
        $arreglo['llanta']= json_decode(Llanta::getObjetoJSON('id', $objeto->getIdLlanta(), null, null));
        //array_push($JSON, $arreglo);
        return json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Rechazo_Llanta::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idLlanta']=$objeto->getIdLlanta();
            $arreglo['proceso']=$objeto->getProceso();
            $arreglo['idProceso']=$objeto->getIdProceso();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['nombreProceso']=$objeto->getNombreProceso();
            $arreglo['llanta']= json_decode(Llanta::getObjetoJSON('id', $objeto->getIdLlanta(), null, null));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getProcesosEnArray() {
        $arreglo=array();
        $array=array();
        for ($i = 0; $i < 12; $i++) {
            $objeto=new Rechazo_Llanta(null, null, null, null);
            $objeto->setProceso($i);
            $array['id']=$i;
            $array['proceso']=$objeto->getNombreProceso();
            array_push($arreglo, $array);
        }
        return $arreglo;
    }
    
    public static function getProcesoEnOptions($deefault) {
        $options='';
        $datos= Rechazo_Llanta::getProcesosEnArray();
        for ($i = 0; $i < count($datos); $i++) {
            $dato=$datos[$i];
            if ($deefault==$dato['id']) $selected='selected';
            else $selected='';
            $options.="<option value='{$dato['id']}' $selected>{$dato['proceso']}</option>";
        }
        return $options;
    }
    
    public function getRechazos() {
        $datosRechazos= Rechazo::getListaEnObjetos(null, null);
        if ($this->id!=null && $this->id!='') $datosRLlantaDetalles= RLlanta_Detalle::getListaEnObjetos("idRechazoLlanta=$this->id", null);
        else $datosRLlantaDetalles=null;
        $JSON=array();
        for ($i = 0; $i < count($datosRechazos); $i++) {
            $rechazo=$datosRechazos[$i];
            $arreglo=array();
            $arreglo['id']=$rechazo->getId();
            $arreglo['nombre']=$rechazo->getNombre();
            $arreglo['observaciones']=$rechazo->getObservaciones();
            $arreglo['fechaRegistro']=$rechazo->getFechaRegistro();
            if (count($datosRLlantaDetalles)>0){
                for ($j = 0; $j < count($datosRLlantaDetalles); $j++) {
                    $rLlanta_Detalle=$datosRLlantaDetalles[$j];
                    if ($rLlanta_Detalle->getIdRechazo()==$rechazo->getId()){
                        $arreglo['checked']=true;
                        $j= count($datosRLlantaDetalles);
                    } else $arreglo['checked']=false;
                }
            } else $arreglo['checked']=false;
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public function eliminarDetalles() {
        global $P, $BD;
        if ($this->id!='' && $this->id!=null){
            $datos= RLlanta_Detalle::getListaEnObjetos("idRechazoLlanta=$this->id", null);
            if (count($datos)>0){
                $sql="delete from {$P}RLlanta_Detalle where idRechazoLlanta=$this->id";
                $r= Conector::ejecutarQuery($sql, null);
                if ($r!=null) return true;
                else return false;
            }
        }
    }
    
    public function getRechazosDetalleJSON() {
        if ($this->id!=null){
            return RLlanta_Detalle::getObjetosJSON("idrechazollanta=$this->id", null);
        } else return json_encode (array());
    }

    public static function getRechazosLlantaJSON($idLlanta) {
        $JSON = array();
        if ($idLlanta!=null) {
            $object = new Rechazo_Llanta('idLlanta', $idLlanta, null, null);
            $rechazo = array();
            $rechazos = array();
            if ($object!=null) {
                foreach ($object as $item => $val) $rechazo["$item"] = $val;
                $objects = RLlanta_Detalle::getListaEnObjetos("idrechazollanta={$object->getId()}", null);
                for ($i=0; $i<count($objects); $i++) {
                    foreach ($objects[$i] as $key => $val) $rechazos[$i]["$key"] = $val;
                }
            }
            array_push($JSON, $rechazo);
            array_push($JSON, $rechazos);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function getValidRechazo($idLlanta) {
        /*
         * SE VALIDARA SI UNA LLANTA DETERMINADA POR $idLlanta YA FUE RECHAZADA
         * TRUE = LLANTA RECHAZADA
         * FALSE = LLANTA NO RECHAZADA
        */
        $status = false;
        if (validVal($idLlanta)) {
            $rechazo = new Rechazo_Llanta('idLlanta', $idLlanta, null, null);
            if (validVal($rechazo->getId())) $status = true;
        }
        return $status;
    }

    private function validSubRegistros() {
        /*
         * SE VALIDA LA EXISTENCIA DE REGISTROS EN "RLLANTA_DETALLE" ASOCIOADOS A LA TABLA "RECHAZO_LLANTA"
         * TRUE = EXISTEN REGISTROS ASOCIADOS
         * FALSE = NO EXISTEN REGISTROS ASOCIADOS
         * */
        $valid = false;
        $sql = "select count(idrechazollanta) from rllanta_detalle where idrechazollanta=$this->id";
        $result = Conector::ejecutarQuery($sql, null);
        if (is_array($result)){
            if ($result[0]['count'] > 0) $valid = true;
        }
        return $valid;
    }

    public static function getDataRechazo($idLlanta){
        /*
         * SE CARGA TODA LA INFORMACIÓN CORRESPONDIENTE AL RECHAZO DE UNA LLANTA APARTID DEL $idLlanta
         * EL VALOR RETONARNADO CORRESPONDE A UN OBJETO JSON QUE CONTIENE CADA UNO DE LOS VALORES ASOCIADOS A LA TABLA RECHAZO_LLANTA, ESTE TAMBIÉN INCLUTE TODOS LOS OBJETOS RELACIONADOS A RLLANTA_DETALLE
         * PUEDE USAR LOS CAMPOS "REGISTER" y "SUBREGISTERS" PARA VALIDAR LA CARGA DE DATOS, ESTE SE ASIGNA EN FALSE AL INICIO DEL METODO Y EN TRUE CUANDO LOS DATOS SON CARGADOS
         * */
        $JSON = array();
        $JSON['register'] = false;
        $JSON['subRegisters'] = false;
        $JSON["rechazos"] = array();
        if (validVal($idLlanta)) {
            $rechazo = new Rechazo_Llanta('idLlanta', $idLlanta, null, null);
            if (validVal($rechazo->getId())){
                $JSON['register'] = true;
                foreach ($rechazo as $item => $val) $JSON["$item"] = $val;
                $JSON['subRegisters'] = $rechazo->validSubRegistros();
                if ($JSON['subRegisters']){
                    $rechazos = RLlanta_Detalle::getListaEnObjetos("idrechazollanta={$rechazo->getId()}", null);
                    for ($i = 0; $i < count($rechazos); $i++) {
                        $array = array();
                        $array["id"] = $rechazos[$i]->getId();
                        $array["fechaRegistro"] = $rechazos[$i]->getFechaRegistro();
                        $rechazoOriginal = $rechazos[$i]->getRechazo();
                        $array["idRechazo"] = $rechazoOriginal->getId();
                        $array["nombre"] = $rechazoOriginal->getNombre();
                        $array["observaciones"] = $rechazoOriginal->getObservaciones();
                        array_push($JSON["rechazos"], $array);
                    }
                }
            }
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

}
