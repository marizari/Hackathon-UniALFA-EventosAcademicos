<?php

// Verifica se veio o ID via GET
// Verifica se veio um ID de evento
if (!isset($_GET['id'])) {
  echo "Evento não encontrado.";
  exit;
}

$id = $_GET['id'];

// Lê os eventos do JSON
$json = file_get_contents('eventos.json');
$eventos = json_decode($json, true);

// Procura o evento
$eventoSelecionado = null;
foreach ($eventos as $evento) {
  if ($evento['id'] == $id) {
    $eventoSelecionado = $evento;
    break;
  }
}

if (!$eventoSelecionado) {
  echo "Evento inválido.";
  exit;
}

// Se for POST, salva os dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['nome'];
  $ra = $_POST['ra'];

   // Criar um array com os dados do aluno
  $novaInscricao = [
    'evento_id' => $id,
    'nome' => $nome,
    'ra' => $ra,
    'data_inscricao' => date('Y-m-d H:i:s')
  ];

  $arquivo = 'inscricoes.json';

  if (file_exists($arquivo)) {
    $conteudo = file_get_contents($arquivo);
    $inscricoes = json_decode($conteudo, true);
  } else {
    $inscricoes = [];
  }

  // Verifica se já existe o arquivo com inscrições
  $arquivo = 'inscricoes.json';
  if (file_exists($arquivo)) {
    $conteudo = file_get_contents($arquivo);
    $inscricoes = json_decode($conteudo, true);
  } else {
    $inscricoes = [];
  }

  // Adiciona a nova inscrição
  $inscricoes[] = $novaInscricao;

    // Salva de volta no arquivo
  file_put_contents($arquivo, json_encode($inscricoes, JSON_PRETTY_PRINT));

  $mensagem = "Inscrição realizada com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Inscrição - <?php echo $eventoSelecionado['titulo']; ?></title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

  <?php include('../templates/header.php'); ?>

  <main class="conteudo">
    <h1>Inscrição no evento</h1>

    <div class="evento-card">
      <h2><?php echo $eventoSelecionado['titulo']; ?></h2>
      <p><strong>Data:</strong> <?php echo $eventoSelecionado['data']; ?></p>
      <p><strong>Palestrante:</strong> <?php echo $eventoSelecionado['palestrante']; ?></p>
      <p><strong>Descrição:</strong> <?php echo $eventoSelecionado['descricao'] ?? 'Evento sem descrição.'; ?></p>
    </div>


    <?php if (isset($mensagem)): ?>
      <p style="color: green; font-weight: bold;"><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <form method="POST" class="form-inscricao">
      <label for="nome">Nome completo:</label><br>
      <input type="text" name="nome" id="nome" required><br><br>

      <label for="ra">RA (matrícula):</label><br>
      <input type="text" name="ra" id="ra" required><br><br>

      <button type="submit">Confirmar Inscrição</button>
    </form>

    <p><a href="index.php">← Voltar à lista de eventos</a></p>
  </main>

  <?php include('../templates/footer.php'); ?>

</body>
</html>

