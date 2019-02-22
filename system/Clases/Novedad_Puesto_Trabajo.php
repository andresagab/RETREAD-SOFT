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
 * Descripcion de la clase Novedad_Puesto_Trabajo:
 *
 * Define las propiedades id, cantidad, estado, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Novedad_Puesto_Trabajo {
    //Propiedades
    private $id;
    private $idPuestoTrabajo;
    private $idEmpleado;
    private $novedad;
    private $status;
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
                $sql="select id, idPuestoTrabajo, idEmpleado, novedad, status, fechaRegistro from {$P}novedad_puesto_trabajo where $campo=$valor $filtro $orden";
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
    	$this->idPuestoTrabajo=$arreglo['idpuestotrabajo'];
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdPuestoTrabajo() {
        return $this->idPuestoTrabajo;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
    }

    function getNovedad() {
        return $this->novedad;
    }

    /**
     * @return mixed
     */
    public function getStatus() {
        return $this->status;
    }
    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getPuestoTrabajo() {
        if ($this->idPuestoTrabajo!=null) return new Puesto_Trabajo ('id', $this->idPuestoTrabajo, null, null);
        else return new Puesto_Trabajo (null, null, null, null);
    }
    
    function getEmpleado() {
        if ($this->idEmpleado!=null) return new Empleado('id', $this->idEmpleado, null, null);
        else return new Empleado(null, null, null, null);
    }
    
    function setId($id) {
        $this->id = $id;
    }

    function setIdPuestoTrabajo($idPuestoTrabajo) {
        $this->idPuestoTrabajo = $idPuestoTrabajo;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    function setNovedad($novedad) {
        $this->novedad = $novedad;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    function getNameStatus(){
        $value='Desconocido';
        if ($this->status) $value='Revisado';
        else $value='Sin revisar';
        //if ($this->status!='' && $this->status!=null) {
        //}
        return $value;
    }

    function getMinNovedad() {
        if  (count_chars($this->novedad)>50) return substr($this->novedad, 0, 50);
        else return $this->novedad;
    }

    function getColorStatus() {
        if ($this->status) $color='#97e67d';
        else $color='#fbb763';
        return $color;
    }
    
    public function grabar() {
        $P='';
        $sql="insert into {$P}novedad_puesto_trabajo (idPuestoTrabajo, idEmpleado, novedad, status, fechaRegistro) values ($this->idPuestoTrabajo, $this->idEmpleado, '$this->novedad', 'f', '$this->fechaRegistro')";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null) return true;
        else return false;
    }

    public function modificar() {
        $P='';
        $sql="update {$P}novedad_puesto_trabajo set idPuestoTrabajo=$this->idPuestoTrabajo, idEmpleado=$this->idEmpleado, novedad='$this->novedad', status='$this->status' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function revisar(){
        $result=false;
        if ($this->id!=null){
            $P='';
            $sql="update {$P}novedad_puesto_trabajo set status='t' where id=$this->id";
            $r=Conector::ejecutarQuery($sql, null);
            if ($r!=null) $result=true;
        }
        return $result;
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}novedad_puesto_trabajo where id=$this->id";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r=!null) return true;
        else return false;
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idPuestoTrabajo, idEmpleado, novedad, status, fechaRegistro from {$P}novedad_puesto_trabajo $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Novedad_Puesto_Trabajo::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Novedad_Puesto_Trabajo($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Novedad_Puesto_Trabajo::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getNovedad()) ."</option>";
        }
        return $options;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null || $valor!='') $objeto=new Novedad_Puesto_Trabajo($campo, $valor, $filtro, $orden);
        else $objeto=new Novedad_Puesto_Trabajo (null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
        $arreglo['idEmpleado']=$objeto->getIdEmpleado();
        $arreglo['novedad']=$objeto->getNovedad();
        $arreglo['minNovedad']=$objeto->getMinNovedad();
        $arreglo['status']=$objeto->getStatus();
        $arreglo['nameStatus']=$objeto->getNameStatus();
        $arreglo['colorStatus']=$objeto->getColorStatus();
        $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
        $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Novedad_Puesto_Trabajo::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
            $arreglo['idEmpleado']=$objeto->getIdEmpleado();
            $arreglo['novedad']=$objeto->getNovedad();
            $arreglo['minNovedad']=$objeto->getMinNovedad();
            $arreglo['status']=$objeto->getStatus();
            $arreglo['nameStatus']=$objeto->getNameStatus();
            $arreglo['colorStatus']=$objeto->getColorStatus();
            $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
            $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function getNumberNovedades(){
        $sql="select count(id) as total from novedad_puesto_trabajo where status='f'";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null) {
            if ($r[0]['total']!=null) return $r[0]['total'];
            else return 0;
        } else return 0;
    }
    
}
