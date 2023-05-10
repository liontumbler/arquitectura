<?php
require_once '../db/Logger.php';
require_once '../db/Database.php';
require_once '../db/ConsultasDB.php';
require_once '../model/Model.php';
require_once '../model/ModelLogin.php';

require_once 'PruebaUnitaria.php';
require_once 'TestModelLogin.php';

$test = new TestModelLogin();
$test->run();
?>