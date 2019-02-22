<?php
require_once dirname(__FILE__).'/../Clases/Rol.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
if(isset($estado)) $estado='t';
else $estado='f';
$redireccion=false;
switch ($accion){
    case 'Adicionar':
        $objeto=new Rol(null, null, null, null);
        $objeto->setNombre($nombre);
        $objeto->setEstado($estado);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    case 'Modificar':
        $objeto=new Rol('id', $id, null, null);
        $objeto->setNombre($nombre);
        $objeto->setEstado($estado);
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Rol('id', $id, null, null);
        $objeto->eliminar();
        break;
    case 'Actualizar accesos':
        $perfil=new Rol('id', $idRol, null, null);
        $opciones=array();
        foreach ($_POST as $Variable => $Valor){
            if (substr($Variable,0,8)=='idOpcion') $opciones[]= substr ($Variable, 9);
        }
        //print_r($opciones);die();
        $perfil->actualizarAccesos($opciones);
        $redireccion=true;
        break;
}
if($redireccion) header("Location: principal.php?CON=system/Pages/rolesAccesos.php&id=$idRol");
else header("Location: principal.php?CON=system/Pages/roles.php");
