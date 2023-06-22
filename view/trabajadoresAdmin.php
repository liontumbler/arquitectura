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
                                <label for="nombresYapellidos" class="form-label">Nombres y Apellidos *</label>
                                <input type="text" class="form-control" id="nombresYapellidos" placeholder="Nombre y Apellido del trabajador" title="Nombre y Apellido del trabajador" required minlength="1" maxlength="100">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="nickname" class="form-label">Apodo (Alias) *</label>
                                <input type="text" textarroba class="form-control" id="nickname" placeholder="nickname" title="nickname" required minlength="1" maxlength="100">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="correo" class="form-label">Correo *</label>
                                <input type="email" class="form-control" id="correo" placeholder="correo del trabajador" title="correo del trabajador" required minlength="1" maxlength="100">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="telefono" class="form-label">Telefono</label>
                                <input type="number" class="form-control" id="telefono" placeholder="Teléfono del trabajador" title="Teléfono del trabajador" required minlength="1" maxlength="13">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="documento" class="form-label">Documento *</label>
                                <input type="number" class="form-control" id="documento" placeholder="Número de documento de identidad" title="Número de documento de identidad" required minlength="1" maxlength="13">
                            </div>
                            <div class="col-lg-12 mb-1 text-center">
                                <span id="clave"></span>
                                <div class="d-grid gap-2">
                                    <button type="button" id="btnClave" class="btn btn-info">Cambio de clave</button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="claveCaja" class="form-label">Clave de Caja</label>
                                <input type="number" class="form-control" id="claveCaja" placeholder="Clave" title="Clave" minlength="4" maxlength="4">
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div class="d-grid gap-2">
                                    <button id="guardar" class="btn btn-primary" type="button">
                                        <i class="bi bi-box"></i>&nbsp;Agregar Trabajador
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <table id="trabajadoresTable"></table>
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
        <script src="resources/js/adminGen.js"></script>
        <script src="resources/js/trabajadores.js"></script>
        <?php
    }
}

$index = new PaginaOnce('Trabajadores', '', '');
echo $index->crearHtml();

?>