<?php
@\session_start();
if (!$rutasLegitima) {
    echo 'no es legitima';
    header('Location: ../index');
} elseif (empty($_SESSION['SesionAdmin']) || !$_SESSION['SesionAdmin']) {
    ?>
    <script>
        location.href = './index';
    </script>
    <?php
}


//echo $_SESSION['SesionAdmin'];
//echo $rutasLegitima;

require_once 'view.php';

class PaginaOnce extends Web implements PaginaX
{
    function __construct($title, $description, $keywords)
    {
        parent::__construct($title, $description, $keywords);
    }

    public function content()
    {
        print_r($this->model('ModelLiga', 'horas'));//
        //cuando cargue la vista hacer consujlta de lo que se a ingresado hoy el trabajador
        ?>
        <div class="d-flex">
            <?php require_once 'layout/sidebarAdmin.php'; ?>
            <div id="contentConSidebar">
                <div class="m-4">
                    <div class="container" style="width: 450px;">
                        
                        <div class="row">
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="ligasAdmin" class="btn btn-light" type="button">
                                        <i class="bi bi-alarm"></i>&nbsp;Ligas
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="tiendaAdmin" class="btn btn-light" type="button">
                                        <i class="bi bi-shop"></i>&nbsp;Tienda
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="descuentoAdmin" class="btn btn-light" type="button">
                                        <i class="bi bi-dash"></i>&nbsp;Descuento
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="pagosAdmin" class="btn btn-light" type="button">
                                        <i class="bi bi-wallet"></i>&nbsp;Pagos
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="quienDebeAdmin" class="btn btn-light" type="button">
                                        <i class="bi bi-patch-question"></i>&nbsp;Quien Debe
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="reportesAdmin" class="btn btn-light" type="button">
                                        <i class="bi bi-bar-chart-line"></i>&nbsp;Reportes
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="configuracionAdmin" class="btn btn-light" type="button">
                                        <i class="bi bi-gear"></i>&nbsp;Configuración
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="salirAdmin" class="btn btn-danger" type="button">
                                        <i class="bi bi-power"></i>&nbsp;Salir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function nav()
    {
    ?>
        <?php require_once 'layout/navTrabajador.php'; ?>
    <?php
    }

    public function footer()
    {
    ?>
        <style>
            .navbar {
                color: <?= $_SESSION['color']; ?> !important;
                background: <?= $_SESSION['background']; ?> !important;
            }
            #sideBarrar {
                color: <?= $_SESSION['color']; ?> !important;
                background: <?= $_SESSION['background']; ?> !important;
            }
        </style>
    <?php
    }

    public function libsJS()
    {
        ?>
        <script src="resources/js/trabajadorGen.js"></script>
        <!--script>
            document.getElementById('ligas').addEventListener('click', function (e) {
                location.href = 'ligas';
            })
            document.getElementById('tienda').addEventListener('click', function (e) {
                location.href = 'tienda';
            })
            document.getElementById('descuento').addEventListener('click', function (e) {
                location.href = 'descuento';
            })
            document.getElementById('pagos').addEventListener('click', function (e) {
                location.href = 'pagos';
            })
            document.getElementById('quienDebe').addEventListener('click', function (e) {
                location.href = 'quienDebe';
            })
            document.getElementById('terminar').addEventListener('click', function (e) {
                location.href = 'index';
                //terminar sesion hacer cuentas hacer insercion de la terminacion
                //abre una modal donde hace las cuantas paracerrar caja
            })
        </script-->
        <?php
    }
}

$index = new PaginaOnce('DashBoard administrador', '', '');
echo $index->crearHtml();

?>