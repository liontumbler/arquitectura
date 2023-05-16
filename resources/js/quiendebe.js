document.querySelector('body').onload = (e) => {
    (function () {
        let validarForm1;

        let resCli = cargarClientes();
        let $table = $('#quienDebeTable')

        resCli.then(function () {
            validarForm1 = new Validardor(['cliente']);
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
            $table.bootstrapTable('destroy')
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
                    halign: 'center',
                    align: 'center',
                    formatter: function(value, row, index) {
                        return '<div style="width: inherit; overflow:hidden; white-space:nowrap; text-overflow: ellipsis; display: block; margin: auto;"">' +
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
                    halign: 'center',
                    align: 'center',
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
                    halign: 'center',
                    align: 'center',
                    footerFormatter: function(data) {
                        if (dataT.length > 0) {
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
                        if (dataT.length > 0) {
                            return `<div class="d-grid gap-2">
                                <button type="button" class="btn btn-success" id="checkPagar">Pagar</button>
                            </div>`;
                        }
                    }
                }],

                data: dataT
            });

            if (dataT.length > 0) {
                document.getElementById('checkPagar').addEventListener('click', function(e) {

                    let dta = $table.bootstrapTable('getData').filter(rw => rw.tipoPago != false);
                    let tipoPago = document.querySelector('input[name="tipoPago"]:checked').value
                    //let total = document.querySelectorAll('tfoot .th-inner')[3].textContent.replace('$', '');

                    dta.push({'pago': tipoPago, 'idCliente': document.getElementById('cliente').value});
                    console.log(dta, tipoPago);
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

                        if (rdta == true) {
                            Swal.fire({
                                title: '¡Pago Ingresado!',
                                text: "Quieres mantenerte en la página o ir al home",
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Mantenerme',
                                cancelButtonText: 'Ir Home'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }else{
                                    location.href = 'trabajando';
                                }
                            })
                        }else{
                            if (rdta == -1) {
                                clienteYaExiste(function (res) {
                                    validarForm1.limpiar();
                                })
                            } else if(rdta == 'T'){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ya cerro caja de esta sesión',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    location.href = './index';
                                })
                            }
                        }
                    }, location.href)
                });
            }
        }
    })();
}