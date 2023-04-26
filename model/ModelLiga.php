<?php
require_once 'Model.php';

class ModelLiga extends Model
{
    public function horas()
    {
        $cn = $this->conectar();
        return $cn->read('horaliga', [], '', 'id, nombre, horas, precio');
    }

    public function minDemas()
    {
        $cn = $this->conectar();
        return $cn->read('gimnasio', ['id' => $_SESSION['gimnasioId']], 'id=:id', 'minDeMasLiga')[0];
    }

    public function claveCaja($clave)
    {
        $cn = $this->conectar();
        $trabajador =  $cn->read('trabajador', ['id' => $_SESSION['trabajadorId']], 'id=:id', 'claveCaja');

        $valido = false;
        if (count($trabajador) == 1 && $trabajador[0]['claveCaja'] == $clave) {
            $valido = true;
        }

        return $valido;
    }

    

    
}
?>