<?php
class ModelConfiguracion extends Model
{
    public function actualizarConfiguracion($data)
    {
        if (!empty($dta->clave)) {
            $dta->clave = password_hash(sha1($dta->clave), PASSWORD_BCRYPT, [
                'cost' => 11,
            ]);
        }
        return $this->updateConfiguracion($_SESSION['SesionAdmin']['gimnasioId'], $data);
    }

    

}
?>