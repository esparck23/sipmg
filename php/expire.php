<?php

session_start();

$test_val = "SESSION TEST";
$_SESSION['testing'] = $test_val;

// 2 horas en segundos
$inactive = 7200;

$_SESSION['expire'] = time() + $inactive; //culminacion estatica

if (time() > $_SESSION['expire']) {
    $_SESSION['testing'] = '';
    session_unset();
    session_destroy();
    $_SESSION['testing'] = '2 horas culminadas';
}

echo $_SESSION['testing'];



?>