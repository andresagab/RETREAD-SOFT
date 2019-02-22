<?php
require_once dirname(__FILE__).'/../Clases/Puesto_Trabajo.php';
require_once dirname(__FILE__).'/../Clases/Puc.php';
require_once dirname(__FILE__).'/../Clases/Producto.php';
require_once dirname(__FILE__).'/../Clases/Insumo_Puesto_Trabajo.php';
require_once dirname(__FILE__).'/../Clases/Novedad_Puesto_Trabajo.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
//print_r($_POST);
//echo "<br>";
//print_r($_FILES);
//die();
switch ($accion){
    case 'Eliminar':
        $objeto=new Novedad_Puesto_Trabajo('id', $id, null, null);
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/novedadesPuestoTrabajo.php&idPT=$idPT");
