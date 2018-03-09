<?php
/**
 * Created by PhpStorm.
 * User: Edwin
 * Date: 20/02/2018
 * Time: 21:00
 */

$root = $_SERVER['DOCUMENT_ROOT'];

include("$root/funciones.php");

class Usuario_modelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function leerUsuario($id)
    {
        $query = $this->db->query(
            "SELECT usu.*, perf.nombre as perfil FROM usuario as usu LEFT JOIN perfil as perf ON  usu.idPerfil = perf.idPerfil WHERE id='$id'"
        );
        $res   = [];
        if (mysqli_num_rows($query) > 0) {
            while ($data = mysqli_fetch_assoc($query)) {
                $res = $data;
            }
        }

        return $res;
    }

    public function validarUsuario($data)
    {
        $usuario  = $this->normalizarDatos($data['usuario']);
        $clave    = $data['clave'];
        $consulta = "SELECT id, clave FROM usuario WHERE usuario='$usuario'";
        $query    = $this->db->query($consulta);
        if (mysqli_num_rows($query) == 1) {
            $rdata     = mysqli_fetch_assoc($query);
            $claveBD   = $rdata['clave'];
            $respuesta = $this->decodePassword(['clave' => $clave, 'hash' => $claveBD]);
            if ($respuesta == 1) {
                $response  = $this->leerUsuario($rdata['id']);
                $responseX = $response;
                session_start();
                $_SESSION['nombre']    = $responseX['nombre'];
                $_SESSION['apellido']  = $responseX['apellido'];
                $_SESSION['perfil']    = $responseX['perfil'];
                $_SESSION['usuario']   = $responseX['usuario'];
                $_SESSION['idUsuario'] = $responseX['id'];
                $_SESSION['correo']    = $responseX['correo'];
                $_SESSION['persona']   = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
                $mensaje               = 'Bienvenido';
            } else {
                $mensaje  = 'Clave Incorrecta';
                $response = [];
            }
        } else {
            $mensaje  = 'Usuario no existe';
            $response = [];
        }

        return json_encode(['mensaje' => $mensaje, 'data' => $response]);
    }

    public function registrarUsuario($data)
    {
        $usuario   = $this->normalizarDatos($data['usuario']);
        $documento = $this->normalizarDatos($data['documento']);
        $nombre    = $this->normalizarDatos($data['nombre']);
        $apellido  = $this->normalizarDatos($data['apellido']);
        $correo    = $this->normalizarDatos($data['correo']);
        $perfil    = $this->normalizarDatos($data['perfil']);
        $document  = $this->normalizarDatos($data['documento']);
        $first     = mb_strtoupper($nombre[0] . $apellido[0]);
        $clave     = $first . $document;
        $clave     = $this->encodePassword($clave);
        $consulta  = "INSERT INTO usuario VALUES (DEFAULT,'$nombre','$apellido','$correo','$usuario','$clave','$perfil','$documento')";
        $query     = $this->db->query($consulta);
        if ($query) {
            $mensaje = '1';
        } else {
            $mensaje = '0';
        }

        return $mensaje;
    }

    public function normalizarDatos($consulta)
    {
        return mysqli_real_escape_string($this->db, $consulta);
    }

    public function RandomToken($length = 16)
    {
        if (!isset($length) || intval($length) <= 8) {
            $length = 16;
        }

        return bin2hex(random_bytes($length));
    }

    public function Salt()
    {
        return strtr(base64_encode(hex2bin($this->RandomToken(16))), '+', '.');
    }

    public function encodePassword($password)
    {
        $cost = 10;
        $salt = $this->Salt();
        $salt = sprintf("$2a$%02d$", $cost) . $salt;
        $hash = crypt($password, $salt);

        return $hash;
    }

    public function decodePassword($data)
    {
        $hash  = $data['hash'];
        $clave = $data['clave'];
        if (hash_equals($hash, crypt($clave, $hash))) {
            $valido = '1';
        } else {
            $valido = '0';
        }

        return $valido;
    }
}