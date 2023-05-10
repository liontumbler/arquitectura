<?php
class Database {
    private $host;
    private $username;
    private $password;
    private $database;
    protected $cn;
    protected $logger;
    protected $ID = 'id=:id';

    public function __construct($host, $username, $password, $database)
    {
        if (file_exists('../logs')) {
            $this->logger = new Logger('../logs/gimnacioDb.log');
        } else {
            $this->logger = new Logger('logs/gimnacioDb.log');
        }
        
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
            $this->logger->log('Error: '."Error al conectar a la base de datos: " . $e->getMessage());
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
            if (strpos($e->getMessage(), '1062') !== false) {//datos duplicados
                return -1;
            } else {
                $this->logger->log('Error: '."Failed to create a record in $table: " . $e->getMessage());
                ServerResponse::getResponse(500);
            }
        }
    }

    public function read($table, $data = ['id' => 1], $where = 'id=:id', $campos = '*') {
        try {
            $sql = "SELECT $campos FROM $table ". ((count($data) > 0) ? "WHERE $where" : '');

            $statement = $this->cn->prepare($sql);
            $statement->execute($data);

            ServerResponse::getResponse(200);
            
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logger->log('Error: '."Failed to read record from $table with ".implode(',', $data).": " . $e->getMessage());
            ServerResponse::getResponse(500);
        }
    }

    public function update($table, $data, $id) {
        try {
            $sql = $this->updateStr($table, $data);

            $statement = $this->cn->prepare($sql);
            $statement->execute(array_merge($data, ['id' => $id]));

            ServerResponse::getResponse(200);
            return $statement->rowCount();
        } catch (PDOException $e) {
            $this->logger->log('Error: '."Failed to update record in $table with id=$id: " . $e->getMessage());
            ServerResponse::getResponse(500);
        }
    }

    public function delete($table, $id) {
        try {
            $sql = $this->deleteStr($table);

            $statement = $this->cn->prepare($sql);
            $statement->execute(['id' => $id]);
        } catch (PDOException $e) {
            $this->logger->log('Error: '."Failed to delete record from $table with id=$id: " . $e->getMessage());
            ServerResponse::getResponse(500);
        }
    }

    /*public function beginTransaction()
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
    }*/

    public function generarArchivoInsertss($consulta, $parametros = array(), $nomArchivo = 'insert:') {
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
?>