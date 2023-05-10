<div id="sideBar">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" id="sideBarrar">
        <a href="index" class="fs-1 d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <i class="bi bi-clipboard-pulse"></i>&nbsp;
            <span class="fs-4"><?= $_SESSION['SesionTrabajador']['gimnasio'] ?></span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto overflow-auto" id="sbUl">
            <li class="nav-item">
                <a href="ligas" class="nav-link text-white" aria-current="page">
                    <i class="bi bi-alarm"></i>&nbsp;
                    Ligas
                </a>
            </li>
            <li>
                <a href="tienda" class="nav-link text-white">
                    <i class="bi bi-shop"></i>&nbsp;
                    Tienda
                </a>
            </li>
            <li>
                <a href="descuento" class="nav-link text-white">
                    <i class="bi bi-dash"></i>&nbsp;
                    Descuento
                </a>
            </li>
            <li>
                <a href="pagos" class="nav-link text-white">
                    <i class="bi bi-wallet"></i>&nbsp;
                    Pagos
                </a>
            </li>
            <li>
                <a href="quienDebe" class="nav-link text-white">
                    <i class="bi bi-patch-question"></i></i>&nbsp;
                    Quien Debe
                </a>
            </li>
            <li>
                <a href="trabajando" class="nav-link text-white">
                    <i class="bi bi-person-workspace"></i>&nbsp;
                    Trabajando
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <!--img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2"-->
                <strong><?= $_SESSION['SesionTrabajador']['nickName'] ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="/index">inicio</a></li>
                <li><a class="dropdown-item" href="/PQR">PQR</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item" href="javascript:" id="sbTerminar">
                        <i class="bi bi-power"></i>&nbsp;Terminar
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>