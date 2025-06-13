<?php
// Lê o JSON como se fosse a API
$json = file_get_contents('eventos.json');
$eventos = json_decode($json, true);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Eventos UniALFA</title>
</head>
<body>
  <h1>Lista de Eventos</h1>

  <?php foreach ($eventos as $evento): ?>
    <div>
      <h2><?php echo $evento['titulo']; ?></h2>
      <p>Data: <?php echo $evento['data']; ?></p>
      <p>Palestrante: <?php echo $evento['palestrante']; ?></p>
      <a href="inscrever.php?id=<?php echo $evento['id']; ?>">Inscreva-se</a>
    </div>
    <hr>
  <?php endforeach; ?>

</body>
</html>
