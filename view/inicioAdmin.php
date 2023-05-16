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
    private $color;
    private $background;
    function __construct($title, $description, $keywords)
    {
        parent::__construct($title, $description, $keywords);
        $this->color = $this->model('ModelAdmin', 'obtenerColorGim', $_SESSION['SesionAdmin']['gimnasioId']);
        $this->background = $this->model('ModelAdmin', 'obtenerBackgroundGim', $_SESSION['SesionAdmin']['gimnasioId']);
    }

    public function content()
    {
        ?>
        <div class="d-flex">
            <?php require_once 'layout/sidebarAdmin.php'; ?>
            <?= input_csrf_token(); ?>
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
                                    <button id="tiendaAdmin" class="btn btn-light" type="button" disabled>
                                        <i class="bi bi-shop"></i>&nbsp;Tienda
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="descuentoAdmin" class="btn btn-light" type="button" disabled>
                                        <i class="bi bi-dash"></i>&nbsp;Descuento
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="pagosAdmin" class="btn btn-light" type="button" disabled>
                                        <i class="bi bi-dash"></i>&nbsp;Pagos
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="equiposAdmin" class="btn btn-light" type="button" disabled>
                                        <i class="bi bi-dash"></i>&nbsp;Equipos
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="productosAdmin" class="btn btn-light" type="button" disabled>
                                        <i class="bi bi-dash"></i>&nbsp;Productos
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="tarifasAdmin" class="btn btn-light" type="button" disabled>
                                        <i class="bi bi-dash"></i>&nbsp;Tarifas liga
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="tarifasAdmin" class="btn btn-light" type="button" disabled>
                                        <i class="bi bi-dash"></i>&nbsp;Trabajador
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="configuracionAdmin" class="btn btn-light" type="button" disabled>
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
                color: <?= $this->color; ?> !important;
                background: <?= $this->background; ?> !important;
            }
            #sideBarrar {
                color: <?= $this->color; ?> !important;
                background: <?= $this->background; ?> !important;
            }
        </style>
        <?php
    }

    public function libsJS()
    {
        ?>
        <script src="resources/js/adminGen.js"></script>
        <script>
            document.getElementById('ligasAdmin').addEventListener('click', function (e) {
                location.href = 'ligasAdmin';
            })
            document.getElementById('tiendaAdmin').addEventListener('click', function (e) {
                location.href = 'tiendaAdmin';
            })
            document.getElementById('descuentoAdmin').addEventListener('click', function (e) {
                location.href = 'descuentoAdmin';
            })
            document.getElementById('salirAdmin').addEventListener('click', salir)
        </script>
        <?php
    }
}

$index = new PaginaOnce('DashBoard administrador', '', '');
echo $index->crearHtml();

?>