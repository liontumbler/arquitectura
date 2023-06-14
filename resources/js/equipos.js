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
                field: 'fecha',
                title: 'Fecha',
                halign: 'center',
                align: 'center',
            }],

            data: rdta
        })

    })();
}