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
        $logger = new Logger('../logs/gimnacioRedirec.log');
        $logger->log('Error: '.'Excepción capturada: '.  $e->getMessage());
        ServerResponse::getResponse(500);
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
?>