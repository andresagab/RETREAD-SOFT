<?php
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Contacto_Persona.php';
require_once dirname(__FILE__).'/../Clases/Empleado.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'Adicionar':
        $objeto=new Contacto_Persona(null, null, null, null);
        $objeto->setIdentificacionPersona($identificacionPersona);
        $objeto->setNombres($nombres);
        $objeto->setApellidos($apellidos);
        $objeto->setTelefono($telefono);
        $objeto->setCelular($celular);
        $objeto->setDireccion($direccion);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    case 'Modificar':
        $objeto=new Contacto_Persona('id', $id, null, null);
        //$objeto->setIdentificacionPersona($identificacionPersona);
        $objeto->setNombres($nombres);
        $objeto->setApellidos($apellidos);
        $objeto->setTelefono($telefono);
        $objeto->setCelular($celular);
        $objeto->setDireccion($direccion);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Contacto_Persona('id', $id, null, null);
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/contactosPersona.php&id=$idEmpleado&identificacion=$identificacionPersona");
