<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "prova_av";

$con = new mysqli($host, $usuario, $senha, $banco);
if ($con->connect_error) {
    die("Erro de conexão: " . $con->connect_error);
}
?>