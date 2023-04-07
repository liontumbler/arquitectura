<?php
require_once 'Controller.php';
use Controllers\Controller;

class ControllerTest extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postIndex()
    {
        $valido = $this->validarTokenCsrf();
        $this->csrf_token_update();
        if ($valido) {
            return $this->model('ModelTest');
        } else {
            return $valido;
        }
    }
}

require_once 'Redirecionar.php';
echo redirec('ControllerTest');
?>