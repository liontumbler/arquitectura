<?php
class ModelCliente extends Model
{
    public function clientes()
    {
        return $this->obtenerClientePorId();
    }

    public function cargarNombreClientePorId($id)
    {
        return $this->obtenerNombreClientePorId($id);
    }

    

}
?>