<?php
$perfil=new Rol('id', $_GET['id'], null, null);
//$accesos=$perfil->getAccesosEnId();
$accesos= Rol_Accesos::getAccesosEnId($perfil->getId());
//print_r($accesos);
$lista='';
    $menus=Opcion::getListaEnObjetos("idMenu is null and ruta is null", null);
    for ($j = 0; $j < count($menus); $j++) {
        $menu=$menus[$j];
        $lista.="<div class='panel panel-info'>";
            $lista.="<div class='panel-heading' title='{$menu->getDescripcion()}' ><strong>Menu: </strong>{$menu->getNombre()}</div>";
            $lista.="<div class='panel-body'>";
        $opciones=Opcion::getListaEnObjetos("idMenu={$menu->getId()}", null);
        //$lista.='<table border="0">';
        for ($h = 0; $h < count($opciones); $h++) {
            $opcion=$opciones[$h];
            /*
            if ($h%8==0){
                if ($h!=0) $lista.='</tr>';
                $lista.='<tr>';
            }*/
            if (in_array($opcion->getId(), $accesos)) $auxiliar='checked';
            else $auxiliar='';
            $lista.="<div class='form-group'>";
                $lista.="<div class='input-group'>";
                    $lista.="<span class='input-group-addon'>{$opcion->getNombre()}</span>";
                    $lista.="<span class='input-group-addon'><input type='checkbox' name='idOpcion_{$opcion->getId()}' $auxiliar></span>";
                $lista.="</div>";
            $lista.="</div>";
            //$lista.="<td><input type='checkbox' name='idOpcion_{$opcion->getId()}' $auxiliar> {$opcion->getNombre()}</td>";
        }
        //$lista.='</tr>';
        //$lista.='</table>';
        $lista.="</div>";
        $lista.="</div>";
    }
    //otras opciones
    //$lista.="<br>Otras opciones";
    $lista.="<div class='panel panel-danger'>";
            $lista.="<div class='panel-heading' title='Opciones del sistema' ><strong>Otras opciones:</strong></div>";
            $lista.="<div class='panel-body'>";
    $opciones=Opcion::getListaEnObjetos("idMenu is null and ruta is not null", null);
    //$lista.='<table border="0">';
    for ($h = 0; $h < count($opciones); $h++) {
        $opcion=$opciones[$h];            
        /*
        if ($h%8==0){
            if ($h!=0) $lista.='</tr>';
            $lista.='<tr>';
        }*/
        if (in_array($opcion->getId(), $accesos)) $auxiliar='checked';
        else $auxiliar='';
        $lista.="<div class='form-group'>";
                $lista.="<div class='input-group'>";
                    $lista.="<span class='input-group-addon'>{$opcion->getNombre()}</span>";
                    $lista.="<span class='input-group-addon'><input type='checkbox' name='idOpcion_{$opcion->getId()}' $auxiliar></span>";
                $lista.="</div>";
            $lista.="</div>";
        //$lista.="<td><input type='checkbox' name='idOpcion_{$opcion->getId()}' $auxiliar> {$opcion->getNombre()}</td>";
    }
    //$lista.='</tr>';
    //$lista.='</table>';
        $lista.='</div>';
    $lista.='</div>';
?>
<div class="col-md-12">
    <div class="col-md-12" id="paddinTop30"></div>
    <div class="col-md-4" ></div>
    <div class="col-md-4" >
        <strong class="text text-success control-label"><h3>ACCESOS DEL ROL <?=strtoupper($perfil->getNombre())?></h3></strong>
    </div>
    <div class="col-md-4" ></div>
    <div class="row col-md-12" id="paddinTop20"></div>
    <div class="col-md-12">
        <form class="horizontal" name="formulario" method="post" action="principal.php?CON=system/Pages/rolesActualizar.php">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <?=$lista?>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-12">
                <input type="hidden" name="idRol" value="<?=$perfil->getId()?>">
                <button class="btn btn-warning" id="btnRegresar">Regresar</button>
                <input class="btn btn-info" type="submit" name="accion" value="Actualizar accesos">
            </div>
        </form>
    </div>
</div>
<script>
    $("#btnRegresar").click(function (){
        window.location="principal.php?CON=system/Pages/roles.php";
    });
</script>