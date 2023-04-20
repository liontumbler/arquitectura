<?php
@\session_start();
if (!$rutasLegitima) {
    header('Location: ../index');
} elseif (!isset($_SESSION['SesionTrabajador']) || !$_SESSION['SesionTrabajador']){
    header('Location: ./index');
}
//session_destroy();
//echo $_SESSION['SesionTrabajador'];

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
                                <input class="form-check-input" type="checkbox" value="" id="checkCliente" checked>
                                <label class="form-check-label" for="checkCliente">
                                    Cliente existe?
                                </label>
                            </div>
                            <div class="col-lg-12 mb-1" id="divClientePre">
                                <label for="cliente" class="form-label">Clientes *</label>
                                <select id="cliente" class="form-select" required>
                                    <option selected value="">Seleccione una opción</option>
                                    <option value="123123">pepe</option>
                                    <option value="701232400">pepa</option>
                                    <option value="234234">papu</option>
                                    <option value="1534234000">3 horas</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-1" id="divClienteNA">
                                <label for="nombreYapellido" class="form-label">Nombre Y Apellido *</label>
                                <input type="text" class="form-control" id="nombreYapellido" placeholder="Nombre Y Apellido del Cliente" title="Nombre Y Apellido del Cliente" required minlength="1" maxlength="50">
                            </div>
                            <div class="col-lg-6 mb-1" id="divClienteD">
                                <label for="documento" class="form-label">Documento *</label>
                                <input type="number" class="form-control" id="documento" placeholder="Documento del Cliente" title="Documento del Cliente" required min="1" max="999999999999">
                            </div>
                            <div class="col-lg-12 mb-1" id="divClienteEQ">
                                <label for="equipo" class="form-label">Equipo</label>
                                <select id="equipo" class="form-select">
                                    <option selected value="">Seleccione una opción</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">BCA</option>
                                    <option value="2">DEVIL'S</option>
                                    <option value="3">NPC</option>
                                </select>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="producto" class="form-label">producto *</label>
                                <select id="producto" class="form-select" required>
                                    <option selected value="">Seleccione una opcion</option>
                                    <option value="5000">papas fritasrisadas</option>
                                    <option value="7000">gaseosa</option>
                                    <option value="10000">dulces</option>
                                    <option value="15000">bubalus</option>
                                </select>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="cantidad" class="form-label">Cantidad *</label>
                                <input type="number" class="form-control" id="cantidad" placeholder="Cantidad del producto" max="20" min="1" max="1000000" value="1" required>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <input class="form-check-input" type="checkbox" value="" id="pago" checked>
                                <label class="form-check-label" for="pago">
                                    Pago?
                                </label>
                            </div>
                            <div class="col-lg-12 mb-1" style="margin-left: 13px;" id="divpago">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medio" id="efectivo" value="efectivo" checked>
                                    <label class="form-check-label" for="efectivo">
                                        Efectivo
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medio" id="digital" value="digital">
                                    <label class="form-check-label" for="digital">
                                        Digital
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="col-lg-12 mb-1">
                                <label class="form-label">Total: <span id="total"></span></label>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="vender" class="btn btn-primary" type="button">
                                        <i class="bi bi-shop"></i>&nbsp;vender
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
            let validarForm1;
            let validarForm2;
            let validarForm3;
            let validarForm4;

            document.querySelector('body').onload = (e) => {
                console.log('termino de cargar vista');

                validarForm1 = new Validardor(['cliente', 'producto' ,'cantidad', 'medio']);
                validarForm2 = new Validardor(['nombreYapellido', 'documento', 'equipo', 'producto' ,'cantidad', 'medio']);
                validarForm3 = new Validardor(['cliente', 'producto' ,'cantidad']);
                validarForm4 = new Validardor(['nombreYapellido', 'documento', 'equipo', 'producto' ,'cantidad']);

                if(document.getElementById('checkCliente').checked){
                    document.getElementById('divClienteNA').style.display = 'none';
                    document.getElementById('divClienteD').style.display = 'none';
                    document.getElementById('divClienteEQ').style.display = 'none';
                }
            }

            document.getElementById('checkCliente').addEventListener('change', function (e) {
                if(this.checked){
                    document.getElementById('divClienteNA').style.display = 'none';
                    document.getElementById('divClienteD').style.display = 'none';
                    document.getElementById('divClienteEQ').style.display = 'none';
                    document.getElementById('divClientePre').style.display = 'block';
                }
                else{
                    document.getElementById('divClienteNA').style.display = 'block';
                    document.getElementById('divClienteD').style.display = 'block';
                    document.getElementById('divClienteEQ').style.display = 'block';
                    document.getElementById('divClientePre').style.display = 'none';
                }
            });
            
            document.getElementById('pago').addEventListener('change', function (params) {
                if(!this.checked)
                    document.getElementById('divpago').style.display = 'none';
                else
                    document.getElementById('divpago').style.display = 'block';
            });

            document.getElementById('producto').addEventListener('change', function (e) {
                if(this.value){
                    let cantidad = document.getElementById('cantidad').value ? parseInt(document.getElementById('cantidad').value) : 0;
                    document.getElementById('total').textContent = this.value * cantidad;
                }
                else
                    document.getElementById('total').textContent = '';
            });

            document.getElementById('cantidad').addEventListener('input', function (e) {
                
                let cantidad = this.value ? parseInt(this.value) : 0;
                document.getElementById('total').textContent = document.getElementById('producto').value * cantidad;
                
            });

            document.getElementById('vender').addEventListener('click', async function (e) {
                let checkCliente = document.getElementById('checkCliente');
                let pago = document.getElementById('pago');
                //console.log(valid, valid.validationMessage);
                let form = '';
                if(checkCliente.checked && pago.checked){
                    form = validarForm1
                }else if(!checkCliente.checked && pago.checked){
                    form = validarForm2
                } else if(checkCliente.checked && !pago.checked){
                    form = validarForm3
                } else if(!checkCliente.checked && !pago.checked){
                    form = validarForm4
                }

                let valid = form.validarCampos();
                if(valid && !valid.validationMessage){
                    this.disabled = true;
                    //console.log(form.crearObjetoJson());
                    let edta = form.crearObjetoJson();
                    let rdta = await fetch('controller/ControllerTienda.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            accion: 'Vender',
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

                    console.log(rdta);
                }
            })
        </script>
        <?php
    }
}

$index = new PaginaOnce('Tienda', '', '');
echo $index->crearHtml();

?>