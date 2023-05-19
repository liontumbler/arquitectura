<?php
if (!$rutasLegitima) {
    header('Location: ../index');
}elseif (!empty($_SESSION['SesionAdmin']) && $_SESSION['SesionAdmin']){
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
            
            <div id="contentConSidebar">
                <div class="m-4">
                    <div class="container shadow carLoguin">
                        <div class="row">
                            <?= input_csrf_token(); ?>
                            <div class="col-lg-12 mb-1">
                                <img src="resources/img/adminLig.svg" alt="Nocarga" class="imgLoguin">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="nickname" class="form-label">Nickname *</label>
                                <input type="text" class="form-control" id="nickname" placeholder="Digite la nickname del trabajador" required minlength="1" maxlength="50" textarroba>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label for="clave" class="form-label">Clave *</label>
                                <input type="password" class="form-control" id="clave" placeholder="Digite la clave del trabajador" required minlength="1" maxlength="50">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <script src="resources/libs/RecaptchaV2/recaptchaV2.js"></script>
                                <div id="recaptcha"></div>
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