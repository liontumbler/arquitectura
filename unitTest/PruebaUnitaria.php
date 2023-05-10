<?php
class PruebaUnitaria
{
    public function assertEquals($expected, $actual, $message = '')
    {
        if ($expected != $actual) {
            echo "Fallo la Prueba: {$message}\n";
            echo "Expectativa: {$expected}\n";
            echo "Actual: ".implode(",", $actual)."\n";
        } else {
            echo "Paso la Prueba: {$message}\n";
        }
    }

    public function run()
    {
        $methods = get_class_methods($this);

        foreach ($methods as $method) {
            if (strpos($method, 'test') === 0) {
                $this->$method();
            }
        }
    }
}
?>