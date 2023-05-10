<?php
require_once 'Controller.php';

class ControllerTest extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }
}

echo redirec('ControllerTest');
?>