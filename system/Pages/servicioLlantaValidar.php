<?php
require_once dirname(__FILE__)."/../Clases/Persona.php";
require_once dirname(__FILE__)."/../Clases/Cliente.php";
require_once dirname(__FILE__)."/../Clases/Servicio.php";
require_once dirname(__FILE__)."/../Clases/Llanta.php";
require_once dirname(__FILE__)."/../Clases/Inspeccion_Inicial.php";
if ($USUARIO->getRol()->getNombre()!='auxiliar'){
    if (isset($_GET['id'])){
        $llanta=new Llanta('id', $_GET['id'], null, null);
        if ($llanta->getId()!=null && $llanta->getId()!=''){
            //$inspeccionInicial
            if ($servicio->getId()!=null) header("Location: principal.php?CON=system/Pages/procesoServicio.php&idServicio={$servicio->getId()}");
            else header("Location: principal.php?CON=system/Pages/serviciosLlantaFormulario.php&idLlanta={$llanta->getId()}");
        } else header("Location: principal.php?CON=system/Pages/ordenesServicio.php");
    } else header("Location: principal.php?CON=system/Pages/ordenesServicio.php");
} else header ("Location: principal.php?CON=system/Pages/accesoDenegado.php");