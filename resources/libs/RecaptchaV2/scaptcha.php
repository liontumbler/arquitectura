<?php
//Autor: edwin velasquez jimenez
//validacion del lado del servidor con la llave secreta
//print_r($_POST);
$cu = curl_init();
curl_setopt($cu, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify?response='.$_POST['response'].'&secret='.'6LffswQmAAAAAEg6h94_61m8eEcjW2i1AI8WDFZF');
curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($cu);

curl_close($cu);

echo $response;
?>