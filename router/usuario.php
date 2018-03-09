<?php
/**
 * Created by PhpStorm.
 * User: Edwin
 * Date: 23/02/2018
 * Time: 12:59
 */

$root = $_SERVER['DOCUMENT_ROOT'] . '/inelcom';
include_once("$root/conexion.php");
require("$root/controlador/usuario.php");

$usuario = new Usuario($mysqli);

$funcion = $_POST['funcion'];
$retorna = '';

switch ($funcion) {
    case "ingresar":
        $retorna = $usuario->validarUsuario($_POST);
        echo $retorna;
        break;
    case "registrar":
        $retorna = $usuario->registrarUsuario($_POST);
        echo $retorna;
        break;
    case "getInfo":
        $retorna = $usuario->leerUsuario($_POST['id']);
        echo $retorna;
        break;
}