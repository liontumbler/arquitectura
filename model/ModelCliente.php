<?php
class ModelCliente extends Model
{
    public function clientes()
    {
        return $this->obtenerClientePorId();
    }

}
?>