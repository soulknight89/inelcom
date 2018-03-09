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
                <?= $general->getTitulo('Registro de Usuario', 'Debe llenar todos los datos') ?>
                <div class="col-lg-12">
                    <form id="registro" role="form">
                        Usuario
                        <input type="text" class="form-control" placeholder="Usuario" id="usuario" name="usuario"
                               value=""/>
                        Documento
                        <input type="text" class="form-control" placeholder="Documento" id="documento" name="documento"
                               value=""/>
                        Nombres
                        <input type="text" class="form-control" placeholder="Nombre" id="nombre" name="nombre"
                               value=""/>
                        Apellidos
                        <input type="text" class="form-control" placeholder="Apellidos" id="apellido" name="apellido"
                               value=""/>
                        Correo
                        <input type="email" class="form-control" placeholder="Correo" id="correo" name="correo"
                               value=""/>
                        <label>Perfil</label>
                        <select class="form-control" id="perfil" name="perfil">
                            <?= $general->getPerfilList(); ?>
                        </select>
                    </form>
                    <br/>
                    <button id="registrar" name="registrar" class="btn btn-sm btn-primary">Registrar</button>
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
        $('#registro').find('input[type = \'text\']').each(function () {
            if (this.value == '') {
                factible = false;
            }
        });
        if (factible == true) {
            $.ajax({
                url:     '/inelcom/router/usuario',
                type:    'POST',
                data:    $('#registro').serialize() + '&funcion=registrar',
                success: function (data) {
                    if (data == '1') {
                        alert('Usuario registrado exitosamente');
                        location.reload(true);
                    } else {
                        alert('Usuario o Documento registrado anteriormente');
                    }

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
</script>
</body>
</html>