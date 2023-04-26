<?php
require_once 'Model.php';

class ModelLogin extends Model
{
    public function login($usu, $clave, $caja)
    {
        //return "$usu, $clave, $caja";
        $cn = $this->conectar();

        $res = $cn->read('trabajador', ['nickname' => $usu], 'nickname=:nickname', 'clave, id, idGimnasio, nombresYapellidos, nickname, correo');
        //return $res;
        if (!$res || count($res) == 0) {
            return $res;
        } else {
            $claveDb = $res[0]['clave'];
            $idTrabajador = $res[0]['id'];
            $idGimnasio = $res[0]['idGimnasio'];
            $nombreTrabajador = $res[0]['nombresYapellidos'];
            $nickname = $res[0]['nickname'];
            $correo = $res[0]['correo'];
            
            $gimnasio = $cn->read('gimnasio', ['id' => $idGimnasio], "id=:id", 'color, background, habilitado, nombre, id');
            //return $gimnasio;

            $color = $gimnasio[0]['color'];
            $background = $gimnasio[0]['background'];
            $habilitado = $gimnasio[0]['habilitado'];
            $nombreGim = $gimnasio[0]['nombre'];
            $gimnasioId = $gimnasio[0]['id'];
            
            if ($habilitado) {
                if ($clave != '' && password_verify(sha1($clave), $claveDb)) {
                    //si existe en registro en caja sin cerrar tomo la sesion que no a cerrado
                    $yaInicioCaja = $cn->read('trabajado', ['idGimnasio' => $idGimnasio, 'idTrabajador' => $idTrabajador], "
                    `idGimnasio`=:idGimnasio
                    AND `idTrabajador`=:idTrabajador
                    AND fechaFin is null;", 'id, iniciCaja');//`fechaInicio` > '".date('Y-m-d')." 00:00:00' AND `fechaInicio` < '".date('Y-m-d')." 23:59:59'
                    //return $yaInicioCaja;
                    $ini = false;
                    $trabajadoId = '';
                    if (!$yaInicioCaja || count($yaInicioCaja) == 0) {
                        $trabajado = [
                            'fechaInicio' => date('Y-m-d H:i:s'),
                            'iniciCaja' => $caja,
                            'idGimnasio' => $idGimnasio,
                            'idTrabajador' => $idTrabajador
                        ];
                        $insert = $cn->create('trabajado', $trabajado);
                        //return $insert;
                        if ($insert > 0) {
                            $_SESSION['caja'] = $caja;
                            $trabajadoId = $insert;
                            $ini = true;
                        }
                    } else {//sesion ya iniciada
                        $trabajadoId = $yaInicioCaja[0]['id'];
                        $_SESSION['caja'] = $yaInicioCaja[0]['iniciCaja'];
                        $ini = 600;
                    }
    
                    $_SESSION['SesionTrabajador'] = true;
                    $_SESSION['trabajadorId'] = $idTrabajador;
                    $_SESSION['nombre'] = $nombreTrabajador;
                    $_SESSION['correo'] = $correo;
                    $_SESSION['nickName'] = $nickname;
                    $_SESSION['gimnasio'] = $nombreGim;
                    $_SESSION['gimnasioId'] = $gimnasioId;
                    $_SESSION['color'] = $color;
                    $_SESSION['background'] = $background;//'#ff8d34';
                    $_SESSION['trabajadoId'] = $trabajadoId;

                    //actualizar clave de caja  claveCaja, enviar codigo por correo
                    $claveCajaNueva = rand(1000, 9999);
                    $updateTrabajador = $cn->update('trabajador', ['claveCaja' => $claveCajaNueva], $idTrabajador);
                    //return $updateTrabajador;
                    //TODO:quitar o cometar if cuando se pase la clave por correo
                    if ($updateTrabajador > 0) {
                        $_SESSION['claveCaja'] = $claveCajaNueva;
                    } else {
                        $_SESSION['claveCaja'] = 0000;
                    }
                    
                    return $ini;
                }
            } else {
                return 800;
            }
        }

        return false;
    }
}

//echo __NAMESPACE__;
?>