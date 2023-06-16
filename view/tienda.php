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
        ?>
        <div class="d-flex">
            <?php require_once 'layout/sidebarTrabajador.php'; ?>
            <div id="contentConSidebar">
                <div class="m-4">
                    
                    <div class="container anchoStandar">
                        <div class="row">
                            <?= input_csrf_token(); ?>
                            <div class="col-lg-12 mb-1">
                                <input class="form-check-input" type="checkbox" value="" id="checkCliente" checked>
                                <label class="form-check-label" for="checkCliente">
                                    Cliente existe?
                                </label>
                            </div>
                            <div class="col-lg-12 mb-1" id="divClientePre">
                                <label for="cliente" class="form-label">Clientes *</label>
                                <select id="cliente" class="form-select" required>
                                    <option selected value="">Seleccione una opción</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-1" id="divClienteNA">
                                <label for="nombreYapellido" class="form-label">Nombre Y Apellido *</label>
                                <input type="text" class="form-control" id="nombreYapellido" placeholder="Nombre Y Apellido del Cliente" title="Nombre Y Apellido del Cliente" required minlength="1" maxlength="50">
                            </div>
                            <div class="col-lg-6 mb-1" id="divClienteD">
                                <label for="documento" class="form-label">Documento</label>
                                <input type="number" class="form-control" id="documento" placeholder="Documento del Cliente" title="Documento del Cliente" min="1" max="999999999999">
                            </div>
                            <div class="col-lg-12 mb-1" id="divClienteEQ">
                                <label for="equipo" class="form-label">Equipo</label>
                                <select id="equipo" class="form-select">
                                    <option selected value="">Seleccione una opción</option>
                                </select>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="producto" class="form-label">Producto *</label>
                                <select id="producto" class="form-select" required>
                                    <option selected value="">Seleccione una opcion</option>
                                </select>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="cantidad" class="form-label">Cantidad *</label>
                                <input type="number" class="form-control" id="cantidad" placeholder="Cantidad del producto" max="20" min="1" max="1000000" value="1" required>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <input class="form-check-input" type="checkbox" value="" id="pago" checked>
                                <label class="form-check-label" for="pago">
                                    Pago?
                                </label>
                            </div>
                            <div class="col-lg-12 mb-1 ms-3" id="divpago">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipoPago" id="efectivo" value="efectivo" checked>
                                    <label class="form-check-label" for="efectivo">
                                        Efectivo
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipoPago" id="digital" value="digital">
                                    <label class="form-check-label" for="digital">
                                        Digital
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="col-lg-12 mb-1">
                                <label class="form-label">Total: <span id="total"></span></label>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="vender" class="btn btn-primary" type="button">
                                        <i class="bi bi-shop"></i>&nbsp;Vender
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
        <script src="resources/js/tienda.js"></script>
        <?php
    }
}

$index = new PaginaOnce('Tienda', '', '');
echo $index->crearHtml();

?>