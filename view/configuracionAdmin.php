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
                    <div class="container">
                        <div class="row">
                            <?= input_csrf_token(); ?>
                            <div class="col-lg-12 text-center">
                                Nombre del plan idPlan
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-1">
                                <span id="clave"></span>
                                <div class="d-grid gap-2">
                                    <button type="button" id="btnClave" class="btn btn-info">Cambio de clave</button>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-1">
                                <input class="form-check-input" type="checkbox" value="" id="habilitado" disabled>
                                <label class="form-check-label" for="habilitado">
                                    Habilitado
                                </label>
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-1">
                                <label for="correo" class="form-label">correo *</label>
                                <input type="text" class="form-control" id="correo" placeholder="Correo del gimnasio" title="Correo del gimnasio" required minlength="1" maxlength="100">
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-1">
                                <label for="nickname" class="form-label">nickname</label>
                                <input type="text" class="form-control" id="nickname" placeholder="NickName login" title="NickName login" disabled>
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-1">
                                <label for="color" class="form-label">Color letra*</label>
                                <input type="color" class="form-control form-control-color" id="color" title="Color de letra" required>
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-1">
                                <label for="background" class="form-label">Color barras *</label>
                                <input type="color" class="form-control form-control-color" id="background" title="Color de barras" required>
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-1">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Nombre del gimnasio" title="Nombre del gimnasio" required minlength="1" maxlength="100">
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-1">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" placeholder="Dirección del gimnasio" title="Dirección del gimnasio" minlength="1" maxlength="100">
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-1">
                                <label for="telefono" class="form-label">teléfono *</label>
                                <input type="text" class="form-control" id="telefono" placeholder="Telefono del gimnasio" title="Telefono del gimnasio" required minlength="1" maxlength="100">
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-1">
                                <label for="minDeMasLiga" class="form-label">Minutos de más de liga *</label>
                                <input type="number" class="form-control" id="minDeMasLiga" placeholder="minutos de mas para la liga" title="minutos de mas para la liga" required minlength="1" maxlength="60">
                            </div>
                            <div class="col-sm-12 mb-1">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" rows="3" minlength="1" maxlength="150"></textarea>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div class="d-grid gap-2">
                                    <button id="guardarConfiguracion" class="btn btn-primary" type="button">
                                        <i class="bi bi-box"></i>&nbsp;Guardar Configuración
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
    {/*<?= $this->color; ?>*/
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
        <script src="resources/js/configuracion.js"></script>
        <?php
    }
}

$index = new PaginaOnce('Configuracion Admin', '', '');
echo $index->crearHtml();

?>