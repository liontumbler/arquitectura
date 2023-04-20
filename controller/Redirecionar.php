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
        if (isset($vars->accion) && $vars->accion != '')
            $accion = strtolower($_SERVER["REQUEST_METHOD"]).$vars->accion;

        $data = null;
        if (isset($vars->data) && $vars->data != ''){
            //print_r($vars->data);
            foreach ($vars->data as $i => $value) {
                $vars->data->$i = preg_replace('/^<SCRIPT>|<\/SCRIPT>|<script>|<\/script>|<\/|<|>|=/', '', $value);
            }
            $data = $vars->data;
        }

        @\session_start();
        if (!isset($vars->csrf_token) || $vars->csrf_token != $_SESSION['csrf_token'])
            throw new Exception('CSRF invalido');
        
        $obj = new $redirec($vars->csrf_token);
        $existeM = method_exists($obj, $accion);
        if ($existeM) {
            return json_encode($obj->$accion($data));
        } else {
            throw new Exception('accion no existe');
        }
    } catch (Exception $e) {
        return 'Excepción capturada: '.  $e->getMessage();
    }
}
?>