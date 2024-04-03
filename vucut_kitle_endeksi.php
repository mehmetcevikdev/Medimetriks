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
  <title>Vücut Kitle Endeksi Hesaplama</title>

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
          <h1>Vücut Kitle Endeksi Hesaplama</h1>
          <div class="on-bilgi">
            Vücut kitle indeksi (VKİ), bireyin boy ve kilo değerleri baz
            alınarak uygun bir kiloya sahip olup olmadığını açıklamaya çalışan
            değerdir. Aşağıda bulunan form üzerindeki bilgileri doldurarak beden
            kitle endeksinizi (BKİ) hesaplayabilirsiniz.
          </div>
          <!--! kullanicidan alinan veriler php kodlari ile boyle yayinlancak -->
          <div class="form-padd">
            <fieldset class="form-konteynir sonuc">
              <legend>Hesaplama Sonuçları</legend>
              <div class="php-container">

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                  // Formdan gelen verileri al
                  $name = $_SESSION['user_name'];
                  $cinsiyet = isset($_POST["cinsiyet"]) ? $_POST["cinsiyet"] : "";
                  $kilo = isset($_POST["kilo"]) ? floatval($_POST["kilo"]) : 0;
                  $boy = isset($_POST["boy"]) ? floatval($_POST["boy"]) : 0;

                  // Verileri kontrol et
                  if (!empty($cinsiyet) && $kilo > 0 && $boy > 0) {
                    // VKİ'yi hesapla
                    $bmi = $kilo / (($boy / 100) * ($boy / 100));

                    // Veritabanına bağlanma bilgileri
                    $servername = "localhost"; // Veritabanı sunucu adı
                    $username = "root"; // Veritabanı kullanıcı adı
                    $password = ""; // Veritabanı şifre
                    $dbname = "medimetriks"; // Kullanılacak veritabanı adı
                
                    try {
                      // Veritabanına bağlan
                      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

                      // Hata modunu ayarla
                      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                      // Veriyi veritabanına ekle
                      $stmt = $conn->prepare("INSERT INTO vki (name, cinsiyet, kilo, boy, bmi) VALUES ('$name',:cinsiyet, :kilo, :boy, :bmi)");
                      $stmt->bindParam(':cinsiyet', $cinsiyet);
                      $stmt->bindParam(':kilo', $kilo);
                      $stmt->bindParam(':boy', $boy);
                      $stmt->bindParam(':bmi', $bmi);
                      $stmt->execute();

                      // Sonucu ekrana yazdır
                      echo "<h2>Vücut Kitle İndeksi (VKİ) Hesaplama Sonucu:</h2>";
                      echo "<p>Cinsiyet: " . ($cinsiyet == "x" ? "Kadın" : "Erkek") . "</p>";
                      echo "<p>Kilo: $kilo kg</p>";
                      echo "<p>Boy: $boy cm</p>";
                      echo "<p>Vücut Kitle İndeksi (VKİ): " . number_format($bmi, 2) . "</p>";

                      // VKİ'ye göre durumu belirle
                      if ($cinsiyet == "x") { // Kadın
                        if ($bmi < 19.1) {
                          echo "<p>Durum: Zayıf</p>";
                        } elseif ($bmi >= 19.1 && $bmi < 25.8) {
                          echo "<p>Durum: Normal</p>";
                        } elseif ($bmi >= 25.8 && $bmi < 27.3) {
                          echo "<p>Durum: Fazla Kilolu</p>";
                        } else {
                          echo "<p>Durum: Obez</p>";
                        }
                      } elseif ($cinsiyet == "y") { // Erkek
                        if ($bmi < 20.7) {
                          echo "<p>Durum: Zayıf</p>";
                        } elseif ($bmi >= 20.7 && $bmi < 26.4) {
                          echo "<p>Durum: Normal</p>";
                        } elseif ($bmi >= 26.4 && $bmi < 27.8) {
                          echo "<p>Durum: Fazla Kilolu</p>";
                        } else {
                          echo "<p>Durum: Obez</p>";
                        }
                      }
                    } catch (PDOException $e) {
                      echo "Bağlantı hatası: " . $e->getMessage();
                    } finally {
                      // Veritabanı bağlantısını kapat
                      $conn = null;
                    }
                  } else {
                    echo "<p>Lütfen geçerli bir cinsiyet, kilo ve boy değeri girin.</p>";
                  }
                }
                ?>


              </div>
            </fieldset>
          </div>
          <div class="form-padd">
            <fieldset class="form-konteynir">
              <legend>Vücut Kitle Endeksi Hesaplama Formu</legend>
              <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
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

                    <p class="form-input-baslik">
                      Kilonuz<span class="form-input-aciklama">kg</span>
                    </p>
                    <input type="number" name="kilo" id="kilo" class="form-textbox" value="" />

                    <p class="form-input-baslik">
                      Boyunuz<span class="form-input-aciklama">cm</span>
                    </p>
                    <input type="number" name="boy" id="boy" class="form-textbox" value="" />
                  </div>

                  <div class="hesapla-sifirla-btn">
                    <input class="sifirla" type="reset"></input>
                    <input type="submit" class="hesaplama" value="Hesapla" />
                  </div>
                </div>
              </form>
            </fieldset>
          </div>
          <div class="aciklamalar">
            <h2>Vücut Kitle Endeksi Açıklamalar</h2>
            <div>
              Vücut kitle endeksi, kilo kontrolü ve ideal kiloya ulaşmak için
              önemli bir parametredir. Bireyin vücut kitle endeksinin normal
              değerlerde olması önerilir ve beslenme programı bu doğrultuda
              hazırlanır. Yukarıda bulunan form vasıtası ile 7 aşamalı
              sınıflandırma ile beden kitle endeksinizi hesaplayabilirsiniz.
              Aşağıda 7 aşamalı sınıflandırmaya yer verilmiştir:
            </div>
            <h2>Vücut Kitle Endeksi Değerleri</h2>
            <div>
              0,0 - 18,4: Zayıf<br />18,5 - 24,9: Normal Kilolu<br />25,0 -
              29,9: Hafif Kilolu<br />30,0 - 34,9: Kilolu<br />35,0 - 44,9:
              Sağlık açısından önemli<br />45,0 - 49,9: Aşırı Kilolu<br />49,9+:
              Morbid (ölümcül) Kilolu
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