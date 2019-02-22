<?php
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Cliente.php';
require_once dirname(__FILE__).'/../Clases/Puc.php';
require_once dirname(__FILE__).'/../Clases/Tercero.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
/*
if (isset($nit)) {
    if ($nit=='' || $nit==null) $nit=$identificacion;
}*/
if (isset($identificacion)) $nit=$identificacion;
switch ($accion){
    case 'Adicionar':
        /*if (isset($fechaNacimiento)){if (strpos($fechaNacimiento, "201")!=null){
                if ($fechaNacimiento!=null){
                    $fechaNa= explode("/", $fechaNacimiento);
                    $fechaNacimiento="$fechaNa[2]-$fechaNa[0]-$fechaNa[1]";
                } else $fechaNacimiento= date ("Y-m-d");
            }
        } else $fechaNacimiento= date ("Y-m-d");*/
        $persona=new Persona(null, null, null, null);
        $persona->setIdentificacion($identificacion);
        $persona->setNombres($nombres);
        $persona->setApellidos($apellidos);
        $persona->setCelular($celular);
        $persona->setEmail($email);
        $persona->setDireccion($direccion);
        $persona->setFechaNacimiento($fechaNacimiento);
        $persona->setFechaRegistro(date("Y-m-d H:i:s"));
        $persona->grabar();
        
        $objeto=new Cliente(null, null, null, null);
        $objeto->setIdentificacion($identificacion);
        $objeto->setNit($nit);
        $objeto->setRazonSocial($razonSocial);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        
        $puc=new Puc(null, null, null, null);
        $puc->setCodigo($identificacion);
        $puc->setNombre($razonSocial);
        $puc->setDescripcion('');
        $puc->setFechaRegistro(date("Y-m-d H:i:s"));
        $puc->setNivel('null');
        $puc->grabar();
        
        $tercero=new Tercero(null, null, null, null);
        $tercero->setCodPuc($puc->getCodigo());
        $cliente=new Cliente('identificacion', "'{$objeto->getIdentificacion()}'", null, null);
        $tercero->setIdCliente($cliente->getId());
        $tercero->setFechaRegistro(date("Y-m-d H:i:s"));
        $tercero->grabar();
        
        break;
    
    case 'Modificar':
        /*if (isset($fechaNacimiento)){if (strpos($fechaNacimiento, "201")!=null){
                if ($fechaNacimiento!=null){
                    $fechaNa= explode("/", $fechaNacimiento);
                    $fechaNacimiento="$fechaNa[2]-$fechaNa[0]-$fechaNa[1]";
                } else $fechaNacimiento= date ("Y-m-d");
            }
        } else $fechaNacimiento= date ("Y-m-d");*/
        $persona=new Persona("identificacion", "'$identificacionAnterior'", null, null);
        $persona->setIdentificacion($identificacion);
        $persona->setNombres($nombres);
        $persona->setApellidos($apellidos);
        $persona->setCelular($celular);
        $persona->setEmail($email);
        $persona->setDireccion($direccion);
        $persona->setFechaNacimiento($fechaNacimiento);
        $persona->modificar($identificacionAnterior);
        
        $objeto=new Cliente('id', $id, null, null);
        $objeto->setIdentificacion($identificacion);
        $objeto->setNit($nit);
        $objeto->setRazonSocial($razonSocial);
        $objeto->modificar();
        
        $puc=new Puc('codigo', "'$identificacionAnterior'", null, null);
        $puc->setCodigo($identificacion);
        $puc->setNombre($razonSocial);
        $puc->setDescripcion('');
        $puc->setNivel('null');
        $puc->modificar();
        
        break;
    case 'Eliminar':
        $objeto=new Cliente('id', $id, null, null);
        $tercero=new Tercero('idCliente', $objeto->getId(), null, null);
        $puc=$tercero->getPuc();
        $tercero->eliminar();
        $puc->eliminar();
        $persona=$objeto->getPersona();
        $objeto->eliminar();
        $persona->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/clientes.php");