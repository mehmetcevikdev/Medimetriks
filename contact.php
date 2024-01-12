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
  <title>Contact | Medimetriks</title>
  <link rel="stylesheet" href="css/base.css" />
  <link rel="stylesheet" href="css/contact.css" />
</head>

<body>
<?php include 'layout/header.php'; ?>

  <!--! contact start -->
  <section class="contact">
    <div class="contact-top">
      <div class="contact-map">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2619.419189770426!2d29.328405776214495!3d38.67113406195183!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14c87f54934838ff%3A0xbb1f82dc1d7569b1!2sU%C5%9Fak%20%C3%9Cniversitesi%2C%20Teknik%20Bilimler%20Meslek%20Y%C3%BCksekokulu!5e0!3m2!1str!2str!4v1702300429652!5m2!1str!2str"
          width="100%" height="500" style="border: 0" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
    <div class="contact-bottom">
      <div class="container">
        <div class="contact-titles">
          <h4>Contact with us</h4>
          <h2>Get In Touch</h2>
          <p>
            In hac habitasse platea dictumst. Pellentesque viverra sem nec
            orci lacinia, in bibendum urna mollis. Quisque nunc lacus, varius
            vel leo a, pretium lobortis metus. Vivamus consectetur consequat
            justo.
          </p>
        </div>
        <!-- contact php start -->
        <?php

        // Veritabanı bağlantısı
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "contact";

        // Veritabanına bağlanma
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Bağlantıyı kontrol etme
        if ($conn->connect_error) {
          die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
        }

        // Form verilerini alma
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $name = $_POST["name"];
          $email = $_POST["email"];
          $subject = $_POST["subject"];
          $message = $_POST["message"];

          // Veritabanına ekleme sorgusu
          $sql = "INSERT INTO contact_message (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

          // Sorguyu çalıştırma
          if ($conn->query($sql) === TRUE) {
            echo '<div style="color: #59b7a5; margin: 20px 0 -30px 0; font-size: 18px;">Mesajınız başarıyla gönderildi.</div>';
          } else {
            echo "Hata: " . $sql . "<br>" . $conn->error;
          }
        }

        // Veritabanı bağlantısını kapatma
        $conn->close();

        ?>
        <!-- contact php end -->
        <div class="contact-elements">

          <form class="contact-form" method="post" action="">
            <div>
              <label for="name">
                Your name
                <span>*</span>
              </label>
              <input type="text" name="name" required />
            </div>
            <div>
              <label for="email">
                Your email
                <span>*</span>
              </label>
              <input type="text" name="email" required />
            </div>
            <div>
              <label for="subject">
                Subject
                <span>*</span>
              </label>
              <input type="text" name="subject" required />
            </div>
            <div>
              <label for="message">
                Your message
                <span>*</span>
              </label>
              <textarea name="message" id="message" type="text" value="" size="30" required></textarea>
            </div>
            <button type="submit" class="btn btn-sm form-button">Send Message</button>
          </form>
          <div class="contact-info">
            <div class="contact-info-item">
              <div class="contact-info-texts">
                <strong>Uşak Üniversitesi</strong>
                <p class="contact-street">
                  Atatürk Blv. 8. Km, 64000 Kaşbelen/Merkez/Uşak
                </p>
                <a href="tel:+1 1234 567 88">Phone: +1 1234 567 88</a>
                <a href="mailto:contact@example.com">Email: contact@example.com</a>
              </div>
            </div>
            <div class="contact-info-item">
              <div class="contact-info-texts">
                <strong>Opening Hours</strong>
                <p class="contact-date">Monday - Friday : 9am - 5pm</p>
                <p>Weekend Closed</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--! contact end -->

  <?php include 'layout/footer.php'; ?>
</body>

</html>