<?php
@\session_start();
if (!$rutasLegitima) {
    header('Location: ../index');
} elseif (!isset($_SESSION['SesionTrabajador']) || !$_SESSION['SesionTrabajador']){
    header('Location: ./index');
}

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
                    <?= input_csrf_token(); ?>
                    <?= password_verify(sha1('admin'), '$2y$11$mjwkbMoRVY/tlZ9ttblRzOomcrFL2JhbGJRz1bpEPcrr9Pn/NtYHy'); ?>
                    
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="quienDebe-tab" data-bs-toggle="tab" data-bs-target="#quienDebe" type="button" role="tab" aria-controls="quienDebe" aria-selected="true">Quien debe</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="quienDebe" role="tabpanel" aria-labelledby="quienDebe-tab">
                            <div class="row g-3 mt-3">
                                <div class="col-lg-2 col-sm-4">
                                    <label for="cliente" class="visually-hidden">Clientes</label>
                                    <select id="cliente" class="form-select">
                                        <option selected value="">Seleccione una opción</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-4">
                                    <label for="documento" class="visually-hidden">Documento</label>
                                    <input type="number" class="form-control" id="documento" placeholder="Documento" min="1" max="999999999999">
                                </div>
                                <div class="col-lg-2 col-sm-4 d-grid gap-2">
                                    <button type="button" class="btn btn-primary mb-3" id="buscar">Buscar</button>
                                </div>
                            </div>
                            <table id="quienDebeTable"></table>
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
                    let validarForm1;

                    let resCli = cargarClientes();
                    let $table = $('#quienDebeTable')

                    resCli.then(function () {
                        validarForm1 = new Validardor(['cliente', 'documento']);
                    })
                    
                    document.getElementById('buscar').addEventListener('click', async function(e) {

                        let valid = validarForm1.validarCampos();
                        console.log(valid);
                        if(valid && !valid.validationMessage){
                            this.disabled = true;

                            let edta = validarForm1.crearObjetoJson()
                            console.log(edta);
                            let rest = await fetch('controller/ControllerQuienDebe.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    accion: 'OptenerDeudor',
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

                            console.log(rest);

                            crearTabla(rest);
                        }
                    })

                    function crearTabla(dataT) {
                        $table.bootstrapTable({
                            cache: false,
                            //toggle: 'quienDebeTable',
                            buttonsClass: 'dark',
                            buttonsOrder: ['export', 'columns', 'fullscreen'],
                            classes: 'table table-striped',

                            showExport: "true",
                            exportDataType: '',
                            exportTypes: ['csv', 'excel', 'pdf'], //['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
                            showFullscreen: "true",

                            showColumns: "true",
                            showColumnsSearch: "true",
                            showColumnsToggleAll: "true",

                            pagination: false,
                            paginationParts: 'pageList',

                            showFooter: true,

                            //locale: 'es-CO'
                            formatNoMatches: function() {
                                return "No se encontraron registros coincidentes"
                            },
                            formatSearch: function() {
                                return "Buscar"
                            },
                            formatColumnsToggleAll: function() {
                                return "Mostrar Todo"
                            },
                            loadingTemplate(message) {
                                return '<div class="ph-item"><div class="ph-picture"></div></div>';
                            },
                            columns: [{
                                field: 'id',
                                title: 'Id',
                                width: '100',
                                widthUnit: 'px',
                                halign: 'center',
                                align: 'center',
                                searchable: false,
                                switchable: false,
                                sortable: false,
                            }, {
                                field: 'tipoDeuda',
                                title: 'Tipo Deuda',
                                width: '150',
                                widthUnit: 'px',
                                sortable: true,
                                falign: 'center',
                                footerFormatter: function(data) {
                                    return 'Nombre del deudor';
                                },
                                formatter: function(value, row, index) {
                                    return '<div style="width: inherit; overflow:hidden; white-space:nowrap; text-overflow: ellipsis;">' +
                                        row.tipoDeuda +
                                        '</div>';
                                },
                            }, {
                                field: 'descripcion',
                                title: 'descripcion',
                                width: '100',
                                widthUnit: 'px',
                                halign: 'center',
                                align: 'center',
                                sortable: true,
                            }, {
                                field: 'total',
                                title: 'Valor',
                                width: '100',
                                widthUnit: 'px',
                                falign: 'center',
                                footerFormatter: function(data) {
                                    let field = this.field
                                    return '$' + data.map(function(row) {
                                        if (row.tipoPago != 'debe') {
                                            return +row[field];
                                        } else {
                                            return +0;
                                        }
                                    }).reduce(function(sum, i) {
                                        return sum + i
                                    }, 0)
                                }
                            }, {
                                field: 'fecha',
                                title: 'Fecha',
                                width: '215',
                                widthUnit: 'px',
                                footerFormatter: function(data) {
                                    return `<div class="gap-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tipoPago" id="efectivo" value="efectivo" checked>
                                            <label class="form-check-label" for="efectivo">
                                                Efectivo
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tipoPago" id="digital" value="digital">
                                            <label class="form-check-label" for="digital">
                                                Digital
                                            </label>
                                        </div>
                                    </div>`;
                                }
                            }, {
                                title: 'Pagar',
                                field: 'tipoPago',
                                width: '100',
                                widthUnit: 'px',
                                align: 'center',
                                halign: 'center',

                                formatter: function(value, row, index) {
                                    //console.log(value, row, index, 'ejecuto alcargar?');
                                    let checked = '';
                                    if (value == 'debe') {
                                        checked = 'checked'
                                        row.tipoPago = true
                                    }

                                    return '<input class="form-check-input checkPago" type="checkbox" ' + checked + '>'
                                },
                                events: {
                                    'click .checkPago': function(e, value, row, index) {
                                        row.tipoPago = !row.tipoPago

                                        let total = '$' + $table.bootstrapTable('getData').map(function(rw) {
                                            if (rw.tipoPago) {
                                                return +rw.total;
                                            } else {
                                                return +0;
                                            }
                                        }).reduce(function(sum, i) {
                                            return sum + i
                                        }, 0)

                                        //$('.fixed-table-footer .th-inner')[2].textContent = total;
                                        $('tfoot .th-inner')[3].textContent = total;
                                    },
                                },
                                footerFormatter: function(data) {
                                    return `<div class="d-grid gap-2">
                                    <button type="button" class="btn btn-success" id="checkPagar">Pagar</button>
                                    </div>`;
                                }
                            }],

                            data: dataT
                        });

                        document.getElementById('checkPagar').addEventListener('click', function(e) {
                            /*pasar php
                            let tipoPago = document.querySelector('input[name="tipoPago"]:checked').id;
                            for (const i in dta) {
                                console.log(dta[i]);

                                const frw = dta[i];
                                if (frw.pago) {
                                    if (tipoPago == 'efectivo') {
                                        frw.pago = 'pazYsalvoEfectivo'
                                    }else if (tipoPago == 'digital') {
                                        frw.pago ='pazYsalvoDigital'
                                    }
                                    fdta.push(frw)
                                    frw.pago = true
                                }else{
                                    frw.pago = 'debe'
                                    fdta.push(frw)
                                    frw.pago = false
                                }
                            }
                            for (let i = 0; i < dta.length; i++) {
                                console.log(frw);

                                const frw = dta[i];
                                if (frw.pago) {
                                    if (tipoPago == 'efectivo') {
                                        frw.pago = 'pazYsalvoEfectivo'
                                    }else if (tipoPago == 'digital') {
                                        frw.pago ='pazYsalvoDigital'
                                    }
                                    
                                }else{
                                    frw.pago = 'debe'
                                }
                            }*/

                            //fdta = fdta.filter(rw => rw.pago != 'debe');

                            let dta = $table.bootstrapTable('getData').filter(rw => rw.tipoPago != false);
                            let tipoPago = document.querySelector('input[name="tipoPago"]:checked').value
                            let total = document.querySelectorAll('tfoot .th-inner')[3].textContent.replace('$', '');

                            dta.push({'pago': tipoPago, 'idCliente': document.getElementById('cliente').value});
                            console.log(dta, tipoPago, total);
                            msgClave(async function () {
                                let rdta = await fetch('controller/ControllerQuienDebe.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        accion: 'Pagar',
                                        data: dta,
                                        csrf_token: document.getElementById('csrf_token').value
                                    })
                                }).then((res) => {
                                    this.disabled = false;
                                    if (res.status == 200) {
                                        return res.json()
                                    }
                                }).catch((res) => {
                                    this.disabled = false;
                                    //console.error(res.statusText);
                                    return res;
                                })

                                console.log(rdta);
                            }, location.href)
                        });
                    }
                })();
            }
            
            //$table.bootstrapTable('showLoading');
            //$table.bootstrapTable('hideLoading');
            //$table.bootstrapTable('hideColumn', 'monto')
            //$table.bootstrapTable('showColumn', 'monto')
            //$table.bootstrapTable('removeAll')
            //$table.bootstrapTable('insertRow', {index: 1, row: row})
            //$table.bootstrapTable('getRowByUniqueId', 1)
            //$table.bootstrapTable('getData')
        </script>
    <?php
    }
}

$index = new PaginaOnce('Quien Debe', '', '');
echo $index->crearHtml();

?>