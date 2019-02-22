<?php
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Cargo_Empleado.php';
require_once dirname(__FILE__).'/../Clases/Empleado.php';
require_once dirname(__FILE__).'/../Clases/Usuario_Persona.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
if(isset($estado)) $estado='t';
else $estado='f';
switch ($accion){
    case 'Adicionar':
        $user=new Usuario(null, null, null, null);
        $user->setUsuario($usuario);
        $user->setClave($clave);
        $user->setEstado($estado);
        $user->setIdRol($idRol);
        $user->setFechaRegistro(date("Y-m-d H:i:s"));
        $user->grabar();
        $usuario=new Usuario('usuario', "'$usuario'", null, null);
        //Asignamos el usuario a la persona
        $objeto=new Usuario_Persona(null, null, null, null);
        $objeto->setIdUsuario($usuario->getId());
        $objeto->setIdentificacion($identificacion);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    
    case 'Modificar':
        $objeto=new Usuario_Persona('id', $id, null, null);
        $user=$objeto->getUsuario();
        $user->setUsuario($usuario);
        $user->setClave($clave);
        $user->setEstado($estado);
        $user->setIdRol($idRol);
        $user->modificar();
        
        break;
    case 'Eliminar':
        $objeto=new Usuario_Persona('id', $id, null, null);
        $user=new Usuario('id', $objeto->getIdUsuario(), null, null);
        $user->eliminar();
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/usuariosPersona.php&identificacion=$identificacion");