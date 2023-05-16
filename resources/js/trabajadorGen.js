async function claveCaja(clave) {
    return await fetch('controller/ControllerLigas.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            accion: 'ClaveCaja',
            data: {clave},
            csrf_token: document.getElementById('csrf_token').value
        })
    }).then((res) => {
        this.disabled = false;
        if (res.status == 200) {
            return res.json();
        }
    }).catch((res) => {
        this.disabled = false;
        //console.error(res.statusText);
        return res;
    })
}

function msgClave(fun, redirec = location.href) {
    Swal.fire({
        title: 'Necesitas la clave de la caja para realizar la acción',
        input: 'password',
        inputPlaceholder: 'Clave 4 digitos',
        inputAttributes: {
            'minlength': '4',
            'maxlength': '4',
            'oninput': "this.value = this.value.replace(/[^0-9]/g, '')",
            'style': 'text-align: center;'
        },
        inputValidator: (value) => {
            if (!value) {
                return '¡El campo no puede estar vacío!'
            }else if(value.length < 4){
                return '¡El campo tiene que ser de 4 cifras!'
            }
        },
        showCancelButton: true,
        confirmButtonText: 'Ingresar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            let val = await claveCaja(result.value);
            if (val) {
                fun()
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Clave Incorrecta',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    if (redirec != '') {
                        location.href = redirec;
                    }
                })
            }
        }else{
            if (redirec != '') {
                location.href = redirec;
            }
        }
    })
}

function clienteYaExiste(fun) {
    Swal.fire({
        icon: 'error',
        title: 'El cliente ya existe',
        showConfirmButton: false,
        timer: 1500
    }).then((result) => {
        fun(result)
    })
}

async function cargarClientes() {
    let clientes = await fetch('controller/ControllerTienda.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            accion: 'CargarClientes',
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

    let select = document.getElementById('cliente');
    for (let i = 0; i < clientes.length; i++) {
        //console.log(clientes[i], 'llena');
        let op = new Option(clientes[i].nombresYapellidos, clientes[i].id)
        select.append(op);
    }
}

async function cargarEquipos() {
    let equipos = await fetch('controller/ControllerTienda.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            accion: 'CargarEquipos',
            //data: '',
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

    let select = document.getElementById('equipo');
    for (let i = 0; i < equipos.length; i++) {
        //console.log(equipos[i], 'llena');
        let op = new Option(equipos[i].nombre, equipos[i].id)
        select.append(op);
    }
}

async function terminar(e) {
    msgClave(async function () {

        Swal.fire({
            title: 'Ingresa el fectivo actual de la caja',
            input: 'text',
            inputLabel: 'Valor Caja',
            showCancelButton: true,
            inputAttributes: {
                'minlength': '1',
                'maxlength': '10',
                'oninput': "this.value = this.value.replace(/[^0-9]/g, '')",
                'style': 'text-align: center;'
            },
            inputValidator: (value) => {
                if (!value) {
                    return '¡El campo no puede estar vacío!'
                }
            }
        }).then(async (result) => {
            console.log(result);
            if (result.isConfirmed) {
                let rest = await fetch('controller/ControllerTrabajando.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        accion: 'Cerrarcaja',
                        data: {finCaja: result.value},
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

                console.log(rest);

                if (rest == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cerro correctamente la sesión',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        if (result.dismiss == 'timer' && result.isDismissed) {
                            location.href = 'loginTrabajador';
                        }else{
                            //location.reload();
                            alert('No selecciona ninguna op');
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al cerrar caja',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        console.log(result, result.isDismissed);
                        if (result.dismiss == 'timer' && result.isDismissed) {
                            location.reload();
                        }else{
                            alert('No selecciona ninguna op');
                        }
                    })
                }
            }else{
                location.href = redirec;
            }
        })
    }, '')
}

(function () {
    setInterval(mueveReloj, 1000);
    
    document.getElementById('sbTerminar').addEventListener('click', terminar);
})();
