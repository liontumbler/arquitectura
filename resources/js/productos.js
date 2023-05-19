document.querySelector('body').onload = (e) => {
    (async function () {
        let validarForm;
        let $table2;

        validarForm = new Validardor(['nombre', 'precio']);
        $table2 = $('#productosTable');

        let rdta = await fetch('controller/ControllerProductos.php', {
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
            }],

            data: rdta
        })

        document.getElementById('agregarProducto').addEventListener('click', async function(e) {
            this.disabled = true;
            let valid = validarForm.validarCampos();
            console.log(valid);
            if(valid && !valid.validationMessage){
                let rdta = await fetch('controller/ControllerProductos.php', {
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
            }else{
                this.disabled = false;
            }
        })
    })();
}