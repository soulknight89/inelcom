<!DOCTYPE html>
<html>
<?php
/**
 * Pagina principal = Login
 */
session_start();
if (!isset($_SESSION['nombre'])) {
    header('location: /inelcom/index.php');
}
$root = $_SERVER['DOCUMENT_ROOT'] . '/inelcom';
include_once("$root/conexion.php");
require("$root/controlador/general.php");
$general = new General($mysqli);
?>
<?= $general->getCss('INELCOM'); ?>
<body>
<div id="wrapper">
    <?= $general->getLeftMenu($_SESSION); ?>
    <div id="page-wrapper" class="gray-bg">
        <?= $general->getTopBar(); ?>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <?= $general->getTitulo('Registro de Oferta', 'Debe llenar todos los datos') ?>
                <div class="col-lg-12">
                    <form id="form_oferta" role="form">
                        <div class="col-md-3">
                            <label>Fecha</label>
                            <input type="text" class="form-control" placeholder="fecha" id="fecha" name="fecha"
                                   value=""/>
                        </div>
                        <div class="col-md-3">
                            <label>Rubro</label>
                            <select class="form-control" id="rubro" name="rubro">
                                <?= $general->getRubroList(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Oferta / Proyecto</label>
                            <input type="text" class="form-control" placeholder="Oferta / Proyecto" id="proyecto"
                                   name="proyecto"
                                   value=""/>
                        </div>
                        <div class="col-md-6">
                            <label>Alcance</label>
                            <input type="text" class="form-control" placeholder="Alcance" id="alcance" name="alcance"
                                   value=""/>
                        </div>
                        <div class="col-md-6">
                            <label>Ofertante Alternativo</label>
                            <input type="text" class="form-control" placeholder="Ofertante Alternativo" value="Ninguno"
                                   id="ofertante_alternativo"
                                   name="ofertante_alternativo"/>
                        </div>
                        <div class="col-md-6">
                            <label>Persona Contacto</label>
                            <input type="text" class="form-control" placeholder="Persona Contacto" id="contacto"
                                   name="contacto"
                                   value=""/>
                        </div>
                        <div class="col-md-4">
                            <label>Cargo Contacto</label>
                            <input type="text" class="form-control" placeholder="Cargo Contacto" value="" id="cargo"
                                   name="cargo"/>
                        </div>
                        <div class="col-md-2">
                            <label>Probabilidad Exito</label>
                            <select id="exito" name="exito" class="form-control">
                                <option value="1" selected>Bajo</option>
                                <option value="2">Medio</option>
                                <option value="3">Alto</option>
                            </select>
                        </div>
                    </form>
                    <div class="col-md-12">
                        <br/>
                        <button id="registrar" name="registrar" class="btn btn-sm btn-primary pull-right">Registrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?= $general->getFooter(); ?>
    </div>
</div>
<?= $general->getScript(); ?>
<script>
    var boton = document.getElementById('registrar');
    boton.onclick = function () {
        var factible = true;
        $('#form_oferta').find('input[type = \'text\']').each(function () {
            if (this.value == '') {
                if (this.name == 'ofertante_alternativo') {
                    this.value = 'Ninguno';
                }
                else {
                    factible = false;
                }
            }
        });
        if (factible == true) {
            $.ajax({
                url:     '/inelcom/router/proyecto',
                type:    'POST',
                data:    $('#form_oferta').serialize() + '&usuario=<?= $_SESSION["idUsuario"]; ?>' + '&funcion=registrar',
                success: function (data) {
                    var datos = JSON.parse(data);
                    if (datos.respuesta == '1') {
                        alert(datos.mensaje);
                        location.reload(true);
                    }
                    else
                        alert('No se pudo registrar la Oferta, por favor verifique los datos');
                },
                error:   function () {
                    console.log('Error');
                }
            });
        }
        else {
            alert('Debe llenar todos los datos!!');
        }
    };

    $(document).ready(function () {
        $('#fecha').daterangepicker({
            format:           'DD-MM-YYYY',
            singleDatePicker: true,
            maxDate:          moment(),
            showDropdowns:    true,
            locale:           {
                firstDay:    1,
                separator:   ' - ',
                format:      'DD/MM/YYYY HH:mm',
                applyLabel:  'OK',
                cancelLabel: 'Cancelar',
                fromLabel:   'De',
                toLabel:     'a',
                daysOfWeek:  ['Dom', 'Lun', 'Mar', 'Mir', 'Jeu', 'Vie', 'Sab'],
                monthNames:  ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
            }
        });
    });
</script>
</body>
</html>