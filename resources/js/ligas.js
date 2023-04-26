document.querySelector('body').onload = (e) => {
    (function () {
        console.log('termino de cargar vista');

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

        async function cargarHoras() {
            let horas = await fetch('controller/ControllerLigas.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    accion: 'CargarHoras',
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

            let select = document.getElementById('selectHora');
            for (let i = 0; i < horas.length; i++) {
                //console.log(horas[i], 'hora', horas[i].nombre);
                let op = new Option(horas[i].nombre, horas[i].id);
                op.setAttribute('horas', horas[i].horas);
                op.setAttribute('precio', horas[i].precio);
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

        let minDemas = 0;
        async function cargarMinDemas() {
            let min = await fetch('controller/ControllerLigas.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    accion: 'MinDemas',
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

            minDemas = min.minDeMasLiga;
        }

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

        let validarForm1;
        let validarForm2;
        let validarForm3;
        let validarForm4;
        let validarForm5;
        let validarForm6;
        let validarForm7;
        let validarForm8;

        let horDemas = 0;

        let resCli = cargarClientes();
        let resHra = cargarHoras();
        let resEqui = cargarEquipos();
        cargarMinDemas();
        //console.log(resCli, resHra, resEqui);
        resCli.then(function () {
            resHra.then(function () {
                resEqui.then(function () {
                    validarForm1 = new Validardor(['cliente', 'selectHora']);
                    validarForm2 = new Validardor(['cliente', 'selectHora', 'tipoPago']);
                    validarForm3 = new Validardor(['cliente', 'selectHora', 'fechaInicio']);
                    validarForm4 = new Validardor(['cliente', 'selectHora', 'tipoPago', 'fechaInicio']);
                    validarForm5 = new Validardor(['nombreYapellido', 'documento', 'equipo', 'selectHora']);
                    validarForm6 = new Validardor(['nombreYapellido', 'documento', 'equipo', 'selectHora', 'tipoPago']);
                    validarForm7 = new Validardor(['nombreYapellido', 'documento', 'equipo', 'selectHora', 'fechaInicio']);
                    validarForm8 = new Validardor(['nombreYapellido', 'documento', 'equipo', 'selectHora', 'tipoPago', 'fechaInicio']);
                })
            })
        })

        if(document.getElementById('checkCliente').checked){
            document.getElementById('divClienteNA').style.display = 'none';
            document.getElementById('divClienteD').style.display = 'none';
            document.getElementById('divClienteEQ').style.display = 'none';
        }

        if (document.getElementById('fechaDefault').checked) {
            document.getElementById('divFechaDefault').style.display = 'none';
        }

        document.getElementById('checkCliente').addEventListener('change', function(e) {
            if (this.checked) {
                document.getElementById('divClienteNA').style.display = 'none';
                document.getElementById('divClienteD').style.display = 'none';
                document.getElementById('divClienteEQ').style.display = 'none';
                document.getElementById('divClientePre').style.display = 'block';
            } else {
                document.getElementById('divClienteNA').style.display = 'block';
                document.getElementById('divClienteD').style.display = 'block';
                document.getElementById('divClienteEQ').style.display = 'block';
                document.getElementById('divClientePre').style.display = 'none';
            }
        });

        document.getElementById('fechaDefault').addEventListener('change', function(e) {
            if (this.checked)
                document.getElementById('divFechaDefault').style.display = 'none';
            else
                document.getElementById('divFechaDefault').style.display = 'block';
        });

        document.getElementById('pago').addEventListener('change', function(e) {
            if (!this.checked)
                document.getElementById('divpago').style.display = 'none';
            else
                document.getElementById('divpago').style.display = 'block';
        });

        document.getElementById('selectHora').addEventListener('change', function(e) {
            if (document.querySelector("#selectHora option[value='"+ this.value +"']").getAttribute('precio')){
                horDemas = document.querySelector("#selectHora option[value='"+ this.value +"']").getAttribute('horas')
                document.getElementById('total').textContent = document.querySelector("#selectHora option[value='"+ this.value +"']").getAttribute('precio');
            } else
                document.getElementById('total').textContent = '';
        });

        document.getElementById('agregarLiga').addEventListener('click', async function(e) {
            //si es mas de las 11 no vender ligas

            let checkCliente = document.getElementById('checkCliente');
            let pago = document.getElementById('pago');
            let fechaDefault = document.getElementById('fechaDefault');
            //console.log(valid, valid.validationMessage);
            let form = '';
            if(checkCliente.checked && pago.checked && fechaDefault.checked){
                form = validarForm2
            } else if(checkCliente.checked && !pago.checked && fechaDefault.checked){
                form = validarForm1
            } else if(!checkCliente.checked && !pago.checked && fechaDefault.checked){
                form = validarForm5
            } else if(!checkCliente.checked && pago.checked && fechaDefault.checked){
                form = validarForm6
            } else if(checkCliente.checked && !pago.checked && !fechaDefault.checked){
                form = validarForm3
            } else if(!checkCliente.checked && !pago.checked && !fechaDefault.checked){
                form = validarForm7
            } else if(!checkCliente.checked && pago.checked && !fechaDefault.checked){
                form = validarForm8
            } else if(checkCliente.checked && pago.checked && !fechaDefault.checked){
                form = validarForm4
            }

            let valid = form.validarCampos();
            //console.log(valid);
            
            if(valid && !valid.validationMessage){
                Swal.fire({
                    title: 'necesitas la clave de la caja para agregar',
                    input: 'password',
                    inputPlaceholder: 'Clave 4 digitos',
                    inputAttributes: {
                        'minlength': '4',
                        'maxlength': '4',
                        'oninput': "this.value = this.value.replace(/[^0-9]/g, '')"
                    },
                    inputValidator: (value) => {
                        if (!value) {
                            return '¡El campo no puede estar vacío!'
                        }
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Ingresar Liga'
                }).then(async (result) => {
                    //console.log(result);
                    if (result.isConfirmed) {
                        let val = await claveCaja(result.value);
                        if (val) {
                            this.disabled = true;
                            let edta = form.crearObjetoJson()
                            //console.log(horDemas, minDemas);
                            if (fechaDefault.checked) {
                                edta['fechaInicio'] = form.obtenerFechaHoraServer((new Date().getTime() + minDemas * 60000));
                                edta['fechaFin'] = form.obtenerFechaHoraServer((new Date().getTime()), minDemas, horDemas);
                            } else {
                                edta['fechaInicio'] = form.obtenerFechaHoraServer(fechaInicio.value, minDemas);
                                edta['fechaFin'] = form.obtenerFechaHoraServer(fechaInicio.value, minDemas, horDemas);
                            }
                            //console.log(edta);

                            let rtda = await fetch('controller/ControllerLigas.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    accion: 'Vender',
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
                                //console.error(res.statusText);
                                return res;
                            })

                            console.log(rtda);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Clave Incorrecta',
                                showConfirmButton: false,
                                timer: 1500
                            }).then((result) => {
                                if (result.dismiss == 'timer' && result.isDismissed) {
                                    validarForm1.limpiar();
                                    validarForm2.limpiar();
                                    validarForm3.limpiar();
                                    validarForm4.limpiar();
                                    validarForm5.limpiar();
                                    validarForm6.limpiar();
                                    validarForm7.limpiar();
                                    validarForm8.limpiar();
                                }else{
                                    //location.href = location.href;
                                    alert('no seleciona ninguna op');
                                }
                            })
                        }
                    }else{
                        validarForm1.limpiar();
                        validarForm2.limpiar();
                        validarForm3.limpiar();
                        validarForm4.limpiar();
                        validarForm5.limpiar();
                        validarForm6.limpiar();
                        validarForm7.limpiar();
                        validarForm8.limpiar();
                    }
                })
            }
        });
    })();
}