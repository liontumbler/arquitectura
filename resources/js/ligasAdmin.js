document.querySelector('body').onload = (e) => {
    (function () {
        
        let validarForm = new Validardor(['cliente', 'Trabajador', 'tipoPago', 'desde', 'hasta']);
        document.getElementById('buscar').addEventListener('click', async function(e) {
            let valid = validarForm.validarCampos();
            console.log(valid);
            if(valid && !valid.validationMessage){
                this.disabled = true;

                let edta = validarForm.crearObjetoJson()
                console.log(edta);

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
                    this.disabled = false;
                    if (res.status == 200) {
                        return res.json()
                    }
                }).catch((res) => {
                    this.disabled = false;
                    console.error(res.statusText);
                    return res;
                })

                console.log(rdta);
                //pintar tabla
            }
        });

    })();
}