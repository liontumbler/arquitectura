<?php
if (!$rutasLegitima) {
    header('Location: ../index');
}elseif (isset($_SESSION['SesionTrabajador']) && $_SESSION['SesionTrabajador']){
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
            <?php require_once 'layout/sidebar.php'; ?>
            <div id="contentConSidebar">
                <div class="m-4">
                    
                    <div class="container" style="width: 450px;">
                        <div class="row">
                            <?= input_csrf_token(); ?>
                            <div class="col-lg-12 mb-1">
                                <label for="nickname" class="form-label">Nickname *</label>
                                <input type="text" class="form-control" id="nickname" placeholder="Dijite la nickname del trabajador" required minlength="1" maxlength="50">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="clave" class="form-label">Clave *</label>
                                <input type="password" class="form-control" id="clave" placeholder="Dijite la clave del trabajador" required minlength="1" maxlength="50">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="caja" class="form-label">Caja *</label>
                                <input type="number" class="form-control" id="caja" placeholder="Dijite el monto del efectivo" required max="1000000" min="0" value="0">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="trabajar" class="btn btn-primary" type="button">trabajar</button>
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
        <script>
            let validar;
            document.querySelector('body').onload = (e) => {
                console.log('termino de cargar vista');
                validar = new Validardor(['nickname', 'clave' ,'caja']);
                console.log(validar.nickname, validar);
            }

            document.getElementById('trabajar').addEventListener('click', async function(e) {
                let valid = validar.validarCampos()

                console.log(valid, valid.validationMessage);

                
                if(valid && !valid.validationMessage){
                    this.disabled = true;
                    console.log(':)');
                    //console.log(validar.crearFormData());
                    //console.log(validar.crearObjetoJson());

                    let edta = validar.crearObjetoJson();
                    let csrf_token = document.getElementById('csrf_token').value;

                    let rdta = await fetch('controller/ControllerLogin.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            accion: 'Login',
                            data: edta,
                            csrf_token
                        })
                    }).then((res) => {
                        this.disabled = false;
                        if (res.status == 200) {
                            return res.json()
                        }
                    }).catch((res) => {
                        this.disabled = false;
                        console.error(res.statusText);
                        return res;
                    })

                    console.log(rdta, 'login');
                    if(rdta){
                        location.href = 'trabajando';
                    }
                    
                }
            });

            
        </script>
        <?php
    }
}

$index = new PaginaOnce('Login Trabajadores', '', '');
echo $index->crearHtml();

?>