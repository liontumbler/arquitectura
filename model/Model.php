<?php
$variablesPeticion = file_get_contents('php://input');
$vars = json_decode($variablesPeticion);
$valores = count((array)$vars);
//print_r($valores);
if ($valores == 0) {
    //header('Location: ../index');
}

class Model extends ConsultasDB
{
    public $id = null;
    protected function toArray()
    {
        return get_class_vars(get_class($this));
    }

    protected function cerrarSesion()
    {
        try {
            @\session_start();
            session_destroy();
            session_unset();
            return true;
        } catch (Exception $e) {
            $logger = '';
            if (file_exists('../logs')) {
                $logger = new Logger('../logs/gimnacioModel.log');
            } else {
                $logger = new Logger('logs/gimnacioModel.log');
            }

            $logger->log('Error: '."Error al conectar a la base de datos: " . $e->getMessage());
            ServerResponse::getResponse(500);
        }
    }
}
?>