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

                    <div class="container" style="width: 450px;">
                        <div class="row">
                            <?= input_csrf_token(); ?>
                            <div class="col-lg-12 mb-1">
                                <label for="titulo" class="form-label">Titulo *</label>
                                <input type="text" class="form-control" id="titulo" placeholder="Titulo" title="Titulo" required minlength="1" maxlength="50">
                            </div>

                            <div class="col-lg-12 mb-1">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" rows="3" minlength="1" maxlength="150"></textarea>
                            </div>
                            
                            <div class="col-lg-12 mb-1">
                                <label for="total" class="form-label">Total *</label>
                                <input type="number" class="form-control" id="total" placeholder="Total" title="Total" required min="1" max="1000000">
                            </div>

                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="agregarDescuento" class="btn btn-primary" type="button">
                                        <i class="bi bi-dash"></i>&nbsp;Agregar Descuento
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
    {
    ?>
        <style>
            .navbar {
                color: <?= $_SESSION['color']; ?> !important;
                background: <?= $_SESSION['background']; ?> !important;
            }
            #sideBarrar {
                color: <?= $_SESSION['color']; ?> !important;
                background: <?= $_SESSION['background']; ?> !important;
            }
        </style>
    <?php
    }

    public function libsJS()
    {
        ?>
        <script src="resources/js/trabajadorGen.js"></script>
        <script>
            document.querySelector('body').onload = (e) => {
                (function () {

                    console.log('termino de cargar vista');

                    let validarForm = new Validardor(['titulo', 'descripcion', 'total']);

                    document.getElementById('agregarDescuento').addEventListener('click', async function(e) {
                        let valid = validarForm.validarCampos();
                        console.log(valid);
                        
                        if(valid && !valid.validationMessage){
                            this.disabled = true;

                            let edta = validarForm.crearObjetoJson()

                            let rtda = await fetch('controller/ControllerDescuento.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    accion: 'Descontar',
                                    data: edta,
                                    csrf_token: document.getElementById('csrf_token').value
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

                            console.log(rtda);

                        }
                    });
                })();
            }

            

            /*function llenarSelec(data, id) {
                let select = document.getElementById(id);
                select.innerHTML = '';
                select.append(new Option('Seleccione una opción', ''));
                for (let i = 0; i < data.length; i++) {
                    let op = new Option(data[i].name, data[i].id)
                    select.append(op);
                }
            }*/
        </script>
<?php
    }
}

$index = new PaginaOnce('Descuentos', '', '');
echo $index->crearHtml();

?>