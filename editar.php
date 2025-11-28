<?php
include 'conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: listar.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $categoria_id = isset($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : null;

    if (mb_strlen($nome) < 2) {
        echo "<script>alert('Preencha o nome corretamente (mínimo 2 caracteres).'); history.back();</script>";
        exit;
    }

    $sql = "UPDATE clientes SET nome = ?, email = ?, telefone = ?, categoria_id = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Erro no prepare: " . $con->error);
    }
    $stmt->bind_param('sssii', $nome, $email, $telefone, $categoria_id, $id);
    $ok = $stmt->execute();
    $stmt->close();

    if ($ok) {
        header('Location: listar.php?msg=atualizado');
        exit;
    } else {
        echo "<script>alert('Erro ao atualizar: " . addslashes($con->error) . "'); history.back();</script>";
        exit;
    }
}

$sql = "SELECT * FROM clientes WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$cliente = $res->fetch_assoc();
$stmt->close();

if (!$cliente) {
    header('Location: listar.php');
    exit;
}

$cat = $con->query("SELECT * FROM categorias ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<title>Editar Cliente</title>
<link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<div class="container">

    <header class="site-header">
        <h1>Editar Cliente</h1>
    </header>

    <div class="top-btns">
        <a class="btn" href="listar.php">← Voltar</a>
    </div>

    <!-- formulário -->
    <form action="editar.php?id=<?= $id ?>" method="post">
        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($cliente['nome'], ENT_QUOTES) ?>">

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($cliente['email'], ENT_QUOTES) ?>">

        <label>Telefone</label>
        <input type="text" name="telefone" value="<?= htmlspecialchars($cliente['telefone'], ENT_QUOTES) ?>">

        <label>Categoria</label>
        <select name="categoria_id">
            <?php while($c = $cat->fetch_assoc()): ?>
                <option value="<?= $c['id'] ?>"
                    <?= ($c['id'] == $cliente['categoria_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['nome'], ENT_QUOTES) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button class="btn" type="submit">Salvar alterações</button>
    </form>

</div>

<div id="toast" class="toast"></div>

<script src="js/script.js"></script>

</body>
</html>