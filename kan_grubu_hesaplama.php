<?php

@include 'config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
  header('location:login-user/login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Kan Grubunu Hesaplama</title>

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
          <h1>Kan Grubunu Hesaplama</h1>
          <div class="on-bilgi">
            Aşağıda bulunan form ile anne ve babanın kan grupları ile bebeğin
            kan grubunun ne olacağını yüzdelik dilimler şeklinde
            hesaplayabilirsiniz.
          </div>
          <!--! kullanicidan alinan veriler php kodlari ile boyle yayinlancak -->
          <div class="form-padd">
            <fieldset class="form-konteynir sonuc">
              <legend>Hesaplama Sonuçları</legend>
              <div class="php-container">

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                  $name = $_SESSION['user_name'];
                  $anne_k = $_POST["anne-k"];
                  $anne_r = $_POST["anne-r"];
                  $baba_k = $_POST["baba-k"];
                  $baba_r = $_POST["baba-r"];
                  $cocuk_r = "";


                  if ($anne_k == "a" && $baba_k == "a") {

                    $a_olasilik = 93.75;
                    $b_olasilik = 0;
                    $ab_olasilik = 0;
                    $o_olasilik = 6.25;

                  } elseif ($anne_k == "b" && $baba_k == "b") {

                    $a_olasilik = 0;
                    $b_olasilik = 93.75;
                    $ab_olasilik = 0;
                    $o_olasilik = 6.25;

                  } elseif ($anne_k == "ab" && $baba_k == "ab") {

                    $a_olasilik = 25;
                    $b_olasilik = 25;
                    $ab_olasilik = 50;
                    $o_olasilik = 0;

                  } elseif ($anne_k == "o" && $baba_k == "o") {

                    $a_olasilik = 0;
                    $b_olasilik = 0;
                    $ab_olasilik = 0;
                    $o_olasilik = 100;

                  } elseif (($anne_k == "a" && $baba_k == "b") || ($anne_k == "b" && $baba_k == "a")) {

                    $a_olasilik = 18.75;
                    $b_olasilik = 18.75;
                    $ab_olasilik = 56.25;
                    $o_olasilik = 6.25;

                  } elseif (($anne_k == "a" && $baba_k == "ab") || ($anne_k == "ab" && $baba_k == "a")) {

                    $a_olasilik = 50;
                    $b_olasilik = 12.5;
                    $ab_olasilik = 37.5;
                    $o_olasilik = 0;

                  } elseif (($anne_k == "a" && $baba_k == "o") || ($anne_k == "o" && $baba_k == "a")) {

                    $a_olasilik = 75;
                    $b_olasilik = 0;
                    $ab_olasilik = 0;
                    $o_olasilik = 25;

                  } elseif (($anne_k == "b" && $baba_k == "ab") || ($anne_k == "ab" && $baba_k == "b")) {

                    $a_olasilik = 12.5;
                    $b_olasilik = 50;
                    $ab_olasilik = 37.5;
                    $o_olasilik = 0;

                  } elseif (($anne_k == "b" && $baba_k == "o") || ($anne_k == "o" && $baba_k == "b")) {

                    $a_olasilik = 0;
                    $b_olasilik = 75;
                    $ab_olasilik = 0;
                    $o_olasilik = 25;

                  } elseif (($anne_k == "ab" && $baba_k == "o") || ($anne_k == "o" && $baba_k == "ab")) {

                    $a_olasilik = 50;
                    $b_olasilik = 50;
                    $ab_olasilik = 0;
                    $o_olasilik = 0;

                  }

                  // Rh faktörü tahmini
                  if ($anne_r == "p" || $baba_r == "p") {
                    $cocuk_r = "+";
                  } else {
                    $cocuk_r = "-";
                  }

                  // Çocuğun kan grubunu ve Rh faktörünü ekrana yazdır
                  echo "A Grubu Olasılığı: " . $a_olasilik . "%<br>";
                  echo "B Grubu Olasılığı: " . $b_olasilik . "%<br>";
                  echo "AB Grubu Olasılığı: " . $ab_olasilik . "%<br>";
                  echo "0 Grubu Olasılığı: " . $o_olasilik . "%<br>";
                  echo "RH Faktörü: " . $cocuk_r;

                  try {
                    $dbh = new PDO('mysql:host=localhost;dbname=medimetriks', 'root', '');

                    $sql = "INSERT INTO kan_grubu (name, anne_kan, baba_kan, anne_rh, baba_rh, cocuk_rh) 
                            VALUES ('$name', :anne_k, :baba_k, :anne_r, :baba_r, :cocuk_r)";

                    $stmt = $dbh->prepare($sql);

                    $stmt->bindParam(':anne_k', $anne_k);
                    $stmt->bindParam(':baba_k', $baba_k);
                    $stmt->bindParam(':anne_r', $anne_r);
                    $stmt->bindParam(':baba_r', $baba_r);
                    $stmt->bindParam(':cocuk_r', $cocuk_r);

                    $stmt->execute();


                  } catch (PDOException $e) {
                    echo "Hata: " . $e->getMessage();
                  }

                }
                ?>



              </div>
            </fieldset>
          </div>

          <div class="form-padd">
            <fieldset class="form-konteynir">
              <legend>Kan Grubu Hesaplama Formu</legend>
              <form action="" method="POST">
                <div class="form-giris">
                  <div class="form-ortala">
                    <p class="form-input-baslik">Anne Kan Grubu</p>
                    <select name="anne-k" id="anneKanGrubu" class="acilir-liste" style="width: 49%;">
                      <option value="a">A</option>
                      <option value="b">B</option>
                      <option value="ab">AB</option>
                      <option value="o">0</option>
                    </select>
                    <select name="anne-r" id="anneKanGrubu" class="acilir-liste" style="width: 49%;">
                      <option value="p">+</option>
                      <option value="n">-</option>
                    </select>
                    <p class="form-input-baslik">Baba Kan Grubu</p>
                    <select name="baba-k" id="babaKanGrubu" class="acilir-liste" style="width: 49%;">
                      <option value="a">A</option>
                      <option value="b">B</option>
                      <option value="ab">AB</option>
                      <option value="o">0</option>
                    </select>
                    <select name="baba-r" id="babaKanGrubu" class="acilir-liste" style="width: 49%;">
                      <option value="p">+</option>
                      <option value="n">-</option>
                    </select>
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
            <h2>Kan Grubu Açıklamalar</h2>
            <div>
              Yukarıda bulunan form üzerinde anne kan grubunu ve baba kan
              grubunu seçin ve ardından hesapla butonuna tıklayın. Bebeğinizin
              kan grubunun ne olacağı olasılık dilimleri ile hesaplanacaktır.
            </div>
          </div>
        </div>

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