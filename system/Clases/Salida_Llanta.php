<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 21/04/2018
 * Time: 20:26
 */

class Salida_Llanta {

    private $id;
    private $idLlanta;
    private $valor;
    private $fechaRegistro;

    /**
     * Salida_Llanta constructor.
     */
    public function __construct($field, $value, $filter, $order) {
        $P='';
        $BD='';
        if ($field!=null){
            if (is_array($field)){
                foreach ($field as $key => $val) $this->$key=$val;
                $this->loadAtributtes($field);
            } else {
                if ($value!=null){
                    $sql="select id, idllanta, valor, fechaRegistro from salida_llanta where $field=$value $filter $order";
                    $result=Conector::ejecutarQuery($sql, $BD);
                    if (count($result)>0){
                        foreach ($result[0] as $key => $val) $this->$key=$val;
                        $this->loadAtributtes($result[0]);
                    }
                } else return null;
            }
        } else return null;
    }

    private function loadAtributtes($data){
        $this->idLlanta=$data['idllanta'];
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
    public function getIdLlanta()
    {
        return $this->idLlanta;
    }

    /**
     * @param mixed $idLlanta
     */
    public function setIdLlanta($idLlanta)
    {
        $this->idLlanta = $idLlanta;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        if ($this->valor!=null) return $this->valor;
        else return 'No registrado';
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
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

    public function getStatus() {
        if ($this->id!=null) return 'Registrada';
        else return 'Sin registrar';
    }

    public function getLlanta(){
        if ($this->idLlanta!=null) return new Llanta('id', $this->idLlanta, null, null);
        else return new Llanta(null, null, null, null);
    }

    public function add(){
        $sql="insert into salida_llanta (idllanta, valor, fecharegistro) values ($this->idLlanta, '$this->valor', '$this->fechaRegistro')";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null) return true;
        else return false;
    }

    public function update(){
        $sql="update salida_llanta set idllanta=$this->idLlanta, valor='$this->valor' where id=$this->id";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null) return true;
        else return false;
    }

    public function delete(){
        $sql="delete from salida_llanta where id=$this->id";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null) return true;
        else return false;
    }

    public static function getList($filter, $order){
        if ($filter!=null) $filter="where $filter";
        $sql="select id, idllanta, valor, fechaRegistro from salida_llanta $filter $order";
        return Conector::ejecutarQuery($sql, null);
    }

    public static function getListObjects($filter, $order){
        $data=Salida_Llanta::getList($filter, $order);
        $objects=array();
        for ($i=0; $i<count($data); $i++) $objects[$i]=new Salida_Llanta($data[$i], null, null, null);
        return $objects;
    }

    public static function getDataJSON($type, $field, $value, $filter, $order, $sql){
        /*
         * $type=0 => se interpreta que el cliente esta solicitando solo
         * un objeto de esta clase en formato JSON para ello se tienen encuenta
         * todos los parametros.
         *
         * $type=1 => se interpreta que el cliente esta solicitando todos
         * los objetos de esta clase en formato JSON, para ello se tienen encuenta
         * los parametros $filter y $order.
         *
         * $type=2 => se interprete que el cliente esta solicitando todos los datos y valores de una cadena sql en
         * formato JSON
         */
        $JSON=array();
        switch ($type){
            case 0:
                if ($value!=null) $object=new Salida_Llanta($field, $value, $filter, $order);
                else $object=new Salida_Llanta(null, null, $filter, $order);
                $JSON=array();
                foreach ($object as $key => $value) $JSON["$key"]=$value;
                break;
            case 1:
                $data= Salida_Llanta::getListObjects($filter, $order);
                for ($i = 0; $i < count($data); $i++) {
                    $object = $data[$i];
                    $array = array();
                    foreach ($object as $key => $value) $array["$key"] = $value;
                    array_push($JSON, $array);
                }
                break;
            case 2:
                //echo $sql;die();
                if ($sql!=null) $r=Conector::ejecutarQuery($sql, null);
                else $r=array();
                for ($i=0; $i<count($r); $i++){
                    $array=array();
                    foreach ($r[$i] as $key => $val) $array["$key"] = $val;
                    array_push($JSON, $array);
                }
                break;
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

}