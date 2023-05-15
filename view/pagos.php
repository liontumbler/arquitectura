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
    private $color;
    private $background;
    function __construct($title, $description, $keywords)
    {
        parent::__construct($title, $description, $keywords);
        $this->color = $this->model('ModelAdmin', 'obtenerColorGim', $_SESSION['SesionTrabajador']['gimnasioId']);
        $this->background = $this->model('ModelAdmin', 'obtenerBackgroundGim', $_SESSION['SesionTrabajador']['gimnasioId']);
    }

    public function content()
    {
    ?>
        <div class="d-flex">
            <?php require_once 'layout/sidebarTrabajador.php'; ?>
            <div id="contentConSidebar">
                <div class="m-4">
                    <?= input_csrf_token(); ?>
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
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="descuentos-tab" data-bs-toggle="tab" data-bs-target="#descuentos" type="button" role="tab" aria-controls="descuentos" aria-selected="false">Descuentos</button>
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
                        <div class="tab-pane fade" id="descuentos" role="tabpanel" aria-labelledby="descuentos-tab">
                            <table id="descuentosTable"></table>
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
                color: <?= $this->color; ?> !important;
                background: <?= $this->background; ?> !important;
            }
            #sideBarrar {
                color: <?= $this->color; ?> !important;
                background: <?= $this->background; ?> !important;
            }
        </style>
        <?php
    }

    public function libsJS()
    {
        ?>
        <script src="resources/js/trabajadorGen.js"></script>
        <script>

            async function cargarLigasCaja() {
                return await fetch('controller/ControllerPagos.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        accion: 'CargarLigasCaja',
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
            }

            async function cargarTiendaCaja() {
                return await fetch('controller/ControllerPagos.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        accion: 'CargarTiendaCaja',
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
            }

            async function cargarPagosCaja() {
                return await fetch('controller/ControllerPagos.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        accion: 'CargarPagosCaja',
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
            }

            async function cargarDescuentos() {
                return await fetch('controller/ControllerPagos.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        accion: 'CargarDescuentos',
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
            }

            let data;
            let $table = $('#ligasTable')
            cargarLigasCaja().then(async (dta) => {
                let limite = dta.length-1;
                let i = 0;
                for (const dt of dta) {
                    let id = dt.idCliente;
                    let nombreCliente = await fetch('controller/ControllerPagos.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            accion: 'CargarNombreCliente',
                            data:{id},
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
                    });

                    dt.idCliente = nombreCliente;

                    if (limite == i) {
                        data = dta;

                        $table.bootstrapTable({
                            cache: false,
                            buttonsClass: 'dark',

                            buttonsOrder: ['export', 'columns', 'fullscreen'],
                            showExport: "true",
                            exportDataType: 'all',
                            exportTypes: ['csv', 'excel', 'pdf'], //['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
                            showFullscreen: "true",
                            showColumns: "true",
                            showColumnsToggleAll: "true",

                            pageList: '[]',

                            search: true,
                            searchAccentNeutralise: "true",
                            searchAlign: "left",

                            showFooter: true,

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
                                console.log(index, row, 'asd');
                                return `
                                    <spam><strong>Cliente:</strong> `+row.idCliente+`</spam><br>
                                    <spam><strong>Inicio:</strong> `+row.fechaInicio+`</spam>
                                    <spam><strong>Fin:</strong> `+row.fechaFin+`</spam>
                                    <br>
                                    <spam><strong>Medio de pago:</strong> `+row.tipoPago+`</spam><br>
                                    <spam><strong>Total:</strong> `+row.total+`</spam><br>
                                `;
                            },
                            loadingTemplate(message) {
                                return '<div class="ph-item"><div class="ph-picture"></div></div>';
                            },
                            columns: [{
                                field: 'id',
                                title: 'ID',
                                halign: 'center',
                                valign: 'middle',
                                align: 'center',
                                searchable: 'false'
                            }, {
                                field: 'idCliente',
                                title: 'Cliente'
                            }, {
                                field: 'fechaInicio',
                                title: 'Inicio'
                            },{
                                field: 'fechaFin',
                                title: 'Fin'
                            }, {
                                field: 'total',
                                title: 'Precio',
                                falign: 'center',
                                halign: 'center',
                                align: 'center',
                                footerFormatter: function(data) {
                                    let field = this.field
                                    return '$' + data.map(function(row) {
                                        return +row[field];
                                    }).reduce(function(sum, i) {
                                        return sum + i
                                    }, 0)
                                }
                            }, {
                                title: 'Pago?',
                                align: 'center',
                                valign: 'middle',
                                formatter: function (value, row, index) {
                                    //console.log(value, row, index, 'ejecuto alcargar?');
                                    if (row.tipoPago == 'debe') {
                                        return '<input class="form-check-input" type="checkbox" disabled>'
                                    }else{
                                        return '<input class="form-check-input" type="checkbox" checked disabled>'
                                    }
                                }
                            }],

                            data: data
                        })
                    }
                    i++;
                }
            })

            let data1;
            let $table1 = $('#tiendaTable')
            cargarTiendaCaja().then(async (dta) => {
                console.log(dta,'tienda');

                let limite = dta.length-1;
                let i = 0;
                for (const dt of dta) {
                    let id = dt.idCliente;
                    let idPro = dt.idProducto;
                    let nombreCliente = await fetch('controller/ControllerPagos.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            accion: 'CargarNombreCliente',
                            data:{id},
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
                    });

                    let nombreProducto = await fetch('controller/ControllerPagos.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            accion: 'CargarNombreProducto',
                            data:{id: idPro},
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
                    });

                    dt.idCliente = nombreCliente;
                    dt.idProducto = nombreProducto;

                    if (limite == i) {
                        data1 = dta;

                        $table1.bootstrapTable({
                            cache: false,
                            buttonsClass: 'dark',

                            buttonsOrder: ['export', 'columns', 'fullscreen'],
                            showExport: "true",
                            exportDataType: 'all',
                            exportTypes: ['csv', 'excel', 'pdf'], //['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
                            showFullscreen: "true",
                            showColumns: "true",
                            showColumnsToggleAll: "true",

                            pageList: '[]',

                            search: true,
                            searchAccentNeutralise: "true",
                            searchAlign: "left",

                            showFooter: true,

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
                                console.log(index, row, 'asd');
                                return `
                                    <spam><strong>Cliente:</strong> `+row.idCliente+`</spam><br>
                                    <spam><strong>Producto:</strong> `+row.idProducto+`</spam><br>
                                    <spam><strong>Valor U:</strong> `+(parseInt(row.total) / parseInt(row.cantidad))+`</spam><br>
                                    <spam><strong>Cantidad:</strong> `+row.cantidad+`</spam><br>
                                    <spam><strong>fecha:</strong> `+row.fecha+`</spam><br>
                                    <spam><strong>Medio de pago:</strong> `+row.tipoPago+`</spam><br>
                                    <spam><strong>Total:</strong> `+row.total+`</spam><br>
                                `;
                            },
                            loadingTemplate(message) {
                                return '<div class="ph-item"><div class="ph-picture"></div></div>';
                            },
                            columns: [{
                                field: 'id',
                                title: 'ID',
                                halign: 'center',
                                valign: 'middle',
                                align: 'center',
                                searchable: 'false'
                            }, {
                                field: 'idCliente',
                                title: 'Cliente'
                            }, {
                                field: 'fecha',
                                title: 'Fehca'
                            },{
                                field: 'idProducto',
                                title: 'Producto'
                            }, {
                                field: 'total',
                                title: 'Precio',
                                falign: 'center',
                                halign: 'center',
                                align: 'center',
                                footerFormatter: function(data) {
                                    let field = this.field
                                    return '$' + data.map(function(row) {
                                        return +row[field];
                                    }).reduce(function(sum, i) {
                                        return sum + i
                                    }, 0)
                                }
                            }, {
                                title: 'Pago?',
                                align: 'center',
                                valign: 'middle',
                                formatter: function (value, row, index) {
                                    //console.log(value, row, index, 'ejecuto alcargar?');
                                    if (row.tipoPago == 'debe') {
                                        return '<input class="form-check-input" type="checkbox" disabled>'
                                    }else{
                                        return '<input class="form-check-input" type="checkbox" checked disabled>'
                                    }
                                }
                            }],

                            data: data1
                        })
                    }
                }
            })

            let data2;
            let $table2 = $('#pagosTable')
            cargarPagosCaja().then(async (dta) => {
                console.log(dta,'pagos');

                let limite = dta.length-1;
                let i = 0;
                for (const dt of dta) {
                    let id = dt.idCliente;
                    let idPro = dt.idProducto;
                    let nombreCliente = await fetch('controller/ControllerPagos.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            accion: 'CargarNombreCliente',
                            data:{id},
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
                    });

                    dt.idCliente = nombreCliente;

                    if (limite == i) {
                        data2 = dta;
                
                        $table2.bootstrapTable({
                            cache: false,
                            buttonsClass: 'dark',

                            buttonsOrder: ['export', 'columns', 'fullscreen'],
                            showExport: "true",
                            exportDataType: 'all',
                            exportTypes: ['csv', 'excel', 'pdf'], //['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
                            showFullscreen: "true",
                            showColumns: "true",
                            showColumnsToggleAll: "true",

                            pageList: '[]',

                            search: true,
                            searchAccentNeutralise: "true",
                            searchAlign: "left",

                            showFooter: true,

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
                                //console.log('gggggggggggggggg', row);
                                let id = row.id;
                                let pago = fetch('controller/ControllerPagos.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        accion: 'CargarListaPagosCajaId',
                                        data:{id},
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
                                });

                                pago.then((data) => {

                                    console.log(data);
                                    let listaP = document.getElementById('listPro'+id)
                                    listaP.innerHTML = '';
                                    data.forEach(async d => {
                                        if (d.pago == 'Liga') {
                                            let ligas = await fetch('controller/ControllerPagos.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json'
                                                },
                                                body: JSON.stringify({
                                                    accion: 'CargarLigaId',
                                                    data:{id: d.id},
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
                                            });

                                            let cadena = '';
                                            ligas.forEach(function (liga) {
                                                cadena += 'fechaInicio: '+liga.fechaInicio+' fechaFin: '+liga.fechaFin+'  tipoPago: '+liga.tipoPago+'  Total: '+liga.total+'<br>';
                                            })

                                            listaP.innerHTML = listaP.innerHTML + cadena;
                                        } else if(d.pago == 'Tienda') {

                                            let tienda = await fetch('controller/ControllerPagos.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json'
                                                },
                                                body: JSON.stringify({
                                                    accion: 'CargarTiendaId',
                                                    data:{id: d.id},
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
                                            });

                                            let cadena = '';
                                            tienda.forEach(async (ti, i) => {
                                                let nombreProducto = await fetch('controller/ControllerPagos.php', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json'
                                                    },
                                                    body: JSON.stringify({
                                                        accion: 'CargarNombreProducto',
                                                        data:{id: ti.idProducto},
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
                                                });

                                                cadena += 'idProducto: '+nombreProducto+' cantidad: '+ti.cantidad+'  fecha: '+ti.fecha+'  tipoPago: '+ti.tipoPago+'  Total: '+ti.total+'<br>';
                                                if(tienda.length - 1 == i){
                                                    listaP.innerHTML = listaP.innerHTML + cadena;
                                                }
                                            })
                                        }
                                    });
                                });

                                return '<div id="listPro'+id+'">Cargando...</div>';
                            },
                            loadingTemplate(message) {
                                return '<div class="ph-item"><div class="ph-picture"></div></div>';
                            },
                            columns: [{
                                field: 'id',
                                title: 'ID',
                                halign: 'center',
                                valign: 'middle',
                                align: 'center',
                                searchable: 'false'
                            }, {
                                field: 'idCliente',
                                title: 'Cliente'
                            }, {
                                field: 'fecha',
                                title: 'Fehca'
                            },{
                                field: 'descripcion',
                                title: 'Descripcion',
                                formatter: function(value, row, index) {
                                    return '<div style="width: inherit; overflow:hidden; white-space:nowrap; text-overflow: ellipsis;">' +
                                        row.descripcion +
                                    '</div>';
                                },
                            }, {
                                field: 'total',
                                title: 'Precio',
                                falign: 'center',
                                halign: 'center',
                                align: 'center',
                                footerFormatter: function(data) {
                                    let field = this.field
                                    return '$' + data.map(function(row) {
                                        return +row[field];
                                    }).reduce(function(sum, i) {
                                        return sum + i
                                    }, 0)
                                }
                            }, {
                                title: 'Pago?',
                                align: 'center',
                                valign: 'middle',
                                formatter: function (value, row, index) {
                                    //console.log(value, row, index, 'ejecuto alcargar?');
                                    if (row.tipoPago == 'debe') {
                                        return '<input class="form-check-input" type="checkbox" disabled>'
                                    }else{
                                        return '<input class="form-check-input" type="checkbox" checked disabled>'
                                    }
                                }
                            }],

                            data: data2
                        })
                    }
                    i++;
                }
            })

            let data3;
            let $table3 = $('#descuentosTable')
            cargarDescuentos().then((dta) => {
                console.log(dta,'decuentos');

                data3 = dta;

                $table3.bootstrapTable({
                    cache: false,
                    buttonsClass: 'dark',

                    buttonsOrder: ['export', 'columns', 'fullscreen'],
                    showExport: "true",
                    exportDataType: 'all',
                    exportTypes: ['csv', 'excel', 'pdf'], //['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
                    showFullscreen: "true",
                    showColumns: "true",
                    showColumnsToggleAll: "true",

                    pageList: '[]',

                    search: true,
                    searchAccentNeutralise: "true",
                    searchAlign: "left",

                    showFooter: true,

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
                        title: 'ID',
                        halign: 'center',
                        valign: 'middle',
                        align: 'center',
                        searchable: 'false'
                    }, {
                        field: 'titulo',
                        title: 'Titulo'
                    }, {
                        field: 'descripcion',
                        title: 'Descripción'
                    },{
                        field: 'fecha',
                        title: 'Fecha'
                    }, {
                        field: 'total',
                        title: 'Precio',
                        falign: 'center',
                        halign: 'center',
                        align: 'center',
                        footerFormatter: function(data) {
                            let field = this.field
                            return '-$' + data.map(function(row) {
                                return +row[field];
                            }).reduce(function(sum, i) {
                                return sum + i
                            }, 0)
                        }
                    }],

                    data: data3
                })
            })
        </script>
<?php
    }
}

$index = new PaginaOnce('Pagos', '', '');
echo $index->crearHtml();

?>