<?php
/**
 * Created by PhpStorm.
 * User: Edwin
 * Date: 08/03/2018
 * Time: 22:31
 */

$root = $_SERVER['DOCUMENT_ROOT'];

include("$root/funciones.php");

class Proyecto_modelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createProyecto($data)
    {
        $fecha        = formatoFecha($data['fecha']);
        $rubro        = $data['rubro'];
        $codigo       = formatoCodigo(
            $data['fecha'], $this->getRubro($rubro), $this->getCodigoActual()
        );
        $proyecto     = normalizarDatos($this->db, $data['proyecto']);
        $alcance      = normalizarDatos($this->db, $data['alcance']);
        $oAlternativo = normalizarDatos($this->db, $data['ofertante_alternativo']);
        $contacto     = normalizarDatos($this->db, $data['contacto']);
        $cargo        = normalizarDatos($this->db, $data['cargo']);
        $exito        = $data['exito'];
        $usuario      = $data['usuario'];


        $sql = "
          INSERT INTO 
          proyecto(
            id, fecha, codigo, rubro, proyecto, status, actualizacion, alcance, ofertante_alternativo,
            contacto_tdp, cargo_tdp, probabilidad_exito, usuario_registra, fecha_registra)
          VALUES (
            DEFAULT,'$fecha','$codigo','$rubro','$proyecto','1',CURDATE(),'$alcance','$oAlternativo',
            '$contacto','$cargo','$exito','$usuario',NOW())
        ";

        $query = $this->db->query($sql);

        if ($query) {
            $this->updateCodigoActual();
            $mensaje   = "Oferta registrada, Codigo: " . $codigo;
            $respuesta = 1;
        } else {
            $mensaje   = "Por favor complete todos los datos";
            $respuesta = 0;
        }

        return json_encode(['respuesta' => $respuesta, 'mensaje' => $mensaje]);
    }

    /**
     * Retorna la lista de proyectos registrados por el usuario
     *
     * @param $usuario
     *
     * @return string
     */
    public function listarProyectos($usuario)
    {
        $sql = "
            SELECT 
                proy.*,
                sta.nombreStatus,
                rub.nombreRubro,
                exi.nombreExito
            FROM proyecto AS proy
            LEFT JOIN status AS sta ON proy.status = idStatus
            LEFT JOIN rubro AS rub ON proy.rubro = idRubro
            LEFT JOIN exito AS exi ON proy.probabilidad_exito = idExito
            WHERE usuario_registra = '$usuario'            
        ";

        $data = [];

        $query = $this->db->query($sql);
        if (mysqli_num_rows($query) > 0) {
            while ($rdata = mysqli_fetch_assoc($query)) {
                $codigo    = $rdata['codigo'];
                $fecha     = formatoFecha($rdata['fecha']);
                $mes       = leerMes($fecha);
                $rubro     = $rdata['nombreRubro'];
                $oferta    = $rdata['proyecto'];
                $version   = $rdata['version'];
                $status    = $rdata['nombreStatus'];
                $id        = $rdata['id'];
                $diaAct    = $rdata['actualizacion'][8] . $rdata['actualizacion'][9];
                $mesAct    = leerMes($rdata['actualizacion']);
                $lapiz     = "<button class='btn btn-circle btn-info' data-id='$id' data-toggle=\"modal\" data-target=\"#modalSeguimiento\"><i class='fa fa-pencil-square-o'></i></button>";
                $alcance   = $rdata['alcance'];
                $ofertante = $rdata['ofertante_alternativo'];
                $contacto  = $rdata['contacto_tdp'];
                $cargo     = $rdata['cargo_tdp'];
                $exito     = $rdata['nombreExito'];
                $data[]    = [
                    $codigo, $fecha, $mes, $rubro, $oferta, $version, $status, $diaAct, $mesAct, $lapiz, $alcance,
                    $ofertante, $contacto, $cargo, $exito,
                ];
            }
        }

        return json_encode(['data' => $data]);
    }

    public function getDetalleProyecto($id)
    {
        $query = $this->db->query("SELECT * FROM proyecto WHERE id='$id'");
        $rdata = mysqli_fetch_assoc($query);

        return json_encode($rdata);
    }

    public function actualizarStatus($id, $status)
    {
        $this->db->query("UPDATE proyecto SET status='$status' WHERE id='$id'");
    }

    public function getCodigoActual()
    {
        $query  = $this->db->query("SELECT actual FROM codigo_temp");
        $rdata  = mysqli_fetch_assoc($query);
        $actual = $rdata['actual'];

        return $actual;
    }

    public function getRubro($id)
    {
        $query = $this->db->query("SELECT nombreRubro FROM rubro WHERE idRubro='$id'");
        $rdata = mysqli_fetch_assoc($query);
        $rubro = $rdata['nombreRubro'];

        return $rubro;
    }

    public function updateCodigoActual()
    {
        $actual = $this->getCodigoActual();
        $nuevo  = $actual + 1;
        $this->db->query("UPDATE codigo_temp SET actual='$nuevo' WHERE id='1'");
    }

}