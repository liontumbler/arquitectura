<?php
require_once 'db/Logger.php';
require_once 'db/Database.php';
require_once 'db/ConsultasDB.php';
require_once 'model/Model.php';
class ViewController
{
    private $obj;
    function __construct($model)
    {
        try {
            $pMayuscula = ucfirst($model);
            $ruta = 'model/'. $pMayuscula .'.php';

            if (is_file($ruta)) {
                require_once $ruta;
                $this->obj = new $pMayuscula;
            } else {
                throw new Exception('File not found: '.$ruta);
            }
        } catch (Exception $e) {
            throw new Exception('Error: '.$e->getMessage());
        }
    }

    public function metodo($metodo = null, $data = null)
    {
        try {
            
            if (!empty($metodo) && !empty($data)) {
                return $this->obj->$metodo($data);
            } elseif (!empty($metodo)) {
                return $this->obj->$metodo();
            } else {
                return $this->obj;
            }
            
        } catch (Exception $e) {
            throw new Exception('Error: '.$e->getMessage());
        }
    }
}
?>