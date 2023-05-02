<?php
if (!$rutasLegitima) {
    header('Location: ../index');
}elseif (isset($_SESSION['SesionAdmin']) && $_SESSION['SesionAdmin']){
    header('Location: inicioAdmin');
}

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
            <?php require_once 'layout/sidebar.php'; ?>
            <div id="contentConSidebar">
                <div class="m-4">
                    
                    <div class="container" style="width: 450px;">
                        <div class="row">
                            <?= input_csrf_token(); ?>
                            <div class="col-lg-12 mb-1">
                                <label for="nickname" class="form-label">Nickname *</label>
                                <input type="text" class="form-control" id="nickname" placeholder="Dijite la nickname del trabajador" required minlength="1" maxlength="50" textarroba>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="clave" class="form-label">Clave *</label>
                                <input type="password" class="form-control" id="clave" placeholder="Dijite la clave del trabajador" required minlength="1" maxlength="50">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="entrar" class="btn btn-primary" type="button">Entrar</button>
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
        <script src="resources/js/loginAdmin.js"></script>
        <?php
    }
}

$index = new PaginaOnce('Login Del Administrador', '', '');
echo $index->crearHtml();

?>