<?php
@\session_start();
if (!$rutasLegitima) {
    header('Location: ../index');
} elseif (empty($_SESSION['SesionTrabajador']) || !$_SESSION['SesionTrabajador']) {
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
                            <button class="nav-link active" id="quienDebe-tab" data-bs-toggle="tab" data-bs-target="#quienDebe" type="button" role="tab" aria-controls="quienDebe" aria-selected="true">Quien debe</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="quienDebe" role="tabpanel" aria-labelledby="quienDebe-tab">
                            <div class="row g-3 mt-3">
                                <div class="col-lg-2 col-sm-4">
                                    <label for="cliente" class="visually-hidden">Clientes</label>
                                    <select id="cliente" class="form-select">
                                        <option selected value="">Seleccione una opción</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-4 d-grid gap-2">
                                    <button type="button" class="btn btn-primary mb-3" id="buscar">Buscar</button>
                                </div>
                            </div>
                            <table id="quienDebeTable"></table>
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
        <script src="resources/js/quiendebe.js"></script>
        <?php
    }
}

$index = new PaginaOnce('Quien Debe', '', '');
echo $index->crearHtml();

?>