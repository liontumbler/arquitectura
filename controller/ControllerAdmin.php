<?php
require_once 'Controller.php';

class ControllerAdmin extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postSalir()
    {
        return $this->model('ModelAdmin')->salir();
    }


    

    
}

echo redirec('ControllerAdmin');
?>