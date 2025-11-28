<?php
include 'conexao.php';

$success = "";
$errors = [];
$categorias = [];

$q = $con->query("SELECT * FROM categorias ORDER BY nome ASC");
while ($c = $q->fetch_assoc()) {
    $categorias[] = $c;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $categoria_id = intval($_POST['categoria_id'] ?? 0);

    if (strlen($nome) < 2) {
        $errors[] = "O nome deve ter pelo menos 2 caracteres.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email inválido.";
    }

    if ($categoria_id <= 0) {
        $errors[] = "Selecione uma categoria válida.";
    }

    if (empty($errors)) {
        $sql = $con->prepare("INSERT INTO clientes (nome, email, telefone, categoria_id) VALUES (?, ?, ?, ?)");
        $sql->bind_param("sssi", $nome, $email, $telefone, $categoria_id);

        if ($sql->execute()) {
            $success = "Cliente cadastrado com sucesso!";
        } else {
            $errors[] = "Erro ao cadastrar no banco!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Novo Cliente</title>
<link rel="stylesheet" href="css/estilo.css">
</head>

<body>

<div class="container">

    <header class="site-header">
        <h1>Novo Cliente</h1>
    </header>

    <div class="top-btns">
        <a class="btn" href="index.php">← Voltar</a>
    </div>

    <?php if (!empty($success)): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="errors">
            <?php foreach ($errors as $e): ?>
                <p><?= htmlspecialchars($e) ?></p>
            <?php endforeach ?>
        </div>
    <?php endif; ?>

    <form id="form-cad" action="cadastrar.php" method="post" autocomplete="off" novalidate>

        <!-- campo fake para ajudar a bloquear autofill -->
        <input type="text" style="display:none">

        <label for="nome">Nome</label>
        <input id="nome" name="nome" type="text" autocomplete="off" required>

        <label for="email">Email</label>
        <input id="email" name="email" type="email" autocomplete="off">

        <label for="telefone">Telefone</label>
        <input id="telefone" name="telefone" type="text" autocomplete="off">

        <label for="categoria_id">Categoria</label>
        <select id="categoria_id" name="categoria_id">
            <option value="">-- escolha --</option>
            <?php foreach ($categorias as $c): ?>
                <option value="<?= (int)$c['id'] ?>"><?= htmlspecialchars($c['nome']) ?></option>
            <?php endforeach ?>
        </select>

        <button class="btn" type="submit">Cadastrar</button>
    </form>

</div>

<div id="toast" class="toast"></div>

<script src="js/script.js"></script>
</body>
</html>