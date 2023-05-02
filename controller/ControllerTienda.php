<?php
require_once 'Controller.php';

class ControllerTienda extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postVender($dta)
    {
        return $this->model('ModelTienda')->vender($dta);
    }

    public function postCargarClientes()
    {
        return $this->model('ModelCliente')->clientes();
    }

    public function postCargarProductos()
    {
        return $this->model('ModelProducto')->productos();
    }

    public function postCargarEquipos()
    {
        return $this->model('ModelEquipo')->equipos();
    }

    
}

echo redirec('ControllerTienda');
?>