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
        
        $ligaD = $this->model('ModelAdmin', 'obtenerLigaTrabaDebe', $_SESSION['SesionTrabajador']['trabajadoId']);
        $ligaVE = $this->model('ModelAdmin', 'obtenerLigaTrabaPagoE', $_SESSION['SesionTrabajador']['trabajadoId']);
        $ligaVD = $this->model('ModelAdmin', 'obtenerLigaTrabaPagoD', $_SESSION['SesionTrabajador']['trabajadoId']);
        $ligaT = $this->model('ModelAdmin', 'obtenerLigaTraba', $_SESSION['SesionTrabajador']['trabajadoId']);
        
        $totalligas = 0;
        foreach ($ligaT as $i => $value) {
            $totalligas = $totalligas + ($value['total']);
        }
        $totalligasDebe = 0;
        foreach ($ligaD as $i => $value) {
            $totalligasDebe = $totalligasDebe + ($value['total']);
        }
        $totalligasPagoE = 0;
        foreach ($ligaVE as $i => $value) {
            $totalligasPagoE = $totalligasPagoE + ($value['total']);
        }
        $totalligasPagoD = 0;
        foreach ($ligaVD as $i => $value) {
            $totalligasPagoD = $totalligasPagoD + ($value['total']);
        }

        $tiendaD = $this->model('ModelAdmin', 'obtenerTiendaTrabaDebe', $_SESSION['SesionTrabajador']['trabajadoId']);
        $tiendaVE = $this->model('ModelAdmin', 'obtenerTiendaTrabaPagoE', $_SESSION['SesionTrabajador']['trabajadoId']);
        $tiendaVD = $this->model('ModelAdmin', 'obtenerTiendaTrabaPagoD', $_SESSION['SesionTrabajador']['trabajadoId']);
        $tiendaT = $this->model('ModelAdmin', 'obtenerTiendaTraba', $_SESSION['SesionTrabajador']['trabajadoId']);

        $totalTienda = 0;
        foreach ($tiendaT as $i => $value) {
            $totalTienda = $totalTienda + ($value['total']);
        }
        $totalTiendaDebe = 0;
        foreach ($tiendaD as $i => $value) {
            $totalTiendaDebe = $totalTiendaDebe + ($value['total']);
        }
        $totalTiendaPagoE = 0;
        foreach ($tiendaVE as $i => $value) {
            $totalTiendaPagoE = $totalTiendaPagoE + ($value['total']);
        }
        $totalTiendaPagoD = 0;
        foreach ($tiendaVD as $i => $value) {
            $totalTiendaPagoD = $totalTiendaPagoD + ($value['total']);
        }

        $pagosVE = $this->model('ModelAdmin', 'obtenerPagosTrabaPagoE', $_SESSION['SesionTrabajador']['trabajadoId']);
        $pagosVD = $this->model('ModelAdmin', 'obtenerPagosTrabaPagoD', $_SESSION['SesionTrabajador']['trabajadoId']);
        $pagosT = $this->model('ModelAdmin', 'obtenerPagosTraba', $_SESSION['SesionTrabajador']['trabajadoId']);

        $totalPagos = 0;
        foreach ($pagosT as $i => $value) {
            $totalPagos = $totalPagos + ($value['total']);
        }
        $totalPagosPagoE = 0;
        foreach ($pagosVE as $i => $value) {
            $totalPagosPagoE = $totalPagosPagoE + ($value['total']);
        }
        $totalPagosPagoD = 0;
        foreach ($pagosVD as $i => $value) {
            $totalPagosPagoD = $totalPagosPagoD + ($value['total']);
        }

        $efectivo = $totalligasPagoE + $totalTiendaPagoE + $totalPagosPagoE;
        $digital = $totalligasPagoD + $totalTiendaPagoD + $totalPagosPagoD;
        $fiado = $totalligasDebe + $totalTiendaDebe;
        $total = $efectivo + $digital + $fiado;

        $descuentos = $this->model('ModelAdmin', 'obtenerDescuentoTraba', $_SESSION['SesionTrabajador']['trabajadoId']);

        $totalDescuento = 0;
        foreach ($descuentos as $i => $value) {
            $totalDescuento = $totalDescuento + ($value['total']);
        }

        $caja = $this->model('ModelAdmin', 'obtenerCajaTraba', $_SESSION['SesionTrabajador']['trabajadoId']);

        ?>
        <div class="d-flex">
            <?php require_once 'layout/sidebarTrabajador.php'; ?>
            <?= input_csrf_token(); ?>
            <div id="contentConSidebar">
                <div class="m-4">
                    <div style="width: 400px; margin: auto;">
                        <ul>
                            <li>fiado de Ligas: <span><?= $totalligasDebe; ?></span></li>
                            <li>vendido de Ligas E: <span><?= $totalligasPagoE; ?></span></li>
                            <li>vendido de Ligas D: <span><?= $totalligasPagoD; ?></span></li>
                            <hr>
                            <li>Ligas Vendidas: <span><?= $totalligas; ?></span></li>
                            <hr>
                            <li>fiado de Tienda: <span><?= $totalTiendaDebe; ?></span></li>
                            <li>vendido de Tienda E: <span><?= $totalTiendaPagoE; ?></span></li>
                            <li>vendido de Tienda D: <span><?= $totalTiendaPagoD; ?></span></li>
                            <hr>
                            <li>Tienda Vendida: <span><?= $totalTienda; ?></span></li>
                            <hr>
                            <li>vendido de Pagos E: <span><?= $totalPagosPagoE; ?></span></li>
                            <li>vendido de Pagos D: <span><?= $totalPagosPagoD; ?></span></li>
                            <hr>
                            <li>Pagos recibidos: <span><?= $totalPagos; ?></span></li>
                            <hr>
                            <hr>
                            <li>Efectivo: <span><?= $efectivo; ?></span></li>
                            <li>Digital: <span><?= $digital; ?></span></li>
                            <li>fiado: <span><?= $fiado; ?></span></li>
                            <li>Caja: <span><?= $caja; ?></span></li>
                            <li>Descuentos: <span>-<?= $totalDescuento; ?></span></li>
                            <hr>
                            <li>Total: <span><?= $total; ?></span></li>
                            <li>Total solo efectivo con caja: <span><?= ($caja + $efectivo) -$totalDescuento; ?></span></li>
                            <li>Total digita + efectivo con caja: <span><?= ($caja + $efectivo + $digital) -$totalDescuento; ?></span></li>
                            <hr>
                            <hr>
                            <hr>
                            <hr>
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
            document.getElementById('terminar').addEventListener('click', async function (e) {
                //location.href = 'index';
                //terminar sesion hacer cuentas hacer insercion de la terminacion
                //abre una modal donde hace las cuantas paracerrar caja
                msgClave(async function () {

                    Swal.fire({
                        title: 'Ingresa el fectivo actual de la caja',
                        input: 'text',
                        inputLabel: 'Valor Caja',
                        showCancelButton: true,
                        inputAttributes: {
                            'minlength': '1',
                            'maxlength': '10',
                            'oninput': "this.value = this.value.replace(/[^0-9]/g, '')",
                            'style': 'text-align: center;'
                        },
                        inputValidator: (value) => {
                            if (!value) {
                                return '¡El campo no puede estar vacío!'
                            }
                        }
                    }).then(async (result) => {
                        console.log(result);
                        if (result.isConfirmed) {
                            let rest = await fetch('controller/ControllerTrabajando.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    accion: 'Cerrarcaja',
                                    data: {finCaja: result.value},
                                    csrf_token: document.getElementById('csrf_token').value
                                })
                            }).then((res) => {
                                this.disabled = false;
                                if (res.status == 200) {
                                    return res.json()
                                }
                            }).catch((res) => {
                                this.disabled = false;
                                console.error(res.statusText);
                                return res;
                            })

                            console.log(rest);

                            

                            if (rest == true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Cerro correctamente la sesión',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    if (result.dismiss == 'timer' && result.isDismissed) {
                                        location.href = 'loginTrabajador';
                                    }else{
                                        //location.href = location.href;
                                        alert('No selecciona ninguna op');
                                    }
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error al cerrar caja',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    console.log(result, result.isDismissed);
                                    if (result.dismiss == 'timer' && result.isDismissed) {
                                        location.href = location.href;
                                    }else{
                                        alert('No selecciona ninguna op');
                                    }
                                })
                            }
                        }else{
                            location.href = redirec;
                        }
                    })
                }, '')
                
            })
        </script>
        <?php
    }
}

$index = new PaginaOnce('DashBoard Trabajadores', '', '');
echo $index->crearHtml();

?>