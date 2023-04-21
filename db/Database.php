<?php
class Database {
    private $host;
    private $username;
    private $password;
    private $database;
    private $cn;

    public function __construct($host, $username, $password, $database) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        try {
            $dsn = "mysql:host=$host;dbname=$database";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->cn = new PDO($dsn, $username, $password, $options);
            //$this->cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error al conectar a la base de datos: " . $e->getMessage();
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

    private function selectStr($table)
    {
        return "SELECT * FROM $table WHERE id=:id";
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

    public function create($table, $data) {
        try {
            $sql = $this->insertStr($table, $data);

            $statement = $this->cn->prepare($sql);
            $statement->execute($data);
        } catch (PDOException $e) {
            throw new Exception("Failed to create a record in $table: " . $e->getMessage());
        }
    }

    public function read($table, $id) {
        try {
            $sql = $this->selectStr($table);

            $statement = $this->cn->prepare($sql);
            $statement->execute(['id' => $id]);

            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Failed to read record from $table with id=$id: " . $e->getMessage());
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
}
?>