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
 * Descripcion de la clase Puesto_Trabajo:
 *
 * Define las propiedades id, nombre, proceso, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Puesto_Trabajo {
    //Propiedades
    private $id;
    private $nombre;
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
                $sql="select id, nombre, proceso, fechaRegistro from {$P}puesto_trabajo where $campo=$valor $filtro $orden";
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
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getProceso() {
        return $this->proceso;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
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
    
    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setProceso($proceso) {
        $this->proceso = $proceso;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    function getNumberNovedades($type) {
        $number=0;
        if ($type=='all') $filter='';
        else if ($type=='ok') $filter="and status='t'";
        else $filter="and status='f'";
        if ($this->id!=null) {
            $sql="select count(id) as cantidad from novedad_puesto_trabajo where idPuestoTrabajo=$this->id $filter";
            $number=Conector::ejecutarQuery($sql, null)[0]['cantidad'];
        }
        return $number;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}puesto_trabajo (nombre, proceso, fechaRegistro) values ('$this->nombre', $this->proceso, '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}puesto_trabajo set nombre='$this->nombre', proceso=$this->proceso where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}puesto_trabajo where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, nombre, proceso, fechaRegistro from {$P}puesto_trabajo $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Puesto_Trabajo::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Puesto_Trabajo($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Puesto_Trabajo::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getNombre()) ."</option>";
        }
        return $options;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Puesto_Trabajo($campo, $valor, $filtro, $orden);
        else $objeto=new Puesto_Trabajo(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['nombre']= rtrim($objeto->getNombre());
        $arreglo['proceso']=$objeto->getProceso();
        $arreglo['nombreProceso']= rtrim($objeto->getNombreProceso());
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['numberNovedades']=$objeto->getNumberNovedades('all');
        $arreglo['numberNovedadesRevisadas']=$objeto->getNumberNovedades('ok');
        $arreglo['numberNovedadesNoRevisadas']=$objeto->getNumberNovedades('notOk');
        $arreglo['statusDelete']=getStatusDelete($objeto->getId(), ['raspado', 'preparacion', 'reparacion', 'cementado', 'relleno', 'corte_banda', 'embandado', 'vulcanizado', 'inspeccion_final'], 'idpuestotrabajo');
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Puesto_Trabajo::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['nombre']= rtrim($objeto->getNombre());
            $arreglo['proceso']=$objeto->getProceso();
            $arreglo['nombreProceso']= rtrim($objeto->getNombreProceso());
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['numberNovedades']=$objeto->getNumberNovedades('all');
            $arreglo['numberNovedadesRevisadas']=$objeto->getNumberNovedades('ok');
            $arreglo['numberNovedadesNoRevisadas']=$objeto->getNumberNovedades('notOk');
            $arreglo['statusDelete']=getStatusDelete($objeto->getId(), ['raspado', 'preparacion', 'reparacion', 'cementado', 'relleno', 'corte_banda', 'embandado', 'vulcanizado', 'inspeccion_final'], 'idpuestotrabajo');
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getProcesosEnArray() {
        $arreglo=array();
        $array=array();
        for ($i = 0; $i < 12; $i++) {
            $objeto=new Puesto_Trabajo(null, null, null, null);
            $objeto->setProceso($i);
            $array['id']=$i;
            $array['proceso']=$objeto->getNombreProceso();
            array_push($arreglo, $array);
        }
        return $arreglo;
    }
    
    public static function getProcesoEnOptions($deefault) {
        $options='';
        $datos= Puesto_Trabajo::getProcesosEnArray();
        for ($i = 0; $i < count($datos); $i++) {
            $dato=$datos[$i];
            if ($deefault==$dato['id']) $selected='selected';
            else $selected='';
            $options.="<option value='{$dato['id']}' $selected>{$dato['proceso']}</option>";
        }
        return $options;
    }

    public static function getInsumosPtJSON($id) {
        $JSON=array();
        /*
        if ($id!=null) {
            $sql="select ipt.id as idInsumoPT, ipt.cantidad as cantidad, ipt.estado as estado,
                   p.nombre as nombreProducto
            from insumo_puestotrabajo as ipt, producto as pr, puc as p
            where ipt.idpuestotrabajo=$id
            and pr.id=ipt.idinsumo
            and p.codigo=pr.codpuc
            and ipt.id not in (select idInsumoPt from insumo_terminacion);";
            //echo $sql;
            $r=Conector::ejecutarQuery($sql, null);
            for ($i=0; $i<count($r); $i++) {
                $data=array();
                foreach ($r[$i] as $key => $val) {
                    $data["$key"]=$val;
                    ${$key}=$val;
                }
                $insumoPT=new Insumo_Puesto_Trabajo(null, null, null, null);
                @$insumoPT->setId($idinsumopt);
                @$insumoPT->setCantidad($cantidad);
                @$insumoPT->setEstado($estado);
                $data['remainingStock']=$insumoPT->getRemainingStock();
                array_push($JSON, $data);
            }
        }*/
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    /*LINE INSERT SINCE 2019-02-28 11:09*/
    public static function getDataJSON($type, $field, $value, $filter, $order, $sql, $extras) {
        $JSON = array();
        switch ($type) {
            case 0:
                if ($field!=null && $value!=null) {
                    foreach ($object = new Puesto_Trabajo($field, $value, $filter, $order) as $item => $val) {
                        $JSON["$item"] = $val;
                        ${$item} = $val;
                    }
                    $data['nombreProceso'] = $object->getNombreProceso();
                    if ($extras) {
                        $JSON['numberNovedades']=$object->getNumberNovedades('all');
                        $JSON['numberNovedadesRevisadas']=$object->getNumberNovedades('ok');
                        $JSON['numberNovedadesNoRevisadas']=$object->getNumberNovedades('notOk');
                        $JSON['statusDelete']=getStatusDelete($object->getId(), ['raspado', 'preparacion', 'reparacion', 'cementado', 'relleno', 'corte_banda', 'embandado', 'vulcanizado', 'inspeccion_final'], 'idpuestotrabajo');
                    }
                }
                break;
            case 1:
                $objects = Puesto_Trabajo::getListaEnObjetos($filter, $order);
                for ($i=0; $i<count($objects); $i++) {
                    $data = array();
                    $object = $objects[$i];
                    foreach ($objects[$i] as $item => $val) {
                        $data["$item"] = $val;
                        ${$item} = $val;
                    }
                    $data['nombreProceso'] = $object->getNombreProceso();
                    if ($extras) {
                        $data['numberNovedades']=$object->getNumberNovedades('all');
                        $data['numberNovedadesRevisadas']=$object->getNumberNovedades('ok');
                        $data['numberNovedadesNoRevisadas']=$object->getNumberNovedades('notOk');
                        $data['statusDelete']=getStatusDelete($object->getId(), ['raspado', 'preparacion', 'reparacion', 'cementado', 'relleno', 'corte_banda', 'embandado', 'vulcanizado', 'inspeccion_final'], 'idpuestotrabajo');
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
                        $object = new Puesto_Trabajo(null, null, null, null);
                        $object->setId(@$id);
                        $object->setProceso(@$proceso);
                        $data['nombreProceso'] = $object->getNombreProceso();
                        if ($extras) {
                            $data['numberNovedades']=$object->getNumberNovedades('all');
                            $data['numberNovedadesRevisadas']=$object->getNumberNovedades('ok');
                            $data['numberNovedadesNoRevisadas']=$object->getNumberNovedades('notOk');
                            $data['statusDelete']=getStatusDelete($object->getId(), ['raspado', 'preparacion', 'reparacion', 'cementado', 'relleno', 'corte_banda', 'embandado', 'vulcanizado', 'inspeccion_final'], 'idpuestotrabajo');
                        }
                        array_push($JSON, $data);
                    }
                }
                break;
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    /*ENDLINE INSERT SINCE 2019-02-28 11:09*/

}
