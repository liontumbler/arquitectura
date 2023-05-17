document.querySelector('body').onload = (e) => {
    (function () {
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
            let array1 = []
            for (const dt of dta) {
                if(0 == i) {
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

                    array1[dt.idCliente] = nombreCliente
                    dt.idCliente = nombreCliente;
                    
                }else{
                    if (array1[dt.idCliente]) {
                        dt.idCliente = array1[dt.idCliente];
                    } else {
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

                        array1[dt.idCliente] = nombreCliente
                        dt.idCliente = nombreCliente;
                    }
                }

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
            let array1 = []
            let array2 = []
            for (const dt of dta) {
                if(0 == i) {
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

                    array1[dt.idCliente] = nombreCliente
                    array2[dt.idProducto] = nombreProducto;

                    dt.idCliente = nombreCliente;
                    dt.idProducto = nombreProducto;
                } else {
                    if (array1[dt.idCliente] && array2[dt.idProducto]) {
                        dt.idCliente = array1[dt.idCliente];
                        dt.idProducto = array2[dt.idProducto];
                    } else {
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

                        array1[dt.idCliente] = nombreCliente
                        array2[dt.idProducto] = nombreProducto;

                        dt.idCliente = nombreCliente;
                        dt.idProducto = nombreProducto;
                    }
                }
                
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
                i++;
            }
        })

        let data2;
        let $table2 = $('#pagosTable')
        cargarPagosCaja().then(async (dta) => {
            console.log(dta,'pagos');

            let limite = dta.length-1;
            let i = 0;
            let array1 = []
            for (const dt of dta) {
                if(0 == i) {
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

                    array1[dt.idCliente] = nombreCliente
                    dt.idCliente = nombreCliente;
                    
                }else{
                    if (array1[dt.idCliente]) {
                        dt.idCliente = array1[dt.idCliente];
                    } else {
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

                        array1[dt.idCliente] = nombreCliente
                        dt.idCliente = nombreCliente;
                    }
                }

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
                                        let array1 = []
                                        tienda.forEach(async (ti, i) => {
                                            if (array1.length == 0) {
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
                                                
                                                array1[ti.idProducto] = nombreProducto;
                                                cadena += 'idProducto: '+nombreProducto+' cantidad: '+ti.cantidad+'  fecha: '+ti.fecha+'  tipoPago: '+ti.tipoPago+'  Total: '+ti.total+'<br>';
                                                
                                            }else{
                                                if (array1[ti.idProducto]) {
                                                    cadena += 'idProducto: '+array1[ti.idProducto]+' cantidad: '+ti.cantidad+'  fecha: '+ti.fecha+'  tipoPago: '+ti.tipoPago+'  Total: '+ti.total+'<br>';;
                                                } else {
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
                                                    
                                                    array1[ti.idProducto] = nombreProducto;
                                                    cadena += 'idProducto: '+nombreProducto+' cantidad: '+ti.cantidad+'  fecha: '+ti.fecha+'  tipoPago: '+ti.tipoPago+'  Total: '+ti.total+'<br>';
                                                }
                                            }

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
    })();
}