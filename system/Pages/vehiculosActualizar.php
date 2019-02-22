<?php
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Cliente.php';
require_once dirname(__FILE__).'/../Clases/Marca_Vehiculo.php';
require_once dirname(__FILE__).'/../Clases/Dimension_Llanta.php';
require_once dirname(__FILE__).'/../Clases/Vehiculo.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'Adicionar':
        $objeto=new Vehiculo(null, null, null, null);
        $objeto->setIdentificacion($identificacion);
        $objeto->setIdMarcaVehiulo($idMarcaVehiculo);
        $objeto->setPlaca($placa);
        $objeto->setLinea($linea);
        $objeto->setModelo($modelo);
        $objeto->setClase($clase);
        $objeto->setCombustible($combustible);
        $objeto->setNumeroLlantas($numeroLlantas);
        $objeto->setIdDimension($idDimension);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    case 'Modificar':
        $objeto=new Vehiculo('id', $id, null, null);
        $objeto->setIdMarcaVehiulo($idMarcaVehiculo);
        $objeto->setPlaca($placa);
        $objeto->setLinea($linea);
        $objeto->setModelo($modelo);
        $objeto->setClase($clase);
        $objeto->setCombustible($combustible);
        $objeto->setNumeroLlantas($numeroLlantas);
        $objeto->setIdDimension($idDimension);
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Vehiculo('id', $id, null, null);
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/vehiculos.php&id=$idCliente");
