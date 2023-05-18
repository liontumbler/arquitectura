<?php
@\session_start();
if (!$rutasLegitima) {
    header('Location: ../index');
} elseif (empty($_SESSION['SesionAdmin']) || !$_SESSION['SesionAdmin']) {
    header('Location: ./index');
}

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
            <div id="contentConSidebar">
                <div class="m-4">
                    <?= input_csrf_token(); ?>
                    
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tienda-tab" data-bs-toggle="tab" data-bs-target="#tienda" type="button" role="tab" aria-controls="tienda" aria-selected="true">Tienda</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="tienda" role="tabpanel" aria-labelledby="tienda-tab">
                        <div class="row g-3 mt-3">
                                <div class="col-lg-1 col-sm-4">
                                    <label for="cliente">Clientes</label>
                                    <select id="cliente" class="form-select">
                                        <option selected value="">Seleccione una opción</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-4">
                                    <label for="trabajador">Trabajador</label>
                                    <select id="trabajador" class="form-select">
                                        <option selected value="">Seleccione una opción</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-4">
                                    <label for="producto">producto</label>
                                    <select id="producto" class="form-select">
                                        <option selected value="">Seleccione una opción</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-4">
                                    <label for="tipoPago">Tipo de Pago</label>
                                    <select id="tipoPago" class="form-select">
                                        <option selected value="">Seleccione una opción</option>
                                        <option value="pazYsalvoEfectivo">debe pero pago Efectivo</option>
                                        <option value="pazYsalvoDigital">debe pero pago Digital</option>
                                        <option value="digital">digital</option>
                                        <option value="efectivo">efectivo</option>
                                        <option value="debe">debe</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-4">
                                    <label for="desde">Desde</label>
                                    <input type="datetime-local" id="desde" class="form-control">
                                </div>
                                <div class="col-lg-2 col-sm-4">
                                    <label for="hasta">Hasta</label>
                                    <input type="datetime-local" id="hasta" class="form-control">
                                </div>
                                <div class="col-lg-1 col-sm-4 d-grid gap-2">
                                    <button type="button" class="btn btn-primary mt-4" id="buscar">Buscar</button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <canvas id="tiendasGraficaBarras">Your browser does not support the canvas element.</canvas>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="tiendasGraficaLineas">Your browser does not support the canvas element.</canvas>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="tiendasGraficaPolarArea">Your browser does not support the canvas element.</canvas>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="tiendasGraficaPie">Your browser does not support the canvas element.</canvas>
                                </div>
                            </div>

                            <table id="tiendaTable"></table>
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="resources/js/adminGen.js"></script>
        <script src="resources/js/tiendaAdmin.js"></script>
        <?php
    }
}

$index = new PaginaOnce('Tienda Administrador', '', '');
echo $index->crearHtml();
?>