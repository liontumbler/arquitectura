<?php
require_once 'Controller.php';
use Controllers\Controller;
use Controllers\ServerResponse;
use Controllers\Logger;

class ControllerQuienDebe extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postOptenerDeudor($dta)
    {
        try {
            ServerResponse::getResponse(200);
            return 'llegue';
            //print_r($dta->nombre);
        } catch (Exception $e) {
            $logger = new Logger('../logs/myapp.log');
            $logger->log('Error: '.$e->getMessage());
            ServerResponse::getResponse(500);
        }
    }
}

require_once 'Redirecionar.php';
echo redirec('ControllerQuienDebe');
?>