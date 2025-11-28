<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
	header("Location: index.php");
	exit();
}
include('conexao.php');
$resultado = $conexao->query("SELECT * FROM produtos 
	ORDER BY data_cadastro DESC");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dashboard</title>

	<link rel="stylesheet" type="text/css" href="css/estilo.css">

</head>
<body>

	<header>
		<h1>Sistema de Produtos</h1>
		<a href="">Sair</a>
	</header>

	<main>
		<a href="cadastrar.php" class ="btn">+ Novo Produto</a>
		<table>
			<tr>
				<th>ID</th><th>Nome</th><th>Preço</th><th>Imagem</th><th>Ação</th>
        </tr>
<?php while ($row = $resultado->fetch_assoc()) {
	?>
	<tr>
		<td><?= $row['id'] ?></td>
		<td><?= $row['nome'] ?></td>
		<td>R$ <?= $row['preco'] ?></td>
		<td><img src="uploads/ <?= $row['imagem'] ?>" width="60"></td>
		<td>
			<a href="">Editar</a>
			<a href="">Excluir</a>

		</td>
	</tr>
<?php } ?>
</table>
	</main>

</body>
</html>