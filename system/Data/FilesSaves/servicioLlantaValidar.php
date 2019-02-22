<?php
require_once dirname(__FILE__)."/../Clases/Persona.php";
require_once dirname(__FILE__)."/../Clases/Cliente.php";
require_once dirname(__FILE__)."/../Clases/Tipo_Llanta.php";
require_once dirname(__FILE__)."/../Clases/Marca_Llanta.php";
require_once dirname(__FILE__)."/../Clases/Llanta.php";
require_once dirname(__FILE__)."/../Clases/Servicio.php";
if ($USUARIO->getRol()->getNombre()!='auxiliar'){
    if (isset($_GET['idLlanta'])){
        $llanta=new Llanta('id', $_GET['idLlanta'], null, null);
        $servicio=new Servicio('idLlanta', $_GET['idLlanta'], null, 'order by id desc');
        //print_r($servicio);die();
        if ($servicio->getId()!=null) header("Location: principal.php?CON=system/Pages/procesoServicio.php&idServicio={$servicio->getId()}");
        else header("Location: principal.php?CON=system/Pages/serviciosLlantaFormulario.php&idLlanta={$llanta->getId()}");
    } else header("Location: principal.php?CON=system/Pages/llantas");
} else header ("Location: principal.php?CON=system/Pages/accesoDenegado.php");