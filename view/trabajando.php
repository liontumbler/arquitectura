<?php
if (!$rutasLegitima) {
    header('Location: ../index');
}

@\session_start();
echo $_SESSION['inicioSesion'];

require_once 'view.php';

class PaginaOnce extends Web implements PaginaX
{
    function __construct($title, $description, $keywords)
    {
        parent::__construct($title, $description, $keywords);
    }

    public function nav()
    {
        require_once 'layout/nav.php';
        ?>
        
        <?php
    }

    public function content()
    {
        ?>
        <div class="d-flex">
            <?php require_once 'layout/sidebar.php'; ?>
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
                    <div class="container" style="width: 390px;">
                        
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

    public function footer()
    {
        ?>
        <script src="resources/js/viewIndex.js"></script>

        <script>
            document.getElementById('sideBar').style.display = 'none';
            //document.getElementById('sideBar').style.display = 'block';

            
        </script>
        <?php
    }
}

$index = new PaginaOnce('index titulo', 'descripcion pagina', 'palabras clave');
echo $index->crearHtml();

?>