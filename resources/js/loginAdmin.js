document.querySelector('body').onload = (e) => {
    (function () {
        let validar = new Validardor(['nickname', 'clave']);

        document.getElementById('entrar').addEventListener('click', async function(e) {
            let valid = validar.validarCampos()

            console.log(valid, valid.validationMessage);

            
            if(valid && !valid.validationMessage){
                this.disabled = true;

                let edta = validar.crearObjetoJson();
                console.log(edta);
                let csrf_token = document.getElementById('csrf_token').value;

                let rdta = await fetch('controller/ControllerLogin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        accion: 'LoginAdmin',
                        data: edta,
                        csrf_token
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

                console.log(rdta, 'loginAdmin');
                if (rdta.length == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Datos incorrectos',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        console.log(result, result.isDismissed);
                        if (result.dismiss == 'timer' && result.isDismissed) {
                            validar.limpiar();
                        }else{
                            //location.href = location.href;
                            alert('No selecciona ninguna op');
                        }
                    })
                }else if(rdta == true){
                    Swal.fire({
                        icon: 'success',
                        title: 'Inicio correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        console.log(result, result.isDismissed);
                        if (result.dismiss == 'timer' && result.isDismissed) {
                            location.href = 'inicioAdmin';
                        }else{
                            //location.href = location.href;
                            alert('No selecciona ninguna op');
                        }
                    })
                }else if(rdta == 800){
                    Swal.fire({
                        title: '¡Estás inactivo!',
                        text: 'Comunícate con el administrador de la página',
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Entiendo!'
                    }).then((result) => {
                        console.log(result);
                        if (result.isConfirmed) {
                            //limpiar datos
                            validar.limpiar();
                        }else{
                            //location.href = location.href;
                            alert('No selecciona ninguna op');
                        }
                    })
                }
            }
        });
    })();
}