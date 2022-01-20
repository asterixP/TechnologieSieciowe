<?php
  require('../db.php');

  $_SESSION['cart'] = $_SESSION['cart'] ?? [];

  $orderWasCreated = false;
  if ($_POST && array_key_exists('delete', $_POST)) {
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) {
      return $item['IdPotrawy'] !== $_POST['id'];
    });
    if (!count($_SESSION['cart'])) {
      header("Location: /");
    }
  }

  if ($_POST && array_key_exists('submit', $_POST)) {
    $statement1 = $db->query('SELECT * FROM Klienci WHERE 
      Imie = \''.$_POST['imie'].'\' AND 
      Nazwisko = \''.$_POST['nazwisko'].'\' AND 
      Adres = \''.$_POST['adres'].'\' AND 
      Telefon = \''.$_POST['telefon'].'\' AND
      Miasto = \''.$_POST['miasto'].'\'');

    // sprawdzam czy istnieje klient o takich danych
    $existingClient = $statement1->rowCount();
    $clientId = null;

    if ($existingClient) {
      $clientId = $statement1->fetch()['IdKlienta'];
    } else {
      $statement2 = $db->query('INSERT INTO Klienci VALUES (null, \''.$_POST['imie'].'\', \''.$_POST['nazwisko'].'\', \''.$_POST['adres'].'\', \''.$_POST['telefon'].'\', \''.$_POST['miasto'].'\')');
      $clientId = $db->lastInsertId();
    }
    
    $statement3 = $db->query('INSERT INTO Zamowienia VALUES (null, CURDATE(), \''.$_POST['date'].'\', '.$clientId.')');
    $orderId = $db->lastInsertId();

    foreach ($_SESSION['cart'] as $item) {
      $statement4 = $db->query('INSERT INTO Koszyk VALUES ('.$orderId.', '.intval($item['IdPotrawy']).', '.$item['Ilosc'].')');
    }

    $orderWasCreated = true;

    unset($_SESSION['cart']);
  }
?>

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
  <!-- Arkusz styli koszyka -->
  <link rel="stylesheet" href="../styles/cart.css" />
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
          
          <?php if ($orderWasCreated): ?>
            <h3 class="section-header">Sukces</h3>
            Zamówienie zostało stworzone. <a href="/amciu"> Wróć na stronę główną.</a>
          <?php else: ?>
            <h3 class="section-header">Koszyk</h3>
            <form method="POST" action="" class="cart-form">
              <h4 class="section-subheader">Dane do zamówienia</h4>
              <input class="input" placeholder="Imię" type="text" name="imie" required maxlength="30" /><br />
              <input class="input" placeholder="Nazwisko" type="text" name="nazwisko" required maxlength="30" /><br />
              <input class="input" placeholder="Adres" type="text" name="adres" required maxlength="50" /><br />
              <input class="input" placeholder="Miasto" type="text" name="miasto" required maxlength="20" /><br />
              <input class="input" placeholder="Numer telefonu" type="tel" name="telefon" required /><br />
              <input class="input" placeholder="Data zamówienia" type="date" name="date" required /><br />
              <input class="button" type="submit" name="submit" value="Złóż zamówienie" />
            </form>

            <h4 class="section-subheader">Zawartość koszyka</h4>
            <div class="cart">
              <div class="cart-item">
                <div class="cart-item-title">Nazwa</div>
                <div class="cart-item-quantity">Ilość</div>
                <div class="cart-item-price">Cena</div>
                <div class="cart-item-delete">Usuń</div>
              </div>
              <?php
                $cartItems = $_SESSION['cart'];
                $total = 0;
                foreach($cartItems as $item):
                  $total += $item['Ilosc'] * $item['Cena'];
              ?>
                <div class="cart-item">
                  <div class="cart-item-title"><?= $item['Nazwa'] ?></div>
                  <div class="cart-item-quantity"><?= $item['Ilosc'] ?></div>
                  <div class="cart-item-price"><?= $item['Ilosc'] * $item['Cena'] ?> zł</div>
                  <div class="cart-item-delete">
                    <form method="POST" action="">
                      <input type="hidden" name="id" value="<?= $item['IdPotrawy'] ?>" class="input" />
                      <input type="submit" name="delete" value="Usuń" class="button danger" />
                    </form>
                  </div>
                </div>
              <?php endforeach; ?>
              <div class="cart-item">
                  <div class="cart-item-title">Razem</div>
                  <div class="cart-item-quantity"></div>
                  <div class="cart-item-price"><?= $total ?> zł</div>
                  <div class="cart-item-delete">
                </div>
            </div>
          <?php endif; ?>
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