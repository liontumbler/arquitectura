document.querySelector('body').onload = (e) => {
    (function () {

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
                op.setAttribute('precio', horas[i].precio);
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

        let audi;
        let voz;

        let validarForm1;
        let validarForm2;
        let validarForm3;
        let validarForm4;
        let validarForm5;
        let validarForm6;
        let validarForm7;
        let validarForm8;

        let resCli = cargarClientes();
        let resHra = cargarHoras();
        let resEqui = cargarEquipos();
        cargarMinDemas();
        //console.log(resCli, resHra, resEqui);
        resCli.then(function () {
            resHra.then(function () {
                resEqui.then(function () {
                    //voz = new Voice().hoverTitle();
                    //audi = new PlaySound('resources/audio/iphone-notificacion.mp3');

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
                document.getElementById('total').textContent = document.querySelector("#selectHora option[value='"+ this.value +"']").getAttribute('precio');
            } else
                document.getElementById('total').textContent = '';
        });

        document.getElementById('agregarLiga').addEventListener('click', async function(e) {
            this.disabled = true;
            //audi.reproducirAudio();
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
            console.log(valid);
            
            if(valid == true && !valid.validationMessage){
                msgClave(async function () {
                    let edta = form.crearObjetoJson();
                    //console.log(minDemas);
                    if (!fechaDefault.checked) {
                        edta['fechaInicio'] = form.obtenerFechaHoraServer(fechaInicio.value, minDemas);
                    }

                    console.log(edta);

                    let rdta = await fetch('controller/ControllerLigas.php', {
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
                            title: '¡Liga Ingresada!',
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
                    }else{
                        if (rdta == -1) {
                            clienteYaExiste(function (res) {
                                validarForm1.limpiar();
                                validarForm2.limpiar();
                                validarForm3.limpiar();
                                validarForm4.limpiar();
                                validarForm5.limpiar();
                                validarForm6.limpiar();
                                validarForm7.limpiar();
                                validarForm8.limpiar();
                            })
                        } else if(rdta == 'T'){
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
                                    title: 'No se agregó la liga',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    location.href = './index';
                                })
                            }
                        }
                    }
                }, location.href)
            }else{
                this.disabled = false;
            }
        });
    })();
}