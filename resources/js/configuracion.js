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
            validarForm = new Validardor(['correo', 'nombre', 'color', 'background', 'direccion', 'telefono', 'minDeMasLiga', 'descripcion']);
            
            document.getElementById('correo').value = configuracion.correo;
            document.getElementById('background').value = configuracion.background;
            document.getElementById('color').value = configuracion.color;
            document.getElementById('descripcion').value = configuracion.descripcion;
            document.getElementById('direccion').value = configuracion.direccion;
            document.getElementById('habilitado').checked = configuracion.habilitado;
            document.getElementById('minDeMasLiga').value = configuracion.minDeMasLiga;
            document.getElementById('nickname').value = configuracion.nickname;
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
                    '<input type="password" class="form-control" aria-describedby="errorPass" id="password2" placeholder="Confirmar Clave Nueva" title="Clave Nueva" required minlength="8" maxlength="8"></input>' +
                    '<div id="errorPass" class="form-text text-danger">contraseña invalida</div>' +
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
                    if (document.getElementById("errorPass").classList.contains("d-none")) {
                        return [document.getElementById('password1').value];
                    }else {
                        return [];
                    }
                }
            }).then(async valid => {
                
                console.log(valid);
                if (valid.isConfirmed && valid.value.length > 0) {
                    document.getElementById('clave').textContent = valid.value[0];
                }else {
                    Swal.fire('clave invalida');
                }
                
            })

            document.getElementById('password1').addEventListener('keyup', function (e) {
                if (e.key != 'Shift' && e.key != 'Unidentified' && e.key != 'CapsLock') {
                    console.log(this.value, e);
                    let conparar = document.getElementById('password2').value

                    if (validarContraseñas(this.value, conparar)){
                        console.log('cumple condicion2');

                        document.getElementById("errorPass").classList.add("d-none");
                    }else {
                        console.log('no cumple2');

                        document.getElementById("errorPass").classList.remove("d-none");
                    }
                }
            })

            document.getElementById('password2').addEventListener('keyup', function (e) {
                if (e.key != 'Shift' && e.key != 'Unidentified' && e.key != 'CapsLock') {   
                    console.log(this.value, e);
                    let conparar = document.getElementById('password1').value
                    
                    if (validarContraseñas(this.value, conparar)){
                        console.log('cumple condicion2');

                        document.getElementById("errorPass").classList.add("d-none");
                    }else {
                        console.log('no cumple2');

                        document.getElementById("errorPass").classList.remove("d-none");
                    }
                }
            })

            function validarContraseñas(pass1, pass2) {
                if (pass1 !== pass2) 
                    return false;
                
                if (pass1.length < 8) 
                    return false;

                const lowercaseCount = (pass1.match(/[a-z]/g) || []).length;
                const uppercaseCount = (pass1.match(/[A-Z]/g) || []).length;
                const numberCount = (pass1.match(/[0-9]/g) || []).length;
                const specialCharCount = (pass1.match(/[^a-zA-Z0-9]/g) || []).length;

                if (
                    lowercaseCount < 2 ||
                    uppercaseCount < 2 ||
                    numberCount < 2 ||
                    specialCharCount < 2
                ) {
                    return false;
                }

                return true;
            }
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

        document.getElementById('guardarConfiguracion').addEventListener('click', async function (e) {
            let valid = validarForm.validarCampos();
            if (valid == true && !valid.validationMessage) {
                let edta = validarForm.crearObjetoJson()
                edta.clave = document.getElementById('clave').textContent;
                console.log(edta);
                this.disabled = true;
                let rdta = await fetch('controller/ControllerAdmin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        accion: 'ActualizarConfiguracion',
                        data: edta,
                        csrf_token: document.getElementById('csrf_token').value
                    })
                }).then((res) => {
                    if (res.status == 200) {
                        return res.json()
                    }
                }).catch((res) => {
                    //console.error(res.statusText);
                    return res;
                })
                this.disabled = false;
                
                //console.log(rdta);
                if (rdta == true) {
                    Swal.fire({
                        title: '¡Configuración guardada!',
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
                            location.href = 'inicioAdmin';
                        }
                    })
                }else{
                    console.log(rdta);
                }
            } else {
                Swal.fire('invalida');
            }
        })
    })();
}