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
                    
                    <div class="container" style="width: 390px;">
                        <div class="row">
                            <?= input_csrf_token(); ?>
                            <div class="col-lg-12 mb-1">
                                <label for="nombreYapellido" class="form-label">Nombre Y Apellido *</label>
                                <input type="text" class="form-control" id="nombreYapellido" placeholder="Dijite la Nombre Y Apellido del Cliente" maxlength="50" minlength="1">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="producto" class="form-label">producto *</label>
                                <select id="producto" class="form-select">
                                    <option selected value="">Seleccione una opcion</option>
                                    <option value="5000">papas fritasrisadas</option>
                                    <option value="7000">gaseosa</option>
                                    <option value="10000">dulces</option>
                                    <option value="15000">bubalus</option>
                                </select>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" placeholder="Dijite la cantidad del producto" max="20" min="1">
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
                                <label class="form-label">Total: <span id="total"></span></label>
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="vender" class="btn btn-primary" type="button">vender</button>
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
            document.getElementById('sideBar').style.display = 'none';
            //document.getElementById('sideBar').style.display = 'block';
            
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

            document.getElementById('nombreYapellido').addEventListener('input', function (e) {
                this.value = this.value.replace(/[^a-zñ ]/g, '').replace(/\s+/g, ' ');
            });

            
        </script>
        <script src="resources/js/global.js"></script>
        <?php
    }
}

$index = new PaginaOnce('Ligas', '', '');
echo $index->crearHtml();

?>