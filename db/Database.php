<?php
class Database {
    private $host;
    private $username;
    private $password;
    private $database;
    private $cn;

    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        try {
            $dsn = "mysql:host=$host;dbname=$database";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => 0,
            ];
            $this->cn = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            $logger = new Logger('../logs/myapp.log');
            $logger->log('Error: '."Error al conectar a la base de datos: " . $e->getMessage());
            ServerResponse::getResponse(500);
            die();
        }
    }

    private function insertStr($table, $data)
    {
        $fields = implode(", ", array_keys($data));
        $values = implode(", :", array_keys($data));
        $values = ":" . $values;

        return "INSERT INTO $table ($fields) VALUES ($values)";
    }

    private function updateStr($table, $data)
    {
        $values = "";
        foreach ($data as $key => $value) {
            $values .= "$key=:$key, ";
        }
        $values = rtrim($values, ", ");

        return "UPDATE $table SET $values WHERE id=:id";
    }

    private function deleteStr($table)
    {
        return "DELETE FROM $table WHERE id=:id";
    }

    public function create($table, $data)
    {
        try {
            $sql = $this->insertStr($table, $data);

            $statement = $this->cn->prepare($sql);
            $statement->execute($data);

            ServerResponse::getResponse(200);
            return $this->cn->lastInsertId();//$statement->rowCount();
        } catch (PDOException $e) {
            $logger = new Logger('../logs/myapp.log');
            $logger->log('Error: '."Failed to create a record in $table: " . $e->getMessage());
            ServerResponse::getResponse(500);
        }
    }

    public function read($table, $data = ['id' => 1], $where = 'id=:id') {
        try {
            $sql = "SELECT * FROM $table WHERE $where";

            $statement = $this->cn->prepare($sql);
            $statement->execute($data);

            ServerResponse::getResponse(200);
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $logger = new Logger('../logs/myapp.log');
            $logger->log('Error: '."Failed to read record from $table with ".implode(',', $data).": " . $e->getMessage());
            ServerResponse::getResponse(500);
        }
    }

    public function update($table, $data, $id) {
        try {
            $sql = $this->updateStr($table, $data);

            $statement = $this->cn->prepare($sql);
            $statement->execute(array_merge($data, ['id' => $id]));
        } catch (PDOException $e) {
            throw new Exception("Failed to update record in $table with id=$id: " . $e->getMessage());
        }
    }

    public function delete($table, $id) {
        try {
            $sql = $this->deleteStr($table);

            $statement = $this->cn->prepare($sql);
            $statement->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new Exception("Failed to delete record from $table with id=$id: " . $e->getMessage());
        }
    }

    public function beginTransaction()
    {
        try {
            return $this->cn->beginTransaction();
        } catch (PDOException $e) {
            throw new Exception("Failed to begin transaction: " . $e->getMessage());
        }
    }

    public function commit()
    {
        try {
            return $this->cn->commit();
        } catch (PDOException $e) {
            throw new Exception("Failed to commit transaction: " . $e->getMessage());
        }
    }

    public function rollback()
    {
        try {
            return $this->cn->rollback();
        } catch (PDOException $e) {
            throw new Exception("Failed to rollback transaction: " . $e->getMessage());
        }
    }

    public function executeTransaction($queries)
    {
        $this->beginTransaction();

        try {
            foreach ($queries as $query) {
                $stmt = $this->cn->prepare($query['sql']);
                $stmt->execute($query['params']);
            }

            $this->commit();
            return true;
        } catch (PDOException $e) {
            $this->rollback();
            return false;
        }
    }

    public function generarArchivoInsertss($consulta, $parametros = array(), $nomArchivo = 'insert:') {//.date('Y-m-d H:i:s')
        $resultado = $this->cn->prepare($consulta);
        $resultado->execute($parametros);
        $tabla = preg_match('/SELECT.*FROM\s+`?(\w+)`?\s*(.*)/i', $consulta, $match) ? $match[1] : 'tabla';
    
        $campos = array();
        foreach ($resultado->fetchAll(PDO::FETCH_ASSOC) as $fila) {
            $valores = array();
            foreach ($fila as $campo => $valor) {
                $campos[] = $campo;
                $valores[] = "'" . $this->cn->quote($valor) . "'";
            }
            $linea = 'INSERT INTO ' . $tabla . ' (' . implode(', ', $campos) . ') VALUES (' . implode(', ', $valores) . ');';
            $lineas[] = $linea;
            unset($valores);
        }
        
        $nombreArchivo = '../backups/'.$nomArchivo.'.sql';
        $archivo = fopen($nombreArchivo, 'w');
        fwrite($archivo, implode("\n", $lineas));
        fclose($archivo);
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