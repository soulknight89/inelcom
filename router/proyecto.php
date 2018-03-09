<?php
/**
 * Created by PhpStorm.
 * User: Edwin
 * Date: 23/02/2018
 * Time: 12:59
 */

$root = $_SERVER['DOCUMENT_ROOT'] . '/inelcom';
include_once("$root/conexion.php");
require("$root/controlador/proyecto.php");

$proyecto = new Proyecto($mysqli);

$funcion = $_POST['funcion'];
$retorna = '';

switch ($funcion) {
    case "registrar":
        $retorna = $proyecto->createProyecto($_POST);
        echo $retorna;
        break;
    case "listar":
        $retorna = $proyecto->listarProyectos($_POST['usuario']);
        echo $retorna;
        break;
    case "detalle":
        $retorna = $proyecto->getDetalleProyecto($_POST['id']);
        echo $retorna;
        break;
    case "guardarStatus":
        $proyecto->actualizarStatus($_POST['id'], $_POST['status']);
        break;
}