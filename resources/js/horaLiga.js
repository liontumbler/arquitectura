document.querySelector('body').onload = (e) => {
    (async function () {
        let validarForm = new Validardor(['nombre', 'precio', 'horas']);
        let $table2 = $('#horaLigaTable');

        let rdta = await fetch('controller/ControllerHoraLiga.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                accion: 'CargarHoraLigas',
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
            }, {
                field: 'horas',
                title: 'Horas',
                halign: 'center',
                align: 'center',
            }, {
                field: 'fecha',
                title: 'Fecha',
                halign: 'center',
                align: 'center',
            }],

            data: rdta
        })

        document.getElementById('agregarHoraLiga').addEventListener('click', async function(e) {
            this.disabled = true;
            let valid = validarForm.validarCampos();
            console.log(valid);
            if(valid && !valid.validationMessage){
                let edta = validarForm.crearObjetoJson()
                console.log(edta);

                let rdta = await fetch('controller/ControllerHoraLiga.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        accion: 'AgregarHoraLiga',
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
                        title: '¡Tarifa Liga Ingresado!',
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
                    Swal.fire({
                        icon: 'error',
                        title: 'No se agregó el Tarifa Liga',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        location.href = './index';
                    })
                }
            }else{
                this.disabled = false;
            }
        })
    })();
}