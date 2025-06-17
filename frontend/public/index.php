<?php
require_once '../src/api.php';

$eventos = fazerRequisicao('http://localhost:3002/eventos');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Eventos UniALFA</title>
</head>
<body>
    <h1>Eventos Disponíveis</h1>
    <?php foreach ($eventos as $evento): ?>
        <div>
            <h2><?= htmlspecialchars($evento['name']) ?></h2>
            <p><strong>Data:</strong> <?= $evento['data'] ?? 'Não informada' ?></p>
            <p><strong>Descrição:</strong> <?= $evento['descricao'] ?? 'Sem descrição' ?></p>
            <a href="inscrever.php?evento_id=<?= $evento['id'] ?>">Inscrever-se</a>
        </div>
        <hr>
    <?php endforeach; ?>
</body>
</html>
