<?php
require_once '../src/api.php';

$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'cpf' => (int) $_POST['cpf'],
        'evento_id' => (int) $_POST['evento_id']
    ];

    $resposta = fazerRequisicao('http://localhost:3002/alunos', 'POST', $dados);

    if (isset($resposta['mensagem'])) {
        $mensagem = $resposta['mensagem'];
    }
}

$evento_id = $_GET['evento_id'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Inscrição no Evento</title>
</head>
<body>
    <h1>Formulário de Inscrição</h1>

    <?php if ($mensagem): ?>
        <p><strong><?= htmlspecialchars($mensagem) ?></strong></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="evento_id" value="<?= htmlspecialchars($evento_id) ?>">
        <label>Nome:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>CPF:</label><br>
        <input type="text" name="cpf" required><br><br>

        <button type="submit">Inscrever</button>
    </form>

    <br>
    <a href="index.php">← Voltar para eventos</a>
</body>
</html>
