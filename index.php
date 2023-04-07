<?php
/**
 * no se debe tocar este archivo
 */

//$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
//$enlace_actual = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
//echo $enlace_actual;

//print_r($_POST);
//print_r($_GET);
//print_r($_SERVER['REQUEST_URI']);
//print_r($_SERVER["REQUEST_METHOD"]);

//echo $_GET['view'];
//echo $_GET['id'];
//if (!isset($_GET['id'])){
    //$_GET['id'] = null;
//}

//$view = explode('/', $_SERVER['REQUEST_URI']);

class Core
{
    function __construct($view)
    {
        //echo '__'.$_GET['id'].'---';
        $ruta = 'view/'.$view.'.php';
        if (is_file($ruta) && $this->tienePermisos()) {
            //seteo la vida de la session en 31536000 segundos o 1 año
            ini_set("session.cookie_lifetime","31536000");
            ini_set("session.gc_maxlifetime","31536000");
            
            @\session_start();
            $rutasLegitima = true;
            //echo '__'.$_GET['id'].'---';
            require_once $ruta;
        } elseif (isset($view))  {
            //echo 'ddd'.$view.'ggg';
            ?>
            <script>
                location.href = './index';
            </script>
            <?php
        }
    }

    private function tienePermisos()
    {
        return true;
    }
}

function csrf_token_update()
{
    @\session_start();
    $_SESSION['csrf_token'] = md5(uniqid(mt_rand(), true));
    return $_SESSION['csrf_token'];
}

function csrf_token()
{
    @\session_start();
    return $_SESSION['csrf_token'];
}

function input_csrf_token()
{
    @\session_start();
    return '<input type="hidden" id="csrf_token" value="'.$_SESSION['csrf_token'].'">';
}

if (!isset($_GET['view'])) {
    $_GET['view'] = null;
}

if (!isset($_GET['id'])) {
    $_GET['id'] = null;
}

if (!isset($_GET['accion'])){
    $_GET['accion'] = null;
}

new Core($_GET['view']);
?>