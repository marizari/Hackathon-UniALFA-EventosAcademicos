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
  <!--biblioteca js, p/simplificar-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/details.css">
</head>
<body>

  <?php include('../templates/header.php'); ?>

  <section class="hero-banner">
    <div class="hero-slide">
      <img src="../img/banner2.jpg" alt="Evento em destaque">
      <div class="hero-overlay">
        <h1>Bem-vindo ao UniALFA Eventos</h1>
        <p>Participe de palestras, workshops e mesas redondas com especialistas</p>
        <a href="#eventos" class="btn-destaque">Ver eventos</a>
      </div>
    </div>
  </section>

  <!-- FILTROS + SEARCH -->
  <div class="filtro-mes-dropdown glass">
    <button class="dropdown-toggle" type="button" aria-expanded="false">
      Filtrar por mês
      <span class="arrow">&#9662;</span>
    </button>
    <div class="dropdown-menu">
      <!-- Corrigido: valores com 2 dígitos e classe .filtro-mes -->
      <label><input type="checkbox" class="filtro-mes" value="01"> Janeiro</label>
      <label><input type="checkbox" class="filtro-mes" value="02"> Fevereiro</label>
      <label><input type="checkbox" class="filtro-mes" value="03"> Março</label>
      <label><input type="checkbox" class="filtro-mes" value="04"> Abril</label>
      <label><input type="checkbox" class="filtro-mes" value="05"> Maio</label>
      <label><input type="checkbox" class="filtro-mes" value="06"> Junho</label>
    </div>
  </div>

  <!-- LISTA DE EVENTOS -->
  <h1>Lista de Eventos</h1>
  <section id="eventos">
    <?php foreach ($eventos as $evento):
      // Pega o mês da data para filtro
      $mesEvento = date('m', strtotime($evento['data']));
    ?>
      <div class="evento-card"
        data-titulo="<?php echo strtolower($evento['titulo']); ?>"
        data-tipo="<?php echo strtolower($evento['tipo']); ?>"
        data-mes="<?php echo $mesEvento; ?>">

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
// Seletores dos elementos
const busca = document.getElementById('busca');
const cards = document.querySelectorAll('.evento-card');
const checkboxesTipo = document.querySelectorAll('.filtro-tipo');
const checkboxesMes = document.querySelectorAll('.filtro-mes');

// Função para filtrar os cards
function filtrarEventos() {
  const termoBusca = busca?.value.toLowerCase() || '';

  const tiposSelecionados = Array.from(checkboxesTipo)
    .filter(cb => cb.checked)
    .map(cb => cb.value.toLowerCase());

  const mesesSelecionados = Array.from(checkboxesMes)
    .filter(cb => cb.checked)
    .map(cb => cb.value);

  cards.forEach(card => {
    const titulo = card.dataset.titulo;
    const tipo = card.dataset.tipo;
    const mes = card.dataset.mes;

    const correspondeBusca = titulo.includes(termoBusca);
    const correspondeTipo = tiposSelecionados.length === 0 || tiposSelecionados.includes(tipo);
    const correspondeMes = mesesSelecionados.length === 0 || mesesSelecionados.includes(mes);

    if (correspondeBusca && correspondeTipo && correspondeMes) {
      card.style.display = 'flex';
    } else {
      card.style.display = 'none';
    }
  });
}

// Eventos para acionar filtro em busca e checkbox
busca?.addEventListener('input', filtrarEventos);
checkboxesTipo.forEach(cb => cb.addEventListener('change', filtrarEventos));
checkboxesMes.forEach(cb => cb.addEventListener('change', filtrarEventos));

// Script para abrir/fechar o dropdown de mês
const dropdown = document.querySelector('.filtro-mes-dropdown');
const toggleBtn = dropdown?.querySelector('.dropdown-toggle');
toggleBtn?.addEventListener('click', () => {
  dropdown.classList.toggle('open');
});
</script>

</html>
