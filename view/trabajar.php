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

    public function crearHtml()
    {
        ?>
        <!DOCTYPE html>
        <html lang="es-CO">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="content-language" content="es-CO">

            <meta name="description" content="<?= $this->description; ?>">
            <meta name="keywords" content="<?= $this->keywords; ?>">

            <title><?= $this->title; ?></title>

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
            
            <style>
                #sideBar{
                    width: 22%;
                    z-index: 1;
                }

                #sideBarrar{
                    width: 280px;
                    height: 92%;
                    position: fixed;
                }

                #sideBarrar ul{
                    display: block;
                }

                #contentConSidebar{
                    width: 78%;
                    display: block;
                    margin: auto;
                }

                body{
                    padding-top: 56px;
                }
            </style>
        </head>

        <body>
            <?= $this->nav(); ?>
            <?= $this->content(); ?>
            <?= $this->footer(); ?>
        </body>

        </html>
        <?php
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
                    
                    <div class="container" style="width: 390px;">
                        <div class="row">
                            <?= input_csrf_token(); ?>
                            <!--div class="col-lg-12">
                                <label for="gimnasio" class="form-label">Gimnasio</label>
                                <select id="gimnasio" class="form-select">
                                    <option selected value="">Seleccione una opcion</option>
                                    <option value="1">pepe</option>
                                    <option value="2">pepa</option>
                                    <option value="3">pepo</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="trabajador" class="form-label">Trabajador</label>
                                <select id="trabajador" class="form-select">
                                    <option selected value="">Seleccione una opcion</option>
                                </select>
                            </div-->
                            <div class="col-lg-12">
                                <label for="nickname" class="form-label">Nickname</label>
                                <input type="password" class="form-control" id="nickname" placeholder="Dijite la nickname del trabajador">
                            </div>
                            <div class="col-lg-12">
                                <label for="clave" class="form-label">Clave</label>
                                <input type="password" class="form-control" id="clave" placeholder="Dijite la clave del trabajador">
                            </div>
                            <div class="col-lg-12">
                                <label for="caja" class="form-label">Caja</label>
                                <input type="number" class="form-control" id="caja" placeholder="Dijite el monto del efectivo">
                            </div>

                            
                            <div class="col-lg-12">
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
        <script src="resources/js/viewIndex.js"></script>

        <script>
            document.getElementById('sideBar').style.display = 'none';
            //document.getElementById('sideBar').style.display = 'block';

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