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
                /*
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
                }*/
            } else {
                this.disabled = false;
            }
        })

    })();
}