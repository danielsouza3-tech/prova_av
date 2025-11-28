<?php
include "conexao.php";

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit();
}

$id = (int) $_GET['id'];

$stmt = $con->prepare("DELETE FROM clientes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: listar.php");
exit();
?>