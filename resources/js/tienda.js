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
                console.error(res.statusText);
                return res;
            })

            let select = document.getElementById('cliente');
            for (let i = 0; i < clientes.length; i++) {
                //console.log(clientes[i], 'llena');
                let op = new Option(clientes[i].nombresYapellidos, clientes[i].id)
                select.append(op);
            }
        }

        async function cargarProductos() {
            let productos = await fetch('controller/ControllerTienda.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    accion: 'CargarProductos',
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
                console.error(res.statusText);
                return res;
            })

            let select = document.getElementById('producto');
            for (let i = 0; i < productos.length; i++) {
                //console.log(productos[i], 'llena');
                let op = new Option(productos[i].nombre, productos[i].id)
                op.setAttribute('precio', productos[i].precio);
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
                console.error(res.statusText);
                return res;
            })

            let select = document.getElementById('equipo');
            for (let i = 0; i < equipos.length; i++) {
                //console.log(equipos[i], 'llena');
                let op = new Option(equipos[i].nombre, equipos[i].id)
                select.append(op);
            }
        }

        let validarForm1;
        let validarForm2;
        let validarForm3;
        let validarForm4;

        let resCli = cargarClientes();
        let resPro = cargarProductos();
        let resEqui = cargarEquipos();
        //console.log(resCli, resPro, resEqui);
        resCli.then(function () {
            resPro.then(function () {
                resEqui.then(function () {
                    validarForm1 = new Validardor(['cliente', 'producto' ,'cantidad', 'tipoPago']);
                    validarForm2 = new Validardor(['nombreYapellido', 'documento', 'equipo', 'producto' ,'cantidad', 'tipoPago']);
                    validarForm3 = new Validardor(['cliente', 'producto' ,'cantidad']);
                    validarForm4 = new Validardor(['nombreYapellido', 'documento', 'equipo', 'producto' ,'cantidad']);
                })
            })
        })

        if(document.getElementById('checkCliente').checked){
            document.getElementById('divClienteNA').style.display = 'none';
            document.getElementById('divClienteD').style.display = 'none';
            document.getElementById('divClienteEQ').style.display = 'none';
        }

        document.getElementById('checkCliente').addEventListener('change', function (e) {
            if(this.checked){
                document.getElementById('divClienteNA').style.display = 'none';
                document.getElementById('divClienteD').style.display = 'none';
                document.getElementById('divClienteEQ').style.display = 'none';
                document.getElementById('divClientePre').style.display = 'block';
            }
            else{
                document.getElementById('divClienteNA').style.display = 'block';
                document.getElementById('divClienteD').style.display = 'block';
                document.getElementById('divClienteEQ').style.display = 'block';
                document.getElementById('divClientePre').style.display = 'none';
            }
        });
        
        document.getElementById('pago').addEventListener('change', function (params) {
            if(!this.checked)
                document.getElementById('divpago').style.display = 'none';
            else
                document.getElementById('divpago').style.display = 'block';
        });

        document.getElementById('producto').addEventListener('change', function (e) {
            if(document.querySelector("#producto option[value='"+ this.value +"']").getAttribute('precio')){
                let cantidad = document.getElementById('cantidad').value ? parseInt(document.getElementById('cantidad').value) : 0;
                document.getElementById('total').textContent = document.querySelector("#producto option[value='"+ this.value +"']").getAttribute('precio') * cantidad;
            }
            else
                document.getElementById('total').textContent = '';
        });

        document.getElementById('cantidad').addEventListener('input', function (e) {
            let cantidad = this.value ? parseInt(this.value) : 0;
            document.getElementById('total').textContent = document.querySelector("#producto option[value='"+ document.getElementById('producto').value +"']").getAttribute('precio') * cantidad;
        });

        document.getElementById('vender').addEventListener('click', async function (e) {
            let checkCliente = document.getElementById('checkCliente');
            let pago = document.getElementById('pago');
            //console.log(valid, valid.validationMessage);
            let form = '';
            if(checkCliente.checked && pago.checked){
                form = validarForm1
            }else if(!checkCliente.checked && pago.checked){
                form = validarForm2
            } else if(checkCliente.checked && !pago.checked){
                form = validarForm3
            } else if(!checkCliente.checked && !pago.checked){
                form = validarForm4
            }

            let valid = form.validarCampos();
            if(valid && !valid.validationMessage){
                this.disabled = true;
                //console.log(form.crearObjetoJson());
                let edta = form.crearObjetoJson();
                let rdta = await fetch('controller/ControllerTienda.php', {
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
                    console.error(res.statusText);
                    return res;
                })

                console.log(rdta);
                if (rdta) {
                    Swal.fire({
                        title: '¡Producto Ingresado!',
                        text: "Quieres mantenerte en la página o ir al home",
                        icon: 'succes',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Mantenerme',
                        cancelButtonText: 'Ir Home'
                    }).then((result) => {
                        console.log(result);
                        if (result.isConfirmed) {
                            validarForm1.limpiar();
                            validarForm2.limpiar();
                            validarForm3.limpiar();
                            validarForm4.limpiar();
                        }else if (result.isDismissed) {
                            location.href = 'trabajando';
                        }else{
                            location.href = 'trabajando';
                        }
                    })
                }
            }
        })
    })();
}