<?php
/**
 * Created by PhpStorm.
 * User: Edwin
 * Date: 20/02/2018
 * Time: 21:00
 */

$root = $_SERVER['DOCUMENT_ROOT'];

include("$root/funciones.php");

class General_modelo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Coloca el titulo de la pagina asi como los CSS
     *
     * @param $title
     *
     * @return string
     */
    public function getCss($title)
    {
        if ($title == null) {
            $title = "Gestion de Obras";
        }

        $head = "
        <head>
            <meta charset=\"utf-8\">
            <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"/>
            <title>$title</title>
            <meta content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\" name=\"viewport\"/>
            <link href=\"/inelcom/css/bootstrap.min.css\" rel=\"stylesheet\">
            <script src=\"https://use.fontawesome.com/2ca56a25bc.js\"></script>
            <link href=\"/inelcom/css/plugins/dataTables/datatables.min.css\" rel=\"stylesheet\">
            <link rel=\"stylesheet\" href=\"https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css\"/>
            <link rel=\"stylesheet\" href=\"https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css\"/>
            <link href=\"/inelcom/css/plugins/datapicker/datepicker3.css\" rel=\"stylesheet\">
            <link href=\"/inelcom/css/plugins/daterangepicker/daterangepicker-bs3.css\" rel=\"stylesheet\">
            <link href=\"/inelcom/css/animate.css\" rel=\"stylesheet\">
            <link href=\"/inelcom/css/style.css\" rel=\"stylesheet\">
        </head>
        ";

        return $head;
    }

    /**
     * Devuelve la lista de scripts
     * @return string
     */
    function getScript()
    {
        $script = "
            <!-- main scripts -->
            <script src=\"/inelcom/js/jquery-3.1.1.min.js\"></script>
            <script src=\"/inelcom/js/bootstrap.min.js\"></script>
            <script src=\"/inelcom/js/plugins/metisMenu/jquery.metisMenu.js\"></script>
            <script src=\"/inelcom/js/plugins/slimscroll/jquery.slimscroll.min.js\"></script>
            <!-- Date picker -->
            <script src=\"/inelcom/js/plugins/datapicker/bootstrap-datepicker.js\"></script>   
            <!-- Date range use moment.js same as full calendar plugin -->
            <script src=\"/inelcom/js/plugins/fullcalendar/moment.min.js\"></script>     
            <!-- Date range picker -->
            <script src=\"/inelcom/js/plugins/daterangepicker/daterangepicker.js\"></script>
            <!-- Datatable -->
            <script src=\"/inelcom/js/plugins/dataTables/datatables.min.js\"></script>    
            <!-- Custom and plugin javascript -->
            <script src=\"/inelcom/js/inspinia.js\"></script>
            <script src=\"/inelcom/js/plugins/pace/pace.min.js\"></script>
        ";

        return $script;
    }

    /**
     * Crear el menu lateral del sistema
     *
     * @param $data
     *
     * @return string
     */

    public function getLeftMenu($data)
    {
        $nombre   = mb_ucfirst($data['nombre']);
        $apellido = mb_ucfirst($data['apellido']);
        $perfil   = mb_ucfirst($data['perfil']);
        $submenu  = $this->getMainMenu($data['idPerfil']);
        $menu     = "
        <nav class=\"navbar-default navbar-static-side\" role=\"navigation\">
            <div class=\"sidebar-collapse\">
                <ul class=\"nav metismenu\" id=\"side-menu\">
                    <li class=\"nav-header\">
                        <div class=\"dropdown profile-element\">
                                <a data-toggle=\"dropdown\" class=\"dropdown-toggle\" href=\"#\">
                                <span class=\"clear\"> <span class=\"block m-t-xs\"> <strong class=\"font-bold\">$nombre $apellido</strong>
                                 </span> <span class=\"text-muted text-xs block\">$perfil <b class=\"caret\"></b></span> </span> </a>
                                <ul class=\"dropdown-menu animated fadeInRight m-t-xs\">
                                    <li><a href=\"/inelcom/index.php\">Logout</a></li>
                                </ul>
                        </div>
                        <div class=\"logo-element\">
                            IN
                        </div>
                    </li>
                    $submenu
                </ul>
    
            </div>
        </nav>
        ";

        return $menu;
    }

    public function getMainMenu($perfil)
    {
        $enlaces = '';
        $data    = $this->db->query("SELECT menu FROM menu WHERE idPerfil='$perfil'");
        if (mysqli_num_rows($data) > 0) {
            $preItem = mysqli_fetch_assoc($data);
            $items   = json_decode($preItem['menu']);
            foreach ($items as $item) {
                $enlace  = $item['acceso'];
                $titulo  = $item['titulo'];
                $enlaces .= '<li>
            <a href="' . $enlace . '">
                <i class="fa fa-th-large"></i> <span class="nav-label">' . $titulo . '</span> </a>
            </li>';
            }
        }

        $menu = "        
        <li class=\"active\">
            <a href=\"index.html\"><i class=\"fa fa-th-large\"></i> <span class=\"nav-label\">Main view</span></a>
        </li>
        <li>
            <a href=\"minor.html\"><i class=\"fa fa-th-large\"></i> <span class=\"nav-label\">Minor view</span> </a>
        </li>
        $enlaces
        ";

        return $menu;
    }

    public function getTopBar()
    {
        $menu = "
        <div class=\"row border-bottom\">
            <nav class=\"navbar navbar-static-top white-bg\" role=\"navigation\" style=\"margin-bottom: 0\">
                <div class=\"navbar-header\">
                    <a class=\"navbar-minimalize minimalize-styl-2 btn btn-primary \" href=\"#\"><i class=\"fa fa-bars\"></i>
                    </a>
                </div>
                <ul class=\"nav navbar-top-links navbar-right\">
                    <li>
                        <a href=\"/inelcom/index.php\">
                            <i class=\"fa fa-sign-out\"></i> Log out
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        ";

        return $menu;
    }

    public function getTitulo($title, $placeholder)
    {
        $menu = "
        <div class=\"col-lg-12\">
            <div class=\"text-center m-t-lg\">
                <h1>
                    $title
                </h1>
                <small>
                    $placeholder
                </small>
            </div>
        </div>
        ";

        return $menu;
    }

    public function getFooter()
    {
        $html = "
        <div class=\"footer\">
            <div class=\"pull-right\">
            </div>
            <div>
                <strong>Copyright</strong> INELCOM &copy; 2018
            </div>
        </div>
        ";

        return $html;
    }

    public function initMain()
    {
        $main = "
        
        ";

        return $main;
    }

    /**
     * Devuelve la lista de Rubros
     * @return string
     */
    public function getRubroList()
    {
        $option = '';
        $query  = $this->db->query("SELECT * FROM rubro");
        while ($rdata = mysqli_fetch_assoc($query)) {
            $option .= '<option value="' . $rdata['idRubro'] . '" data-inicial="' . $rdata['nombreRubro'][0] . '">' . mb_strtoupper(
                    $rdata['nombreRubro']
                ) . '</option>';
        }

        return $option;
    }

    /**
     * Devuelve la lista de Rubros
     * @return string
     */
    public function getPerfilList()
    {
        $option = '';
        $query  = $this->db->query("SELECT * FROM perfil");
        while ($rdata = mysqli_fetch_assoc($query)) {
            $option .= '<option value="' . $rdata['idPerfil'] . '">' . mb_strtoupper(
                    $rdata['nombre']
                ) . '</option>';
        }

        return $option;
    }

    /**
     * Devuelve la lista de status
     * @return string
     */
    public function getStatusList()
    {
        $option = '';
        $query  = $this->db->query("SELECT * FROM status");
        while ($rdata = mysqli_fetch_assoc($query)) {
            $option .= '<option value="' . $rdata['idStatus'] . '">' . mb_strtoupper(
                    $rdata['nombreStatus']
                ) . '</option>';
        }

        return $option;
    }

    /**
     * Agrega un comentario al proyecto
     *
     * @param $data
     *
     * @return string
     */
    public function agregarComentario($data)
    {
        $id_obra    = $data['obra'];
        $comentario = mysqli_real_escape_string($this->db, $data['comentario']);
        $usuario    = mysqli_real_escape_string($this->db, $data['usuario']);

        $consulta = $this->db->query("SELECT sisego FROM obras WHERE id='$id_obra'");
        while ($rdata = mysqli_fetch_assoc($consulta)) {
            $sisego = $rdata['sisego'];
        }
        $consulta2 = $this->db->query(
            "INSERT INTO comentario_obras(id_obra,obra,comentario,usuario) VALUES ('$id_obra','$sisego','$comentario','$usuario')"
        );
        if ($consulta2) {
            return "1";
        } else {
            return '0';
        }
    }

    /**
     * @param $data
     *
     * @return string
     */

    public function agregarSituacion($data)
    {
        $id_obra    = $data['obra'];
        $situacion  = $data['situacion'];
        $comentario = "Cambio de situacion: " . $situacion;
        $usuario    = mysqli_real_escape_string($this->db, $_POST['usuario']);

        $consulta = $this->db->query("SELECT sisego FROM obras WHERE id='$id_obra'");

        while ($rdata = mysqli_fetch_array($consulta)) {
            $sisego = $rdata['sisego'];
        }

        $this->db->query(
            "INSERT INTO comentario_obras(id_obra,obra,comentario,usuario) VALUES ('$id_obra','$sisego','$comentario','$usuario')"
        );

        $busca_situ = $this->db->query("SELECT id FROM cambio_situacion WHERE id='$id_obra' ORDER BY ID DESC LIMIT 1");
        if (mysqli_num_rows($busca_situ) > 0) {
            while ($rsa = mysqli_fetch_array($busca_situ)) {
                $rid = $rsa['id'];
            }
            $this->db->query(
                "UPDATE cambio_situacion SET fechacierre=NOW(), duracion=DATEDIFF(CURDATE(),DATE(fechahora)) WHERE id='$rid'"
            );
        }

        $consulta3 = $this->db->query(
            "INSERT INTO cambio_situacion(id_obra,situacion,usuario) VALUES ('$id_obra','$situacion','$usuario')"
        );

        $this->db->query("UPDATE obras SET situacion='$situacion' WHERE id='$id_obra'");

        if ($consulta3) {
            return "1";
        } else {
            return '0';
        }
    }

    /***
     * @param $segmento
     * @param $analista
     *
     * @return string
     */

    public function totalMultipar($segmento, $analista)
    {
        if ($segmento != '') {
            $segmento = " AND segmento ='" . $segmento . "' ";
        }
        $dataEx = [];
        $zonasX = $this->db->query("SELECT * FROM zonas WHERE responsable='$analista'");
        while ($rz = mysqli_fetch_assoc($zonasX)) {
            $departamentoZona = mb_strtolower(ltrim(rtrim($rz['departamento'])));
            $provinciasZona   = ltrim(rtrim($rz['provincias']));
            $provinciaMenos   = ltrim(rtrim($rz['menos_prov']));
            $distritosZona    = ltrim(rtrim($rz['distritos']));
            $distritoMenos    = ltrim(rtrim($rz['menos']));
            /*$region = ltrim(rtrim($rz['region']));*/
            $query          = "";
            $queryDepa      = "ubicacion='$departamentoZona' ";
            $queryProvincia = "";
            $queryDistrito  = "";

            if ($provinciaMenos == '' && $provinciasZona == 'Todas' && $distritosZona == 'Todas' && $distritoMenos == '') {
                $query = $queryDepa;
            } else if ($provinciaMenos != '' && $provinciasZona == 'Todas') {
                $arrayProvincias = explode(',', $provinciaMenos);
                foreach ($arrayProvincias as $provinciaTemp) {
                    $provTemp = ltrim(rtrim($provinciaTemp));
                    if ($queryProvincia == "") {
                        $queryProvincia = "provincia!='$provTemp'";
                    } else {
                        $queryProvincia = $queryProvincia . " AND provincia!='$provTemp'";
                    }
                }
                $queryProvincia = " AND ( " . $queryProvincia . " ) ";
                $query          = $queryDepa . ' ' . $queryProvincia . ' ' . $queryDistrito;
            } else if ($provinciasZona != 'Todas') {
                $arrayProvincias = explode(',', $provinciasZona);
                if ($distritosZona == 'Todas' && $distritoMenos == '') {
                    foreach ($arrayProvincias as $provinciaTemp) {
                        $provTemp = ltrim(rtrim($provinciaTemp));
                        if ($queryProvincia == "") {
                            $queryProvincia = "provincia='$provTemp'";
                        } else {
                            $queryProvincia = $queryProvincia . " OR provincia='$provTemp'";
                        }
                    }
                    $queryProvincia = " AND ( " . $queryProvincia . " ) ";
                    $query          = $queryDepa . ' ' . $queryProvincia . ' ' . $queryDistrito;
                } else if ($distritosZona == "Todas" && $distritoMenos != '') {
                    foreach ($arrayProvincias as $provinciaTemp) {
                        $provTemp = ltrim(rtrim($provinciaTemp));
                        if ($queryProvincia == "") {
                            $queryProvincia = "provincia='$provTemp'";
                        } else {
                            $queryProvincia = $queryProvincia . " OR provincia='$provTemp'";
                        }
                    }
                    $queryProvincia = " AND ( " . $queryProvincia . " ) ";
                    $arrayDistritos = explode(',', $distritoMenos);
                    foreach ($arrayDistritos as $distritoTemp) {
                        $distriTemp = ltrim(rtrim($distritoTemp));
                        if ($queryDistrito == "") {
                            $queryDistrito = "distrito!='$distriTemp'";
                        } else {
                            $queryDistrito = $queryDistrito . " AND distrito!='$distriTemp'";
                        }
                    }
                    $queryDistrito = " AND ( " . $queryDistrito . " ) ";
                    $query         = $queryDepa . ' ' . $queryProvincia . ' ' . $queryDistrito;
                } else if ($distritosZona != 'Todas') {
                    $arrayDistritos = explode(',', $distritosZona);
                    if ($departamentoZona != 'lima') {
                        foreach ($arrayDistritos as $distritoTemp) {
                            $distriTemp = ltrim(rtrim($distritoTemp));
                            if ($queryDistrito == "") {
                                $queryDistrito = "distrito='$distriTemp'";
                            } else {
                                $queryDistrito = $queryDistrito . " OR distrito='$distriTemp'";
                            }
                        }
                        $queryDistrito = " AND ( " . $queryDistrito . " ) ";
                        $query         = $queryDepa . ' ' . $queryProvincia . ' ' . $queryDistrito;
                    } else {
                        $queryRara       = "";
                        $arrayProvincias = explode(',', $provinciasZona);
                        foreach ($arrayProvincias as $provinciaTemp) {
                            $provTemp = ltrim(rtrim($provinciaTemp));
                            if ($queryProvincia == "") {
                                $queryProvincia = "provincia='$provTemp'";
                            } else {
                                $queryProvincia = $queryProvincia . " OR provincia='$provTemp'";
                            }
                        }
                        $queryProvincia = " ( " . $queryProvincia . " ) ";
                        $queryRara      = "provincia='$provTemp'";

                        foreach ($arrayDistritos as $distritoTemp) {
                            $distriTemp = ltrim(rtrim($distritoTemp));
                            if ($queryDistrito == "") {
                                $queryDistrito = "distrito='$distriTemp'";
                            } else {
                                $queryDistrito = $queryDistrito . " OR distrito='$distriTemp'";
                            }
                        }
                        $queryRara      = " ( " . $queryDistrito . " ) ";
                        $queryProvincia = " AND ( $queryProvincia OR " . $queryRara . " ) ";
                        $query          = $queryDepa . ' ' . $queryProvincia;
                    }
                }
            }

            $sql = "
            SELECT * , if(estado!='finalizado',datediff(CURDATE(),fecha_inicio),datediff(fecha_fin_real,fecha_inicio)) as dias_actual 
            FROM obras 
            WHERE                      
              ultima_milla!='si' AND tipo_proyecto='multipar'
              AND estado not in ('finalizado','sisego','revision','inspeccion','cancelado','finalizado trunco')
              AND ( $query )";

            $res = $this->db->query($sql);

            while ($rdata = mysqli_fetch_assoc($res)) {
                $idObraM      = $rdata['id'];
                $id           = $rdata['id'];
                $fibras       = $rdata['fibras'];
                $sisego       = $rdata['sisego'];
                $posiciones   = $rdata['posiciones'];
                $lic_list     = $rdata['licencia_listo'];
                $fin_estimada = formatoFecha($rdata['fecha_fin_estimada']);
                $id_obra      = $rdata['id'];
                $grafo        = $rdata['grafo'];
                $contrata     = $rdata['contrata_gics'];
                $duracion     = $rdata['duracion'];
                $direccion    = $rdata['direccion'];
                $situacion    = $rdata['situacion'];
                $departamento = mb_strtoupper($rdata['ubicacion']);
                $provincia    = mb_strtoupper($rdata['provincia']);
                $cliente      = mb_strtoupper($rdata['cliente']);
                $fecha_inicio = formatoFecha($rdata['fecha_inicio']);
                if ($rdata['fecha_fin_contrata'] != '') {
                    $fecha_fin = formatoFecha($rdata['fecha_fin_contrata']);
                } else {
                    $fecha_fin = '00-00-0000';
                }
                $ult_act = soloFecha($rdata['ultima_actualizacion']);
                $bandeja = $rdata['bandeja'];
                if ($rdata['estado'] == 'finalizado' || $rdata['estado'] == 'finalizado trunco' || $rdata['bandeja'] == 'inspeccion' || $rdata['bandeja'] == 'sisego') {
                    $estado = 'Finalizado';
                } else if ($rdata['estado'] == 'cancelado') {
                    $estado = 'Cancelado';
                } else if ($rdata['estado'] == 'paralizado') {
                    $estado = 'Paralizado';
                } else {
                    $estado = 'Inicio de Ejecución';
                }
                $dias                  = '0';
                $total                 = '0';
                $diasRed               = $rdata['dias_actual'];
                $buscar_paralizaciones = $this->db->query(
                    "SELECT count(id) as total, sum(if(duracion=0,datediff(CURDATE(),fecha_paralizado),duracion)) as dias FROM obras_paralizadas WHERE idObra='$id_obra'"
                );
                if (mysqli_num_rows($buscar_paralizaciones) > 0) {
                    while ($rpara = mysqli_fetch_assoc($buscar_paralizaciones)) {
                        $dias    = $rpara['dias'];
                        $total   = $rpara['total'];
                        $diasRed = $rdata['dias_actual'] - $dias;
                    }
                }

                if ($dias == '') {
                    $dias = '0';
                }

                // Atencion de regiones
                $distrito      = $rdata['distrito'];
                $segmento      = strtoupper($rdata['segmento']);
                $tipo_proyecto = strtoupper($rdata['tipo_proyecto']);
                $sisego        = "<btn class=\"btn btn-xs btn-primary\" data-toggle=\"modal\" data-target=\"#exampleModal\" data-id=\"$id\">$sisego</btn>";
                $botones       = "<a href=\"#\" title=\"Comentarios\" data-toggle='modal'data-target=\"#exampleModal2\" data-id='$idObraM' style=\"color:black;\"><i class=\"fa fa-pencil\"></i></a>";
                $dataEx[]      = [
                    $segmento, $tipo_proyecto, $sisego, $grafo, $cliente, $direccion, $fecha_inicio, $duracion,
                    $fin_estimada,
                    leerMes($fin_estimada), $estado, mb_strtoupper($bandeja), $departamento, $provincia, $total, $dias,
                    $diasRed,
                    $botones, 'Multipar', mb_strtoupper($contrata), mb_strtoupper($situacion),
                ];
            }
        }
        $datos = ["data" => $dataEx];

        return json_encode($datos);
    }

    /**
     * @param string $idObra
     *
     * @return mixed
     */
    public function getInfoSIGO($idObra)
    {
        $sql  = "
            SELECT
              id, sisego, grafo, cliente, direccion, provincia, distrito, pep2, ptr, requiere_tendido, requiere_canalizado, 
              ticket, ura, contrata_diseno, contrata, fecha_inicio, fecha_fin_estimada, estado, bandeja, expediente, 
              if(fecha_equipos is null,'',DATE_FORMAT(fecha_equipos,'%d-%m-%Y')) as fecha_equipos, hora_equipos
            FROM obras 
            WHERE                      
              id='$idObra'";
        $res  = $this->db->query($sql);
        $data = mysqli_fetch_assoc($res);

        return json_encode($data);
    }

    /**
     * Guarda los datos del diseno
     *
     * @param $data
     *
     * @return mixed
     */

    public function guardarDiseno($data)
    {
        $id      = $data['id'];
        $ptr     = $data['ptr'];
        $tendido = $data['tendido'];
        if ($tendido == 'null') {
            $tendido = 'no';
        }
        $canalizado = $data['canalizado'];
        if ($canalizado == 'null') {
            $canalizado = 'no';
        }
        $ticket   = $data['ticket'];
        $ura      = $data['ura'];
        $contrata = $data['contrata'];
        $archivo  = '  ';
        if (!empty($_FILES)) {
            $archivo   = mysqli_real_escape_string($this->db, $_FILES['expediente']['name']);
            $archivo   = " , expediente='" . $archivo . "'";
            $targetDir = "../data/" . $id . "/expediente";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $targetDir = $targetDir . "/";
            $file      = $_FILES['expediente']['tmp_name'];
            $basename  = basename($_FILES['expediente']['name']);
            move_uploaded_file($file, $targetDir . $basename);
        }
        $query = "
            UPDATE obras
            SET ptr='$ptr', requiere_tendido='$tendido', requiere_canalizado='$canalizado', ticket='$ticket', ura='$ura', contrata='$contrata' $archivo
            WHERE id='$id'
        ";
        $res   = $this->db->query($query);

        return $res;
    }

    /**
     * Almacena el perfil de la obra
     *
     * @param file $data
     *
     * @return string
     */

    public function guardarPerfil($data)
    {
        $id  = $data['id'];
        $res = 'No se selecciono archivo';
        if (!empty($_FILES)) {
            $archivo   = mysqli_real_escape_string($this->db, $_FILES['perfil']['name']);
            $targetDir = "../data/" . $id . "/perfil";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $targetDir = $targetDir . "/";
            $file      = $_FILES['perfil']['tmp_name'];
            $basename  = basename($_FILES['perfil']['name']);
            move_uploaded_file($file, $targetDir . $basename);
            $query = "
                UPDATE obras
                SET  perfil='$archivo'
                WHERE id='$id'
            ";
            $res   = $this->db->query($query);
            if ($res) {
                $res = "1";
            }
        }

        return $res;
    }

    /**
     * Envia la obra a ejecucion
     *
     * @param $data
     *
     * @return string
     */

    public function enviarDiseno($data)
    {
        $id      = $data['id'];
        $usuario = $data['usuario'];
        $query   = "
        SELECT * FROM obras 
        WHERE 
          ptr!='' and requiere_tendido!='' and requiere_canalizado!='' and ticket!='' and ura!='' and ura is not NULL and contrata!='' 
          AND contrata is not NULL AND expediente!='' AND expediente is not NULL AND perfil is not NULL AND id='$id' ";
        $exe     = $this->db->query($query);
        if (mysqli_num_rows($exe) > 0) {
            $consulta[] = "UPDATE obras SET bandeja='operaciones', ultima_actualizacion=CURDATE() WHERE id='$id'";
            $consulta[] = "
            INSERT INTO 
            registro_cambio (id, idObra, bandeja_actual, estado_a, bandeja_nueva, estado_n, actualiza, fecha_actualizacion) 
            VALUES (default,'$id','diseño','inicio','operaciones','inicio','$usuario',NOW())";
            $consulta[] = "INSERT INTO 
            comentario_obras(id_comen, id_obra, obra, comentario, usuario, agregado_el) 
            VALUES (default,'$id','','Cambio de bandeja a Operaciones','$usuario',NOW())";
            foreach ($consulta as $sql) {
                $this->db->query($sql);
            }
            $message = "1";
        } else {
            $message = "2";
        }

        return $message;
    }
}
