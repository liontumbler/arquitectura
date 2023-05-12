//sacar un archivo para trabajadores
function mueveReloj() {
    let momentoActual = new Date()
    let hora = momentoActual.getHours()
    let minuto = momentoActual.getMinutes()
    let segundo = momentoActual.getSeconds()

    let periodo = "A.M.";
    if (hora > 12) {
        hora -= 12;
        periodo = "P.M.";
    }

    if (hora == 0) {
        hora = 12;
    } else if (hora > 12) {
        hora -= 12;
    }

    hora = hora < 10 ? "0" + hora : hora;
    minuto = minuto < 10 ? "0" + minuto : minuto;
    segundo = segundo < 10 ? "0" + segundo : segundo;

    const horaActual = hora + ":" + minuto + ":" + segundo + " " + periodo;

    document.getElementById('hora').textContent = horaActual;
}

setInterval(mueveReloj, 1000);

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