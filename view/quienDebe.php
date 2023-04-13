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

    public function footer()
    {
    ?>
        <script>
            document.getElementById('sideBar').style.display = 'none';
            //document.getElementById('sideBar').style.display = 'block';

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
                //clickToSelect: "true",//selecionar el chech desde cualquiercolumna
                classes: 'table table-striped',
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
                    searchable: 'false'
                }, {
                    field: 'tipo',
                    title: 'Tipo Deuda',
                    footerFormatter: function (data) {
                        return 'nombre deldeudor';
                    }
                }, {
                    field: 'monto',//price
                    title: 'Valor',
                    footerFormatter: function (data) {
                        let field = this.field
                        return '$' + data.map(function (row) {
                            return + row[field];
                        }).reduce(function (sum, i) {
                            return sum + i
                        }, 0)
                    }
                }, {
                    field: 'fecha',
                    title: 'Fecha'
                }, {
                    title: 'Pagar',
                    field: 'pago',
                    align: 'center',
                    valign: 'middle',
                    formatter: function (value, row, index) {
                        console.log(value, row, index, 'ejecuto alcargar?');
                        let checked = value ? 'checked' : '';
                        return '<input class="form-check-input" type="checkbox" '+checked+'>'
                    },
                    footerFormatter: function (data) {
                        return '<button type="button" class="btn btn-success">Pagar</button>';
                    }
                }],

                data: data
            })

            //$table.bootstrapTable('showLoading');//bootstrapTable('destroy').bootstrapTable()
            //$table.bootstrapTable('hideColumn', 'monto')
            //$table.bootstrapTable('showColumn', 'monto')
            //$table.bootstrapTable('getSelections')

            $table.on('all.bs.table', function(e, name, args) {
                console.log(name, args)
            })
        </script>
<?php
    }
}

$index = new PaginaOnce('index titulo', 'descripcion pagina', 'palabras clave');
echo $index->crearHtml();

?>