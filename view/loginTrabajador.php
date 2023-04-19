<?php
if (!$rutasLegitima) {
    header('Location: ../index');
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
                                <label for="nickname" class="form-label">Nickname</label>
                                <input type="password" class="form-control" id="nickname" placeholder="Dijite la nickname del trabajador">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="clave" class="form-label">Clave</label>
                                <input type="password" class="form-control" id="clave" placeholder="Dijite la clave del trabajador">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="caja" class="form-label">Caja</label>
                                <input type="number" class="form-control" id="caja" placeholder="Dijite el monto del efectivo" max="1000000">
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
            document.getElementById('trabajar').addEventListener('click', async function(e) {
                this.disabled = true;
                if(true){
                    let nickname = document.getElementById('nickname').value;
                    let clave = document.getElementById('clave').value;
                    let caja = document.getElementById('caja').value;
                    let csrf_token = document.getElementById('csrf_token').value;

                    let rdta = await fetch('controller/ControllerLogin.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            accion: 'Login',
                            data:{ nickname, clave, caja},
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
                    
                }
            });

            document.getElementById('caja').addEventListener('input', function (e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            
        </script>
        <?php
    }
}

$index = new PaginaOnce('Login Trabajadores', '', '');
echo $index->crearHtml();

?>