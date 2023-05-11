<?php
require_once 'Controller.php';

class ControllerPagos extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postCargarLigasCaja()
    {
        return $this->model('ModelLiga')->cargarLigasCaja();
    }

    public function postCargarTiendaCaja()
    {
        return $this->model('ModelTienda')->cargarTiendaCaja();
    }

    public function postCargarPagosCaja()
    {
        return $this->model('ModelPagos')->cargarPagosCaja();
    }

    public function postCargarListaPagosCajaId($dta)
    {
        return $this->model('ModelPagos')->cargarListaPagosCajaId($dta->id);
    }

    public function postCargarLigaId($dta)
    {
        return $this->model('ModelLiga')->cargarLigaPorId($dta->id);
    }

    public function postCargarTiendaId($dta)
    {
        return $this->model('ModelTienda')->cargarTiendaPorId($dta->id);
    }

    public function postCargarNombreCliente($dta)
    {
        return $this->model('ModelCliente')->cargarNombreClientePorId($dta->id);
    }

    public function postCargarNombreProducto($dta)
    {
        return $this->model('ModelProducto')->cargarNombreProductoPorId($dta->id);
    }

    

    

    


    

    

    


    

    
}

echo redirec('ControllerPagos');
?>