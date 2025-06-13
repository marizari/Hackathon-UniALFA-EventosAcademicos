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


<!-- FILTROS + SEARCH  -->
<section class="filtros">
  <input type="text" id="busca" placeholder="Buscar evento...">
  
  <div class="dropdown">
    <button onclick="toggleDropdown()" class="dropbtn">Filtrar por curso</button>
    <div id="filtrosCursos" class="dropdown-content">
      <label><input type="checkbox" name="curso" value="ADM"> Administração</label>
      <label><input type="checkbox" name="curso" value="Direito"> Direito</label>
      <label><input type="checkbox" name="curso" value="Psicologia"> Psicologia</label>
       <label><input type="checkbox" name="curso" value="Pedagogia"> Pedagogia</label>
      <label><input type="checkbox" name="curso" value="SI"> Sistemas para Internet</label>
    </div>
  </div>
</section>


    <!-- LISTA DE EVENTOS -->
    <h1>Lista de Eventos</h1>
  <section id="eventos">
  <?php foreach ($eventos as $evento): ?>
    <div class="evento-card">
      
      <!-- IMAGEM DO PALESTRANTE -->
      <div class="evento-imagem">
        <img src="../assets/img/<?php echo $evento['foto']; ?>" alt="Foto de <?php echo $evento['palestrante']; ?>">
      </div>

      <!-- INFORMAÇÕES -->
      <div class="evento-info">
        <h2><?php echo $evento['titulo']; ?></h2>
        <p><strong>Descrição:</strong> <?php echo $evento['descricao']; ?></p>
        <p><strong>Tipo:</strong> <?php echo $evento['tipo']; ?></p>
        <p><strong>Data:</strong> <?php echo $evento['data']; ?> às <?php echo $evento['hora']; ?></p>
        <p><strong>Local:</strong> <?php echo $evento['local']; ?></p>
        <p><strong>Palestrante:</strong> <?php echo $evento['palestrante']; ?></p>
        <a href="../public/inscrever.php?id=<?php echo $evento['id']; ?>">Inscreva-se</a>
      </div>

    </div>
  <?php endforeach; ?>
</section>

  <!-- JS da busca -->
  <script>
    const busca = document.getElementById('busca');
    const cards = document.querySelectorAll('.evento-card');

    busca.addEventListener('input', () => {
      const termo = busca.value.toLowerCase();
      cards.forEach(card => {
        const titulo = card.querySelector('h2').innerText.toLowerCase();
        card.style.display = titulo.includes(termo) ? 'block' : 'none';
      });
    });



    
  function toggleDropdown() {
    document.getElementById("filtrosCursos").classList.toggle("show");
  }

  // Fecha o dropdown se clicar fora do botão
  window.onclick = function(e) {
    if (!e.target.matches('.dropbtn')) {
      const dropdowns = document.getElementsByClassName("dropdown-content");
      for (let i = 0; i < dropdowns.length; i++) {
        dropdowns[i].classList.remove("show");
      }
    }
  }
  </script>

  <?php include('../templates/footer.php'); ?>

</body>
</html>
