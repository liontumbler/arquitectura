document.querySelector('body').onload = (e) => {
    (function () {
        let validarForm;

        async function cargarTrabajadores() {
            let trabajadores = await fetch('controller/ControllerAdmin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    accion: 'CargarTrabajadores',
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

            //console.log(trabajadores);
            
            let select = document.getElementById('Trabajador');
            for (let i = 0; i < trabajadores.length; i++) {
                //console.log(trabajadores[i], 'llena');
                let op = new Option(trabajadores[i].nombresYapellidos, trabajadores[i].id)
                select.append(op);
            }
        }
        let $table2;
        let resCli = cargarClientes();
        let resTra = cargarTrabajadores();
        resCli.then(function () {
            resTra.then(function () {
                validarForm = new Validardor(['cliente', 'Trabajador', 'tipoPago', 'desde', 'hasta']);
                $table2 = $('#ligasTable');
            })
        })

        document.getElementById('buscar').addEventListener('click', async function(e) {
            let valid = validarForm.validarCampos();
            console.log(valid);
            if(valid && !valid.validationMessage){
                this.disabled = true;

                let edta = validarForm.crearObjetoJson()
                console.log(edta);

                if (edta.desde) 
                    edta.desde = validarForm.obtenerFechaHoraServer(edta.desde)

                if (edta.hasta) 
                    edta.hasta = validarForm.obtenerFechaHoraServer(edta.hasta)

                let rdta = await fetch('controller/ControllerAdmin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        accion: 'BuscarLigas',
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

                console.log(rdta, 'ligas');

                /**graficar  sacar un metodo que pinte las graficas*/
                const ctxBarras = document.getElementById('ligasGraficaBarras');
                const ctxLineas = document.getElementById('ligasGraficaLineas');
                let digital = rdta.filter(liga => liga.tipoPago == 'digital');
                let efectivo = rdta.filter(liga => liga.tipoPago == 'efectivo');
                let pazYsalvoEfectivo = rdta.filter(liga => liga.tipoPago == 'pazYsalvoEfectivo');
                let pazYsalvoDigital = rdta.filter(liga => liga.tipoPago == 'pazYsalvoDigital');
                let debe = rdta.filter(liga => liga.tipoPago == 'debe');

                const myChart = new Chart(ctxBarras, {
                    type: 'bar',
                    data: {
                        labels: ['digital', 'efectivo', 'pazYsalvoEfectivo', 'pazYsalvoDigital', 'debe'],
                        datasets: [{
                            label: 'Tipos de pagos',
                            data: [digital.length, efectivo.length, pazYsalvoEfectivo.length, pazYsalvoDigital.length, debe.length],
                            borderWidth: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        animation: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 2
                                }
                            }
                        },
                        plugins: {
                            customCanvasBackgroundColor: {
                                color: '#f9f9f9',
                            },
                            legend: {
                                labels: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'El tipo de pago que más se ha hecho'
                            }
                        },
                        layout: {
                            padding: 30
                        }
                    },
                    plugins: [{
                        id: 'customCanvasBackgroundColor',
                        beforeDraw: (chart, args, options) => {
                            const {ctx} = chart;
                            ctx.save();
                            ctx.globalCompositeOperation = 'destination-over';
                            ctx.fillStyle = options.color || '#99ffff';
                            ctx.fillRect(0, 0, chart.width, chart.height);
                            ctx.restore();
                        }
                    }],
                });

                //arreglar
                const myChart2 = new Chart(ctxLineas, {
                    //fechas vesus totales
                    type: 'line',
                    data: {
                        labels: ['fecha', 'fecha', 'fecha'],
                        datasets: [
                            {
                                label: 'Debe',
                                data: [1,2,3,4],
                                borderColor: '#ff0000',
                                backgroundColor: '#ff00007a',
                            },
                            {
                                label: 'Digital',
                                data: [6,7,8,9,10],
                                borderColor: '#0000ff',
                                backgroundColor: '#0000ff7a',
                            },
                            {
                                label: 'Efectivo',
                                data: [6,7,8,9,10],
                                borderColor: '#00ff00',
                                backgroundColor: '#00ff007a',
                            },
                            {
                                label: 'pazYsalvoEfectivo',
                                data: [6,7,8,9,10],
                                borderColor: '#f0f0f0',
                                backgroundColor: '#f0f0f07a',
                            },
                            {
                                label: 'pazYsalvoDigital',
                                data: [6,7,8,9,10],
                                borderColor: '#0f0f0f',
                                backgroundColor: '#0f0f0f7a',
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        animation: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 2
                                }
                            }
                        },
                        plugins: {
                            customCanvasBackgroundColor: {
                                color: '#f9f9f9',
                            },
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'lineas :)'
                            }
                        },
                        layout: {
                            padding: 30
                        }
                    },
                    plugins: [{
                        id: 'customCanvasBackgroundColor',
                        beforeDraw: (chart, args, options) => {
                            const {ctx} = chart;
                            ctx.save();
                            ctx.globalCompositeOperation = 'destination-over';
                            ctx.fillStyle = options.color || '#99ffff';
                            ctx.fillRect(0, 0, chart.width, chart.height);
                            ctx.restore();
                        }
                    }],
                });
    
                Chart.defaults.backgroundColor = '#9BD0F5';//color barras
                Chart.defaults.borderColor = '#36A2EB';//color barras bordes
                Chart.defaults.color = '#000';
                /**graficar */

                let limite = rdta.length-1;
                let i = 0;
                let array1 = []
                let array2 = []
                for (const dt of rdta) {
                    if(0 == i) {
                        let id = dt.idCliente;
                        let idTra = dt.idTrabajador;
                        let nombreCliente = await fetch('controller/ControllerAdmin.php', {
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

                        let nombreTrabajador = await fetch('controller/ControllerAdmin.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                accion: 'CargarNombreTrabajador',
                                data:{id: idTra},
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
                        array2[dt.idTrabajador] = nombreTrabajador;

                        dt.idCliente = nombreCliente;
                        dt.idTrabajador = nombreTrabajador;
                    } else {
                        if (array1[dt.idCliente] && array2[dt.idTrabajador]) {
                            dt.idCliente = array1[dt.idCliente];
                            dt.idTrabajador = array2[dt.idTrabajador];
                        } else {
                            let id = dt.idCliente;
                            let idTra = dt.idTrabajador;
                            let nombreCliente = await fetch('controller/ControllerAdmin.php', {
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

                            let nombreTrabajador = await fetch('controller/ControllerAdmin.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    accion: 'CargarNombreTrabajador',
                                    data:{id: idTra},
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
                            array2[dt.idTrabajador] = nombreTrabajador;

                            dt.idCliente = nombreCliente;
                            dt.idTrabajador = nombreTrabajador;
                        }
                    }

                    if (limite == i) {
                        $table2.bootstrapTable('destroy')
                        $table2.bootstrapTable({
                            cache: false,
                            buttonsClass: 'dark',

                            buttonsOrder: ['columns', 'fullscreen'],
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
                                return '<div id="listPro'+row.id+'">Cargando...</div>';
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
                                field: 'idTrabajador',
                                title: 'Trabajador'
                            }, {
                                field: 'fechaInicio',
                                title: 'Inicio'
                            }, {
                                field: 'fechaFin',
                                title: 'Final'
                            }, {
                                field: 'tipoPago',
                                title: 'Tipo Pago'
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

                            data: rdta
                        })
                    }
                    i++;
                }
            }
        });
    })();
}