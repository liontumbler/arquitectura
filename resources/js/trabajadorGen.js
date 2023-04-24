//sacar un archivo para trabajadores
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

setInterval(mueveReloj, 1000);