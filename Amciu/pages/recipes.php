<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>PasiBrzuch</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Andika+New+Basic:wght@400;700&family=Balsamiq+Sans&display=swap" rel="stylesheet">

  <!-- Arkusz resetujący domyślne style przeglądarek internetowych -->
  <link rel="stylesheet" href="../styles/reset.css" />
  <!-- Główny arkusz styli -->
  <link rel="stylesheet" href="../styles/main.css" />
  <!-- Arkusz styli strony z przepisami -->
  <link rel="stylesheet" href="../styles/recipes.css" />
</head>

<body>

  <div class="page-wrapper">

    <!-- Header -->
    <header id="header" class="header">

      <!-- Logo -->
      <a href="/" class="logo">
        <img src="../assets/img/logo1.svg" alt="logo" class="logo-img" />
      </a>

      <div class="description">
        <h1>PasiBrzuch</h1>

        <!-- Hasło reklamowe -->
        <p>Tak dobre jedzenie, że się upasiesz</p>
      </div>
    </header>

    <!-- Content -->
    <main id="main" class="main">

      <!-- Lista produktów -->
      <section class="section section-grey">
        <div class="container">
          <h3 class="section-header">Potrawy wigilijne</h3>
          <h4 class="section-subheader">Typ potrawy</h4>
          <select class="input js-select recipe-select">
            <option value="zupy">Zupy</option>
            <option value="pierogi">Pierogi</option>
            <option value="Dania ze śledziami">Dania ze śledziami</option>
          </select>
          <button class="button js-button">Pokaż</button>
        </div>
      </section>

      <section class="section">
        <div class="container js-recipes">
        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer id="footer" class="footer">
      <div class="container">

        <!-- Kontakt -->
        <section class="footer-section contact">
          <h4 class="footer-header">Kontakt:</h4>
          <p>
            tel. 997 112 997
            <br/> fax. 112 112 112
            <br/> PasiBrzuch@gmail.com
          </p>
        </section>

        <section class="footer-section address">
          <h4 class="footer-header">Adres:</h4>
          <p>
            <br/> Lewartowskiego 15/2,
            <br/> 00-120 Warszawa
          </p>
        </section>

        <!-- Mapa strony -->
        <section class="footer-section sitemap">
          <h4 class="footer-header">Mapa strony:</h4>
          <ul>
            <li>
              <a href="/amciu">Strona główna</a>
            </li>
            <li>
              <a href="./pages/cart.php">Koszyk</a>
            </li>
            <li>
              <a href="./pages/recipes.php">Przepisy</a>
            </li>
            <li>
              <a href="./pages/contact.php">Kontakt</a>
            </li>
            <?php
              require('../db.php');
              $statement = $db->query('SELECT * FROM Kategorie');
              $categories = $statement->fetchAll();
              foreach ($categories as $category):
            ?>
              <li>
                <a href="./pages/dishes.php?category=<?= $category['IdKategorii'] ?>"><?= $category['Nazwa'] ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </section>
      </div>
    </footer>
  </div>

  <script src="../scripts/recipes.js"></script>
</body>

</html>