<?php
require_once '../src/api.php';

// Consome a API Node.js para buscar alunos com eventos
$alunosComEventos = fazerRequisicao('http://localhost:3002/alunos/eventos-com-alunos');

if (!is_array($alunosComEventos)) {
    $alunosComEventos = [];
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
    th, td { padding: 0.8rem 1rem; border: 1px solid #444; text-align: left; }
    th { background-color: #333; color: white; }
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
      color: #aaa;
      margin-top: 3rem;
      font-style: italic;
    }
  </style>
</head>
<body>

<?php include('../templates/header.php'); ?>

<main>
  <h1>Certificados Emitidos</h1>

  <?php if (empty($alunosComEventos)): ?>
    <p class="nenhum">Nenhuma inscrição encontrada para emissão de certificados.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>RA</th>
          <th>Evento</th>
          <th>Certificado</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($alunosComEventos as $aluno): ?>
          <tr>
            <td><?= htmlspecialchars($aluno['nome']); ?></td>
            <td><?= htmlspecialchars($aluno['matricula_ra']); ?></td>
            <td>
              <?= htmlspecialchars($aluno['evento']['nome'] ?? 'Evento não encontrado'); ?>
            </td>
            <td>
              <a href="http://localhost:3002/certificado/<?= $aluno['aluno_id']; ?>" class="btn-certificado" target="_blank">Visualizar</a>
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