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

        document.getElementById('btnClave').addEventListener('click', function (e) {
            //clave  clave
            Swal.fire({
                title: 'cambiar clave',
                html:
                    '<div class="container row mx-auto">' +
                    
                    '<div class="form-group col-sm-12 mb-2">' +
                    '<label for="password1" class="form-label">Clave *</label>' +
                    '<input type="password" class="form-control" id="password1" placeholder="Clave Nueva" title="Clave Nueva" required minlength="8" maxlength="8"></input>' +
                    '</div>' +
                    '<div class="form-group col-sm-12 mb-2">' +
                    '<label for="password2" class="form-label">Confirmacion *</label>' +
                    '<input type="password" class="form-control" id="password2" placeholder="Confirmar Clave Nueva" title="Clave Nueva" required minlength="8" maxlength="8"></input>' +
                    '</div>' +
                    '<div class="form-group col-sm-12 mb-2">' +
                    '<div class="progress">' +
                    '<div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>' +
                    '</div>' +
                    '</div>' +
                    
                    '</div>',
                focusConfirm: false,
                showCancelButton: true,
                allowOutsideClick: false,
                confirmButtonText: 'Cambiar',
                inputValidator: (value) => {
                    console.log(value, 'value');
                },
                preConfirm: () => {
                    if (document.getElementById('nombreEdit').value) {
                        return [
                            document.getElementById('nombreEdit').value,
                        ]
                    }else{
                        return [];
                    }
                }
            }).then(async valid => {
                
                console.log(valid, valido);
                
            })

            /*document.getElementById('password1').addEventListener('change', function (e) {
                console.log(this.value);
            })*/

            document.getElementById('password1').addEventListener('keyup', function (e) {
                console.log(this.value);
                let conparar = document.getElementById('password2').value

                var regex = /^(.*[A-Z].*[A-Z])(.*[a-z].*[a-z])(.*\d.*\d)(.*[!@#$%^&*].*[!@#$%^&*])/;

                if (regex.test(this.value)){
                    console.log('cumple condicion');
                }else {
                    console.log('no cumple');
                }

                if (this.value && conparar == this.value) {
                    console.log('son iguales');
                }
            })

            document.getElementById('password2').addEventListener('keyup', function (e) {
                console.log(this.value);
                let conparar = document.getElementById('password1').value
                if (this.value && conparar == this.value) {
                    console.log('son iguales');
                }
            })

            

        })

        
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