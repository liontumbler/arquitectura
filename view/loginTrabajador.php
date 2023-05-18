<?php
if (!$rutasLegitima) {
    header('Location: ../index');
}elseif (!empty($_SESSION['SesionTrabajador']) && $_SESSION['SesionTrabajador']){
    header('Location: trabajando');
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
                <div>
                    <div class="container" style="width: 450px; background: #f5f2f2; padding: 25px;">
                        <div class="row">
                            <?= input_csrf_token(); ?>
                            <div class="col-lg-12 mb-1">
                                <img src="resources/img/adminLig.svg" alt="Nocarga" style="width: 190px; display: block; margin: auto;">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="nickname" class="form-label">Nickname *</label>
                                <input type="text" class="form-control" id="nickname" placeholder="Digite la nickname del trabajador" required minlength="1" maxlength="50" textarroba>
                            </div>
                            <div class="col-lg-6 mb-1">
                                <label for="clave" class="form-label">Clave *</label>
                                <input type="password" class="form-control" id="clave" placeholder="Digite la clave del trabajador" required minlength="1" maxlength="50">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label for="caja" class="form-label">Caja *</label>
                                <input type="number" class="form-control" id="caja" placeholder="Digite el monto del efectivo" required max="1000000" min="0" value="0">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <script src="resources/libs/RecaptchaV2/recaptchaV2.js"></script>
                                <div id="recaptcha"></div>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="trabajar" class="btn btn-primary" type="button">Trabajar</button>
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
        <script src="resources/js/loginTrabajador.js"></script>
        <?php
    }
}

$index = new PaginaOnce('Login Trabajadores', '', '');
echo $index->crearHtml();

?>