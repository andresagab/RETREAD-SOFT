<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */

/**
 * Descripcion de la clase Rol:
 *
 * Define las propiedades id, nombre. estado y fecha de registro, las cuales permiten identificar el tipo de rol de usuario que hay en el sistema de
 * informacion. El rol ayudara al sistema de informacion a proteger los diferentes modulos que este contiene.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Rol {
    //Propiedades
    private $id;
    private $nombre;
    private $estado;
    private $fechaRegistro;
    //Fin propiedades

    //Constructor
    function __construct($campo, $valor, $filtro, $orden){
    	$BD='';
    	$P='';
    	if ($campo!=null) {
    		if (is_array($campo)){
    			foreach ($campo as $key => $value) $this->$key=$value;
    			$this->cargarAtributos($campo);
    		} else {
    			$sql="select id, nombre, estado, fechaRegistro from {$P}rol where $campo=$valor $filtro $orden";
    			$resultado=Conector::ejecutarQuery($sql, $BD);
    			if (count($resultado) > 0) {
    				foreach ($resultado[0] as $key => $value) $this->$key=$value;
    				$this->cargarAtributos($resultado[0]);
    			}
    		}
    	} else return null;
    }
    //Fin constructor

    private function cargarAtributos($arreglo){
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getEstado() {
        return $this->estado;
    }
    
    function getNombreEstado() {
        if ($this->estado){
            return 'Activo';
        } else return 'Bloqueado';
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}rol (nombre, estado, fechaRegistro) values ('$this->nombre', '$this->estado', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}rol set nombre='$this->nombre', estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}rol where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, nombre, estado, fechaRegistro from {$P}rol $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Rol::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Rol($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Rol::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            if (strtolower($objeto->getNombre())!='desarrollador') $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getNombre()) ."</option>";
        }
        return $options;
    }
    
    public static function getRolJSON($campo, $valor, $filtro, $orden) {
        $objeto=new Rol($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['nombre']=$objeto->getNombre();
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['estadoNombre']=$objeto->getNombreEstado();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Rol::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['nombre']=$objeto->getNombre();
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['estadoNombre']=$objeto->getNombreEstado();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
       
    public function actualizarAccesos($opciones){
        $BD=null;$P='';        
        $cadenaSQL="delete from {$P}rol_accesos where idRol={$this->id};";
        Conector::ejecutarQuery($cadenaSQL, $BD);
        for ($i = 0; $i < count($opciones); $i++) {
            $cadenaSQL="insert into {$P}rol_accesos (idRol, idOpcion, fechaRegistro) values "
            . "($this->id,{$opciones[$i]}, now());";
            Conector::ejecutarQuery($cadenaSQL, $BD);            
        }        
    }
    
    public function getAccesos() {
        if ($this->id!=null){
            $sql="select o.id, nombre, descripcion, ruta, idmenu, o.fechaRegistro from opcion as o, rol_accesos as ra where o.id=idopcion and idrol=$this->id order by idmenu";
            return Conector::ejecutarQuery($sql, null);
        } else return null;
    }
    
    public function getAccesosEnObjetos() {
        $datos= $this->getAccesos();
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Opcion($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public function getMenu($usuario) {
        $menu='';
        $opciones= $this->getAccesosEnObjetos();
        switch (strtolower($this->nombre)){
            case 'desarrollador':
                /*
                 * Solo para usuario admin -> clave -> 1use-admin-root
                 */
                $menu="<div class='collapse navbar-collapse' id='navegacion'>
                                <ul class='nav navbar-nav text-uppercase'>
                                    <li><a href='principal.php?CON=system/Pages/inicio.php'>Inicio</a></li>
                                    <li><a href='principal.php?CON=system/Pages/empleados.php'>Funcionarios</a></li>
                                    <li><a href='principal.php?CON=system/Pages/bitacoras.php'>Bitacoras</a></li>
                                    <li class='dropdown'>
                                        <a id='liConfiguracion' href='' class='dropdown-toggle' data-toggle='dropdown' role='button'><i class='fa fa-gear'></i></a>
                                        <ul class='dropdown-menu' role='menu'>
                                            <!--<li><a href='principal.php?CON=system/Pages/cargosEmpleado.php'>Cargos de empleado</a></li>
                                            <li class='divider'></li>-->
                                            <li><a href='principal.php?CON=system/Pages/opciones.php'>Opciones</a></li>
                                            <li class='divider'></li>
                                            <li><a href='principal.php?CON=system/Pages/menu.php'>Menus</a></li>
                                            <li class='divider'></li>
                                            <li><a href='principal.php?CON=system/Pages/roles.php'>Roles</a></li>
                                            <li class='divider'></li>
                                        </ul>
                                        <div class='mdl-tooltip' for='liConfiguracion'>Configuracion</div>
                                    </li>
                                    <li id='btnOpcionesUsuarioSesion'>
                                        <a class='text text-warning'><i class='fa fa-user-o'> $usuario</i></a>
                                    </li>
                                </ul>
                            </div>
                            <ul class='mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect' for='btnOpcionesUsuarioSesion'>
                                <a data-toggle='modal' href='/#_frmCambiarClave' id='btnCambiarClave'>
                                    <li class='mdl-menu__item'>
                                        <i class='fa fa-key'></i><span> Cambiar contraseña</span>
                                    </li>
                                </a>
                                <a href='index.php'>
                                    <li class='mdl-menu__item'>
                                        <i class='fa fa-power-off'></i><span> Cerrar sesion</span>
                                    </li>
                                </a>
                            </ul>
                            <div class='mdl-tooltip' for='btnOpcionesUsuarioSesion'>Opciones de cuenta</div>
                    ";
                break;
            default :
                $idMenu=0;
                //$opciones= Rol_Accesos::getListaEnObjetos("idRol={$this->id}", "");
                $menu="<div class='collapse navbar-collapse' id='navegacion'>
                                <ul class='nav navbar-nav text-uppercase'>";
                for ($i = 0; $i < count($opciones); $i++) {
                    $opcion=$opciones[$i];
                    //$opcion=$opciones[$i]->getOpcion();
                    if ($opcion->getIdMenu()!=$idMenu) {
                        if (($opcion->getIdMenu()!=null)){
                            $menuObjetoOpcion=$opcion->getMenu();
                            if ($idMenu!=0) $menu.="</li></ul>\n";
                            //$menu.="<li class='dropdown'><a href='' data-toggle='dropdown' role='button' title='{$opcion->getMenu()->getDescripcion()}'>{$opcion->getMenu()->getNombre()}</a>\n<ul class='dropdown-menu' role='menu'>\n";
                            if ($menuObjetoOpcion->getDescripcion()=="Configuracion")$menu.="<li class='dropdown'><a href='' data-toggle='dropdown' role='button' id='_tit{$opcion->getId()}'><div class='mdl-tooltip' for='_tit{$opcion->getId()}'>{$menuObjetoOpcion->getDescripcion()}</div>{$menuObjetoOpcion->getNombre()} <span><div ng-show='generalElements.notifyInSettings' style='width: 8px; height: 8px; border-radius: 4px; background: #c69500'></div></span></a>\n<ul class='dropdown-menu' role='menu'>\n";
                            else $menu.="<li class='dropdown'><a href='' data-toggle='dropdown' role='button' id='_tit{$opcion->getId()}'><div class='mdl-tooltip' for='_tit{$opcion->getId()}'>{$menuObjetoOpcion->getDescripcion()}</div>{$menuObjetoOpcion->getNombre()}</a>\n<ul class='dropdown-menu' role='menu'>\n";
                        } else $menu.="</li></ul>\n";
                        $idMenu=$opcion->getIdMenu();
                    }
                    if ($opcion->getRuta()=='system/Pages/cortesBandas.php') $menu.="<li ng-controller='badges'><a href='principal.php?CON={$opcion->getRuta()}' title='{$opcion->getDescripcion()}'>{$opcion->getNombre()} <span class='badge'>{{ dataBadges.numeroCortesBanda }}</span></a></li>\n";
                    else if ($opcion->getRuta()==='system/Pages/puestosTrabajo.php') $menu.="<li ng-controller='badgesNovedadesPT'><a href='principal.php?CON={$opcion->getRuta()}' title='{$opcion->getDescripcion()}'>{$opcion->getNombre()} <span class='badge badge-warning'>{{ badgeNPT.number }}</span></a></li>\n";
                    else $menu.="<li><a href='principal.php?CON={$opcion->getRuta()}' title='{$opcion->getDescripcion()}'>{$opcion->getNombre()}</a></li>\n";
                    if (($opcion->getIdMenu()!=null))$menu.="<li class='divider'></li>";
                }
                //$menu.="<li id='btnLiSalir' ><a href='index.php'><span class='fa fa-power-off'></span></a><div class='mdl-tooltip' for='btnLiSalir'>Cerrar sesion</div></li>";
                $menu.="<li id='btnOpcionesUsuarioSesion'><a class='text text-warning'><i class='fa fa-user-o'> $usuario</i></a></li>";
                $menu.="</ul>";
//                $menu.="<div class='navbar-text'>
//                            <a href='#'><span class='glyphicon glyphicon-user text-warning' ></span>&nbsp;&nbsp;<i class='text text-warning'>$usuario</i></a>
//                        </div>";
                $menu.="<ul class='mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect' for='btnOpcionesUsuarioSesion'>
                                <a data-toggle='modal' href='/#_frmCambiarClave' id='btnCambiarClave'>
                                    <li class='mdl-menu__item'>
                                        <i class='fa fa-key'></i><span> Cambiar contraseña</span>
                                    </li>
                                </a>
                                <a href='index.php'>
                                    <li class='mdl-menu__item'>
                                        <i class='fa fa-power-off'></i><span> Cerrar sesion</span>
                                    </li>
                                </a>
                            </ul>
                            <div class='mdl-tooltip' for='btnOpcionesUsuarioSesion'>Opciones de cuenta</div>";
                $menu.="</div>";
                return $menu;
                break;
        }
        return $menu;
    }
}
