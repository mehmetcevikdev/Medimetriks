<?php

@include 'config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Medimetriks</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/login-page.css">

</head>

<body>

   

   <!-- Header start -->
   <header class="hcontainer">
      <nav>
         <div class="logo">
            <a href="user_page.php">Medimetriks</a>
         </div>
         <div class="menu">
            <ul>
               <li><a href="../anasayfa.php">Hesaplamalar</a></li>
               <li><a href="../contact.php">Contact</a></li>
            </ul>
            <a href="user_page.php">
               <button class="menu-button">
                  <?php echo $_SESSION['user_name'] ?>
               </button>
            </a>
         </div>
      </nav>
   </header>
   <!-- Header end -->


   <div class="container">
      <div class="content">
         <!-- <h3>hi, <span>
               <?php echo $_SESSION['user_name'] ?>
            </span></h3> -->
         <h1>Hoşgeldin <span>
               <?php echo $_SESSION['user_name'] ?>
            </span></h1>
         <p>Buradan gideceğin sayfayı secebilirsin.</p>
         <a href="../anasayfa.php" class="btn">hesaplamalar</a>
         <a href="../contact.php" class="btn">contact</a>
         <a href="logout.php" class="btn">logout</a>
      </div>

   </div>

</body>

</html>