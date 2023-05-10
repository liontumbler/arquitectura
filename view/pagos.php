<?php
@\session_start();
if (!$rutasLegitima) {
    header('Location: ../index');
} elseif (empty($_SESSION['SesionTrabajador']) || !$_SESSION['SesionTrabajador']){
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

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="ligas-tab" data-bs-toggle="tab" data-bs-target="#ligas" type="button" role="tab" aria-controls="ligas" aria-selected="true">Ligas</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tienda-tab" data-bs-toggle="tab" data-bs-target="#tienda" type="button" role="tab" aria-controls="tienda" aria-selected="false">Tienda</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pagos-tab" data-bs-toggle="tab" data-bs-target="#pagos" type="button" role="tab" aria-controls="pagos" aria-selected="false">Pagos</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="ligas" role="tabpanel" aria-labelledby="ligas-tab">
                            <table id="ligasTable"></table>
                        </div>
                        <div class="tab-pane fade" id="tienda" role="tabpanel" aria-labelledby="tienda-tab">
                            <table id="tiendaTable"></table>
                        </div>
                        <div class="tab-pane fade" id="pagos" role="tabpanel" aria-labelledby="pagos-tab">
                            <table id="pagosTable">
                                <thead>
                                    <tr>
                                    </tr>
                                </thead>
                            </table>
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
            let data = [
                {
                    id: 1,
                    name: 'Item 1',
                    price: '$1',
                    monto: 'eche',
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 'eche',
                    pago: false
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 'eche',
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 'eche',
                    pago: false
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 'eche',
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 'eche',
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 'eche',
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 'eche',
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 'eche',
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 'eche',
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 'eche',
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 'eche',
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 'eche',
                    pago: true
                },
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2',
                    monto: 'eche',
                    pago: true
                }
            ];

            let $table = $('#ligasTable')
            $table.bootstrapTable({
                cache: false,
                height: '460',
                buttonsClass: 'dark',

                buttonsOrder: ['export', 'columns', 'fullscreen'],
                showExport: "true",
                exportDataType: 'all',
                exportTypes: ['csv', 'excel', 'pdf'], //['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
                showFullscreen: "true",
                showColumns: "true",
                showColumnsToggleAll: "true",

                pagination: true,
                paginationVAlign: "both",
                paginationParts: 'pageList',
                pageSize: 5,
                pageList: '[]',

                search: true,
                searchAccentNeutralise: "true",
                searchAlign: "left",

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
                detailView: "true",
                detailFormatter: function(index, row) {
                    console.log(index, row);
                    return 'hola mundo';
                },
                loadingTemplate(message) {
                    return '<div class="ph-item"><div class="ph-picture"></div></div>';
                },
                /*maintainMetaData: true,
                formatter: function(value, row, index) { //?
                    /*if (index === 2) {
                        return {
                            disabled: true
                        }
                    }
                    if (index === 5) {
                        return {
                            disabled: true,
                            checked: true
                        }
                    }
                    return value*//*
                    console.log(value, row, index);
                    return value;
                },*/
                columns: [{
                    field: 'id',
                    title: 'Item ID',
                    halign: 'right',
                    valign: 'middle',
                    align: 'right',
                    searchable: 'false'
                }, {
                    field: 'name',
                    title: 'Item Name'
                }, {
                    field: 'price',
                    title: 'Item Price'
                }, {
                    field: 'monto',
                    title: 'Item Price'
                }, {
                    title: 'pago? <input class="form-check-input" type="checkbox">',
                    field: 'pago',
                    //checkbox: true,
                    //checkboxEnabled: false,
                    align: 'center',
                    valign: 'middle',
                    formatter: function (value, row, index) {
                        //console.log(value, row, index, 'ejecuto alcargar?');
                        let checked = value ? 'checked' : '';
                        return '<input class="form-check-input" type="checkbox" '+checked+'>'
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

$index = new PaginaOnce('Pagos', '', '');
echo $index->crearHtml();

?>