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
                <?= $general->getTitulo('Ofertas Registradas', '') ?>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table id="proyectos" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Fecha</th>
                                <th>Mes Oferta</th>
                                <th>Rubro</th>
                                <th>Oferta / Proyecto</th>
                                <th>Version</th>
                                <th>Status</th>
                                <th>Dia Act.</th>
                                <th>Mes Act.</th>
                                <th>Seguimiento</th>
                                <th>Alcance</th>
                                <th>Ofertante Alternativo</th>
                                <th>Contacto TDP</th>
                                <th>Cargo</th>
                                <th>Probabilidad de Exito</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!-- Empieza el Modal -->
        <div class="modal inmodal" id="modalSeguimiento" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                                    class="sr-only">Close</span></button>
                        <!--i class="fa fa-laptop modal-icon"></i-->
                        <h4 class="modal-title" id="tituloCodigo"></h4>
                        <small class="font-bold" id="tituloProyecto"></small>
                    </div>
                    <div class="modal-body">
                        <p id="cuerpoAlcance"></p>
                        <div class="form-group">
                            <label>Status</label>
                            <select id="status" class="form-control">
                                <?= $general->getStatusList(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="guardarDatos();">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin del Modal -->
        <?= $general->getFooter(); ?>
    </div>
</div>
<?= $general->getScript(); ?>
<script>

    function loadOfertas () {
        oTabla = $('#proyectos').DataTable({
            'ajax':     {
                'url':  '/inelcom/router/proyecto',
                'type': 'POST',
                'data': function (d) {
                    d.funcion = 'listar';
                    d.usuario = '<?= $_SESSION['idUsuario'];?>';
                }
            },
            pageLength: 25,
            responsive: true,
            dom:        '<"html5buttons"B>lTfgitp',
            buttons:    [
                {
                    extend:    'excel',
                    filename:  'Reporte INELCOM',
                    sheetName: 'Ofertas',
                    text:      'EXCEL'
                },
                {extend: 'pdf', title: 'Reporte INELCOM', text: 'PDF'},
                {
                    extend:    'print',
                    text:      'Imprimir',
                    customize: function (win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ]
        });
    };

    function reloadData() {
        $('#proyectos').DataTable().ajax.reload();
    };

    var temporal = '';

    $(document).ready(function () {
        loadOfertas();

        $('#modalSeguimiento').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            temporal = button.data('id');
            var modal = $(this);
            leerDatos(temporal);
        });
    });

    function leerDatos (temporal) {
        var form_data = new FormData;
        form_data.append('id', temporal);
        form_data.append('funcion', 'detalle');
        $.ajax({
            url:         '/inelcom/router/proyecto',
            type:        'POST',
            cache:       false,
            contentType: false,
            processData: false,
            data:        form_data,
            success:     function (data) {
                var datos = JSON.parse(data);
                $('#tituloCodigo').html(datos.codigo);
                $('#tituloProyecto').html(datos.proyecto);
                $('#cuerpoAlcance').html(datos.alcance);
                $('#status').val(datos.status);
            },
            error:       function () {
                console.log('Error');
            }
        });
    }

    function guardarDatos () {
        var form_data = new FormData;
        form_data.append('id', temporal);
        form_data.append('status', $('#status').val());
        form_data.append('funcion', 'guardarStatus');
        $.ajax({
            url:         '/inelcom/router/proyecto',
            type:        'POST',
            cache:       false,
            contentType: false,
            processData: false,
            data:        form_data,
            success:     function (data) {
                alert('Status actualizado');
                reloadData();
                $('#modalSeguimiento').modal('hide');
            },
            error:       function () {
                console.log('Error');
            }
        });
    }
</script>
</body>
</html>
