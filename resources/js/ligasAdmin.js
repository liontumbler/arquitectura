document.querySelector('body').onload = (e) => {
    (function () {
        let validarForm;

        let $table2;
        let resCli = cargarClientes();
        let resTra = cargarTrabajadores();
        resCli.then(function () {
            resTra.then(function () {
                validarForm = new Validardor(['cliente', 'trabajador', 'tipoPago', 'desde', 'hasta']);
                $table2 = $('#ligasTable');
            })
        })

        function total(arr) {
            let total = 0;
            for (const t in arr) {
                total += arr[t].total;
            }

            return total;
        }

        let myChart;
        let myChart2;
        let myChart3;
        let myChart4;
        function graficar(rdta) {
            if (myChart) 
                myChart.destroy();
            
            if (myChart2) 
                myChart2.destroy();

            if (myChart3) 
                myChart3.destroy();

            if (myChart4) 
                myChart4.destroy();
            
            const ctxBarras = document.getElementById('ligasGraficaBarras');
            const ctxLineas = document.getElementById('ligasGraficaLineas');
            const ctxPolarArea = document.getElementById('ligasGraficaPolarArea');
            const ctxPie = document.getElementById('ligasGraficaPie');
            
            let digital = rdta.filter(liga => liga.tipoPago == 'digital');
            let efectivo = rdta.filter(liga => liga.tipoPago == 'efectivo');
            let pazYsalvoEfectivo = rdta.filter(liga => liga.tipoPago == 'pazYsalvoEfectivo');
            let pazYsalvoDigital = rdta.filter(liga => liga.tipoPago == 'pazYsalvoDigital');
            let debe = rdta.filter(liga => liga.tipoPago == 'debe');
            
            myChart = new Chart(ctxBarras, {
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
                            text: 'ventas por tipo de pago'
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

            let labelsFecha = [];
            let labelsTrabajador = [];
            let labelsCliente = [];
            for (const i in rdta) {
                let fecha = rdta[i]['fechaInicio'].split(' ')[0]
                if (i == 0) {
                    labelsFecha.push(fecha)
                }else{
                    let diferente = 0;
                    for (const j in labelsFecha) {
                        if (labelsFecha[j] != fecha) {
                            diferente++;
                        }
                    }

                    if (diferente >= labelsFecha.length) {
                        labelsFecha.push(fecha)
                    }
                }

                let trabajador = rdta[i]['idTrabajador']
                if (i == 0) {
                    labelsTrabajador.push(trabajador)
                }else{
                    let diferente = 0;
                    for (const j in labelsTrabajador) {
                        if (labelsTrabajador[j] != trabajador) {
                            diferente++;
                        }
                    }

                    if (diferente >= labelsTrabajador.length) {
                        labelsTrabajador.push(trabajador)
                    }
                }

                let cliente = rdta[i]['idCliente']
                if (i == 0) {
                    labelsCliente.push(cliente)
                }else{
                    let diferente = 0;
                    for (const j in labelsCliente) {
                        if (labelsCliente[j] != cliente) {
                            diferente++;
                        }
                    }

                    if (diferente >= labelsCliente.length) {
                        labelsCliente.push(cliente)
                    }
                }
            }

            let arraydebe = []
            let arraydigital = []
            let arrayefectivo = []
            let arraypazYsalvoEfectivo = []
            let arraypazYsalvoDigital = []
            for (const f in labelsFecha) {
                let deb = rdta.filter(liga => liga.fechaInicio.indexOf(labelsFecha[f]) >= 0 && liga.tipoPago == 'debe');
                arraydebe[f] = total(deb)
                let dig = rdta.filter(liga => liga.fechaInicio.indexOf(labelsFecha[f]) >= 0 && liga.tipoPago == 'digital');
                arraydigital[f] = total(dig);
                let efe = rdta.filter(liga => liga.fechaInicio.indexOf(labelsFecha[f]) >= 0 && liga.tipoPago == 'efectivo');
                arrayefectivo[f] = total(efe);
                let pazEfe = rdta.filter(liga => liga.fechaInicio.indexOf(labelsFecha[f]) >= 0 && liga.tipoPago == 'pazYsalvoEfectivo');
                arraypazYsalvoEfectivo[f] = total(pazEfe);
                let pazDig = rdta.filter(liga => liga.fechaInicio.indexOf(labelsFecha[f]) >= 0 && liga.tipoPago == 'pazYsalvoDigital');
                arraypazYsalvoDigital[f] = total(pazDig);
            }

            myChart2 = new Chart(ctxLineas, {
                type: 'line',
                data: {
                    labels: labelsFecha,
                    datasets: [
                        {
                            label: 'Debe',
                            data: arraydebe,
                            borderColor: '#ff0000',
                            backgroundColor: '#ff00007a',
                        },
                        {
                            label: 'Digital',
                            data: arraydigital,
                            borderColor: '#0000ff',
                            backgroundColor: '#0000ff7a',
                        },
                        {
                            label: 'Efectivo',
                            data: arrayefectivo,
                            borderColor: '#00ff00',
                            backgroundColor: '#00ff007a',
                        },
                        {
                            label: 'pazYsalvoEfectivo',
                            data: arraypazYsalvoEfectivo,
                            borderColor: '#a6f7de',
                            backgroundColor: '#a6f7de7a',
                        },
                        {
                            label: 'pazYsalvoDigital',
                            data: arraypazYsalvoDigital,
                            borderColor: '#000000',
                            backgroundColor: '#0000007a',
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
                            },
                            //max: 1000000,
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
                            text: 'totales por fecha'
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

            let arrayidTrabajador = []
            for (const f in labelsTrabajador) {
                let paztra = rdta.filter(liga => liga.idTrabajador == labelsTrabajador[f]);
                arrayidTrabajador[f] = total(paztra);
            }

            myChart3 = new Chart(ctxPolarArea, {
                type: 'polarArea',
                data: {
                    labels: labelsTrabajador,
                    datasets: [
                        {
                            label: 'Trabajadores',
                            data: arrayidTrabajador,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    animation: false,
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
                            text: 'totales Trabajadores'
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

            let arrayidCliente = []
            for (const f in labelsCliente) {
                let paztra = rdta.filter(liga => liga.idCliente == labelsCliente[f]);
                arrayidCliente[f] = total(paztra);
            }

            myChart4 = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: labelsCliente,
                    datasets: [
                        {
                            label: 'Clientes',
                            data: arrayidCliente,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    animation: false,
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
                            text: 'totales Clientes'
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
            Chart.defaults.color = '#000';
        }

        document.getElementById('buscar').addEventListener('click', async function(e) {
            this.disabled = true;
            let valid = validarForm.validarCampos();
            if(valid && !valid.validationMessage){
                let edta = validarForm.crearObjetoJson()

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
                    if (res.status == 200) {
                        return res.json()
                    }
                }).catch((res) => {
                    console.error(res.statusText);
                    return res;
                })

                console.log(rdta, 'ligas');

                if (!rdta){
                    Swal.fire({
                        icon: 'error',
                        title: 'En la consulta',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        this.disabled = false;
                    })
                    return;
                }

                graficar(rdta);

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
                            if (res.status == 200) {
                                return res.json()
                            }
                        }).catch((res) => {
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
                            if (res.status == 200) {
                                return res.json()
                            }
                        }).catch((res) => {
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
                                if (res.status == 200) {
                                    return res.json()
                                }
                            }).catch((res) => {
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
                                if (res.status == 200) {
                                    return res.json()
                                }
                            }).catch((res) => {
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
                        this.disabled = false;
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
            }else{
                this.disabled = false;
            }
        });
    })();
}