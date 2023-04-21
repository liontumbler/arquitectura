<?php
namespace Controllers;

$variablesPeticion = file_get_contents('php://input');
$vars = json_decode($variablesPeticion);
$valores = count((array)$vars);
//print_r($valores);
if ($valores == 0) {
    header('Location: ../index');
}

class Controller
{
    protected $token;
    function __construct($token)
    {
        try {
            @\session_start();
            $this->token = $token;
        } catch (Exception $e) {
            echo 'Error: '.$e->getMessage();
            die();
        }
    }

    protected function model($modelo)
    {
        try {
            $pMayuscula = ucfirst($modelo);
            $ruta = '../model/'. $pMayuscula .'.php';

            if (is_file($ruta)) {
                require_once $ruta;
                return new $pMayuscula;
            } else {
                throw new Exception('File not found: '.$ruta);
            }
        } catch (Exception $e) {
            throw new Exception('Error: '.$e->getMessage());
        }
    }

    protected function view($view)
    {
        try {
            $ruta = '../view/'. $view .'.php';
            if (is_file($ruta)) {
                require_once $ruta;
                return new $view;
            } else {
                throw new Exception('File not found: '.$ruta);
            }
        } catch (Exception $e) {
            throw new Exception('Error: '.$e->getMessage());
        }
    }

    protected function validarTokenCsrf()
    {
        try {
            $value = true;
            if (!isset($this->token) || $this->token != $_SESSION['csrf_token']) {
                $value = false;
            } else {
                $this->csrf_token_update();
            }
            return $value;
        } catch (Exception $e) {
            throw new Exception('Error: '.$e->getMessage());
        }
    }

    function csrf_token_update()
    {
        try {
            $_SESSION['csrf_token'] = md5(uniqid(mt_rand(), true));
        } catch (Exception $e) {
            throw new Exception('Error: '.$e->getMessage());
        }
    }
}

class Logger {
    private $logFile;
    
    public function __construct($logFile) {
        $this->logFile = $logFile;
        if (!file_exists($logFile)) {
            fopen($logFile, 'w');
        }
    }
    
    public function log($message) {
        $date = date('Y-m-d H:i:s');
        $formattedMessage = "[$date] $message\n";
        file_put_contents($this->logFile, $formattedMessage, FILE_APPEND);
    }
}

class ServerResponse {
    public static function getResponse($statusCode)
    {
        $statusCodes = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );

        if (array_key_exists($statusCode, $statusCodes)) {
            $statusMessage = $statusCodes[$statusCode];
            header("HTTP/1.1 $statusCode $statusMessage");
        } else {
            header("HTTP/1.1 500 Internal Server Error");
        }
    }
}
/*
$queries = [
    [
        'sql' => 'INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)',
        'params' => ['Juan', 'juan@example.com', '123456'],
    ],
    [
        'sql' => 'UPDATE usuarios SET email = ? WHERE id = ?',
        'params' => ['juan_nuevo@example.com', 1],
    ],
    ];

    if ($db->executeTransaction($queries)) {
    echo "Transacción exitosa";
    } else {
    echo "Error en la transacción";
    }

    $data = ['nombre' => 'Juan', 'email' => 'juan@example.com', 'contraseña' => '123456'];
    $db->create('usuarios', $data);

    // Leer el registro con ID 1 de la tabla "usuarios"
    $registro = $db->read('usuarios', 1);
    echo $registro['nombre'];

    // Actualizar el registro con ID 2 de la tabla "usuarios"
    $data = ['nombre' => 'Pedro', 'email' => 'pedro@example.com'];
    $db->update('usuarios', $data, 2);

    // Eliminar el registro con ID 3 de la tabla "usuarios"
    $db->delete('usuarios', 3);
*/

//echo __NAMESPACE__;
?>