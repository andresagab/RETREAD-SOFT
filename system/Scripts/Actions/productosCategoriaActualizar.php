<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 2/10/2018
 * Time: 19:24
 */
header("Access-control-Allow-Origin: *");
header("Access-control-Allow-Methods: GET, POST");
header("Access-control-Allow-Headers: X-Requested-with");
header("Content-type: text/html; charset=utf-8");
require_once dirname(__FILE__) . '/../../Tools/Conector.php';
require_once dirname(__FILE__) . '/../../Clases/Usuario.php';
require_once dirname(__FILE__) . '/../../Clases/Usuario_Persona.php';
require_once dirname(__FILE__) . '/../../Clases/Persona.php';
require_once dirname(__FILE__) . '/../../Clases/Telefono_Persona.php';
require_once dirname(__FILE__) . '/../../Clases/Cargo_Empleado.php';
require_once dirname(__FILE__) . '/../../Clases/Rol.php';
require_once dirname(__FILE__) . '/../../Clases/Empleado.php';
require_once dirname(__FILE__) . '/../../Clases/Categoria_Producto.php';
require_once dirname(__FILE__) . '/../../Clases/Producto.php';
require_once dirname(__FILE__) . '/../../Clases/Carga_Producto.php';
require_once dirname(__FILE__) . '/../../Clases/Puesto_Trabajo.php';
require_once dirname(__FILE__) . '/../../Clases/Insumo_Puesto_Trabajo.php';
require_once dirname(__FILE__) . '/../../Clases/Carga_Producto_Puesto_Trabajo.php';
date_default_timezone_set("America/Bogota");
$response='SD';
foreach ($_GET as $key => $val) ${$key}=$val;
foreach ($_POST as $key => $val) ${$key}=$val;
$postdata= file_get_contents("php://input");
$request= json_decode($postdata);
//print_r($request->producto->idproducto);die();
if (isset($method)){
    switch ($method) {
        case 'addCarga':
            $response='ID';
            if ($request!=null) {
                if (@$request->idEmpleado!=null && @$request->producto!=null && @$request->cantidad!=null && @$request->fechaRegistro!=null) {
                    if ($request->producto->idproducto!=null) {

                        $object=new Carga_Producto(null, null, null, null);
                        $object->setIdEmpleado($request->idEmpleado);
                        $object->setIdProducto($request->producto->idproducto);
                        $object->setCantidad($request->cantidad);
                        $day=substr($request->fechaRegistro, 8, 10);
                        $object->setFechaRegistro(substr($request->fechaRegistro, 0, 8) . ($day-1) . ' ' . date('H:i:s'));
                        if ($object->add(true)) {
                            $response='OK';
                            $nameCategoria=strtolower($object->getProducto()->getCategoria()->getNombre());
                            if ($nameCategoria=='parches' || $nameCategoria=='bandas') {
                                if ($nameCategoria=='parches') $numberProceso=3;
                                else $numberProceso=6;
                                $puestoTrabajo=new Puesto_Trabajo('proceso', $numberProceso, null, null);
                                if ($puestoTrabajo->getId()!=null) {
                                    $insumoPT=new Insumo_Puesto_Trabajo('idInsumo', $object->getIdProducto(), " and idPuestoTrabajo={$puestoTrabajo->getId()} and estado='t'", ' order by cantidad asc limit 1');
                                    if ($insumoPT->getId()!=null) {
                                        $cargaProductoPT= new Carga_Producto_Puesto_Trabajo(null, null, null, null);
                                        $cargaProductoPT->setidInsumoPuestoTrabajo($insumoPT->getId());
                                        $cargaProductoPT->setIdEmpleado($request->idEmpleado);
                                        $cargaProductoPT->setCantidad($request->cantidad);
                                        $cargaProductoPT->setFechaRegistro(date('Y-m-d H:i:s'));
                                        $cargaProductoPT->add(false);
                                    }
                                }
                            }
                        } else $response='SDE';
                    }
                }
            }
            break;
        default:
            $response='SD';
            break;
    }
}
echo $response;