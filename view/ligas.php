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
        <!--div id="cargando" style="width: 100%; height: 100%; position: fixed; background: #000000db; top: 0; z-index: 1031; display: flex; align-items: center;">
            <div class="text-center" style="display: block;margin: auto;">
                <div class="spinner-border text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h2 style="color: #fff;">Cargando...</h2>
            </div>
        </div-->
        <div class="d-flex">
            <?php require_once 'layout/sidebar.php'; ?>
            <div id="contentConSidebar">
                <div class="m-4">
                    
                    <div class="container" style="width: 450px;">
                        <div class="row">
                            <?= input_csrf_token(); ?>
                            <div class="col-lg-12 mb-1">
                                <input class="form-check-input" type="checkbox" value="" id="cliente" checked>
                                <label class="form-check-label" for="cliente">
                                    Cliente existe?
                                </label>
                            </div>
                            <div class="col-lg-12 mb-1" id="divClientePre">
                                <label for="cliente" class="form-label">Clientes*</label>
                                <select id="cliente" class="form-select">
                                    <option selected value="">Seleccione una opción</option>
                                    <option value="123123">pepe</option>
                                    <option value="701232400">pepa</option>
                                    <option value="234234">papu</option>
                                    <option value="1534234000">3 horas</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-1" id="divClienteNA">
                                <label for="nombreYapellido" class="form-label">Nombre Y Apellido *</label>
                                <input type="text" class="form-control" id="nombreYapellido" placeholder="Nombre Y Apellido del Cliente" title="Nombre Y Apellido del Cliente">
                            </div>
                            <div class="col-lg-6 mb-1" id="divClienteD">
                                <label for="documento" class="form-label">Documento *</label>
                                <input type="text" class="form-control" id="documento" placeholder="Documento del Cliente" title="Documento del Cliente">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="hora" class="form-label">Hora *</label>
                                <select id="hora" class="form-select">
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
                                <input type="datetime-local" class="form-control" id="fechaInicio" placeholder="fecha y hora de inicio">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <input class="form-check-input" type="checkbox" value="" id="pago" checked>
                                <label class="form-check-label" for="pago">
                                    Pago?
                                </label>
                            </div>
                            <div class="col-lg-12 mb-1" style="margin-left: 13px;" id="divpago">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medio" id="digital">
                                    <label class="form-check-label" for="digital">
                                        Digital
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medio" id="efectivo" checked>
                                    <label class="form-check-label" for="efectivo">
                                        Efectivo
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="col-lg-12 mb-1">
                                <label class="form-label">Total: <b id="total"></b></label>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="agregarLiga" class="btn btn-primary" type="button">Agregar Liga</button>
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
            if(document.getElementById('cliente').checked){
                document.getElementById('divClienteNA').style.display = 'none';
                document.getElementById('divClienteD').style.display = 'none';
            }

            document.getElementById('cliente').addEventListener('change', function (e) {
                if(this.checked){
                    document.getElementById('divClienteNA').style.display = 'none';
                    document.getElementById('divClienteD').style.display = 'none';
                    document.getElementById('divClientePre').style.display = 'block';
                }
                else{
                    document.getElementById('divClienteNA').style.display = 'block';
                    document.getElementById('divClienteD').style.display = 'block';
                    document.getElementById('divClientePre').style.display = 'none';
                }
            });

            if(document.getElementById('fechaDefault').checked){
                document.getElementById('divFechaDefault').style.display = 'none';
            }
            
            document.getElementById('fechaDefault').addEventListener('change', function (e) {
                if(this.checked)
                    document.getElementById('divFechaDefault').style.display = 'none';
                else
                    document.getElementById('divFechaDefault').style.display = 'block';
            });

            document.getElementById('pago').addEventListener('change', function (e) {
                if(!this.checked)
                    document.getElementById('divpago').style.display = 'none';
                else
                    document.getElementById('divpago').style.display = 'block';
            });

            document.getElementById('hora').addEventListener('change', function (e) {
                console.log('hoe');
                if(this.value)
                    document.getElementById('total').textContent = this.value;
                else   
                    document.getElementById('total').textContent = '';
            });

            function llenarSelec(data, id) {
                let select = document.getElementById(id);
                select.innerHTML = '';
                select.append(new Option('Seleccione una opción', ''));
                for (let i = 0; i < data.length; i++) {
                    let op = new Option(data[i].name, data[i].id)
                    select.append(op);
                }
            }
        </script>
        <?php
    }
}

$index = new PaginaOnce('Ligas', '', '');
echo $index->crearHtml();

?>