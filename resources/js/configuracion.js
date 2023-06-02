document.querySelector('body').onload = (e) => {
    (function () {
        let validarForm;

        async function cargarConfiguracion() {
            return await fetch('controller/ControllerAdmin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    accion: 'CargarConfiguracion',
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
        }

        let resConfig = cargarConfiguracion();
        
        resConfig.then(function (data) {
            console.log(data);
            validarForm = new Validardor(['cliente', 'trabajador', 'tipoPago', 'desde', 'hasta']);
                    
        });
    })();
}