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
    <title>Günlük Kalori İhtiyacı Hesaplama </title>

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
                    <h1>Günlük Kalori İhtiyacı Hesaplama</h1>
                    <div class="on-bilgi">
                        Aşağıda bulunan form ile vücudunuzun ihtiyaç duyduğu kalori
                        miktarını, haftada 1kg almak ve 1kg vermek için kaç kalori almanız
                        gerektiğini hesaplayabilirsiniz. Karbonhidrat, protein ve yağ
                        dağılımını görüntüleyebilirsiniz.
                    </div>

                    <!--! kullanicidan alinan veriler php kodlari ile boyle yayinlancak -->
                    <div class="form-padd">
                        <fieldset class="form-konteynir sonuc">
                            <legend>Hesaplama Sonuçları</legend>
                            <div class="php-container">

                                <?php
                                /* Verilerini alacağımız değişkenleri belirledimiz kısın */
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $name = $_SESSION['user_name'];
                                    $gender = $_POST["cinsiyet"];
                                    $weight = $_POST["kilo"];
                                    $height = $_POST["boy"];
                                    $age = $_POST["yas"];
                                    $tempo = isset($_POST["tempo"]) ? $_POST["tempo"] : 1.2;

                                    /* Cinsiyete göre günlük kalori ihticayını hesaplayan yapı */
                                    if ($gender == "x") {
                                        $daily_calories = 655 + 9.6 * $weight + 1.8 * $height - 4.7 * $age;
                                    } else {
                                        $daily_calories = 66 + 13.7 * $weight + 5 * $height - 6.8 * $age;
                                    }

                                    /* Formdan gelen günlük ne kadar hareket ettiğini hesaplayan yapı */
                                    switch ($tempo) {
                                        case 1.2:
                                            $daily_calories *= 1.2;
                                            break;
                                        case 1.375:
                                            $daily_calories *= 1.375;
                                            break;
                                        case 1.55:
                                            $daily_calories *= 1.55;
                                            break;
                                        case 1.725:
                                            $daily_calories *= 1.725;
                                            break;
                                        case 1.9:
                                            $daily_calories *= 1.9;
                                            break;
                                        default:
                                            $daily_calories *= 1.2; // Varsayılan olarak masabasi
                                            break;
                                    }

                                    /* Hesaplamaların Kullanıcıya Sunulduğu Kısım */
                                    echo "<b>Günlük Kalori İhtiyacınız</b> <br />";
                                    echo "<b>Kalori İhtiyacınız: </b>" . $daily_calories . " kcal <br />";
                                    echo "Karbonhidrat (55%) " . $daily_calories * 0.55 . " kcal <br />";
                                    echo "Protein (15%) " . $daily_calories * 0.15 . " kcal <br />";
                                    echo "Yağ (30%) " . $daily_calories * 0.3 . " kcal <br />";
                                    echo "<br />";

                                    echo "Haftada 1kg vermek için Günlük Kalori İhtiyacınız <br />";
                                    echo "Kalori İhtiyacınız: -" . $daily_calories - 1100 . " kcal <br />";
                                    echo "Karbonhidrat (55%) -" . ($daily_calories - 1100) * 0.55 . " kcal <br />";
                                    echo "Protein (15%) -" . ($daily_calories - 1100) * 0.15 . " kcal <br />";
                                    echo "Yağ (30%) -" . ($daily_calories - 1100) * 0.3 . " kcal <br />";
                                    echo "<br />";

                                    echo "Haftada 1kg almak için Günlük Kalori İhtiyacınız <br />";
                                    echo "Kalori İhtiyacınız: " . $daily_calories + 1100 . " kcal <br />";
                                    echo "Karbonhidrat (55%) " . ($daily_calories + 1100) * 0.55 . " kcal <br />";
                                    echo "Protein (15%) " . ($daily_calories + 1100) * 0.15 . " kcal <br />";
                                    echo "Yağ (30%) " . ($daily_calories + 1100) * 0.3 . " kcal <br />";
                                    echo "<br />";

                                    // Veritabanı bağlantısı
                                    $servername = "localhost";
                                    $username = "root";
                                    $password = "";
                                    $dbname = "hesaplamalar";

                                    // Veritabanına bağlanma
                                    $conn = new mysqli($servername, $username, $password, $dbname);

                                    // Bağlantıyı kontrol etme
                                    if ($conn->connect_error) {
                                        die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
                                    }

                                    // Veritabanına ekleme sorgusu
                                    $sql = "INSERT INTO gunluk_kalori_ihtiyaci (name, cinsiyet, kilo, boy, yas, tempo, gunluk_kalori)
            VALUES ('$name','$gender', '$weight', '$height', '$age', '$tempo', '$daily_calories')";

                                    // Sorguyu çalıştırma
                                    if ($conn->query($sql) === TRUE) {

                                    } else {
                                        echo "Hata: " . $sql . "<br>" . $conn->error;
                                    }

                                    // Veritabanı bağlantısını kapatma
                                    $conn->close();
                                }
                                ?>

                            </div>
                        </fieldset>
                    </div>
                    <div class="form-padd">
                        <fieldset class="form-konteynir">
                            <legend>Günlük Kalori İhtiyacı Hesaplama Formu</legend>
                            <form action="gunluk_kalori_ihtiyaci.php" method="POST">
                                <div class="form-giris">
                                    <div class="form-ortala">
                                        <!-- Cinsiyet seçme kısmı -->
                                        <p class="form-input-baslik">Cinsiyetiniz</p>
                                        <div>
                                            <input type="radio" name="cinsiyet" id="radio1" class="radio" value="x"
                                                checked="" />
                                            <label for="radio1">Kadın</label>
                                        </div>

                                        <div style="margin-bottom: 10px">
                                            <input type="radio" name="cinsiyet" id="radio2" class="radio" value="y" />
                                            <label for="radio2">Erkek</label>
                                        </div>

                                        <!-- Kilo bilgilerinin girildiği kısım -->
                                        <p for="weight" class="form-input-baslik">
                                            Kilonuz<span class="form-input-aciklama">kg</span>
                                        </p>
                                        <input type="number" name="kilo" id="kilo" class="form-textbox" value="" />

                                        <!-- Boy bilgilerinin girildiği kısım -->
                                        <p for="height" class="form-input-baslik">
                                            Boyunuz<span class="form-input-aciklama">cm</span>
                                        </p>
                                        <input type="number" name="boy" id="boy" class="form-textbox" value="" />

                                        <!-- Yaş bilgilerinin girildiği kısım -->
                                        <p for="age" class="form-input-baslik">
                                            Yaşınız<span class="form-input-aciklama">sayı</span>
                                        </p>
                                        <input type="number" name="yas" id="yas" class="form-textbox" value="" />

                                        <!-- Gün içinde ne kadar hareket ettiğini gösteren listenin olduğu kısım -->
                                        <p class="form-input-baslik">Günlük Temponuz</p>
                                        <select name="tempo" id="tempo" class="acilir-liste">
                                            <option value="1.2" selected="">
                                                Masabaşı iş (Egzersiz az / hiç)
                                            </option>
                                            <option value="1.375">
                                                Hafif egzersiz (Haftanın 1-3 günü)
                                            </option>
                                            <option value="1.55">
                                                Orta egzersiz (Haftanın 3-5 günü)
                                            </option>
                                            <option value="1.725">
                                                Aktif egzersiz (Haftanın 6-7 günü)
                                            </option>
                                            <option value="1.9">Yüksek tempo (Yoğun egzersiz)</option>
                                        </select>
                                    </div>

                                    <!-- Hesaplama ve Sıfırla Kodlarının olduğu kısım -->
                                    <div class="hesapla-sifirla-btn">
                                        <input class="sifirla" type="reset"></input>
                                        <input type="submit" class="hesaplama" value="Hesapla" />
                                    </div>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                    <div class="aciklamalar">
                        <h2>Günlük Kalori İhtiyacı Açıklamalar</h2>
                        <div>
                            Günlük kalori ihtiyacınızı hesaplamak için form üzerinde
                            cinsiyetinizi seçin. Kilonuzu, boyunuzu, yaşınızı ve günlük
                            temponuzu form üzerindeki alanlara doldurarak hesapla butonuna
                            tıklayın. Sonuçlar görüntülendiğinde günlük kalori ihtiyacınız,
                            haftada 1kg almak ve vermek için almanız gereken kalori miktarı
                            görüntülenir.
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