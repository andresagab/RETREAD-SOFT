<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 13/06/2018
 * Time: 15:05
 */

class Bitacora {

    private $id;
    private $sesion;
    private $usuario;
    private $suceso;
    private $ip;
    private $detalles;
    private $registroAnterior;
    private $fechaRegistro;

    /**
     * Bitacora constructor.
     */
    public function __construct($field, $value, $filter, $order) {
        if ($field!=null){
            if (is_array($field)){
                foreach ($field as $key => $val) $this->$key=$val;
                $this->setFieldsPSQL($field);
            } else {
                $sql="select id, sesion, usuario, suceso, ip, detalles, registroAnterior, fechaRegistro from bitacora where $field=$value $filter $order";
                $res=Conector::ejecutarQuery($sql, null);
                if (count($res)>0){
                    foreach ($res[0] as $key => $val) $this->$key=$val;
                    $this->setFieldsPSQL($res[0]);
                }
            }
        }
    }

    private function setFieldsPSQL($data){
        $this->registroAnterior=$data['registroanterior'];
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
    public function getSesion()
    {
        return $this->sesion;
    }

    /**
     * @param mixed $sesion
     */
    public function setSesion($sesion)
    {
        $this->sesion = $sesion;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getSuceso()
    {
        return $this->suceso;
    }

    /**
     * @param mixed $suceso
     */
    public function setSuceso($suceso)
    {
        $this->suceso = $suceso;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getDetalles()
    {
        return $this->detalles;
    }

    /**
     * @param mixed $detalles
     */
    public function setDetalles($detalles)
    {
        $this->detalles = $detalles;
    }

    /**
     * @return mixed
     */
    public function getRegistroAnterior()
    {
        return $this->registroAnterior;
    }

    /**
     * @param mixed $registroAnterior
     */
    public function setRegistroAnterior($registroAnterior)
    {
        $this->registroAnterior = $registroAnterior;
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

    /**
     * return definition of suceso
     */
    public function getNameSuceso()
    {
        switch (strtoupper($this->suceso)){
            case 'I':
                return 'Ingreso exitoso al sistema';
                break;
            case 'F':
                return 'Ingreso fallido al sistema';
                break;
            case 'S':
                return 'Salida del sistema';
                break;
            case 'A':
                return 'Adicion de informacion';
                break;
            case 'M':
                return 'Modificacion de informacion';
                break;
            case 'E':
                return 'Eliminacion de informacion';
                break;
            default:
                return 'Desconocido';
                break;
        }
    }

    private function add(){
        $sql="insert into bitacora (sesion, usuario, suceso, ip, detalles, registroAnterior, fechaRegistro) values ($this->sesion, '$this->usuario', '$this->suceso', '$this->ip', '$this->detalles', '$this->registroAnterior', '$this->fechaRegistro')";
        Conector::ejecutarQueryMultiple($sql, null);
    }

    private function update(){
        $sql="update bitacora set sesion=$this->sesion, usuario='$this->usuario', suceso='$this->suceso', ip='$this->ip', detalles='$this->detalles', registroAnterior='$this->registroAnterior' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    private function delete(){
        $sql="delete from bitacora where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public static function getList($filter, $order){
        if ($filter!=null) $filter="where $filter";
        $sql="select id, sesion, usuario, suceso, ip, detalles, registroAnterior, fechaRegistro from bitacora $filter $order";
        return Conector::ejecutarQuery($sql, null);
    }

    public static function getListObjects($filter, $order){
        $data=Bitacora::getList($filter, $order);
        $objects=array();
        for ($i=0; $i<count($data); $i++) $objects[$i]=new Bitacora($data[$i], null, null, null);
        return $objects;
    }

    public static function getDataJSON($type, $field, $value, $filter, $order, $sql, $extras){
        $JSON=array();
        switch ($type){
            case 0:
                if ($field!=null && $value!=null) {
                    $object=new Bitacora($field, $value, $filter, $order);
                    foreach ($object as $key => $val) $JSON["$key"]=$val;
                }
                break;
            case 1:
                $data=Bitacora::getListObjects($filter, $order);
                for ($i=0; $i<count($data); $i++){
                    $array=array();
                    foreach ($data[$i] as $key => $val) $array["$key"]=$val;
                    if ($extras) {
                        $array['nameSuceso']=$data[$i]->getNameSuceso();
                        $array['btnDetails']=$data[$i]->getDetails();
                    }
                    array_push($JSON, $array);
                }
                break;
            case 2:
                if ($sql!=null) {
                    $res=Conector::ejecutarQuery($sql, null);
                    for ($i=0; $i<count($res); $i++){
                        $array=array();
                        foreach ($res[$i] as $key => $val) $array["$key"]=$val;
                        array_push($JSON, $array);
                    }
                }
                break;
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    private static function getOldData($detail){
        $detail=strtolower($detail);
        $type=substr($detail, 0, strpos($detail, ' '));
        $data=explode(" ", $detail);
        if ($type=='update') {
            $endChar=6;
            $table=$data[1];
        } else {
            $endChar=11;
            $table=$data[2];
        }
        $where= substr($detail, strpos($detail, "where"));
        $sql="select * from $table $where";
        $res=Conector::ejecutarQuery($sql, null);
        $JSON=array();
        for ($i=0; $i<count($res); $i++){
            $tempArray=array();
            foreach ($res[$i] as $key => $val) $tempArray["$key"]=$val;
            array_push($JSON, $tempArray);
        }
        return json_encode($JSON,JSON_UNESCAPED_UNICODE);
    }

    public static function preparedAndExecuteAdd($usuario, $suceso, $detalles){
        $object=new Bitacora(null, null, null, null);
        $object->setSesion('null');
        $object->setUsuario($usuario);
        $object->setSuceso($suceso);
        $object->setIp($_SERVER['REMOTE_ADDR']);
        $object->setDetalles($detalles);
        $object->setFechaRegistro(date("Y-m-d H:i:s"));
        switch (strtolower($suceso)){
            case 'insert': $object->setSuceso('A');break;
            case 'update':
                $object->setSuceso('M');
                $object->setRegistroAnterior(Bitacora::getOldData($detalles));
                break;
            case 'delete':
                $object->setSuceso('E');
                $object->setRegistroAnterior(Bitacora::getOldData($detalles));
                break;
        }
        if ($object->getSuceso()!='I' && $object->getSuceso()!='F'){
            $object->setSesion($_SESSION['sesion']);
            if ($object->getSuceso()!='S') $object->setDetalles(str_replace("'", '|', $detalles));
        }
        //print_r($object);die();
        $object->add();
        if ($suceso=='I') $_SESSION['sesion']=Bitacora::getMaxId();
    }

    private static function getMaxId(){
        $sql="select max(id) as id from bitacora";
        $res=Conector::ejecutarQuery($sql, null);
        if ($res!=null){
            if ($res[0]['id']!=null) return $res[0]['id'];
            else return 1;
        } else return 1;
    }

    private function getDetails(){
        $valid=false;
        if ($this->id!=null){
            if ($this->suceso!='S' && $this->suceso!='I' && $this->suceso!='F') $valid=true;
        }
        return $valid;
    }

}