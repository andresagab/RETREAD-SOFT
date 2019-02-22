<?php
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Usuario_Persona.php';
require_once dirname(__FILE__).'/../Clases/Cargo_Empleado.php';
require_once dirname(__FILE__).'/../Clases/Empleado.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'Adicionar':
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
        
        $objeto=new Empleado(null, null, null, null);
        $objeto->setIdentificacion($identificacion);
        $objeto->setIdCargo($idCargo);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        
        $usuario=new Usuario(null, null, null, null);
        $usuario->setUsuario($identificacion);
        $usuario->setClave("usuariopanam");
        $usuario->setIdRol($idCargo);
        $usuario->setEstado('t');
        $usuario->setFechaRegistro(date("Y-m-d H:i:s"));
        $usuario->grabar();
        
        $usuario=new Usuario('usuario', "'$identificacion'", null, null);
        
        $usuarioPersona=new Usuario_Persona(null, null, null, null);
        $usuarioPersona->setIdUsuario($usuario->getId());
        $usuarioPersona->setIdentificacion($identificacion);
        $usuarioPersona->setFechaRegistro(date("Y-m-d H:i:s"));
        $usuarioPersona->grabar();
        break;
    
    case 'Modificar':
        $persona=new Persona("identificacion", "'$identificacionAnterior'", null, null);
        $persona->setIdentificacion($identificacion);
        $persona->setNombres($nombres);
        $persona->setApellidos($apellidos);
        $persona->setCelular($celular);
        $persona->setEmail($email);
        $persona->setDireccion($direccion);
        $persona->setFechaNacimiento($fechaNacimiento);
        $persona->modificar($identificacionAnterior);
        
        $objeto=new Empleado("id", $id, null, null);
        $objeto->setIdentificacion($identificacion);
        $objeto->setIdCargo($idCargo);
        $objeto->modificar();
        
        $usuario=new Usuario('usuario', "'$identificacionAnterior'", null, null);
        $usuario->setUsuario($identificacion);
        $usuario->modificarUsuario();
        
        break;
    case 'Eliminar':
        $objeto=new Empleado('id', $id, null, null);
        $usuarioPersona=new Usuario_Persona('identificacion', "'{$objeto->getIdentificacion()}'", null, null);
        $usuario=$usuarioPersona->getUsuario();
        $usuarioPersona->eliminar();
        $usuario->eliminar();
        $persona=$objeto->getPersona();
        $objeto->eliminar();
        $persona->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/empleados.php");