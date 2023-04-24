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