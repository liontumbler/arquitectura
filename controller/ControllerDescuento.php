<?php
require_once 'Controller.php';

class ControllerDescuento extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postDescontar($dta)
    {
        return $this->model('ModelDescontar')->descontar($dta);
    }


    

    
}

echo redirec('ControllerDescuento');
?>