document.getElementById('btnSidebar').addEventListener('click', function (e) {
    if(document.getElementById('sideBar').style.display == 'block')
        document.getElementById('sideBar').style.display = 'none';
    else
        document.getElementById('sideBar').style.display = 'block';
});