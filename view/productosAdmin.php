<?php
@\session_start();
if (!$rutasLegitima) {
    header('Location: ../index');
} elseif (empty($_SESSION['SesionAdmin']) || !$_SESSION['SesionAdmin']){
    header('Location: ./index');
}

//echo $_SESSION['SesionAdmin'];

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

                    <div class="container anchoStandar">
                        <div class="row">
                            <?= input_csrf_token(); ?>
                            <div class="col-lg-12 mb-1">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Nombre del Producto" title="Nombre del Producto" required minlength="1" maxlength="100">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" rows="3" minlength="1" maxlength="150"></textarea>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="precio" class="form-label">Precio *</label>
                                <input type="number" class="form-control" id="precio" placeholder="Precio del Producto" title="Precio del Producto" min="1" max="999999999999">
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div class="d-grid gap-2">
                                    <button id="agregarProducto" class="btn btn-primary" type="button">
                                        <i class="bi bi-box"></i>&nbsp;Agregar Producto
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <table id="productosTable"></table>
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
        <script src="resources/js/productos.js"></script>
        <?php
    }
}

$index = new PaginaOnce('Ligas', '', '');
echo $index->crearHtml();

?>