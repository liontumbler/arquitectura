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
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: false
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: false
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 10000,
                    pago: true
                }
            ];

            let $table = $('#quienDebeTable')
            $table.bootstrapTable({
                cache: false,
                toggle: 'quienDebeTable',
                height: '393',
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
                    halign: 'center',
                    align: 'center',
                    searchable: false,
                    switchable: false,
                    sortable: false,
                }, {
                    field: 'name',
                    title: 'Tipo Deuda',
                    sortable: true,
                    falign: 'center',
                    footerFormatter: function (data) {
                        return 'Nombre del deudor';
                    }
                }, {
                    field: 'monto',//price
                    title: 'Valor',
                    falign: 'center',
                    footerFormatter: function (data) {
                        let field = this.field
                        return '$' + data.map(function (row) {
                            if (row.pago) {
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
                    title: 'Fecha'
                }, {
                    title: 'Pagar',
                    field: 'pago',
                    align: 'center',
                    halign: 'center',
                    formatter: function (value, row, index) {
                        console.log(value, row, index, 'ejecuto alcargar?');
                        let checked = value ? 'checked' : '';
                        return '<input class="form-check-input checkPago" type="checkbox" '+checked+'>'
                    },
                    events: {
                        'click .checkPago': function (e, value, row, index) {
                            row.pago = !row.pago;
                            let total =  '$' + $table.bootstrapTable('getData').map(function (row) {
                                if (row.pago) {
                                    return + row['monto'];
                                }else{
                                    return +0;
                                }
                            }).reduce(function (sum, i) {
                                return sum + i
                            }, 0)

                            $('.fixed-table-footer .th-inner')[2].textContent = total;
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