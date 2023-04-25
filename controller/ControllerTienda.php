<?php
require_once 'Controller.php';
use Controllers\Controller;

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
        return $this->model('ModelTienda')->clientes();
    }

    public function postCargarProductos()
    {
        return $this->model('ModelTienda')->productos();
    }

    public function postCargarEquipos()
    {
        return $this->model('ModelTienda')->equipos();
    }

    
}

require_once 'Redirecionar.php';
echo redirec('ControllerTienda');
?>