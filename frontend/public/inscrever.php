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
  <!--bibliotea js, p/simplificar-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

  <?php include('../templates/header.php'); ?>

  <main class="conteudo">
  <h1 class="titulo-inscricao"> Inscrição no evento:</h1>

  <div class="evento-card evento-inscricao-card">
    <h2><?php echo $eventoSelecionado['titulo']; ?></h2>
    <p><i class="fa-solid fa-calendar-days"></i> <?php echo $eventoSelecionado['data']; ?> às <?php echo $eventoSelecionado['hora'] ?? '00:00'; ?></p>
    <p><i class="fa-solid fa-user-tie"></i> <?php echo $eventoSelecionado['palestrante']; ?></p>
    <p><i class="fa-solid fa-map-marker-alt"></i> <?php echo $eventoSelecionado['local'] ?? 'Local a definir'; ?></p>
    <p><i class="fa-solid fa-align-left"></i> <?php echo $eventoSelecionado['descricao'] ?? 'Evento sem descrição.'; ?></p>
  </div>

  <?php if (isset($mensagem)): ?>
    <div class="mensagem-sucesso">
      <?php echo $mensagem; ?>
    </div>
  <?php endif; ?>

  <form method="POST" class="form-inscricao">
    <label for="nome">Nome completo:</label>
    <input type="text" name="nome" id="nome" required placeholder="Digite seu nome completo">

    <label for="ra">RA (matrícula):</label>
    <input type="text" name="ra" id="ra" required placeholder="Ex: 2023123456">

    <button type="submit">Confirmar Inscrição</button>
  </form>

  <div class="voltar-centro">
    <a href="index.php" class="botao-voltar">← Voltar à lista de eventos</a>
  </div>
</main>

  <?php include('../templates/footer.php'); ?>

</body>
</html>

