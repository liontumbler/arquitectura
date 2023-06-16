<?php
@\session_start();
if (!$rutasLegitima) {
    header('Location: ../index');
} elseif (empty($_SESSION['SesionTrabajador']) || !$_SESSION['SesionTrabajador']){
    header('Location: ./index');
}

//echo $_SESSION['SesionTrabajador'];

require_once 'view.php';

class PaginaOnce extends Web implements PaginaX
{
    private $color;
    private $background;
    function __construct($title, $description, $keywords)
    {
        parent::__construct($title, $description, $keywords);
        $this->color = $this->model('ModelAdmin', 'obtenerColorGim', $_SESSION['SesionTrabajador']['gimnasioId']);
        $this->background = $this->model('ModelAdmin', 'obtenerBackgroundGim', $_SESSION['SesionTrabajador']['gimnasioId']);
    }

    public function content()
    {
        $totalligasDebe = $this->model('ModelAdmin', 'obtenerLigaTrabaDebeTotal', $_SESSION['SesionTrabajador']['trabajadoId']);
        $totalligasPagoE = $this->model('ModelAdmin', 'obtenerLigaTrabaPagoETotal', $_SESSION['SesionTrabajador']['trabajadoId']);
        $totalligasPagoD = $this->model('ModelAdmin', 'obtenerLigaTrabaPagoDTotal', $_SESSION['SesionTrabajador']['trabajadoId']);
        $totalligas = $this->model('ModelAdmin', 'obtenerLigaTrabaTotal', $_SESSION['SesionTrabajador']['trabajadoId']);

        $totalTiendaDebe = $this->model('ModelAdmin', 'obtenerTiendaTrabaDebeTotal', $_SESSION['SesionTrabajador']['trabajadoId']);
        $totalTiendaPagoE = $this->model('ModelAdmin', 'obtenerTiendaTrabaPagoETotal', $_SESSION['SesionTrabajador']['trabajadoId']);
        $totalTiendaPagoD = $this->model('ModelAdmin', 'obtenerTiendaTrabaPagoDTotal', $_SESSION['SesionTrabajador']['trabajadoId']);
        $totalTienda = $this->model('ModelAdmin', 'obtenerTiendaTrabaTotal', $_SESSION['SesionTrabajador']['trabajadoId']);

        $totalPagosPagoE = $this->model('ModelAdmin', 'obtenerPagosTrabaPagoETotal', $_SESSION['SesionTrabajador']['trabajadoId']);
        $totalPagosPagoD = $this->model('ModelAdmin', 'obtenerPagosTrabaPagoDTotal', $_SESSION['SesionTrabajador']['trabajadoId']);
        $totalPagos = $this->model('ModelAdmin', 'obtenerPagosTrabaTotal', $_SESSION['SesionTrabajador']['trabajadoId']);

        $efectivo = $totalligasPagoE + $totalTiendaPagoE + $totalPagosPagoE;
        $digital = $totalligasPagoD + $totalTiendaPagoD + $totalPagosPagoD;
        $fiado = $totalligasDebe + $totalTiendaDebe;
        $total = $efectivo + $digital + $fiado;

        $totalDescuento = $this->model('ModelAdmin', 'obtenerDescuentoTrabaTotal', $_SESSION['SesionTrabajador']['trabajadoId']);
        if (empty($totalDescuento)) {
            $totalDescuento = 0;
        }

        $caja = $this->model('ModelAdmin', 'obtenerCajaTraba', $_SESSION['SesionTrabajador']['trabajadoId']);
        if (empty($caja)) {
            $caja = 0;
        }
        ?>
        <div class="d-flex">
            <?php require_once 'layout/sidebarTrabajador.php'; ?>
            <?= input_csrf_token(); ?>
            <div id="contentConSidebar">
                <div class="m-4">
                    <div class="row container-md centerRow">
                        <div class="col-md-4">
                            <div class="carBoard mb-2">
                                <span>Fiado de Ligas: <strong><?= $totalligasDebe; ?></strong></span>
                                <br>
                                <span>Vendido de ligas Efectivo: <strong><?= $totalligasPagoE; ?></strong></span>
                                <br>
                                <span>Vendido de ligas Digital: <strong><?= $totalligasPagoD; ?></strong></span>
                                <hr>
                                <strong>Ligas Vendidas: <strong><?= $totalligas; ?></strong></strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="carBoard mb-2">
                                <span>Fiado de Tienda: <strong><?= $totalTiendaDebe; ?></strong></span>
                                <br>
                                <span>Vendido de tienda Efectivo: <strong><?= $totalTiendaPagoE; ?></strong></span>
                                <br>
                                <span>Vendido de tienda Digital: <strong><?= $totalTiendaPagoD; ?></strong></span>
                                <hr>
                                <strong>Tienda Vendida: <span><?= $totalTienda; ?></span></strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="carBoard mb-2">
                                <span>Pagos recibidos en Efectivo: <strong><?= $totalPagosPagoE; ?></strong></span>
                                <br>
                                <span>Pagos recibidos en Digital: <strong><?= $totalPagosPagoD; ?></strong></span>
                                <br>
                                <br>
                                <hr>
                                <strong>Pagos totales: <span><?= $totalPagos; ?></span></strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="carBoard mb-2">
                                <span>Efectivo: <strong><?= $efectivo; ?></strong></span>
                                <br>
                                <span>Digital: <strong><?= $digital; ?></strong></span>
                                <br>
                                <span>Fiado: <strong><?= $fiado; ?></strong></span>
                                <br>
                                <span>Caja: <strong><?= $caja; ?></strong></span>
                                <br>
                                <span>Descuentos: <strong>-<?= $totalDescuento; ?></strong></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="carBoard mb-2">
                                <br>
                                <br>
                                <span>Total: <strong><?= $total; ?></strong></span>
                                <br>
                                <span>Total solo efectivo con caja: <strong><?= ($caja + $efectivo) -$totalDescuento; ?></strong></span>
                                <br>
                                <span>Total digita + efectivo con caja: <strong><?= ($caja + $efectivo + $digital) -$totalDescuento; ?></strong></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="container anchoStandar">
                        <div class="row">
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="ligas" class="btn btn-light" type="button">
                                        <i class="bi bi-alarm"></i>&nbsp;Ligas
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="tienda" class="btn btn-light" type="button">
                                        <i class="bi bi-shop"></i>&nbsp;Tienda
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="descuento" class="btn btn-light" type="button">
                                        <i class="bi bi-dash"></i>&nbsp;Descuento
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="pagos" class="btn btn-light" type="button">
                                        <i class="bi bi-wallet"></i>&nbsp;Pagos
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="quienDebe" class="btn btn-light" type="button">
                                        <i class="bi bi-patch-question"></i>&nbsp;Quien Debe
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="terminar" class="btn btn-danger" type="button">
                                        <i class="bi bi-power"></i>&nbsp;Terminar
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
            #sideBar a {
                color: <?= $this->color; ?> !important;
            }
        </style>
        <?php
    }

    public function libsJS()
    {
        ?>
        <script src="resources/js/trabajadorGen.js"></script>
        <script>
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
            document.getElementById('terminar').addEventListener('click', terminar);
        </script>
        <?php
    }
}

$index = new PaginaOnce('DashBoard Trabajadores', '', '');
echo $index->crearHtml();

?>