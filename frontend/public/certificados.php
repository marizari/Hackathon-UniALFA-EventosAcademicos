<?php
// Lê os eventos para usar o título
$eventosJson = file_get_contents('eventos.json');
$eventos = json_decode($eventosJson, true);

// Cria um array associativo evento_id => evento
$eventosPorId = [];
foreach ($eventos as $evento) {
    $eventosPorId[$evento['id']] = $evento;
}

// Lê as inscrições
$inscricoesArquivo = 'inscricoes.json';
if (file_exists($inscricoesArquivo)) {
    $inscricoesJson = file_get_contents($inscricoesArquivo);
    $inscricoes = json_decode($inscricoesJson, true);
} else {
    $inscricoes = [];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Certificados - UniALFA Eventos</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    main { max-width: 900px; margin: 2rem auto; padding: 0 1rem; }
    h1 { text-align: center; margin-bottom: 2rem; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 0.8rem 1rem; border: 1px solid #ccc; text-align: left; }
    th { background-color: #f4f4f4; }
    .btn-certificado {
      background-color: var(--primary-color);
      color: white;
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    .btn-certificado:hover {
      background-color: var(--secondary-color);
    }
    .nenhum {
      text-align: center;
      color: #666;
      margin-top: 3rem;
      font-style: italic;
    }
  </style>
</head>
<body>

<?php include('../templates/header.php'); ?>

<main>
  <h1>Certificados Emitidos</h1>

  <?php if (count($inscricoes) === 0): ?>
    <p class="nenhum">Nenhuma inscrição encontrada para emissão de certificados.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>RA</th>
          <th>Evento</th>
          <th>Data da Inscrição</th>
          <th>Certificado</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($inscricoes as $inscricao): ?>
          <tr>
            <td><?php echo htmlspecialchars($inscricao['nome']); ?></td>
            <td><?php echo htmlspecialchars($inscricao['ra']); ?></td>
            <td>
              <?php 
                $eventoId = $inscricao['evento_id'];
                echo isset($eventosPorId[$eventoId]) ? htmlspecialchars($eventosPorId[$eventoId]['titulo']) : 'Evento não encontrado'; 
              ?>
            </td>
            <td><?php echo date('d/m/Y H:i', strtotime($inscricao['data_inscricao'])); ?></td>
            <td>
              <!-- Aqui você pode fazer o link real para o certificado -->
              <a href="#" class="btn-certificado" onclick="alert('Funcionalidade de certificado ainda não implementada!')">Visualizar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</main>

<?php include('../templates/footer.php'); ?>

</body>
</html>
