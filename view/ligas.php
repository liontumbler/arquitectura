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
                                <label for="hora" class="form-label">Hora *</label>
                                <select id="hora" class="form-select" required>
                                    <option selected value="">Seleccione una opción</option>
                                    <option value="5000">30 minutos</option>
                                    <option value="7000">1 hora</option>
                                    <option value="10000">2 horas</option>
                                    <option value="15000">3 horas</option>
                                </select>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <input class="form-check-input" type="checkbox" value="" id="fechaDefault" checked>
                                <label class="form-check-label" for="fechaDefault">
                                    Fecha default
                                </label>
                            </div>
                            <div class="col-lg-12 mb-1" id="divFechaDefault">
                                <label for="fechaInicio" class="form-label">Fecha Y hora de inicio *</label>
                                <input type="datetime-local" class="form-control" id="fechaInicio" placeholder="fecha y hora de inicio" required>
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
                                <label class="form-label">Total: <b id="total"></b></label>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="agregarLiga" class="btn btn-primary" type="button">
                                        <i class="bi bi-alarm"></i>&nbsp;Agregar Liga
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
            let validarForm5;
            let validarForm6;
            let validarForm7;
            let validarForm8;

            document.querySelector('body').onload = (e) => {
                console.log('termino de cargar vista');

                validarForm1 = new Validardor(['cliente', 'hora']);
                validarForm2 = new Validardor(['cliente', 'hora', 'medio']);
                validarForm3 = new Validardor(['cliente', 'hora', 'fechaInicio']);
                validarForm4 = new Validardor(['cliente', 'hora', 'medio', 'fechaInicio']);
                validarForm5 = new Validardor(['nombreYapellido', 'documento', 'equipo', 'hora']);
                validarForm6 = new Validardor(['nombreYapellido', 'documento', 'equipo', 'hora', 'medio']);
                validarForm7 = new Validardor(['nombreYapellido', 'documento', 'equipo', 'hora', 'fechaInicio']);
                validarForm8 = new Validardor(['nombreYapellido', 'documento', 'equipo', 'hora', 'medio', 'fechaInicio']);

                if(document.getElementById('checkCliente').checked){
                    document.getElementById('divClienteNA').style.display = 'none';
                    document.getElementById('divClienteD').style.display = 'none';
                    document.getElementById('divClienteEQ').style.display = 'none';
                }

                if (document.getElementById('fechaDefault').checked) {
                    document.getElementById('divFechaDefault').style.display = 'none';
                }
            }

            document.getElementById('checkCliente').addEventListener('change', function(e) {
                if (this.checked) {
                    document.getElementById('divClienteNA').style.display = 'none';
                    document.getElementById('divClienteD').style.display = 'none';
                    document.getElementById('divClienteEQ').style.display = 'none';
                    document.getElementById('divClientePre').style.display = 'block';
                } else {
                    document.getElementById('divClienteNA').style.display = 'block';
                    document.getElementById('divClienteD').style.display = 'block';
                    document.getElementById('divClienteEQ').style.display = 'block';
                    document.getElementById('divClientePre').style.display = 'none';
                }
            });

            document.getElementById('fechaDefault').addEventListener('change', function(e) {
                if (this.checked)
                    document.getElementById('divFechaDefault').style.display = 'none';
                else
                    document.getElementById('divFechaDefault').style.display = 'block';
            });

            document.getElementById('pago').addEventListener('change', function(e) {
                if (!this.checked)
                    document.getElementById('divpago').style.display = 'none';
                else
                    document.getElementById('divpago').style.display = 'block';
            });

            document.getElementById('hora').addEventListener('change', function(e) {
                if (this.value)
                    document.getElementById('total').textContent = this.value;
                else
                    document.getElementById('total').textContent = '';
            });

            document.getElementById('agregarLiga').addEventListener('click', async function(e) {
                let minDemas = 10;
                //si es mas de las 11 no vender ligas

                let checkCliente = document.getElementById('checkCliente');
                let pago = document.getElementById('pago');
                let fechaDefault = document.getElementById('fechaDefault');
                //console.log(valid, valid.validationMessage);
                let form = '';
                if(checkCliente.checked && pago.checked && fechaDefault.checked){
                    form = validarForm2
                } else if(checkCliente.checked && !pago.checked && fechaDefault.checked){
                    form = validarForm1
                } else if(!checkCliente.checked && !pago.checked && fechaDefault.checked){
                    form = validarForm5
                } else if(!checkCliente.checked && pago.checked && fechaDefault.checked){
                    form = validarForm6
                } else if(checkCliente.checked && !pago.checked && !fechaDefault.checked){
                    form = validarForm3
                } else if(!checkCliente.checked && !pago.checked && !fechaDefault.checked){
                    form = validarForm7
                } else if(!checkCliente.checked && pago.checked && !fechaDefault.checked){
                    form = validarForm8
                } else if(checkCliente.checked && pago.checked && !fechaDefault.checked){
                    form = validarForm4
                }

                let valid = form.validarCampos();
                console.log(valid);
                
                if(valid && !valid.validationMessage){
                    this.disabled = true;
                    let edta = form.crearObjetoJson()
                    if (fechaDefault.checked) {
                        edta['fechaInicio'] = form.obtenerFechaHoraServer((new Date().getTime() + minDemas * 60000));
                    } else {
                        edta['fechaInicio'] = form.obtenerFechaHoraServer(fechaInicio.value, minDemas);
                    }

                    //console.log(edta);

                    let rtda = await fetch('controller/ControllerLigas.php', {
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

                    console.log(rtda);
                }
            });

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

$index = new PaginaOnce('Ligas', '', '');
echo $index->crearHtml();

?>