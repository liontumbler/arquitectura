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

    public function postBuscarLigas($dta)
    {
        $contadorVacios = 0;
        foreach ($dta as $value) {
            if (empty($value)) {
                $contadorVacios++;
            }
        }

        if ($contadorVacios >= count((array) $dta)) {
            return false;
        }

        return $this->model('ModelAdmin')->buscarLigas($dta);
    }


    

    
}

echo redirec('ControllerAdmin');
?>