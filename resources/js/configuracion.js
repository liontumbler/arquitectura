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

            let configuracion = data[0]
            validarForm = new Validardor(['correo', 'nickname', 'color', 'background', 'direccion', 'telefono', 'minDeMasLiga', 'descripcion']);
            
            document.getElementById('correo').value = configuracion.correo;
            document.getElementById('background').value = configuracion.background;
            document.getElementById('color').value = configuracion.color;
            document.getElementById('descripcion').value = configuracion.descripcion;
            document.getElementById('direccion').value = configuracion.direccion;
            document.getElementById('habilitado').checked = configuracion.habilitado;
            document.getElementById('minDeMasLiga').value = configuracion.minDeMasLiga;
            document.getElementById('nickname').value = configuracion.nickname;
            document.getElementById('correo').value = configuracion.correo;
            document.getElementById('nombre').value = configuracion.nombre;
            document.getElementById('telefono').value = configuracion.telefono;
            
        });

        
        let background = '';
        let color = '';

        document.getElementById('background').addEventListener('change', function (e) {
            console.log('background', this.value, color);
            background = 'background: ' +this.value+ ' !important';
            document.getElementsByClassName('navbar')[0].style.cssText = background +'; '+ color;
            document.getElementById('sideBarrar').style.cssText = background +'; '+ color;
        })

        document.getElementById('color').addEventListener('change', function (e) {
            console.log('color', this.value, background);
            color = 'color: ' +this.value+ ' !important';
            document.getElementsByClassName('navbar')[0].style.cssText = color +'; '+ background ;
            document.getElementById('sideBarrar').style.cssText = color +'; '+ background ;

            for (const element of document.querySelectorAll('#sideBar a')) {
                element.style.cssText = color;
            }
        })
    })();
}