<?php

@include 'config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
  header('location:login-user/login_form.php');
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="utf-8" />
  <title>Vücut Kan Hacmi Hesaplama</title>

  <!-- JS baglanti -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

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
          <h1>Vücut Kan Hacmi Hesaplama</h1>
          <div class="on-bilgi">
            Bu sayfada vücudunuzda bulunan kan miktarını hesaplayabilirsiniz. Bu
            hesaplama sağlık problemi bulunmayan bireyler için özel formül ve
            katsayılar kullanılarak yapılır. Form üzerindeki gerekli yerleri
            doldurun ve hesapla butonuna tıklayın.
          </div>

          <!--! kullanicidan alinan veriler php kodlari ile boyle yayinlancak -->
          <div class="form-padd">
            <fieldset class="form-konteynir sonuc">
              <legend>Hesaplama Sonuçları</legend>
              <div class="php-container">

                <?php
                // Veritabanı bağlantısı
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "medimetriks";

                // Bağlantı oluştur
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Bağlantı kontrol et
                if ($conn->connect_error) {
                  die("Bağlantı hatası: " . $conn->connect_error);
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                  $name = $_SESSION['user_name'];
                  $cinsiyet = $_POST["cinsiyet"];
                  $boy = $_POST["boy"];
                  $kilo = $_POST["kilo"];

                  list($vucutKanHacmi, $hematokrit, $hemoglobin) = hesaplaVucutKanHacmi($cinsiyet, $boy, $kilo);

                  echo "<p>Vücut Kan Hacmi: " . $vucutKanHacmi . " litre</p>";
                  echo "<p>Hematokrit: " . $hematokrit . " %</p>";
                  echo "<p>Hemoglobin: " . $hemoglobin . " g/dL</p>";


                  // SQL sorgusu oluştur
                  $sql = "INSERT INTO vucut_kan_hacmi (name, cinsiyet, boy, kilo, vucut_kan_hacmi, hematokrit, hemoglobin)
                  VALUES ('$name','$cinsiyet', $boy, $kilo, $vucutKanHacmi, $hematokrit, $hemoglobin)";

                  // Sorguyu çalıştır
                  if ($conn->query($sql) === TRUE) {

                  } else {
                    echo "Hata: " . $sql . "<br>" . $conn->error;
                  }

                }
                // Bağlantıyı kapat
                $conn->close();

                // Vücut kan hacmini, hematokrit ve hemoglobin hesapla
                function hesaplaVucutKanHacmi($cinsiyet, $boy, $kilo)
                {
                  // Vücut kan hacmi formülü
                  $oran = ($cinsiyet == 'erkek') ? 0.07 : 0.08;
                  $vucutKanHacmi = $kilo * $oran;

                  // Hematokrit formülü (% cinsinden)
                  $hematokrit = ($cinsiyet == 'erkek') ? 0.42 : 0.36;

                  // Hemoglobin formülü (g/dL cinsinden)
                  $hemoglobin = ($cinsiyet == 'erkek') ? 13.8 : 12.1;

                  return array($vucutKanHacmi, $hematokrit, $hemoglobin);
                }
                ?>


              </div>
            </fieldset>
          </div>
          <div class="form-padd">
            <fieldset class="form-konteynir">
              <legend>Vücut Kan Hacmi Hesaplama Formu</legend>
              <form action="" method="POST">
                <div class="form-giris">
                  <div class="form-ortala">
                    <p class="form-input-baslik">Cinsiyetiniz</p>
                    <div>
                      <input type="radio" name="cinsiyet" id="radio1" class="radio" value="x" checked="" />
                      <label for="radio1">Kadın</label>
                    </div>
                    <div style="margin-bottom: 10px">
                      <input type="radio" name="cinsiyet" id="radio2" class="radio" value="y" />
                      <label for="radio2">Erkek</label>
                    </div>
                    <div class="t s"></div>
                    <p class="form-input-baslik">
                      Kilonuz<span class="form-input-aciklama">kg</span>
                    </p>
                    <input type="number" name="kilo" id="kilo" class="form-textbox" value="" />
                    <p class="form-input-baslik">
                      Boyunuz<span class="form-input-aciklama">cm</span>
                    </p>
                    <input type="number" name="boy" id="boy" class="form-textbox" value="" />
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
            <h2>Vücut Kan Hacmi Açıklamalar</h2>
            <div>
              Vücudumuzda bulunan kan sürekli hareket halinde olan sıvı bir
              yapıdadır ve kan hücrelerinden oluşur. Kanın koruma, taşıma,
              savunma ve düzenleme görevleri bulunmaktadır. İnsanlardaki kanın
              özelliklerini belirtmek amacıyla, antikorlara ve antijenlere
              bakılarak belirlenmiş olan sınıflandırma sistemine kan grupları
              adını verebiliriz.
            </div>
          </div>
        </div>

        <!-- ilgini cekelilir link -->
        <?php include 'layout/ilgini-cekebilir.php'; ?>

      </div>
      <div class="t s"></div>
    </div>
  </div>
  <div class="t s"></div>

  <?php include 'layout/footer.php'; ?>

  <script src="js/index.js"></script>
</body>

</html>