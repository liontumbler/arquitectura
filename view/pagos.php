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
                            <table id="pagosTable"></table>
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

            $('#ligasTable').bootstrapTable({
                cache: false,
                toggle: 'ligasTable',
                height: '460',
                pagination: true,
                pageSize: 5,
                pageList: '[]',
                search: true,
                searchAccentNeutralise: "true",
                searchAlign: "left",
                formatNoMatches: function() {
                    return "No se encontraron registros coincidentes"
                },
                formatSearch: function() {
                    return "Buscar"
                },
                formatShowingRows: function(t, e, i, n) {
                    return void 0 !== n && n > 0 && n > i ? "Showing ".concat(t, " to ").concat(e, " of ").concat(i, " rows (filtered from ").concat(n, " total rows)") : "Resultados ".concat(t, " de ").concat(e, " de ").concat(i, " totales")
                },
                columns: [{
                    field: 'id',
                    title: 'Item ID',
                    halign: 'right',
                    align: 'right',
                    searchable: 'false'
                }, {
                    field: 'name',
                    title: 'Item Name'
                }, {
                    field: 'price',
                    title: 'Item Price'
                }],


                data: [{
                    id: 1,
                    name: 'Item 1',
                    price: '$1'
                }, 
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2'
                }, 
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2'
                }, 
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2'
                }, 
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2'
                }, 
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2'
                }, 
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2'
                }, 
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2'
                }, 
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2'
                }, 
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2'
                }, 
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2'
                }, 
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2'
                }, 
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2'
                }, 
                {
                    id: 2,
                    name: 'Item 2',
                    price: '$2'
                }]
            })
        </script>
        <?php
    }
}

$index = new PaginaOnce('index titulo', 'descripcion pagina', 'palabras clave');
echo $index->crearHtml();

?>