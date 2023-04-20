<?php
if (!$rutasLegitima) {
    header('Location: ../index');
}elseif (isset($_SESSION['SesionTrabajador']) && $_SESSION['SesionTrabajador']){
    header('Location: trabajando');
}

require_once 'view.php';

class PaginaOnce extends Web implements PaginaX
{
    function __construct($title, $description, $keywords)
    {
        parent::__construct($title, $description, $keywords);
    }

    public function content()
    {
        ?>
        <div class="d-flex">
            <?php require_once 'layout/sidebar.php'; ?>
            <div id="contentConSidebar">
                <div class="m-4">
                    
                    <div class="container" style="width: 450px;">
                        <div class="row">
                            <?= input_csrf_token(); ?>
                            <div class="col-lg-12 mb-1">
                                <label for="nickname" class="form-label">Nickname *</label>
                                <input type="text" class="form-control" id="nickname" placeholder="Dijite la nickname del trabajador" required minlength="1" maxlength="50">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="clave" class="form-label">Clave *</label>
                                <input type="password" class="form-control" id="clave" placeholder="Dijite la clave del trabajador" required minlength="1" maxlength="50">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <label for="caja" class="form-label">Caja *</label>
                                <input type="number" class="form-control" id="caja" placeholder="Dijite el monto del efectivo" required max="1000000" min="0" value="0">
                            </div>
                            <div class="col-lg-12 mb-1">
                                <div class="d-grid gap-2">
                                    <button id="trabajar" class="btn btn-primary" type="button">trabajar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function footer()
    {
        ?>
        <script>
            class Validardor {
                constructor(campos = []) {
                    this.campos = campos;
                    for (const i in this.campos) {
                        const campo = this.campos[i];
                        const campoMask = campo+'Mask';

                        if(document.getElementById(campo)){
                            this[campoMask] = document.getElementById(campo).cloneNode(true);
                            this[campo] = document.getElementById(campo);
                        }else if(document.querySelector('input[type="radio"][name="'+ campo +'"]:checked')){
                            this[campoMask] = document.querySelector('input[type="radio"][name="'+ campo +'"]:checked').cloneNode(true);
                            this[campo] = document.querySelector('input[type="radio"][name="'+ campo +'"]:checked');
                        }else{
                            console.error('no existe id o name');
                            return;
                        }

                        const input = this[campo];
                        const inputMask = this[campoMask];
                        if(inputMask.type == 'text' || inputMask.type == 'number' || inputMask.type == 'password'){
                            input.addEventListener('input', (e) => {
                                input.value = input.value.replace(/^<SCRIPT>|<\/SCRIPT>|<script>|<\/script>|<\/|<|>|=/g, '');
                            });
                        }

                        input.addEventsListeners = function(events, func) {
                            events = events.replace(' ', '');
                            var event = events.split(',');
                            for (const e in event) {
                                input.addEventListener(event[e], func, false);
                            }
                        }

                        input.hide = function () {
                            input.style.display = 'none';
                        }

                        input.show = function () {
                            input.style.display = 'block';
                        }

                        input.show = function () {
                            input.style.display = 'block';
                        }

                        if(input.getAttribute('alfaNS') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = input.value.replace(/[^A-Za-zñÑ]/g, '');
                            });
                        }

                        if(input.getAttribute('textNS') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = input.value.replace(/[^0-9A-Za-zñÑ]/g, '');
                            });
                        }

                        if(input.getAttribute('numberNS') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = input.value.replace(/[^0-9]/g, '');
                            });
                        }

                        if(input.getAttribute('alfaLowerCaseNS') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = input.value.replace(/[A-ZÑ]/g, input.value.toLowerCase()).replace(/[^a-zñ]/g, '');
                            });
                        }

                        if(input.getAttribute('alfaUpperCaseNS') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = input.value.replace(/[a-zñ]/g, input.value.toUpperCase()).replace(/[^A-ZÑ]/g, '');
                            });
                        }

                        if(input.getAttribute('alfa') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = input.value.replace(/[^A-Za-zñÑ ]/g, '').replace(/\s+/g, ' ');
                            });
                        }

                        if(input.getAttribute('text') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = input.value.replace(/[^0-9A-Za-zñÑ ]/g, '').replace(/\s+/g, ' ');
                            });
                        }

                        if(input.getAttribute('number') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = input.value.replace(/[^0-9 ]/g, '').replace(/\s+/g, ' ');
                            });
                        }

                        if(input.getAttribute('alfaLowerCase') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = input.value.replace(/[A-ZÑ]/g, input.value.toLowerCase()).replace(/[^a-zñ ]/g, '').replace(/\s+/g, ' ');
                            });
                        }

                        if(input.getAttribute('alfaUpperCase') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = input.value.replace(/[a-zñ]/g, input.value.toUpperCase()).replace(/[^A-ZÑ ]/g, '').replace(/\s+/g, ' ');
                            });
                        }

                        if(input.getAttribute('textTilde') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = input.value.replace(/[^0-9A-Za-zñÑÁáÉéÍíÓóÚú.,:; ]/g, '').replace(/\s+/g, ' ');
                            });
                        }

                        if(input.getAttribute('textTilde') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = input.value.replace(/[^0-9 ]/g, '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                            });
                        }

                        if(input.getAttribute('email') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = input.value.replace(/[^0-9A-Za-zñÑ@\-\_.]/g, '');
                            });
                        }

                        if(input.getAttribute('textArroba') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = input.value.replace(/[^0-9A-Za-zñÑ@]/g, '');
                            });
                        }

                        if(input.getAttribute('noCopy') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = this.#quitarEventCopy(input);
                            });
                        }

                        if(input.getAttribute('noPaste') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = this.#quitarEventPaste(input);
                            });
                        }

                        if(input.getAttribute('noCut') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = this.#quitarEventCut(input);
                            });
                        }

                        if(input.getAttribute('noDrag') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = this.#quitarEventDrag(input);
                            });
                        }

                        if(input.getAttribute('protected') == ''){
                            input.addEventListener('input', (e) => {
                                input.value = this.#quitarEventDrag(input);
                                input.value = this.#quitarEventCopy(input);
                                input.value = this.#quitarEventPaste(input);
                                input.value = this.#quitarEventCut(input);
                            });
                        }

                        

                    

                    }//for

                }

                crearFormData() {
                    let formData = new FormData();
                    for (const i in this.campos) {
                        const campo = this.campos[i];
                        const campoMask = campo+'Mask';

                        let input = this[campo];
                        let inputMask = this[campoMask];

                        if(inputMask.type == 'radio'){
                            let value = (inputMask.value && inputMask.value != 'on') ? inputMask.value : 1;
                            formData.append(campo, value);
                        }else if(input.type == 'file' && input.files.length > 0){
                            for (const i in input.files.length) {
                                formData.append(input.id + '[]', input.files[i]);
                            }
                        }else{
                            formData.append(campo, input.value);
                        }
                        
                    }
                    return formData;
                }

                crearObjetoJson() {
                    let data = {};
                    for (const i in this.campos) {
                        const campo = this.campos[i];
                        const campoMask = campo+'Mask';

                        let input = this[campo];
                        let inputMask = this[campoMask];

                        if(inputMask.type == 'radio'){
                            let value = (inputMask.value && inputMask.value != 'on') ? inputMask.value : 1;
                            data[campo] = value;
                        }else if(input.type == 'file' && input.files.length > 0){
                            data['files'] = input.files;
                        }else{
                            data[campo] = input.value;
                        }
                    }
                    return data;
                }

                validarCampos() {
                    for (const i in this.campos) {
                        const campo = this.campos[i];
                        const campoMask = campo+'Mask';

                        let input = this[campo];
                        let inputMask = this[campoMask];

                        if(inputMask.type == 'text' || inputMask.type == 'number' || inputMask.type == 'password'){
                            inputMask.value = input.value;
                        }else if (inputMask.type == 'radio') {
                            console.log('es radio');
                        }


                        if (!inputMask.value && inputMask.required) {
                            //console.log('no hay valor');
                            input.setCustomValidity(inputMask.validationMessage);
                            input.focus();
                            input.select();
                            return input;
                        }

                        if(inputMask.type == 'number'){
                            //console.log(inputMask.max, inputMask.min, inputMask.value);
                            if(inputMask.max && parseInt(inputMask.value) > parseInt(inputMask.max)){
                                input.setCustomValidity(inputMask.validationMessage);
                                input.focus();
                                input.select();
                                return input;
                            }else if(inputMask.min && parseInt(inputMask.value) < parseInt(inputMask.min)){
                                input.setCustomValidity(inputMask.validationMessage);
                                input.focus();
                                input.select();
                                return input;
                            }
                        }

                        if(inputMask.type == 'text' || inputMask.type == 'number' || inputMask.type == 'password'){
                            //console.log(inputMask.getAttribute('maxlength'), inputMask.getAttribute('minlength'), inputMask.maxlength);
                            if(inputMask.getAttribute('maxlength') && parseInt(inputMask.value.length) > parseInt(inputMask.getAttribute('maxlength'))){
                                input.setCustomValidity(inputMask.validationMessage);
                                input.focus();
                                input.select();
                                return input;
                            } else if(inputMask.getAttribute('minlength') && parseInt(inputMask.value.length) < parseInt(inputMask.getAttribute('minlength'))){
                                input.setCustomValidity(inputMask.validationMessage);
                                input.focus();
                                input.select();
                                return input;
                            }
                        }

                        //console.log(inputMask.validity.valid, inputMask.checkValidity());
                        if (!(inputMask.validity.valid && inputMask.checkValidity())) {
                            input.setCustomValidity(inputMask.validationMessage);
                            input.focus();
                            input.select();
                            return input;
                        }
                    }

                    return true;
                }

                bloqueoInspecionar() {
                    let body = document.querySelector('body');
                    body.addEventListener('contextmenu', (e) => {
                        e.preventDefault();
                    });
                    body.addEventListener('keydown', (e) => {
                        if (e.key == 'F12' || (e.ctrlKey && e.shiftKey && e.key == 'I'))
                            e.preventDefault();
                    });
                    body.addEventListener('keyup', (e) => {
                        if (e.key == 'F12' || (e.ctrlKey && e.shiftKey && e.key == 'I'))
                            e.preventDefault();
                    });
                    body.addEventListener('keypress', (e) => {
                        if (e.key == 'F12' || (e.ctrlKey && e.shiftKey && e.key == 'I'))
                            e.preventDefault();
                    });
                    this.bloqueoMsgConsole();
                }

                bloqueoMsgConsole() {
                    console.log = () => {};
                    console.warn = () => {};
                    console.error = () => {};
                    console.count = () => {};
                    console.table = () => {};
                    console.time = () => {};
                    console.timeEnd = () => {};
                    console.trace = () => {};
                    console.info = () => {};
                    console.debug = () => {};
                    console.countReset = () => {};
                    console.timeLog = () => {};
                    console.group = () => {};
                    console.groupEnd = () => {};
                    console.groupCollapsed = () => {};
                    console.clear = () => {};
                }

                #quitarEventDrag(input) {
                    input.addEventsListeners('dragover, dragstart, drop, drag, dragend', function (e){
                        e.preventDefault();
                    });
                }

                #quitarEventCopy(input) {
                    input.addEventListener('copy', function (e){
                        e.preventDefault();
                    });
                }

                #quitarEventPaste(input) {
                    input.addEventListener('paste', function (e){
                        e.preventDefault();
                    });
                }

                #quitarEventCut(input) {
                    input.addEventListener('cut', function (e){
                        e.preventDefault();
                    });
                }
            }

            let validar;
            document.querySelector('body').onload = (e) => {
                console.log('termino de cargar vista');
                validar = new Validardor(['nickname', 'clave' ,'caja']);
                console.log(validar.nickname, validar);
            }

            document.getElementById('trabajar').addEventListener('click', async function(e) {
                let valid = validar.validarCampos()
                //valid.focus()
                console.log(valid, valid.validationMessage);
                //this.disabled = true;
                if(valid && !valid.validationMessage){
                    console.log(':)');
                    console.log(validar.crearFormData());
                    console.log(validar.crearObjetoJson());

                    let edta = validar.crearObjetoJson();

                    /*let nickname = document.getElementById('nickname').value;
                    let clave = document.getElementById('clave').value;
                    let caja = document.getElementById('caja').value;*/
                    let csrf_token = document.getElementById('csrf_token').value;

                    let rdta = await fetch('controller/ControllerLogin.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            accion: 'Login',
                            data: edta,//{ nickname, clave, caja},
                            csrf_token
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

                    console.log(rdta, 'login');
                    if(rdta){
                        location.href = 'trabajando';
                    }
                    
                }
            });

            
        </script>
        <?php
    }
}

$index = new PaginaOnce('Login Trabajadores', '', '');
echo $index->crearHtml();

?>