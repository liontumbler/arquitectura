<?php
require_once 'Controller.php';

class ControllerProductos extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postCargarProdutos()
    {
        return $this->model('ModelProducto')->cargarProdutos();
    }

    public function postAgregarProducto($dta)
    {
        return $this->model('ModelProducto')->agregarProducto($dta);
    }


    

    
}

echo redirec('ControllerProductos');
?>