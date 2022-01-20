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
  <!-- Arkusz styli strony z daniami -->
  <link rel="stylesheet" href="../styles/dishes.css" />
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
          <?php
            require('../db.php');
            $categoryId = $_GET['category'];
            $statement = $db->query('SELECT * FROM Kategorie WHERE IdKategorii = '. $categoryId);
            $categoryName = $statement->fetchAll()[0]['Nazwa'];

            if ($_POST && $_POST['id'] && $_POST['ilosc']) {
              $_SESSION['cart'] = $_SESSION['cart'] ?? [];
              $quantity = 0;
              foreach($_SESSION['cart'] as $item) {
                if ($_POST['id'] == $item['IdPotrawy']) {
                  $quantity = $item['Ilosc'];
                  break;
                }
              }
              $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) {
                return $item['IdPotrawy'] !== $_POST['id'];
              });
              array_push($_SESSION['cart'], [
                'IdPotrawy' => $_POST['id'],
                'Ilosc' => $quantity + $_POST['ilosc'],
                'Cena' => $_POST['cena'],
                'Nazwa' => $_POST['nazwa']
              ]);
              echo 'Dodano '.$_POST['ilosc'].'x '.$_POST['nazwa'].' do koszyka. <a href="./koszyk.php">Zobacz koszyk.</a>';
            }
            unset($_POST);
            ?>
          <h3 class="section-header"><?= $categoryName ?></h3>
          <?php
              $statement = $db->query('SELECT * FROM Potrawy WHERE IdKategorii = '. $categoryId);
              $dishes = $statement->fetchAll();
              foreach ($dishes as $dish):
            ?>
               <article class="dish">
                <img src="<?= $dish['Obrazek'] ?>" alt="image" class="dish-image">
                <div class="dish-info">
                  <h4 class="dish-name"><?= $dish['Nazwa'] ?></h4>
                  <?= $dish['Cena'] ?>zł
                </div>
                <form method="POST" action="">
                  Ilość: 
                  <input type="number" class="input" min="1" name="ilosc" value="1" />
                  <input type="submit" name="submit" class="button" value="Zamów" />
                  <input type="hidden" name="id" value="<?= $dish['IdPotrawy'] ?>"/>
                  <input type="hidden" name="nazwa" value="<?= $dish['Nazwa'] ?>"/>
                  <input type="hidden" name="cena" value="<?= $dish['Cena'] ?>"/>
                </form>
              </article>
            <?php endforeach; ?>
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

</body>

</html>