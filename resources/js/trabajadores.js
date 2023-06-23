document.querySelector('body').onload = (e) => {
    (async function () {
        let validarForm = new Validardor(['nombresYapellidos', 'nickname', 'correo', 'telefono', 'documento', 'claveCaja']);
        let $table2 = $('#trabajadoresTable');

        let rdta = await fetch('controller/ControllerAdmin.php', {
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

        console.log(rdta);

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
            columns: [{
                field: 'id',
                title: 'ID',
                halign: 'center',
                valign: 'middle',
                align: 'center',
                searchable: 'false'
            }, {
                field: 'nombresYapellidos',
                title: 'Nombres y Apellidos',
                halign: 'center',
                align: 'center',
            }, {
                field: 'documento',
                title: 'Documento',
                halign: 'center',
                align: 'center',
            }, {
                field: 'correo',
                title: 'Correo',
                halign: 'center',
                align: 'center',
            }, {
                field: 'claveCaja',
                title: 'Clave de la Caja',
                halign: 'center',
                align: 'center',
            }, {
                field: 'nickname',
                title: 'Apodo (Alias)',
                halign: 'center',
                align: 'center',
            }, {
                field: 'telefono',
                title: 'Teléfono',
                halign: 'center',
                align: 'center',
            },{
                title: 'Acción',
                width: '100',
                widthUnit: 'px',
                align: 'center',
                halign: 'center',
                formatter: function(value, row, index) {
                    return '<i class="bi bi-pencil-fill editar" title="Editar"></i>';
                },
                events: {
                    'click .editar': function(e, value, row, index) {
                        console.log(value, row, index, 'click');
                        
                        Swal.fire({
                            title: 'Editar trabajador',
                            html:
                                '<div class="container row mx-auto">' +
                                '<div class="form-group col-sm-12 mb-2">' +
                                '<label for="nombresYapellidosEdit" class="form-label">Nombres y Apellidos *</label>' +
                                '<input type="text" class="form-control" id="nombresYapellidosEdit" value="'+row.nombresYapellidos+'" placeholder="Nombre y Apellido del trabajador" title="Nombre y Apellido del trabajador" required minlength="1" maxlength="100"></input>' +
                                '</div>' +
                                '<div class="form-group col-sm-12 mb-2">' +
                                '<label for="correoEdit" class="form-label">Correo *</label>' +
                                '<input type="email" class="form-control" id="correoEdit" value="'+row.correo+'" placeholder="correo del trabajador" title="correo del trabajador" required minlength="1" maxlength="100"></input>' +
                                '</div>' +
                                '<div class="form-group col-sm-12 mb-2">' +
                                '<label for="telefonoEdit" class="form-label">Telefono</label>' +
                                '<input type="number" class="form-control" id="telefonoEdit" value="'+row.telefono+'" placeholder="Teléfono del trabajador" title="Teléfono del trabajador" required minlength="1" maxlength="13"></input>' +
                                '</div>' +
                                '<div class="form-group col-sm-12 mb-2">' +
                                '<label for="documentoEdit" class="form-label">Documento *</label>' +
                                '<input type="number" class="form-control" id="documentoEdit" value="'+row.documento+'" placeholder="Número de documento de identidad" title="Número de documento de identidad" required minlength="1" maxlength="13"></input>' +
                                '</div>' +
                                '<div class="form-group col-sm-12 mb-2">' +
                                '<label for="claveCajaEdit" class="form-label">Clave de Caja</label>' +
                                '<input type="number" class="form-control" id="claveCajaEdit" value="'+row.claveCaja+'" placeholder="Clave" title="Clave" minlength="4" maxlength="4"></input>' +
                                '</div>' +
                                '<div class="col-sm-12 mb-2">' +
                                '<span id="claveEdit"></span>' +
                                '<div class="d-grid gap-2">' +
                                    '<button type="button" id="btnClaveEdit" class="btn btn-info">Cambio de clave</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>'
                                ,
                            focusConfirm: false,
                            showCancelButton: true,
                            allowOutsideClick: false,
                            confirmButtonText: 'Actualizar',
                            preConfirm: () => {
                                if (document.getElementById('nombresYapellidosEdit').value &&
                                    document.getElementById('correoEdit').value &&
                                    document.getElementById('documentoEdit').value
                                ) {
                                    return [
                                        document.getElementById('nombresYapellidosEdit').value,
                                        document.getElementById('correoEdit').value,
                                        document.getElementById('documentoEdit').value,
                                    ]
                                }else{
                                    return [];
                                }
                            }
                        }).then(async valid => {
                            let validarForm2 = new Validardor(['nombresYapellidosEdit', 'correoEdit', 'telefonoEdit', 'documentoEdit', 'claveCajaEdit']);
                            let valido = validarForm2.validarCampos();
                            console.log(valid, valido);
                            if (valid && valid.isConfirmed && valid.value.length > 0 && (valido == true && !valido.validationMessage)) {

                                let edta = validarForm2.crearObjetoJson()
                                edta.clave = document.getElementById('claveEdit').textContent;
                                edta.id = row.id;

                                console.log(edta);

                                this.disabled = true;
                                let rdtaUp = await fetch('controller/ControllerAdmin.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        accion: 'ActualizarTrabajador',
                                        data: edta,
                                        csrf_token: document.getElementById('csrf_token').value
                                    })
                                }).then((res) => {
                                    if (res.status == 200) {
                                        return res.json()
                                    }
                                }).catch((res) => {
                                    return res;
                                })
                                this.disabled = false;
                                
                                if (rdtaUp == true) {
                                    Swal.fire({
                                        title: '¡Se actualiza el trabajador!',
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
                                            location.href = 'inicioAdmin';
                                        }
                                    })
                                }else{
                                    console.log(rdtaUp);
                                }
                            }else if(valid.isDismissed){
                                Swal.fire('cancelo');
                            }else if(valid.isDenied){
                                Swal.fire('cancelo');
                            }else if(!valid || valid.value.length == 0){
                                Swal.fire('no hay datos para actualizar');
                            }else {
                                Swal.fire('error en los datos');
                            }
                        })

                        document.getElementById('btnClaveEdit').addEventListener('click', async function (e) {
                            document.getElementById('claveEdit').textContent = generarAlfanumerico();
                        })
                    },
                },
            }],

            data: rdta
        })

        document.getElementById('clave').textContent = generarAlfanumerico();

        document.getElementById('btnClave').addEventListener('click', async function (e) {
            document.getElementById('clave').textContent = generarAlfanumerico();
        })

        function generarAlfanumerico() {
            var caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var longitud = 8;
            var alfanumerico = '';

            for (var i = 0; i < longitud; i++) {
                var indice = Math.floor(Math.random() * caracteres.length);
                alfanumerico += caracteres.charAt(indice);
            }

            return alfanumerico;
        }

        document.getElementById('guardar').addEventListener('click', async function (e) {
            //this.disabled = true;
            let valid = validarForm.validarCampos();
            if (valid == true && !valid.validationMessage) {
                let edta = validarForm.crearObjetoJson()
                edta.clave = document.getElementById('clave').textContent
                console.log(edta);
                
                let rdta = await fetch('controller/ControllerAdmin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        accion: 'AgregarTrabajador',
                        data: edta,
                        csrf_token: document.getElementById('csrf_token').value
                    })
                }).then((res) => {
                    if (res.status == 200) {
                        return res.json()
                    }
                }).catch((res) => {
                    //console.error(res.statusText);
                    return res;
                })
                this.disabled = false;

                console.log(rdta);
                //console.log(rdta);
                if (rdta == true) {
                    Swal.fire({
                        title: '¡Trabajador Ingresado!',
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
                            location.href = 'inicioAdmin';
                        }
                    })
                }else{
                    if(rdta == 601){
                        Swal.fire({
                            icon: 'error',
                            title: 'Tu plan se excedió, contáctate con nosotros para cambiar el plan o adquirir uno personalizado',
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            location.href = location.reload();
                        })
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'No se agregó el producto',
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            location.href = './index';
                        })
                    }
                }
            } else {
                this.disabled = false;
            }
        })

    })();
}