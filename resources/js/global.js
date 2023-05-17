if (document.getElementById('sideBar')) {
    document.getElementById('sideBar').style.display = 'none';
    //document.getElementById('sideBar').style.display = 'block';
}

if (document.getElementById('btnSidebar')) {
    document.getElementById('btnSidebar').addEventListener('click', function (e) {
        if(document.getElementById('sideBar').style.display == 'block')
            document.getElementById('sideBar').style.display = 'none';
        else
            document.getElementById('sideBar').style.display = 'block';
    });
}

//document.querySelector('.table .table-striped')
//$('.table.table-striped').css('width', '100%');

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

function cargando() {
    if (!document.getElementById('cargando')) {
        let cargando = document.createElement('div');
        cargando.style.cssText = 'width: 100%; height: 100%; position: fixed; background: #000000db; top: 0; z-index: 1031; display: flex; align-items: center;'
        cargando.id = 'cargando';
        cargando.innerHTML = `
        <div class="text-center" style="display: block;margin: auto;">
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h2 style="color: #fff;">Cargando...</h2>
        </div>
        `;
        document.querySelector('body').append(cargando);
    }
}

function endCargando() {
    if (document.getElementById('cargando')) {
        document.getElementById('cargando').remove();
    }
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

class Voice {
    #time = null;
    #voice = null;
    #nativeVoice = null;

    constructor(){
        if (!'speechSynthesis' in window) {
            console.error('no soporta voz el navegador');
        }else{
            this.#nativeVoice = window.speechSynthesis;
            this.#voice = new SpeechSynthesisUtterance();
        }
    }

    validar() {
        return (this.#voice && this.#nativeVoice);
    }

    hablar(text, voz = 7, velocidad = 1) {
        if (this.validar() && this.#nativeVoice.getVoices()[voz]) {
            this.#voice.voice = this.#nativeVoice.getVoices()[voz];//21
            this.#voice.rate = velocidad;//2
            //this.#voice.volume = 0.5;//1
            this.#voice.text = text;
            
            this.#nativeVoice.speak(this.#voice);
        }else{
            console.error('El navegador no soporta voz');
        }
    }

    hoverTitle() {
        document.querySelectorAll('[title]').forEach((title) => {
            title.addEventListener("mouseover", (e) => {
                if (this.#voice.text == title.title && this.#nativeVoice.paused && this.#nativeVoice.speaking) {
                    this.#nativeVoice.resume()
                } else {
                    this.#nativeVoice.cancel();
                    this.#time = setTimeout(() => {
                        this.hablar(title.title);
                    }, 500);
                }
                //console.log(this.#voice, this.#nativeVoice, 1);
            });
        
            title.addEventListener("mouseout", (e) => {
                if (this.#nativeVoice.speaking) {
                    this.#nativeVoice.pause();
                }
                clearTimeout(this.#time);
            });
        })
    }
}

class PlaySound {
    #audio;
    constructor(rutaArchivo) {
        this.#audio = new Audio(rutaArchivo);
        this.#audio.currentTime = 0.2;
        this.#audio.id = 'voice';
    }

    reproducirAudio(fun = null) {
        this.#audio.play();
        this.#audio.onended = function (e) {
            if(fun)
                fun();
        }
    }
}

class Validardor {
    constructor(campos = []) {
        this.campos = campos;
        for (const i in this.campos) {
            const campo = this.campos[i];
            const campoMask = '#'+campo+'Mask';

            if(document.getElementById(campo)){
                this[campoMask] = document.getElementById(campo).cloneNode(true);
                this[campo] = document.getElementById(campo);
            }else if(document.querySelector('input[type="radio"][name="'+ campo +'"]:checked')){
                this[campoMask] = document.querySelector('input[type="radio"][name="'+ campo +'"]:checked').cloneNode(true);
                this[campo] = document.querySelector('input[type="radio"][name="'+ campo +'"]:checked');
            }else{
                console.error('no existe id o name', campo);
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

            if(input.getAttribute('alfans') == ''){
                input.addEventListener('input', (e) => {
                    input.value = input.value.replace(/[^A-Za-zñÑ]/g, '');
                });
            }

            if(input.getAttribute('textns') == ''){
                input.addEventListener('input', (e) => {
                    input.value = input.value.replace(/[^0-9A-Za-zñÑ]/g, '');
                });
            }

            if(input.getAttribute('numberns') == ''){
                input.addEventListener('input', (e) => {
                    input.value = input.value.replace(/[^0-9]/g, '');
                });
            }

            if(input.getAttribute('alfalowercasens') == ''){
                input.addEventListener('input', (e) => {
                    input.value = input.value.replace(/[A-ZÑ]/g, input.value.toLowerCase()).replace(/[^a-zñ]/g, '');
                });
            }

            if(input.getAttribute('alfauppercasens') == ''){
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

            if(input.getAttribute('alfalowerCase') == ''){
                input.addEventListener('input', (e) => {
                    input.value = input.value.replace(/[A-ZÑ]/g, function(letra) {
                        return letra.toLowerCase();
                    }).replace(/[^a-zñ ]/g, '').replace(/\s+/g, ' ');
                });
            }

            if(input.getAttribute('alfaupperCase') == ''){
                input.addEventListener('input', (e) => {
                    input.value = input.value.replace(/[a-zñ]/g, function(letra) {
                        return letra.toUpperCase();
                    }).replace(/[^A-ZÑ ]/g, '').replace(/\s+/g, ' ');
                });
            }

            if(input.getAttribute('texttilde') == ''){
                input.addEventListener('input', (e) => {
                    input.value = input.value.replace(/[^0-9A-Za-zñÑÁáÉéÍíÓóÚú.,:; ]/g, '').replace(/\s+/g, ' ');
                });
            }

            if(input.getAttribute('numberpoin') == ''){
                input.addEventListener('input', (e) => {
                    input.value = input.value.replace(/[^0-9 ]/g, '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                });
            }

            if(input.getAttribute('email') == ''){
                input.addEventListener('input', (e) => {
                    input.value = input.value.replace(/[^0-9A-Za-zñÑ@\-\_.]/g, '');
                });
            }

            if(input.getAttribute('textarroba') == ''){
                input.addEventListener('input', (e) => {
                    input.value = input.value.replace(/[^0-9A-Za-zñÑ@]/g, '');
                });
            }

            if(input.getAttribute('nocopy') == ''){
                input.addEventListener('input', (e) => {
                    input.value = this.#quitarEventCopy(input);
                });
            }

            if(input.getAttribute('nopaste') == ''){
                input.addEventListener('input', (e) => {
                    input.value = this.#quitarEventPaste(input);
                });
            }

            if(input.getAttribute('nocut') == ''){
                input.addEventListener('input', (e) => {
                    input.value = this.#quitarEventCut(input);
                });
            }

            if(input.getAttribute('nodrag') == ''){
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
            const campoMask = '#'+campo+'Mask';

            let input = this[campo];
            let inputMask = this[campoMask];

            if(inputMask.type == 'radio'){
                let value = (inputMask.value && inputMask.value != 'on') ? inputMask.value : 1;
                formData.append(campo, value);
            }else if(input.type == 'file' && input.files.length > 0){
                for (const i in input.files.length) {
                    formData.append(input.id + '[]', input.files[i]);
                }
            }else if(inputMask.type == 'number'){
                formData.append(campo, parseInt(input.value));
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
            const campoMask = '#'+campo+'Mask';

            let input = this[campo];
            let inputMask = this[campoMask];

            if(inputMask.type == 'radio'){
                let value = (document.querySelector('[name="'+campo+'"]:checked').value && document.querySelector('[name="'+campo+'"]:checked').value != 'on') ? document.querySelector('[name="'+campo+'"]:checked').value : 1;
                data[campo] = value;
            }else if(inputMask.type == 'file' && inputMask.files.length > 0){
                data['files'] = input.files;
            }else if(inputMask.type == 'number'){
                data[campo] = parseInt(input.value);
            }else{
                data[campo] = input.value;
            }
        }
        return data;
    }

    limpiar() {
        let data = {};
        for (const i in this.campos) {
            const campo = this.campos[i];
            const campoMask = '#'+campo+'Mask';

            let input = this[campo];
            let inputMask = this[campoMask];

            if(inputMask.type == 'checkbox'){ //inputMask.type == 'radio' || 
                input.checked = false;
                inputMask.checked = false;
            }else if(input.type == 'file' && input.files.length > 0){
                input.value = '';
                inputMask.value = '';
            }else if(inputMask.type == 'number'){
                input.value = '';
                inputMask.value = '';
            }else{
                input.value = '';
                inputMask.value = '';
            }
        }
        return data;
    }

    obtenerFechaHoraServer(value, minDeMas = 0, horasDeMas = 0) {

        const fecha = new Date(value);
        const anio = fecha.getFullYear();
        const mes = fecha.getMonth() + 1 < 10 ? `0${fecha.getMonth() + 1}` : fecha.getMonth() + 1;
        const dia = fecha.getDate() < 10 ? `0${fecha.getDate()}` : fecha.getDate();

        fecha.setHours(fecha.getHours() + parseInt(horasDeMas));
        const horas = fecha.getHours() < 10 ? `0${fecha.getHours()}` : fecha.getHours();

        fecha.setMinutes(fecha.getMinutes() + parseInt(minDeMas));
        const minutos = fecha.getMinutes() < 10 ? `0${fecha.getMinutes()}` : fecha.getMinutes();

        const segundos = fecha.getSeconds() < 10 ? `0${fecha.getSeconds()}` : fecha.getSeconds();

        return `${anio}-${mes}-${dia} ${horas}:${minutos}:${segundos}`;
    }

    convertirLetrasANumeroPoin(texto) {
        let cadena = texto.toString();
        cadena = cadena.replace(/[^\d.]/g, '').replace('.', ',');
        if (!cadena)
            return false;

        let partes = cadena.split(',');
        partes[0] = parseInt(partes[0]).toLocaleString();

        return partes.join(',');
    }

    validarCampos() {
        for (const i in this.campos) {
            const campo = this.campos[i];
            const campoMask = '#'+campo+'Mask';

            let input = this[campo];
            let inputMask = this[campoMask];

            if (inputMask.type != 'radio' && inputMask.type != 'checkbox') {
                inputMask.value = input.value;
            }

            if (!inputMask.value && inputMask.required) {
                //console.log('no hay valor', inputMask.value, '2', input.value);
                input.setCustomValidity(inputMask.validationMessage);
                input.focus();
                if (input.select) 
                    input.select();

                return input;
            }

            if(inputMask.type == 'number'){
                //console.log(inputMask.max, inputMask.min, inputMask.value);
                if(inputMask.max && parseInt(inputMask.value) > parseInt(inputMask.max)){
                    input.setCustomValidity(inputMask.validationMessage);
                    input.focus();
                    if (input.select) 
                        input.select();

                    return input;
                }else if(inputMask.min && parseInt(inputMask.value) < parseInt(inputMask.min)){
                    input.setCustomValidity(inputMask.validationMessage);
                    input.focus();
                    if (input.select)
                        input.select();

                    return input;
                }
            }

            if(inputMask.type == 'text' || inputMask.type == 'number' || inputMask.type == 'password'){
                //console.log(inputMask.getAttribute('maxlength'), inputMask.getAttribute('minlength'), inputMask.maxlength);
                if(inputMask.value && inputMask.getAttribute('maxlength') && parseInt(inputMask.value.length) > parseInt(inputMask.getAttribute('maxlength'))){
                    input.setCustomValidity(inputMask.validationMessage);
                    input.focus();
                    if (input.select) 
                        input.select();

                    return input;
                } else if(inputMask.value && inputMask.getAttribute('minlength') && parseInt(inputMask.value.length) < parseInt(inputMask.getAttribute('minlength'))){
                    input.setCustomValidity(inputMask.validationMessage);
                    input.focus();
                    if (input.select) 
                        input.select();

                    return input;
                }
            }

            //console.log(inputMask.validity.valid, inputMask.checkValidity());
            if (!(inputMask.validity.valid && inputMask.checkValidity())) {
                input.setCustomValidity(inputMask.validationMessage);
                input.focus();
                if (input.select) 
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