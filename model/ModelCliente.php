<?php
require_once 'Model.php';

class ModelCliente extends Model
{
    public function clientes()
    {
        $cn = $this->conectar();
        return $cn->read('cliente', [], '', 'id, nombresYapellidos, documento');
    }

}
?>