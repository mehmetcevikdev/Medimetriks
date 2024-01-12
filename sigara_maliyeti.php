<?php

@include 'config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
  header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="utf-8" />
  <title>Sigara Maliyeti Hesaplama</title>

  <!-- JS baglanti -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

  <link rel="stylesheet" href="css/base.css" />
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- header link -->
  <?php include 'layout/header.php'; ?>


  <div class="content">
    <div class="container">

    <?php include 'layout/sol_menu.php'; ?>
    
      <div class="m52">
        <div class="screen">
          <h1>Sigara Maliyeti Hesaplama</h1>
          <div class="on-bilgi">Sigara sağlığımıza çok büyük zararlar vermesinin yanında maddi külfetleride yanında
            getirir. Bu sayfada günlük içtiğiniz sigara adeti ve paket fiyatı ile sigaraya ne kadar harcama yaptığınızı
            hesaplayabilirsiniz.</div>
          <div class="form-padd">
            <fieldset class="form-konteynir sonuc">
              <legend>Hesaplama Sonuçları</legend>
              <div class="php-container">

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                  // Formdan verileri al
                  $name = $_SESSION['user_name'];
                  $icilen_adet = $_POST["icilen"];
                  $paket_ucreti = $_POST["ucret"];

                  // Hesaplamaları yap
                  $gunde_harcama = ($icilen_adet * $paket_ucreti) * 1 / 20;
                  $haftalik_harcama = $gunde_harcama * 7;
                  $aylik_harcama = $haftalik_harcama * 4;
                  $yillik_harcama = $aylik_harcama * 12;

                  // Veritabanı bağlantısı
                  $servername = "localhost";
                  $username = "root";
                  $password = "";
                  $dbname = "hesaplamalar";

                  // Veritabanına bağlan
                  $conn = new mysqli($servername, $username, $password, $dbname);

                  // Bağlantıyı kontrol et
                  if ($conn->connect_error) {
                    die("Veritabanına bağlantı hatası: " . $conn->connect_error);
                  }

                  // Veritabanına ekleme sorgusu
                  $sql = "INSERT INTO sigara_maliyeti (name, icilen_adet, paket_ucreti, gunde_harcama, haftalik_harcama, aylik_harcama, yillik_harcama)
            VALUES ('$name','$icilen_adet', '$paket_ucreti', '$gunde_harcama', '$haftalik_harcama', '$aylik_harcama', '$yillik_harcama')";

                  // Sorguyu çalıştır ve sonucu kontrol et
                  if ($conn->query($sql) === TRUE) {

                  } else {
                    echo "Veri ekleme hatası: " . $conn->error;
                  }

                  // Veritabanı bağlantısını kapat
                  $conn->close();

                  // Sonucu ekrana yazdır
                  echo "<h2>Sigara Harcamalarınız</h2>";
                  echo "<p>Günde içilen sigara adeti: $icilen_adet</p>";
                  echo "<p>Paket ücreti: $paket_ucreti TL</p>";
                  echo "<p>Günlük harcama: $gunde_harcama TL</p>";
                  echo "<p>Haftalık sigara maliyetiniz: $haftalik_harcama TL</p>";
                  echo "<p>Aylık sigara maliyetiniz: $aylik_harcama TL</p>";
                  echo "<p>Yıllık sigara maliyetiniz: $yillik_harcama TL</p>";
                }
                ?>


              </div>
            </fieldset>
          </div>
          <div class="form-padd">
            <fieldset class="form-konteynir">
              <legend>Sigara Maliyeti Hesaplama Formu</legend>
              <form action="" method="POST">
                <div class="form-giris">
                  <div class="form-ortala">

                    <p class="form-input-baslik">Bir günde içilen sigara<span class="form-input-aciklama">adet</span>
                    </p>
                    <input type="number" name="icilen" id="icilen" class="form-textbox" maxlength="3" value="">
                    <p class="form-input-baslik">Paket ücreti<span class="form-input-aciklama">TL</span></p>
                    <input type="number" name="ucret" class="form-textbox" id="ucret" maxlength="2" value="">
                  </div>
                  <div class="t s"></div>
                  <div class="hesapla-sifirla-btn">
                    <input class="sifirla" type="reset"></input>
                    <input type="submit" class="hesaplama" value="Hesapla" />
                  </div>
                </div>
              </form>
            </fieldset>
          </div>
          <div class="aciklamalar">
            <h2>Sigara Maliyeti Açıklamalar</h2>
            <div>Günlük içtiğiniz sigara adedini, paket fiyatını form üzerindeki metin kutucuklarına doldurun ve hesapla
              butonuna tıklayın. Dilerseniz "Geçmiş Maliyetleri Dahil Et" seçeneği ile şu ana kadar sigaraya ne kadar
              bütçe ayırdığınızı hesaplayabilirsiniz.</div>
          </div>
        </div>

        <!-- ilgini cekelilir link -->
        <?php include 'layout/ilgini-cekebilir.php'; ?>

      </div>

      <div class="t s"></div>
    </div>
  </div>

  <div class="t s"></div>
  <!-- footer link -->
  <?php include 'layout/footer.php'; ?>

  <script src="js/index.js"></script>
</body>

</html>