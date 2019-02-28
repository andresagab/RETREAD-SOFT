<script src="lib/controladores/llantasEditarCorteBanda.js"></script>
<div ng-controller="llantasEditarCorteBanda">
<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 27/02/2019
 * Time: 20:10
 */
if (strtolower($USUARIO->getRol()->getNombre())!='operario' && strtolower($USUARIO->getRol()->getNombre())!='operario cb'){
    require_once dirname(__FILE__) . '/../Clases/Corte_Banda.php';
    if (isset($_GET['id']) && isset($_GET['idCorteBanda'])) {
        $object = new Corte_Banda("id", $_GET['idCorteBanda'], null, null);
        //$llanta = new Llanta("id", $_GET['id'], null, null);
        if ($object->getIdPuestoTrabajo()!=null) {
            ?>
                <input type="hidden" name="idLlanta" value="<?= $_GET['id'] ?>">
                <input type="hidden" name="idCorteBanda" value="<?= $_GET['idCorteBanda'] ?>">
                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                    <h3 class="text-uppercase mdl-color-text--blue">EDITAR CORTE DE BANDA</h3>
                    <span class="text text-uppercase text-nowrap">RP: {{ html.data.llanta.rp }}</span>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="paddinTop20" ng-show="html.components.loadSpinner">
                    <div class="mdl-spinner mdl-js-spinner is-active"></div>
                </div>
                <!--FORM-->
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <form name="frmCorteBanda" ng-submit="">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Puesto de trabajo</span>
                                <select name="idPuestoTrabajo">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <!--END FORM-->
            </div>
            <?php
        } else {
            ?>
                <input type="hidden" name="idLlanta" value="<?= $_GET['id'] ?>">
                <input type="hidden" name="idCorteBanda" value="<?= $_GET['idCorteBanda'] ?>">
                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="paddinTop20" ng-show="html.components.loadSpinner">
                        <div class="mdl-spinner mdl-js-spinner is-active"></div>
                    </div>
                    <div class="alert alert-warning">
                        <h3 class="text-uppercase">AÚN NO SE HA REGISTRADO EL CORTE DE BANDA, POR LO TANTO NO ES POSIBLE EDITAR DICHOS DATOS, INTENTALO MAS TARDE</h3>
                    </div>
                    <button class="btn btn-primary" type="button" ng-click="prevPage();">Regresar</button>
                </div>
            </div>
            <?php
        }
    } else header("Location: principal.php?CON=system/pages/unknowData.php");
} else header("Location: principal.php?CON=system/pages/accesoDenegado.php");
?>
