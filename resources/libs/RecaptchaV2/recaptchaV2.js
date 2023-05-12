
/**
 * facil implementacion recaptchaV2
 * validarRV2L() valida recaptcha desde cliente (puede dar error de cors)
 * validarRV2S() valida recaptcha desde servidor con un archivo php (mejor opcion)
 * Autor: edwin velasquez jimenez
*/

function RecaptchaV2(element, keyPublic) {
    //challenge_ts: "2022-06-24T13:20:47Z"
    //hostname: "localhost"

    let div = document.createElement('div');
    div.className = 'g-recaptcha';
    div.setAttribute('data-sitekey', keyPublic);

    let script = document.createElement('script');
    script.src = 'https://www.google.com/recaptcha/api.js?';
    script.async = true;
    script.defer = true;

    element.append(div);
    element.append(script);
    
    this.validarRV2L = function(fn, keySecret) {
        let token = grecaptcha.getResponse();
        if(!token){
            fn(false);
        }else{

            fetch('https://www.google.com/recaptcha/api/siteverify?response='+ token +'&secret='+ keySecret, {
                method: 'GET',
            }).then(data => {
                //console.log('then1', data);
                if(!data.ok)
                    return data.ok;

                return data.json();
            }).then(data => {
                if(data){
                    let resRecaptcha = data;

                    let validador = validarResRecaptcha(resRecaptcha);

                    fn(validador);
                }else{
                    console.error('errorRecaptcha', 'servidor google no response');
                    fn(false);
                }
            }).catch(error => {
                console.error('errorRecaptcha', error);
                fn(false);
            });
        }
    }

    this.validarRV2S = function(fn, rutaServidor = 'scaptcha.php') {
        let token = grecaptcha.getResponse();
        if(!token){
            fn(false);
        }else{
            let datos = new FormData();
            datos.append('response', token);
            fetch(rutaServidor, {
                method: 'POST',
                body: datos,
            }).then(data => {
                if(!data.ok)
                    return data.ok;

                return data.json();
            }).then(data => {
                if(data){
                    let resRecaptcha = data;

                    let validador = validarResRecaptcha(resRecaptcha);

                    fn(validador);
                }else{
                    console.error('errorRecaptcha', 'servidor google no response');
                    fn(false);
                }
            }).catch(error => {
                console.error('errorRecaptcha', error);
                fn(false);
            });
        }
    }

    function validarResRecaptcha(res) {
        let validador = false;
        if (res.success)
            validador = true;

        return validador;
    }
}