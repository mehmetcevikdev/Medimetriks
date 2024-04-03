<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Header start -->
  <header class="container">
    <nav>
      <div class="logo">
        <a href="login-user/user_page.php">Medimetriks</a>
      </div>
      <div class="menu">
        <ul>
          <li><a href="index.php">Hesaplamalar</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
        <a href="login-user/user_page.php">
          <button class="menu-button">
            <?php echo $_SESSION['user_name'] ?>
          </button>
        </a>
      </div>
    </nav>
  </header>
  <!-- Header end -->
</body>
</html>