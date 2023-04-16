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
                if(true){
                    let nickname = document.getElementById('nickname').value;
                    let clave = document.getElementById('clave').value;
                    let caja = document.getElementById('caja').value;
                    let csrf_token = document.getElementById('csrf_token').value;

                    let res = await fetch('controller/ControllerTest.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            accion: 'Datos2',
                            data:{ nickname, clave, caja},
                            csrf_token
                        })
                    }).then((res) => {
                        return res.json()
                    }) 

                    console.log(res, 'csrf_token');
                    
                }
            });

            document.getElementById('caja').addEventListener('input', function (e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            function llenarSelec(data, id) {
                let select = document.getElementById(id);
                select.innerHTML = '';
                select.append(new Option('Seleccione una opcion', ''));
                for (let i = 0; i < data.length; i++) {
                    let op = new Option(data[i].name, data[i].id)
                    select.append(op);
                }
            }
        </script>
        <?php
    }
}

$index = new PaginaOnce('index titulo', 'descripcion pagina', 'palabras clave');
echo $index->crearHtml();

?>