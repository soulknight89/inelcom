<!DOCTYPE html>
<?php
if (isset($_SESSION)) {
    session_destroy();
}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INELCOM | Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="gray-bg">
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name">IN</h1>
        </div>
        <h3>Bienvenido</h3>
        <p>Inicio de Sesion</p>
        <form class="m-t" role="form" action="index.html">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Usuario" id="usuario" name="usuario" value=""
                       required="">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Clave" id="clave" name="clave" value=""
                       required="">
            </div>
        </form>
        <button id="ingresar" class="btn btn-primary block full-width m-b">Ingresar</button>
        <a href="#">
            <small>Olvido su clave?</small>
        </a>
        <!--p class="text-muted text-center">
            <small>Do not have an account?</small>
        </p>
        <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a-->
    </div>
</div>
<!-- Mainly scripts -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    var boton = document.getElementById('ingresar');
    boton.onclick = function () {
        var usuario = document.getElementById('usuario').value;
        var clave = document.getElementById('clave').value;
        if (usuario && clave) {
            $.ajax({
                url:     'router/usuario',
                type:    'POST',
                data:    {funcion: 'ingresar', usuario: usuario, clave: clave},
                success: function (msg) {
                    var datos = JSON.parse(msg);
                    var nombre = datos['data']['nombre'];
                    if (datos.data.isArray && (datos.data).length == 0) {
                        alert(datos.mensaje);
                    } else {
                        if (datos.mensaje == 'Bienvenido') {
                            alert(datos.mensaje + ': ' + nombre);
                            var principal = datos.data.perfil;
                            window.location = 'vista/' + principal;
                        } else {
                            alert(datos.mensaje);
                        }
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