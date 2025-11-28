<?php
include 'conexao.php';

$sql = "SELECT clientes.*, categorias.nome AS categoria
        FROM clientes
        LEFT JOIN categorias ON clientes.categoria_id = categorias.id
        ORDER BY clientes.id DESC";
$res = $con->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Lista de Clientes</title>
<link rel="stylesheet" href="css/estilo.css">
<style>
    table{border-collapse:collapse;width:100%;margin-top:20px}
    th,td{border:1px solid #ccc;padding:8px;text-align:left}
    th{background:#111;color:#fff}
    .acoes a{margin-right:10px}
</style>
</head>

<body>

<div class="container">

    <header class="site-header">
        <h1>Clientes</h1>
    </header>

    <div class="top-btns">
        <a class="btn" href="index.php">← Voltar</a>
        <a class="btn" href="cadastrar.php">Novo Cadastro</a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Categoria</th>
            <th>Ações</th>
        </tr>

        <?php while($c = $res->fetch_assoc()): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['nome'] ?></td>
            <td><?= $c['email'] ?></td>
            <td><?= $c['telefone'] ?></td>
            <td><?= $c['categoria'] ?></td>
            <td class="acoes">
                <a href="editar.php?id=<?= $c['id'] ?>" class="editar">Editar</a>
                <a href="excluir.php?id=<?= $c['id'] ?>" class="excluir">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>

</div>

<script src="js/script.js"></script>
</body>
</html>