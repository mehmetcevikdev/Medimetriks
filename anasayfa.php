<?php

@include 'config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
  header('location:login_form.php');
}

?>

<html lang="tr">

<head>
  <meta charset="utf-8" />
  <title>Hesaplamalar | Medimetriks</title>
  <link rel="stylesheet" href="css/base.css" />
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php include 'layout/header.php'; ?>

  <div class="content">
    <div class="container">

    <?php include 'layout/sol_menu.php'; ?>

      <div class="m52">
        <div class="screen">
          <h1>Hesaplamalar</h1>
          <div class="on-bilgi">
            Dilediğiniz her konuda hesaplama işlemlerinizi yapabileceğiniz
            pratik hesaplama araçları tek bir sayfada derlenmiştir.
            Hesaplamalarınızı bir kaç tıklama ile basitçe yapabilirsiniz.
          </div>
          <div class="anasayfa-hesaplamalar">
            <a href="gunluk_kalori_ihtiyaci.php"> <img src="img/kalori.jpg" alt="Günlük Kalori İhtiyacı Hesaplama" />
              <div class="yazi">Günlük Kalori İhtiyacı Hesaplama</div>
            </a>
            <a href="sigara_maliyeti.php"><img src="img/sigara.jpg" alt="Günlük Su İhtiyacı Hesaplama" />
              <div class="yazi">Sigara Maliyeti Hesaplama</div>
            </a>
            <a href="kan_grubu_hesaplama.php"><img src="img/kan-grubu.png" alt="Kan Grubu Hesaplama" />
              <div class="yazi">Kan Grubu Hesaplama</div>
            </a>
            <a href="vucut_kan_hacmi.php"><img src="img/kan-hacmi.jpg" alt="Vücut Kan Hacmi Hesaplama" />
              <div class="yazi">Vücut Kan Hacmi Hesaplama</div>
            </a>
            <a href="vucut_kitle_endeksi.php"><img src="img/vki.jpg" alt="Vücut Kitle Endeksi Hesaplama" />
              <div class="yazi">Vücut Kitle Endeksi Hesaplama</div>
            </a>
            <div class="t s"></div>
          </div>
        </div>
      </div>
      <div class="t s"></div>
    </div>
  </div>
  <div class="t s"></div>

  <?php include 'layout/footer.php'; ?>

</body>

</html>