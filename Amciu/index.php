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
  <link rel="stylesheet" href="./styles/reset.css" />
  <!-- Główny arkusz styli -->
  <link rel="stylesheet" href="./styles/main.css" />
  <!-- Arkusz styli strony głównej -->
  <link rel="stylesheet" href="./styles/homepage.css" />
</head>
<body>

  <div class="page-wrapper">

    <!-- Header -->
    <header id="header" class="header">

      <!-- Logo -->
      <a href="/" class="logo">
        <img
          src="./assets/img/logo1.svg"
          alt="logo"
          class="logo-img"
        />
      </a>

      <div class="description">
        <h1>PasiBrzuch</h1>
  
        <!-- Hasło reklamowe -->
        <p>Tak dobre jedzenie, że się upasiesz</p>
      </div>
    </header>
    
    <!-- Content -->
    <main id="main" class="main">

      <!-- O nas -->
      <section class="section section-grey">
        <div class="container">
          <h3 class="section-header">O nas</h3>
          <p class="about-text">
            Jesteśmy firmą kateringową z siedzibą w Warszawie. Od ponad 10 lat zajmujemy się urządzaniem wszelkiego rodzaju imprez okolicznościowych.
          </p>
          <div class="about">
            <div class="about-item">
              <img src="./assets/img/certification.svg" alt="icon" />
              <p>Nasze jedzonko jest pyszne i wyśmienite</p>
            </div>
            <div class="about-item">
              <img src="./assets/img/goal.svg" alt="icon" />
              <p>Rok do roku zwiększamy ilość naszych konsumentów o nawet 150%.</p>
            </div>
            <div class="about-item">
              <img src="./assets/img/satisfaction.svg" alt="icon" />
              <p>Grono naszych klientów powiększa się z dnia na dzień i wyrażają o nas same najlepsze opinie.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Przekierowania do stron z opisem dań -->
      <section class="section">
        <div class="container">
          <h3 class="section-header">Zobacz menu</h3>
          <ul class="menu">
            <?php
              require('./db.php');
              $statement = $db->query('SELECT * FROM Kategorie');
              $categories = $statement->fetchAll();
              foreach ($categories as $category):
            ?>
              <li class="menu-item">
                <a href="./pages/dishes.php?category=<?= $category['IdKategorii'] ?>" class="menu-link"><?= $category['Nazwa'] ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </section>

      <!-- Zobacz przepisy -->
      <section class="section section-grey">
        <div class="container">
          <div class="menu-item menu-item-recipes">
            <a href="./pages/recipes.php">Organizujemy również cateringi okolicznościowe. Sprawdź!</a>
          </div>
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
            tel. 997 112 997<br/>
            fax. 112 112 112<br/>
            PasiBrzuch@gmail.com
          </p>
        </section>

        <section class="footer-section address">
          <h4 class="footer-header">Adres:</h4>
          <p>
            Lewartowskiego 15/2,<br/>
            00-120 Warszawa
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
            <?php foreach ($categories as $category): ?>
              <li>
                <a href="./pages/dishes.php?category=<?= $category['IdKategorii'] ?>"><?= $category['Nazwa'] ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </section>
      </div>
    </footer>
  </div>
  
</body>
</html>