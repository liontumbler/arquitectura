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