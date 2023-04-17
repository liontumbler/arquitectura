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
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="quienDebe-tab" data-bs-toggle="tab" data-bs-target="#quienDebe" type="button" role="tab" aria-controls="quienDebe" aria-selected="true">Quien debe</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="quienDebe" role="tabpanel" aria-labelledby="quienDebe-tab">
                            <div class="row g-3 mt-3">
                                <div class="col-lg-4">
                                    <label for="buscarDeudor" class="visually-hidden">Buscar Deudor</label>
                                    <input type="text" class="form-control" id="buscarDeudor" placeholder="nombre y apellido del deudor">
                                </div>
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary mb-3">Buscar</button>
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
        # code... nuevo nav con otras opciones
    }

    public function footer()
    {
    ?>
        <script>
            let data = [
                {
                    id: 1,
                    name: 'Item 1',
                    price: '$1',
                    monto: 10000,
                    pago: 'debe'
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: 'pazYsalvoEfectivo'
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: 'debe'
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: 'pazYsalvoDigital'
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: 'digital'
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: 'efectivo'
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: 'debe'
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: 'debe'
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: 'debe'
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: 'debe'
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: 'debe'
                },
                {
                    id: 2,
                    name: 'Item 2wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww',
                    price: '$2',
                    monto: 10000,
                    pago: 'debe'
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: 'debe'
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: 'debe'
                }
            ];

            let $table = $('#quienDebeTable')
            $table.bootstrapTable({
                cache: false,
                toggle: 'quienDebeTable',
                buttonsClass: 'dark',
                buttonsOrder: ['export', 'columns', 'fullscreen'],
                classes: 'table table-striped',

                showExport: "true",
                exportDataType: 'all',
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
                    //width: '100',
                    //widthUnit: 'px',
                    halign: 'center',
                    align: 'center',
                    searchable: false,
                    switchable: false,
                    sortable: false,
                }, {
                    field: 'name',
                    title: 'Tipo Deuda',
                    width: '150',
                    widthUnit: 'px',
                    sortable: true,
                    falign: 'center',
                    footerFormatter: function (data) {
                        return 'Nombre del deudor';
                    },
                    formatter: function (value, row, index) {
                        return '<div style="width: inherit; overflow:hidden; white-space:nowrap; text-overflow: ellipsis;">'
                            +row.name+
                        '</div>';
                    },
                }, {
                    field: 'monto',//price
                    title: 'Valor',
                    //width: '100',
                    //widthUnit: 'px',
                    falign: 'center',
                    footerFormatter: function (data) {
                        let field = this.field
                        return '$' + data.map(function (row) {
                            
                            
                            if (row.pago == 'debe') {
                                return + row[field];
                            }else{
                                return +0;
                            }
                        }).reduce(function (sum, i) {
                            return sum + i
                        }, 0)
                    }
                }, {
                    field: 'price',
                    title: 'Fecha',
                    //width: '100',
                    //widthUnit: 'px',
                    footerFormatter: function (data) {
                        return `<div class="d-grid gap-2">
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
                        </div>`;
                    }
                }, {
                    title: 'Pagar',
                    field: 'pago',
                    //width: '100',
                    //widthUnit: 'px',
                    align: 'center',
                    halign: 'center',

                    formatter: function (value, row, index) {
                        //console.log(value, row, index, 'ejecuto alcargar?');
                        let checked = '';
                        //if (value == 'debe') {
                            checked = 'checked'
                            row.pago = 'pazYsalvoEfectivo'
                            /*let medio = document.querySelector('input[name="medio"]:checked').id;
                            console.log(medio);
                            if (medio == 'efectivo') {
                                row.pago = 'pazYsalvoEfectivo'
                            }else if (medio == 'digital') {
                                row.pago ='pazYsalvoDigital'
                            }*/
                        //}
                        
                        return '<input class="form-check-input checkPago" type="checkbox" '+checked+'>'
                    },
                    events: {
                        'click .checkPago': function (e, value, row, index) {
                            console.log(value, row, index, 'chech', this);

                            let medio = document.querySelector('input[name="medio"]:checked').id;
                            console.log(medio);
                            if (row.pago.indexOf('debe') >= 0) {//row.pago.indexOf('pazYsalvo') >= 0
                                if (medio == 'efectivo') {
                                    row.pago = 'pazYsalvoEfectivo'
                                }else if (medio == 'digital') {
                                    row.pago ='pazYsalvoDigital'
                                }
                            }else{
                                row.pago = 'debe'
                            }
                            console.log('row.pago', row.pago);

                            let total =  '$' + $table.bootstrapTable('getData').map(function (rw) {

                                if (rw.pago.indexOf('debe') < 0) {//rw.pago.indexOf('pazYsalvo') >= 0
                                    if (medio == 'efectivo') {
                                        rw.pago = 'pazYsalvoEfectivo'
                                    }else if (medio == 'digital') {
                                        rw.pago ='pazYsalvoDigital'
                                    }

                                    return + rw['monto'];
                                }else{
                                    return +0;
                                }
                            }).reduce(function (sum, i) {
                                return sum + i
                            }, 0)

                            //$('.fixed-table-footer .th-inner')[2].textContent = total;
                            $('tfoot .th-inner')[2].textContent = total;
                            
                        },
                    },
                    footerFormatter: function (data) {
                        return `<div class="d-grid gap-2">
                        <button type="button" class="btn btn-success" id="checkPagar">Pagar</button>
                        </div>`;
                    }
                }],

                data: data
            });

            $('#checkPagar').on('click', function (e) {
                console.log('pago');
            })

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

$index = new PaginaOnce('index titulo', 'descripcion pagina', 'palabras clave');
echo $index->crearHtml();

?>