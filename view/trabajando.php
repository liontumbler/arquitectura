<?php
@\session_start();
if (!$rutasLegitima) {
    header('Location: ../index');
} elseif (!isset($_SESSION['SesionTrabajador']) || !$_SESSION['SesionTrabajador']){
    header('Location: ./index');
}
//session_destroy();
//echo $_SESSION['SesionTrabajador'];//

require_once 'view.php';

class PaginaOnce extends Web implements PaginaX
{
    function __construct($title, $description, $keywords)
    {
        parent::__construct($title, $description, $keywords);
    }

    public function content()
    {
        ?>
        <div class="d-flex">
            <?php require_once 'layout/sidebarTrabajador.php'; ?>
            <div id="contentConSidebar">
                <div class="m-4">
                    <div>
                        <ol>
                            <li>ligas:</li>
                            <li>tienda:</li>
                            <li>caja:</li>
                            <li>pagos:</li>
                            <li>descuentos:-</li>
                            <li>total:</li>
                        </ul>
                    </div>
                    <div class="container" style="width: 450px;">
                        
                        <div class="row">
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="ligas" class="btn btn-primary" type="button">Ligas</button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="tienda" class="btn btn-primary" type="button">Tienda</button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="descuento" class="btn btn-secondary" type="button">Descuento</button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div class="d-grid gap-2">
                                    <button id="pagos" class="btn btn-secondary" type="button">pagos</button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="quienDebe" class="btn btn-info" type="button">Quien Debe</button>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="terminar" class="btn btn-danger" type="button">Terminar</button>
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
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <a href="javascript:" class="navbar-brand" id="btnSidebar">Gimnasios</a>
            </div>
        </nav>
    <?php
    }

    public function footer()
    {
        ?>
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
            })
        </script>
        <?php
    }
}

$index = new PaginaOnce('DashBoard Trabajadores', '', '');
echo $index->crearHtml();

?>