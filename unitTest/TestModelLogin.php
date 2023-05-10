<?php
class TestModelLogin extends PruebaUnitaria
{
    public function testLogin()
    {
        $model = new ModelLogin();
        $result = $model->login('test@', '123', '800000');
        $this->assertEquals(false, $result, 'login fallido');
    }

    /*public function testFinSesion()
    {
        $model = new ModelLogin();
        $result = $model->finSesion('100');
        $this->assertEquals(null, $result, 'Session should be closed');
    }*/
}
?>