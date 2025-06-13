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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <?php include('../templates/header.php'); ?>
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
   <?php include('../templates/footer.php'); ?>

</body>
</html>
