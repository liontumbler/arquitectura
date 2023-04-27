<?php
require_once '../db/DataBase.php';

$variablesPeticion = file_get_contents('php://input');
$vars = json_decode($variablesPeticion);
$valores = count((array)$vars);
//print_r($valores);
if ($valores == 0) {
    header('Location: ../index');
}

class Model
{
    public $id = null;
    protected function toArray()
    {
        return get_class_vars(get_class($this));
    }

    protected function conectar()
    {
        //return new Database('localhost', 'root', '', 'test1');
        return new Database('92.204.97.231', 'edlion_admin', '[WeF!hXG{]V#', 'edlion_test1');
        //return new Database('11.110.0.2', 'edlion', 'v{24_t;PdSIe', 'edlion_test1');
    }

    protected function cerrarSesion()
    {
        try {
            @\session_start();
            session_destroy();
            session_unset();
            return true;
        } catch (Exception $e) {
            $logger = new Logger('../logs/gimnacioModel.log');
            $logger->log('Error: '."Error al conectar a la base de datos: " . $e->getMessage());
            ServerResponse::getResponse(500);
        }
    }
}
?>