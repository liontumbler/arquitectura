document.querySelector('body').onload = (e) => {
    (async function () {
        let validarForm = new Validardor(['nombre', 'precio', 'descripcion']);
        let $table2 = $('#productosTable');

        let rdta = await fetch('controller/ControllerAdmin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                accion: 'CargarProdutos',
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
                field: 'nombre',
                title: 'Nombre',
                halign: 'center',
                align: 'center',
            }, {
                field: 'precio',
                title: 'Precio',
                halign: 'center',
                align: 'center',
            },{
                field: 'descripcion',
                title: 'Descripción',
                width: '250',
                formatter: function(value, row, index) {
                    return '<div class="textoLargoTabla">' +
                        row.descripcion +
                    '</div>';
                },
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
                                '<label for="nombreEdit" class="form-label">Nombre *</label>' +
                                '<input type="text" class="form-control" id="nombreEdit" value="'+row.nombre+'" placeholder="Nombre del Producto" title="Nombre del Producto" required minlength="1" maxlength="100">' +
                                '</div>' +
                                '<div class="form-group col-sm-12 mb-2">' +
                                '<label for="descripcionEdit" class="form-label">Descripción</label>' +
                                '<textarea class="form-control" id="descripcionEdit" rows="3" minlength="1" maxlength="150">'+row.descripcion+'</textarea>' +
                                '</div>' +
                                '<div class="form-group col-sm-12 mb-2">' +
                                '<label for="precioEdit" class="form-label">Precio *</label>' +
                                '<input type="number" class="form-control" id="precioEdit" value="'+row.precio+'" placeholder="Precio del Producto" title="Precio del Producto" min="1" max="999999999999">' +
                                '</div>' +
                                '</div>'
                                ,
                            focusConfirm: false,
                            showCancelButton: true,
                            allowOutsideClick: false,
                            confirmButtonText: 'Actualizar',
                            preConfirm: () => {
                                if (document.getElementById('nombreEdit').value &&
                                    document.getElementById('precioEdit').value
                                ) {
                                    return [
                                        document.getElementById('nombreEdit').value,
                                        document.getElementById('precioEdit').value,
                                    ]
                                }else{
                                    return [];
                                }
                            }
                        }).then(async valid => {
                            let validarForm2 = new Validardor(['nombreEdit', 'descripcionEdit', 'precioEdit']);
                            let valido = validarForm2.validarCampos();
                            console.log(valid, valido);
                            if (valid && valid.isConfirmed && valid.value.length > 0 && (valido == true && !valido.validationMessage)) {

                                let edta = validarForm2.crearObjetoJson()
                                edta.id = row.id;

                                console.log(edta);

                                this.disabled = true;
                                let rdtaUp = await fetch('controller/ControllerAdmin.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        accion: 'ActualizarProducto',
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
                                        title: '¡Se actualiza el producto!',
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

        document.getElementById('agregarProducto').addEventListener('click', async function(e) {
            this.disabled = true;
            let valid = validarForm.validarCampos();
            console.log(valid);
            if(valid == true && !valid.validationMessage){
                let edta = validarForm.crearObjetoJson()
                console.log(edta);

                let rdta = await fetch('controller/ControllerAdmin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        accion: 'AgregarProducto',
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
                        title: '¡Producto Ingresado!',
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
            }else{
                this.disabled = false;
            }
        })
    })();
}