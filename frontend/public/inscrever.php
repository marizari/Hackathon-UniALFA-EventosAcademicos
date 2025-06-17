<?php
require_once '../src/api.php';

if (!isset($_GET['evento_id']) || !is_numeric($_GET['evento_id'])) {
  header("Location: index.php?erro=evento_invalido");
  exit;
}

$evento_id = (int)$_GET['evento_id'];

try {
  $eventoSelecionado = fazerRequisicao("http://localhost:3002/eventos/{$evento_id}");

  if (!$eventoSelecionado) {
    throw new Exception("Resposta vazia da API");
  }

  if (isset($eventoSelecionado['erro'])) {
    throw new Exception($eventoSelecionado['erro']);
  }

  if (!isset($eventoSelecionado['id'])) {
    throw new Exception("Estrutura de dados inesperada");
  }
} catch (Exception $e) {
  error_log("Erro no inscrever.php: " . $e->getMessage());
  header("Location: index.php?erro=evento_nao_encontrado");
  exit;
}

try {
  $palestranteResponse = fazerRequisicao("http://localhost:3002/palestrantes/evento/{$evento_id}");
  $nomePalestrante = $palestranteResponse[0]['nome'] ?? 'Palestrante não informado';
} catch (Exception $e) {
  $nomePalestrante = 'Palestrante não informado';
  error_log("Erro ao buscar palestrante: " . $e->getMessage());
}

$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $requiredFields = ['nome', 'email', 'ra'];
    foreach ($requiredFields as $field) {
      if (empty($_POST[$field])) {
        throw new Exception("O campo " . ucfirst($field) . " é obrigatório");
      }
    }

    $dadosInscricao = [
      'nome' => htmlspecialchars($_POST['nome']),
      'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
      'matricula_ra' => (int)$_POST['ra'],
      'evento_id' => $evento_id,
      'password' => 'senhapadrao'
    ];

    $resposta = fazerRequisicao('http://localhost:3002/alunos', 'POST', $dadosInscricao);

    if (isset($resposta['mensagem'])) {
      $mensagem = htmlspecialchars($resposta['mensagem']);
    } else {
      throw new Exception("Resposta inesperada da API");
    }
  } catch (Exception $e) {
    $mensagem = "Erro ao processar inscrição: " . $e->getMessage();
    error_log("Erro no formulário: " . $e->getMessage());
  }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Inscrição - <?= htmlspecialchars($eventoSelecionado['nome'] ?? 'Evento'); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-dark text-light">

  <?php include('../templates/header.php'); ?>

  <main class="container my-5">
    <h1 class="mb-4">Inscrição no Evento</h1>

    <div class="card bg-light text-dark mb-4">
      <div class="card-body">
        <h3 class="card-title"><?= htmlspecialchars($eventoSelecionado['nome']); ?></h3>
        <p class="card-text"><?= htmlspecialchars($eventoSelecionado['descricao'] ?? ''); ?></p>
        <ul class="list-unstyled">
          <li><strong>Data:</strong> <?= $eventoSelecionado['data'] ?? 'Data não informada'; ?></li>
          <li><strong>Palestrante:</strong> <?= htmlspecialchars($nomePalestrante); ?></li>
          <li><strong>Local:</strong> <?= $eventoSelecionado['local'] ?? 'Local a definir'; ?></li>
        </ul>
      </div>
    </div>

    <?php if (!empty($mensagem)): ?>
      <div class="alert alert-info"><?= $mensagem; ?></div>
    <?php endif; ?>

    <form method="POST" class="bg-secondary p-4 rounded">
      <div class="mb-3">
        <label for="nome" class="form-label">Nome completo</label>
        <input type="text" class="form-control" id="nome" name="nome" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="ra