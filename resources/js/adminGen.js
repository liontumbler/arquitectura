setInterval(mueveReloj, 1000);

async function sal() {
    return await fetch('controller/ControllerAdmin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            accion: 'Salir',
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
}

function salir(e) {

    Swal.fire({
        title: 'Seguro deseas cerrar sesión',
        showDenyButton: true,
        confirmButtonText: 'Salir',
        denyButtonText: `Cancelar`,
    }).then(async (result) => {
        if (result.isConfirmed) {
            sal().then(function (rest) {
                console.log(rest, 'salir');

                if (rest == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cerro correctamente la sesión',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        if (result.dismiss == 'timer' && result.isDismissed) {
                            location.href = 'loginAdmin';
                        }else{
                            //location.reload();
                            alert('No selecciona ninguna op');
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al cerrar sesión',
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
            })
        } 
    })
}

const min = 15;
var fecha = new Date();
fecha.setMinutes(fecha.getMinutes() + min);
var interval = setInterval(function (e) {
    console.log('cuento');
    const fechaactual = new Date();
    if (fechaactual.getHours() == fecha.getHours() && fechaactual.getMinutes() == fecha.getMinutes() && fechaactual.getSeconds() == fecha.getSeconds()) {
        clearTimeout(interval);
        sal().then(function (data) {
            if (data == true) {
                location.reload();
            }
        });
    }
}, 1000);

document.querySelector('body').addEventListener('click', function (e) {
    fecha = new Date();
    fecha.setMinutes(fecha.getMinutes() + min);
})