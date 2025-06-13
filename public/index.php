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

  <section class="carrossel">
  <div class="slides">
    <img src="../assets/img/banner1.jpg" alt="Banner 1">
    <img src="../assets/img/banner2.jpg" alt="Banner 2">
    <img src="../assets/img/banner3.jpg" alt="Banner 3">
  </div>
</section>



<!-- FILTROS + SEARCH -->
<section class="filtros">
  <input type="text" id="busca" placeholder="Buscar evento...">

  <div class="filtros-curso">
    <label><input type="checkbox" class="filtro-tipo" value="Workshop"> Workshop</label>
    <label><input type="checkbox" class="filtro-tipo" value="Palestra"> Palestra</label>
    <label><input type="checkbox" class="filtro-tipo" value="Mesa Redonda"> Mesa Redonda</label>
  </div>
</section>

    <!-- LISTA DE EVENTOS -->
    <h1>Lista de Eventos</h1>
  <section id="eventos">
<?php foreach ($eventos as $evento): ?>

  <div class="evento-card"
    data-titulo="<?php echo strtolower($evento['titulo']); ?>"
    data-tipo="<?php echo strtolower($evento['tipo']); ?>">

    <!-- TOPO: tipo e duração -->
    <div class="evento-topo">
      <span class="badge tipo"><?php echo $evento['tipo']; ?></span>
      <span class="badge duracao"><?php echo $evento['duracao']; ?></span>
    </div>

    <!-- IMAGEM DO PALESTRANTE -->
    <div class="evento-imagem">
      <img src="../assets/img/<?php echo $evento['foto']; ?>" alt="Foto de <?php echo $evento['palestrante']; ?>">
    </div>

    <!-- INFORMAÇÕES -->
    <div class="evento-info">
      <h2><?php echo $evento['titulo']; ?></h2>
      <p><strong>Descrição:</strong> <?php echo $evento['descricao']; ?></p>
      <p><strong>Data:</strong> <?php echo $evento['data']; ?> às <?php echo $evento['hora']; ?></p>
      <p><strong>Local:</strong> <?php echo $evento['local']; ?></p>
      <p><strong>Palestrante:</strong> <?php echo $evento['palestrante']; ?></p>
      <a href="../public/inscrever.php?id=<?php echo $evento['id']; ?>">Inscreva-se</a>
    </div>

  </div>
<?php endforeach; ?>
</section>


  <?php include('../templates/footer.php'); ?>

</body>

<!-- JavaScript de busca e filtro -->
 <script>
const busca = document.getElementById('busca');
const cards = document.querySelectorAll('.evento-card');
const checkboxes = document.querySelectorAll('.filtro-tipo');

// Função para filtrar os cards
function filtrarEventos() {
  const termoBusca = busca.value.toLowerCase();
  const tiposSelecionados = Array.from(checkboxes)
    .filter(cb => cb.checked)
    .map(cb => cb.value.toLowerCase());

  cards.forEach(card => {
    const titulo = card.dataset.titulo;
    const tipo = card.dataset.tipo;

    const correspondeBusca = titulo.includes(termoBusca);
    const correspondeFiltro = tiposSelecionados.length === 0 || tiposSelecionados.includes(tipo);

    if (correspondeBusca && correspondeFiltro) {
      card.style.display = 'flex';
    } else {
      card.style.display = 'none';
    }
  });
}

busca.addEventListener('input', filtrarEventos);
checkboxes.forEach(cb => cb.addEventListener('change', filtrarEventos));
</script>

</html>
