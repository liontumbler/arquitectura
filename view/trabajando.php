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
    function __construct($title, $description, $keywords)
    {
        parent::__construct($title, $description, $keywords);
    }

    public function content()
    {
        $tiendaV = $this->model('ModelAdmin', 'obtenerTiendaTraba', $_SESSION['SesionTrabajador']['trabajadoId']);
        $tiendaD = $this->model('ModelAdmin', 'obtenerTiendaTrabaDebe', $_SESSION['SesionTrabajador']['trabajadoId']);
        $tiendaP = $this->model('ModelAdmin', 'obtenerTiendaTrabaPago', $_SESSION['SesionTrabajador']['trabajadoId']);
        
        $ligaV = $this->model('ModelAdmin', 'obtenerLigaTraba', $_SESSION['SesionTrabajador']['trabajadoId']);
        $ligaD = $this->model('ModelAdmin', 'obtenerLigaTrabaDebe', $_SESSION['SesionTrabajador']['trabajadoId']);
        $ligaP = $this->model('ModelAdmin', 'obtenerLigaTrabaPago', $_SESSION['SesionTrabajador']['trabajadoId']);
        
        $pagosP = $this->model('ModelAdmin', 'obtenerpagosTrabaPago', $_SESSION['SesionTrabajador']['trabajadoId']);

        $totalTienda = 0;
        foreach ($tiendaV as $i => $value) {
            $totalTienda = $totalTienda + ($value['total']);
        }
        $totalTiendaDebe = 0;
        foreach ($tiendaD as $i => $value) {
            $totalTiendaDebe = $totalTiendaDebe + ($value['total']);
        }
        $totalTiendaPago = 0;
        foreach ($tiendaP as $i => $value) {
            $totalTiendaPago = $totalTiendaPago + ($value['total']);
        }

        $totalligas = 0;
        foreach ($ligaV as $i => $value) {
            $totalligas = $totalligas + ($value['total']);
        }
        $totalligasDebe = 0;
        foreach ($ligaD as $i => $value) {
            $totalligasDebe = $totalligasDebe + ($value['total']);
        }
        $totalligasPago = 0;
        foreach ($ligaP as $i => $value) {
            $totalligasPago = $totalligasPago + ($value['total']);
        }

        $totalPagosPagoefectivo = 0;
        $totalPagosPagodigital = 0;
        foreach ($pagosP as $i => $value) {
            if ($value['tipoPago'] == 'efectivo') {
                $totalPagosPagoefectivo = $totalPagosPagoefectivo + ($value['total']);
            } elseif ($value['tipoPago'] == 'digital') {
                $totalPagosPagodigital = $totalPagosPagodigital + ($value['total']);
            }
        }
        ?>
        <div class="d-flex">
            <?php require_once 'layout/sidebarTrabajador.php'; ?>
            <div id="contentConSidebar">
                <div class="m-4">
                    <div style="width: 400px; margin: auto;">
                        <ul>
                            <hr>
                            <hr>
                            <li>fiado de Ligas: <span><?= $totalligasDebe; ?></span></li>
                            <li>vendido de Ligas: <span><?= $totalligasPago; ?></span></li>
                            <li>Ligas en total: <span><?= $totalligas; ?></span></li>
                            <hr>
                            <hr>
                            <li>fiado de tienda: <span><?= $totalTiendaDebe; ?></span></li>
                            <li>vendido de tienda: <span><?= $totalTiendaPago; ?></span></li>
                            <li>Tienda en total: <span><?= $totalTienda; ?></span></li>
                            <hr>
                            <hr>
                            <li>total fiado: <span><?= $totalligasDebe + $totalTiendaDebe; ?></span></li>
                            <li>total pagos: <span><?= $totalligasPago + $totalTiendaPago; ?></span></li>
                            <li>total vendido: <span><?= $totalligas + $totalTienda; ?></span></li>
                            <hr>
                            <hr>
                            <li>pago efectivo: <span><?= $totalPagosPagoefectivo; ?></span></li>
                            <li>pago digital: <span><?= $totalPagosPagodigital; ?></span></li>
                            <li>total efectivo con digital: <span><?= $totalligasPago + $totalTiendaPago + ($totalPagosPagoefectivo + $totalPagosPagodigital); ?></span></li>
                            <hr>
                            <hr>

                            falta lo que se anota en descuento
                        </ul>
                    </div>
                    <div class="container" style="width: 450px;">
                        
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
            document.getElementById('terminar').addEventListener('click', function (e) {
                location.href = 'index';
                //terminar sesion hacer cuentas hacer insercion de la terminacion
                //abre una modal donde hace las cuantas paracerrar caja
            })
        </script>
        <?php
    }
}

$index = new PaginaOnce('DashBoard Trabajadores', '', '');
echo $index->crearHtml();

?>