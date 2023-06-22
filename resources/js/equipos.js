document.querySelector('body').onload = (e) => {
    (async function () {
        let validarForm = new Validardor(['nombre']);
        let $table2 = $('#equiposTable');

        let rdta = await fetch('controller/ControllerAdmin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                accion: 'CargarEquipos',
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

            showFooter: false,

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
                field: 'nombre',
                title: 'Nombre',
                halign: 'center',
                align: 'center',
            }, {
                field: 'fecha',
                title: 'Fecha',
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
                            title: 'Editar Equipo',
                            html:
                                '<div class="container row mx-auto">' +
                                '<div class="form-group col-sm-12 mb-2">' +
                                '<label for="nombreEdit">nombre Equipo</label>' +
                                '<input id="nombreEdit" class="swal2-input" value="'+row.nombre+'" maxlength="50" required>' +
                                '</div>' +
                                '</div>',
                            focusConfirm: false,
                            showCancelButton: true,
                            allowOutsideClick: false,
                            confirmButtonText: 'Actualizar',
                            inputValidator: (value) => {
                                console.log(value, 'value');
                            },
                            preConfirm: () => {
                                if (document.getElementById('nombreEdit').value) {
                                    return [
                                        document.getElementById('nombreEdit').value,
                                    ]
                                }else{
                                    return [];
                                }
                            }
                        }).then(async valid => {
                            let validarForm2 = new Validardor(['nombreEdit']);
                            let valido = validarForm2.validarCampos();
                            console.log(valid, valido);
                            if (valid.isConfirmed && valid && valid.value.length > 0 && (valido == true && !valido.validationMessage)) {

                                if (valid.value[0] == row.nombre) {
                                    Swal.fire('no hay datos para actualizar');
                                    return;
                                }

                                let edta = validarForm2.crearObjetoJson()
                                edta.id = row.id;

                                this.disabled = true;
                                let rdtaUp = await fetch('controller/ControllerAdmin.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        accion: 'ActualizarEquipo',
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
                                        title: '¡Se actualiza el equipo!',
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
                    },
                },
            }],

            data: rdta
        })

        document.getElementById('agregarEquipo').addEventListener('click', async function (e) {
            let valid = validarForm.validarCampos();
            if (valid == true && !valid.validationMessage) {
                let edta = validarForm.crearObjetoJson()
                console.log(edta);
                this.disabled = true;
                let rdta = await fetch('controller/ControllerAdmin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        accion: 'AgregarEquipo',
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
                        title: '¡Equipo Ingresado!',
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
                            title: 'No se agregó el equipo',
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            //location.href = './index';
                        })
                    }
                }
            } else {
                this.disabled = false;
            }
        })

    })();
}