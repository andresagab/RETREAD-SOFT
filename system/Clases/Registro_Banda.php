<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 22/04/2018
 * Time: 19:19
 */

class Registro_Banda{

    private $id;
    private $idPreparacion;
    private $idPuestoTrabajo;
    private $estado;
    private $idGravado;
    private $anchoBanda;
    private $largoBanda;
    private $empates;
    private $observaciones;
    private $fechaRegistro;

    /**
     * Registro_Banda constructor.
     */
    public function __construct($field, $value, $filter, $order){
        $P='';
        $BD='';
        if ($field!=null){
            if (is_array($field)){
                foreach ($field as $key => $val) $this->$key=$val;
                $this->loadAtributtes($field);
            } else {
                if ($value!=null) {
                    $sql="select id, idpreparacion, idpuestotrabajo, estado, idgravado, anchobanda, largobanda, empates, observaciones, fecharegistro from registro_banda where $field=$value $filter $order";
                    $result=Conector::ejecutarQuery($sql, null);
                    if (count($result)>0){
                        foreach ($result[0] as $key => $val) $this->$key=$val;
                        $this->loadAtributtes($result[0]);
                    }
                } else return null;
            }
        } else return null;
    }

    private function loadAtributtes($data){
        $this->idPreparacion=$data['idpreparacion'];
        $this->idPuestoTrabajo=$data['idpuestotrabajo'];
        $this->idGravado=$data['idgravado'];
        $this->anchoBanda=$data['anchobanda'];
        $this->largoBanda=$data['largobanda'];
        $this->fechaRegistro=$data['fecharegistro'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getIdPuestoTrabajo()
    {
        return $this->idPuestoTrabajo;
    }

    /**
     * @param mixed $idPuestoTrabajo
     */
    public function setIdPuestoTrabajo($idPuestoTrabajo)
    {
        $this->idPuestoTrabajo = $idPuestoTrabajo;
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
    public function getIdGravado()
    {
        return $this->idGravado;
    }

    /**
     * @param mixed $idGravado
     */
    public function setIdGravado($idGravado)
    {
        $this->idGravado = $idGravado;
    }

    /**
     * @return mixed
     */
    public function getAnchoBanda()
    {
        return $this->anchoBanda;
    }

    /**
     * @param mixed $anchoBanda
     */
    public function setAnchoBanda($anchoBanda)
    {
        $this->anchoBanda = $anchoBanda;
    }

    /**
     * @return mixed
     */
    public function getLargoBanda()
    {
        return $this->largoBanda;
    }

    /**
     * @param mixed $largoBanda
     */
    public function setLargoBanda($largoBanda)
    {
        $this->largoBanda = $largoBanda;
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

    /**
     * @return mixed
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param mixed $observaciones
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    /**
     * @return mixed
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * @param mixed $fechaRegistro
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function getNombreEstado(){
        if ($this->estado) return 'Corte registrado';
        else return 'Corte sin registrar';
    }

    public function getPreparacion(){
        if ($this->idPreparacion!=null) return new Preparacion('id', $this->idPreparacion, null, null);
        else return new Preparacion(null, null, null, null);
    }

    public function getPuestoTrabajo(){
        if ($this->idPuestoTrabajo!=null) return new Puesto_Trabajo('id', $this->idPuestoTrabajo, null, null);
        else return new Puesto_Trabajo(null, null, null, null);
    }

    public function getGravado(){
        if ($this->idGravado!=null) return new Gravado_Llanta('id', $this->idGravado, null, null);
        else return new Gravado_Llanta(null, null, null, null);
    }

    public function add(){
        $sql="insert into registro_banda (idpreparacion, idpuestotrabajo, estado, idgravado, anchobanda, largobanda, empates, observaciones, fecharegistro) values ($this->idPreparacion, $this->idPuestoTrabajo, '$this->estado', $this->idGravado, $this->anchoBanda, $this->largoBanda, $this->empates, '$this->observaciones', '$this->fechaRegistro')";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r=!null) return true;
        else return false;
    }

    public function update(){
        $sql="update registro_banda set idpreparacion=$this->idpreparacion, idpuestotrabajo=$this->idPuestoTrabajo, estado='$this->estado', idgravado=$this->idGravado, anchobanda=$this->anchoBanda, largobanda=$this->largoBanda, empates=$this->empates, observaciones='$this->observaciones' where id=$this->id";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r=!null) return true;
        else return false;
    }

    public function delete(){
        $sql="delete from registro_banda where id=$this->id";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r=!null) return true;
        else return false;
    }

    public static function getList($filter, $order){
        if ($filter!=null) $filter="where $filter";
        $sql="select id, idpreparacion, idpuestotrabajo, estado, idgravado, anchobanda, largobanda, empates, observaciones, fecharegistro from registro_banda $filter $order";
        return Conector::ejecutarQuery($sql, null);
    }

    public static function getListObjects($filter, $order){
        $data=Registro_Banda::getList($filter, $order);
        $objects=array();
        for ($i=0; $i<count($data); $i++){
            $objects[$i]=new Registro_Banda($data[$i], null, null, null);
        }
        return $objects;
    }

    public static function getDataJSON($type, $field, $value, $filter, $order, $sql, $extra){
        $JSON=array();
        switch ($type){
            case 0:
                if ($value!=null) $object=new Registro_Banda($field, $value, $filter, $order);
                else $object=new Registro_Banda(null, null, null, null);
                foreach ($object as $key => $val) $JSON["$key"]=$val;
                if ($extra){
                    $JSON["preparacion"]=json_decode(Preparacion::getObjetoJSON('id', "{$object->getIdPreparacion()}", null, null));
                    $JSON["puestoTrabajo"]=json_decode(Puesto_Trabajo::getObjetoJSON('id', "{$object->getIdPuestoTrabajo()}", null, null));
                    $JSON["gravado"]=json_decode(Gravado_Llanta::getObjetoJSON('id', "{$object->getIdGravado()}", null, null));
                    $JSON["nombreEstado"]=$object->getNombreEstado();
                    $JSON["colorEstado"]=$object->getColorEstado();
                    $JSON["nombreEmpates"]=$object->getEmpates();
                }
                break;
            case 1:
                $data=Registro_Banda::getListObjects($filter, $order);
                for ($i=0; $i<count($data); $i++){
                    $object=$data[$i];
                    $array=array();
                    foreach ($object as $key => $val) $array["$key"]=$val;
                    if ($extra){
                        $array["preparacion"]=json_decode(Preparacion::getObjetoJSON('id', "{$object->getIdPreparacion()}", null, null));
                        $array["puestoTrabajo"]=json_decode(Puesto_Trabajo::getObjetoJSON('id', "{$object->getIdPuestoTrabajo()}", null, null));
                        $array["gravado"]=json_decode(Gravado_Llanta::getObjetoJSON('id', "{$object->getIdGravado()}", null, null));
                        $array["nombreEstado"]=$object->getNombreEstado();
                        $array["colorEstado"]=$object->getColorEstado();
                        $array["nombreEmpates"]=$object->getEmpates();
                    }
                    array_push($JSON, $array);
                }
                break;
            case 2:
                if ($sql!=null) $r=Conector::ejecutarQuery($sql, null);
                else $r=array();
                for ($i=0; $i<count($r); $i++){
                    $array=array();
                    foreach ($r[$i] as $key => $val) $array["$key"]=$val;
                    array_push($JSON, $array);
                }
                break;
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public function getColorEstado(){
        $color='';
        if ($this->id!=null) {
            if ($this->estado){
                if ($this->empates!=null && $this->idPuestoTrabajo!=null) $color='#a4e489';
                else $color="#e47870";
            } else $color='#e47870';
        }
        return $color;
    }

}