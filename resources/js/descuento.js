document.querySelector('body').onload = (e) => {
    (function () {

        let validarForm = new Validardor(['titulo', 'descripcion', 'total']);

        document.getElementById('agregarDescuento').addEventListener('click', async function(e) {
            let valid = validarForm.validarCampos();
            console.log(valid);
            
            if(valid && !valid.validationMessage){
                msgClave(async function () {
                    this.disabled = true;

                    let edta = validarForm.crearObjetoJson()
                    console.log(edta);

                    let rdta = await fetch('controller/ControllerDescuento.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            accion: 'Descontar',
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

                    if (rdta == true) {
                        Swal.fire({
                            title: '¡Descuento Ingresada!',
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
                                location.href = 'trabajando';
                            }
                        })
                    } else if (rdta == 'T') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ya cerro caja de esta sesión',
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            location.href = './index';
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
                                title: 'No se agregó el descuento',
                                showConfirmButton: false,
                                timer: 1500
                            }).then((result) => {
                                location.href = './index';
                            })
                        }
                    }
                }, location.href)
            }
        });
    })();
}