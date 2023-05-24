<?php
$variablesPeticion = file_get_contents('php://input');
$vars = json_decode($variablesPeticion);
$valores = count((array)$vars);
//print_r($valores);
if ($valores == 0) {
    header('Location: ../index');
}

function redirec($redirec)
{
    $variablesPeticion = file_get_contents('php://input');
    $vars = json_decode($variablesPeticion);
    //print_r($vars->accion);

    try {
        $accion = '';
        if (!empty($vars->accion) && $vars->accion != '')
            $accion = strtolower($_SERVER["REQUEST_METHOD"]).$vars->accion;

        $data = null;
        if (!empty($vars->data) && $vars->data != ''){
            //print_r($vars->data);
            foreach ($vars->data as $i => $value) {
                if (!is_object($value) && !is_array($value)) {
                    $vars->data->$i = preg_replace('/^<SCRIPT>|<\/SCRIPT>|<script>|<\/script>|<\/|<|>|=/', '', $value);
                } else {
                    foreach ($value as $e => $val) {
                        $value->$e = preg_replace('/^<SCRIPT>|<\/SCRIPT>|<script>|<\/script>|<\/|<|>|=/', '', $val);
                    }
                }
            }
            $data = $vars->data;
        }

        @\session_start();
        if (empty($vars->csrf_token) || $vars->csrf_token != $_SESSION['csrf_token'])
            throw new Exception('CSRF invalido');
        
        $obj = new $redirec($vars->csrf_token);
        $existeM = method_exists($obj, $accion);
        if ($existeM) {
            return json_encode($obj->$accion($data));
        } else {
            throw new Exception('accion no existe');
        }
    } catch (Exception $e) {
        $logger = new Logger('../logs/gimnacioRedirec.log');
        $logger->log('Error: '.'Excepción capturada: '.  $e->getMessage());
        ServerResponse::getResponse(500);
    }
}

?>