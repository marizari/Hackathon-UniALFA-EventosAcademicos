<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['nome'];
  $ra = $_POST['ra'];
  $evento_id = $_POST['evento_id'];

  // Criar um array com os dados do aluno
  $novaInscricao = [
    'evento_id' => $evento_id,
    'nome' => $nome,
    'ra' => $ra,
    'data_inscricao' => date('Y-m-d H:i:s')
  ];

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

  // Exibe mensagem de sucesso
  echo "<p style='color: green;'>Inscrição realizada com sucesso!</p>";
}

// Verifica se veio um ID de evento
if (!isset($_GET['id'])) {
  echo "Evento não encontrado.";
  exit;
}

$id = $_GET['id'];

// Carrega os eventos
$json = file_get_contents('eventos.json');
$eventos = json_decode($json, true);

// Procura o evento pelo ID
$eventoSelecionado = null;
foreach ($eventos as $evento) {
  if ($evento['id'] == $id) {
    $eventoSelecionado = $evento;
    break;
  }
}

// Se não encontrou o evento
if (!$eventoSelecionado) {
  echo "Evento não encontrado.";
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Inscrição - <?php echo $eventoSelecionado['titulo']; ?></title>
</head>
<body>
  <h1>Inscrição no evento: <?php echo $eventoSelecionado['titulo']; ?></h1>
  <p><strong>Data:</strong> <?php echo $eventoSelecionado['data']; ?></p>
  <p><strong>Palestrante:</strong> <?php echo $eventoSelecionado['palestrante']; ?></p>
  <p><strong>Descrição:</strong> <?php echo $eventoSelecionado['descricao']; ?></p>

  <form method="POST" action="inscrever.php?id=<?php echo $id; ?>">
    <input type="hidden" name="evento_id" value="<?php echo $id; ?>">
    <label for="nome">Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label for="ra">RA (matrícula):</label><br>
    <input type="text" name="ra" required><br><br>

    <button type="submit">Confirmar Inscrição</button>
  </form>

  <p><a href="index.php">← Voltar à lista de eventos</a></p>
</body>
</html>
