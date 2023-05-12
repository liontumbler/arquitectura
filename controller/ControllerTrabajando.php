<?php
require_once 'Controller.php';

class ControllerTrabajando extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postCerrarcaja($dta)
    {
        return $this->model('ModelTrabajado')->cerrarcaja($dta->finCaja);
    }
}

echo redirec('ControllerTrabajando');
?>