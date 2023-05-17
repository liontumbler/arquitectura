<?php
class ModelCliente extends Model
{
    public function clientes()
    {
        return $this->obtenerClienteNombrePorId();
    }

    public function cargarNombreClientePorId($id)
    {
        return $this->obtenerNombreClientePorId($id);
    }

    

}
?>