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
 * Descripcion de la clase Uso_Insumo_Proceso:
 *
 * Define las propiedades id, idEmpleado, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Uso_Insumo_Proceso {
    //Propiedades
    private $id;
    private $idEmpleado;
    private $idProceso;
    private $proceso;
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
                $sql="select id, idEmpleado, idProceso, proceso, fechaRegistro from {$P}Uso_Insumo_Proceso where $campo=$valor $filtro $orden";
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
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->idProceso=$arreglo['idproceso'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
    }

    function getIdProceso() {
        return $this->idProceso;
    }

    function getProceso() {
        return $this->proceso;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    function setProceso($proceso) {
        $this->proceso = $proceso;
    }

    function setIdProceso($idProceso) {
        $this->idProceso = $idProceso;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
    
    function getEmpleado(){
        if ($this->idEmpleado!=null && $this->idEmpleado!='') return new Empleado ('id', $this->idEmpleado, null, null);
        else return new Empleado (null, null, null, null);
    }
    
    function getNombreProceso($tabla) {
        $nombreProceso='';
        $nombreTabla='';
        switch ($this->proceso) {
            case 0:
                $nombreProceso='Inspeccion inicial';
                $nombreTabla='Inspeccion_Inicial';
                break;
            case 1:
                $nombreProceso='Raspado';
                $nombreTabla='Raspado';
                break;
            case 2:
                $nombreProceso='Preparacion';
                $nombreTabla='Preparacion';
                break;
            case 3 :
                $nombreProceso='Reparacion';
                $nombreTabla='Reparacion';
                break;
            case 4 :
                $nombreProceso='Cementado';
                $nombreTabla='Cementado';
                break;
            case 5 :
                $nombreProceso='Relleno';
                $nombreTabla='Relleno';
                break;
            case 6 :
                $nombreProceso='Corte de banda';
                $nombreTabla='Corte_Banda';
                break;
            case 7 :
                $nombreProceso='Embandado';
                $nombreTabla='Embandado';
                break;
            case 8 :
                $nombreProceso='Vulcanizado';
                $nombreTabla='Vulcanizado';
                break;
            case 9 :
                $nombreProceso='Inspeccion final';
                $nombreTabla='Inspeccion_Final';
                break;
            case 10 :
                $nombreProceso='Terminacion';
                $nombreTabla='Terminacion';
                break;
            default:
                $nombreProceso='Desconocido';
                $nombreTabla='Desconocido';
                break;
        }
        if ($tabla) return $nombreTabla;
        else return $nombreProceso;
    }
    
    public function grabar() {
        $P='';
        $sql="insert into {$P}Uso_Insumo_Proceso (idEmpleado, idProceso, proceso, fechaRegistro) values ($this->idEmpleado, $this->idProceso, $this->proceso, '$this->fechaRegistro')";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null) return true;
        else return false;
    }

    public function modificar() {
        $P='';
        $sql="update {$P}Uso_Insumo_Proceso set idEmpleado=$this->idEmpleado, proceso=$this->proceso, idProceso=$this->idProceso where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}Uso_Insumo_Proceso where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idEmpleado, proceso, idProceso, fechaRegistro from {$P}Uso_Insumo_Proceso $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Uso_Insumo_Proceso::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Uso_Insumo_Proceso($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Uso_Insumo_Proceso($campo, $valor, $filtro, $orden);
        else $objeto=new Uso_Insumo_Proceso(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idEmpleado']=$objeto->getIdEmpleado();
        $arreglo['idProceso']=$objeto->getIdProceso();
        $arreglo['proceso']=$objeto->getProceso();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['nombreProceso']=$objeto->getNombreProceso(false);
        $arreglo['nombreTablaProceso']=$objeto->getNombreProceso(true);
        $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
        //if ($valor!=null) $arreglo['procesoObjeto']= json_decode($objeto->getNombreProceso(true)::getObjetoJSON('id', $objeto->getIdProceso(), null, null));
        //else $arreglo['procesoObjeto']='[]';
        return json_encode($arreglo, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Uso_Insumo_Proceso::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idEmpleado']=$objeto->getIdEmpleado();
            $arreglo['idProceso']=$objeto->getIdProceso();
            $arreglo['proceso']=$objeto->getProceso();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['nombreProceso']=$objeto->getNombreProceso(false);
            $arreglo['nombreTablaProceso']=$objeto->getNombreProceso(true);
            $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
            //if (count($datos>0)) $arreglo['procesoObjeto']= json_decode($objeto->getNombreProceso(true)::getObjetoJSON('id', $objeto->getIdProceso(), null, null));
            //else $arreglo['procesoObjeto']='[]';
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getProcesosEnArray() {
        $arreglo=array();
        $array=array();
        for ($i = 0; $i < 12; $i++) {
            $objeto=new Uso_Insumo_Proceso(null, null, null, null);
            $objeto->setProceso($i);
            $array['id']=$i;
            $array['proceso']=$objeto->getNombreProceso(false);
            $array['tabla']=$objeto->getNombreProceso(true);
            array_push($arreglo, $array);
        }
        return $arreglo;
    }
    
    public static function getProcesoEnOptions($deefault) {
        $options='';
        $datos= Uso_Insumo_Proceso::getProcesosEnArray();
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
        if ($this->id!=null && $this->id!='') $datosREmpleadoDetalles= REmpleado_Detalle::getListaEnObjetos("idRechazoEmpleado=$this->id", null);
        else $datosREmpleadoDetalles=null;
        $JSON=array();
        for ($i = 0; $i < count($datosRechazos); $i++) {
            $rechazo=$datosRechazos[$i];
            $arreglo=array();
            $arreglo['id']=$rechazo->getId();
            $arreglo['nombre']=$rechazo->getNombre();
            $arreglo['observaciones']=$rechazo->getObservaciones();
            $arreglo['fechaRegistro']=$rechazo->getFechaRegistro();
            if (count($datosREmpleadoDetalles)>0){
                for ($j = 0; $j < count($datosREmpleadoDetalles); $j++) {
                    $rEmpleado_Detalle=$datosREmpleadoDetalles[$j];
                    if ($rEmpleado_Detalle->getIdRechazo()==$rechazo->getId()){
                        $arreglo['checked']=true;
                        $j= count($datosREmpleadoDetalles);
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
            $datos= REmpleado_Detalle::getListaEnObjetos("idRechazoEmpleado=$this->id", null);
            if (count($datos)>0){
                $sql="delete from {$P}REmpleado_Detalle where idRechazoEmpleado=$this->id";
                $r= Conector::ejecutarQuery($sql, null);
                if ($r!=null) return true;
                else return false;
            }
        }
    }
    
    public function getInfoUsosInsumos() {
        /*
         * Esta funcion retorna un arreglo de tipo JSON con informacion relacio-
         * nada al uso, el registro y la terminacion de los insumo durante un
         * proceso de rencauche determinado.
         * 
         * Se toma como base fundamental de la consulta SQL las variable de la
         * clase idProceso, proceso.
         */
        $JSON=array();
        if ($this->id!=null){
            $sql="select pt.id as idpuestotrabajo, pt.nombre as puestotrabajo, p.nombre as insumo, uipd.usado as usado, uipd.cantidad as cantidadUsada, uipd.terminado as terminado, ipt.cantidad as cantidad, ipt.id as idinsumo, per.nombres || ' ' || per.apellidos as empleado_usador, perer.nombres || ' ' || perer.apellidos as empleado_envio
                    from uso_insumo_proceso as uip, uso_insumo_proceso_detalle as uipd, insumo_puestotrabajo as ipt, puesto_trabajo as pt, producto as i, puc as p, empleado as e, persona as per, usuario as u, usuario_persona as up, empleado as er, persona as perer 
                    where uipd.idusoinsumoproceso=uip.id 
                    and ipt.id=uipd.idinsumopt 
                    and pt.id=ipt.idpuestotrabajo 
                    and i.id=ipt.idinsumo 
                    and p.codigo=i.codpuc
                    and e.id=uipd.idempleado
                    and per.identificacion=e.identificacion
                    and u.usuario=ipt.usuario 
                    and up.idusuario=u.id 
                    and perer.identificacion=up.identificacion 
                    and er.identificacion=perer.identificacion
                    and uip.idproceso=$this->idProceso 
                    and uip.proceso=$this->proceso";
            $r=Conector::ejecutarQuery($sql, null);
            if ($r!=null){
                $arreglo=array();
                if ($r[0]>0){
                    for ($i = 0; $i < count($r); $i++) {
                        foreach ($r[$i] as $key => $value) ${$key}=$value;
                        $arreglo['idPuestoTrabajo']=$idpuestotrabajo;
                        $arreglo['puestoTrabajo']=$puestotrabajo;
                        $arreglo['idInsumo']=$idinsumo;
                        $arreglo['insumo']=$insumo;
                        $arreglo['usado']=$usado;
                        $arreglo['cantidad']=$cantidad;
                        $arreglo['empleadoUso']=$empleado_usador;
                        $arreglo['empleadoEnvio']=$empleado_envio;
                        $arreglo['cantidadUsada']=$cantidadusada;
                        if (!$terminado){
                            $insumoTerminacion=new Insumo_Terminacion('idInsumoPT', $idinsumo, null, null);
                            if ($insumoTerminacion->getId()!=null) {
                                $arreglo['terminado']=true;
                                $arreglo['nombreTerminado']='Si';
                            }
                            else {
                                $arreglo['terminado']=false;
                                $arreglo['nombreTerminado']='No';
                            }
                        } else {
                            $arreglo['terminado']=$terminado;
                            $arreglo['nombreTerminado']='Si';
                        }
                        if ($usado) $arreglo['nombreUsado']='Si';
                        else $arreglo['nombreUsado']='No';
                        $insumoPT=new Insumo_Puesto_Trabajo('id', $idinsumo, null, null);
                        //$arreglo['remainingStock']=$insumoPT->getRemainingStock();
                        array_push($JSON, $arreglo);
                    }
                }
                return json_encode($JSON);
            } else return json_encode ($JSON);
        } else return json_encode($JSON);
    }
    
    public static function getUsosInforme($idProceso, $proceso) {
        $JSON=array();
        $JSON['datos']=array();
        if ($idProceso!=null && $proceso!=null){
            $sql="select pt.id as idpuestotrabajo, pt.nombre as puestotrabajo, p.nombre as insumo, uipd.usado as usado, uipd.cantidad as cantidadUsada, uipd.terminado as terminado, ipt.cantidad as cantidad, ipt.id as idinsumo, per.nombres || ' ' || per.apellidos as empleado_usador, perer.nombres || ' ' || perer.apellidos as empleado_envio
                    from uso_insumo_proceso as uip, uso_insumo_proceso_detalle as uipd, insumo_puestotrabajo as ipt, puesto_trabajo as pt, producto as i, puc as p, empleado as e, persona as per, usuario as u, usuario_persona as up, empleado as er, persona as perer 
                    where uipd.idusoinsumoproceso=uip.id 
                    and ipt.id=uipd.idinsumopt 
                    and pt.id=ipt.idpuestotrabajo 
                    and i.id=ipt.idinsumo 
                    and p.codigo=i.codpuc
                    and e.id=uipd.idempleado
                    and per.identificacion=e.identificacion
                    and u.usuario=ipt.usuario 
                    and up.idusuario=u.id 
                    and perer.identificacion=up.identificacion 
                    and er.identificacion=perer.identificacion
                    and uip.idproceso=$idProceso 
                    and uip.proceso=$proceso";
            $r=Conector::ejecutarQuery($sql, null);
            if ($r!=null){
                $arreglo=array();
                if ($r[0]>0){
                    $JSON['total']= count($r);
                    for ($i = 0; $i < count($r); $i++) {
                        foreach ($r[$i] as $key => $value) ${$key}=$value;
                        $arreglo['idPuestoTrabajo']=$idpuestotrabajo;
                        $arreglo['puestoTrabajo']=$puestotrabajo;
                        $arreglo['idInsumo']=$idinsumo;
                        $arreglo['insumo']=$insumo;
                        $arreglo['usado']=$usado;
                        $arreglo['cantidad']=$cantidad;
                        $arreglo['empleadoUso']=$empleado_usador;
                        $arreglo['empleadoEnvio']=$empleado_envio;
                        $arreglo['cantidadUsada']=$cantidadusada;
                        if (!$terminado){
                            $insumoTerminacion=new Insumo_Terminacion('idInsumoPT', $idinsumo, null, null);
                            if ($insumoTerminacion->getId()!=null) {
                                $arreglo['terminado']=true;
                                $arreglo['nombreTerminado']='Si';
                            }
                            else {
                                $arreglo['terminado']=false;
                                $arreglo['nombreTerminado']='No';
                            }
                        } else {
                            $arreglo['terminado']=$terminado;
                            $arreglo['nombreTerminado']='Si';
                        }
                        if ($usado) $arreglo['nombreUsado']='Si';
                        else $arreglo['nombreUsado']='No';
                        array_push($JSON['datos'], $arreglo);
                    }
                } else $JSON['total']=0;
                return json_encode($JSON);
            } else {
                $JSON['total']=0;
                return json_encode ($JSON);
            }
        } else return json_encode($JSON);
    }

    public static function getDataProcesoJSON($table, $field, $value, $filter, $order, $numeroProceso) {
        $JSON = array();
        $sql = "select * from $table where $field=$value $filter $order";
        if (is_array($result = Conector::ejecutarQuery($sql, null))){
            if (count($result)==0) {
                foreach ($result[$i] as $item => $val) {
                    $JSON["$item"] = $val;
                    ${$item} = $val;
                }
                $sql = "select id from uso_insumo_proceso where idproceso=$value and proceso=$numeroProceso";
                if (is_array($result = Conector::ejecutarQuery($sql, null))) {
                    if ($result[0][0]!=null) $JSON["usosRegistrados"] = true;
                    else $JSON["usosRegistrados"] = false;
                }
            } else {
                for ($i=0; $i<count($result); $i++) {
                    $data = array();
                    foreach ($result[$i] as $item => $val) {
                        $data["$item"] = $val;
                        ${$item} = $val;
                    }
                    $sql = "select id from uso_insumo_proceso where idproceso={$result[$i]['id']} and proceso=$numeroProceso";
                    if (is_array($result = Conector::ejecutarQuery($sql, null))) {
                        if ($result[0][0]!=null) $data["usosRegistrados"] = true;
                        else $data["usosRegistrados"] = false;
                    }
                    array_push($JSON, $data);
                }
            }
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

}
