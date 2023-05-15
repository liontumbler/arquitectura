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
                    <?= input_csrf_token(); ?>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="ligas-tab" data-bs-toggle="tab" data-bs-target="#ligas" type="button" role="tab" aria-controls="ligas" aria-selected="true">Ligas</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tienda-tab" data-bs-toggle="tab" data-bs-target="#tienda" type="button" role="tab" aria-controls="tienda" aria-selected="false">Tienda</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pagos-tab" data-bs-toggle="tab" data-bs-target="#pagos" type="button" role="tab" aria-controls="pagos" aria-selected="false">Pagos</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="descuentos-tab" data-bs-toggle="tab" data-bs-target="#descuentos" type="button" role="tab" aria-controls="descuentos" aria-selected="false">Descuentos</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="ligas" role="tabpanel" aria-labelledby="ligas-tab">
                            <table id="ligasTable"></table>
                        </div>
                        <div class="tab-pane fade" id="tienda" role="tabpanel" aria-labelledby="tienda-tab">
                            <table id="tiendaTable"></table>
                        </div>
                        <div class="tab-pane fade" id="pagos" role="tabpanel" aria-labelledby="pagos-tab">
                            <table id="pagosTable"></table>
                        </div>
                        <div class="tab-pane fade" id="descuentos" role="tabpanel" aria-labelledby="descuentos-tab">
                            <table id="descuentosTable"></table>
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
        <script src="resources/js/trabajadorGen.js"></script>
        <script src="resources/js/pagos.js"></script>
        <?php
    }
}

$index = new PaginaOnce('Pagos', '', '');
echo $index->crearHtml();

?>