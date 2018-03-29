<?php
require_once 'core/init.php';
if(Input::exists()){
  if(true){ //csrf protection
    $validate = new Validation();
    $validate->check($_POST, array(
      'name' => array(
        'required' => array(true, 'You Must Enter Your Name'),
        'max' => array(20, 'Your Name Must Be At Most 20 Characters'),
        'regexp' => array('/^[A-Za-z_0-9]+$/i', "Please Enter A Valid Name | Note That You can only use English letters, numbers and underscores.")
      ),
      'email' => array(
        'required' => array(true, 'You Must Enter Your Email'),
        'min' => array(4, 'Your Email Must Be At Least 4 Characters'),
        'max' => array(40, 'Your Name Must Be At Most 40 Characters'),
        'regexp' => array('/^[A-Za-z_\.0-9]+@+[A-Za-z_\.0-9]+$/i', "Please Enter A Valid Email.")
      ),
      'telephone' => array(
        'regexp' => array('/^|[\+0-9]+$/i', "Please Enter A Valid Telephone Number.")
      ),
      'message' => array(
        'required' => array('true', 'You Can\'t Leave Your Message Empty'),
        'max' => array(700, 'Your Message Must Be At Most 700 Characters')
      )
    ));
    if($validate->passed()){
      //send the message
      /* SENDING EMAIL ADDRESS // CONFIGURE IT WITH YOUR DATA //php mailer used: https://github.com/PHPMailer/PHPMailer
      $mail = new PHPMailer();                              // Passing `true` enables exceptions
      try {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'user@example.com';                 // SMTP username
        $mail->Password = 'secret';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
        $mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        //Attachments
        $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
      } catch (Exception $e) {

      }
      */
      Session::put('status', '<div class="alert alert-success text-center" style="position: fixed; z-index:9999; width: 100%;"> Your message has been sent </div>');
      Redirect::re();
    }else{
      Session::put('status', '<div class="alert alert-danger text-center" style="position: fixed; z-index:9999; width: 100%;"> Message could not be sent. </div>');
      $errors = $validate->errors();
    }
  }else{
    Redirect::re();
  }

}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <!-- including style files -->
    <link href="https://fonts.googleapis.com/css?family=Chicle|Cairo" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/font-awesome.min.css" rel="stylesheet"/>
    <link href="css/style.css" rel="stylesheet"/>

    <!-- including Script files -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php echo Session::flash('status'); ?>
    <!-- Starting Headers -->
    <header>
      <div class="container">
        <div class="intro">
          <p>Don't Wait To Contact Us</p>
          <h1>Contact Us</h1>
          <p></p>
        </div>
        <a href="#info">
          <i class="fa fa-arrow-down"></i>
        </a>
      </div>
    </header>
    <!-- Ending Headers -->

    <!-- Starting Info -->
    <section class="info" id="info">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-xs-6">
            <h3>Address</h3>
            <p>
              11231 Buah Batu Bandung
            </p>
          </div>
          <div class="col-md-3 col-xs-6">
            <h3>Phone</h3>
            <p>
              9876-54321
              <br />
              9876-52244
            </p>
          </div>
          <div class="col-md-3 col-xs-6">
            <h3>Open Time</h3>
            <p>
              Everyday except for holiday
              <br />
              From 10 AM – 5 PM
            </p>
          </div>
          <div class="col-md-3 col-xs-6">
            <h3>Email</h3>
            <p>
              <a href="mailto:Email@Company.com">Email@Company.com</a>
            </p>
          </div>
        </div>
      </div>
    </section>
    <!-- Ending Info -->

    <!-- Starting Contact Form -->
    <section class="contact">
      <div class="container">
        <h1 class="page-header text-center">Message Us</h1>
        <div class="row">
          <div class="col-md-6 col-xs-12">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

              <input type="text" name="name" id="name" placeholder="Your Name" value="<?php echo @Input::get('name'); ?>" maxlength="20" required />
              <label class='text text-danger' for="name"><?php echo @$errors['name']; ?></label>

              <input type="emas il" name="email" id="email" placeholder="Your Email" value="<?php echo @Input::get('email'); ?>" minlength="4" maxlength="40" required />
              <label class='text text-danger' for="email"><?php echo @$errors['email']; ?></label>

              <input type="number" name="telephone" id="telephone" placeholder="Your Telephone" value="<?php echo @Input::get('telephone'); ?>" />
              <label class='text text-danger' for="telephone"><?php echo @$errors['telephone']; ?></label>

              <textarea name="message" id="message" placeholder="Your Message" maxlength="700"><?php echo @Input::get('message'); ?></textarea>
              <label class='text text-danger' for="message"><?php echo @$errors['message']; ?></label>

              <input type="submit" value="Send Message" />
            </form>
          </div>
          <div class="col-md-6 col-xs-12">
            <iframe frameborder="0" scrolling="no" src="https://maps.google.com/maps?q=Jl.%20Buah%20Batu%20No.51%2C%20Malabar%2C%20Lengkong%2C%20Kota%20Bandung%2C%20Jawa%20Barat%2040262&amp;t=m&amp;z=15&amp;output=embed&amp;iwloc=near"></iframe>
          </div>
        </div>
      </div>
    </section>
    <!-- Ending Contact Form -->

    <!-- Starting Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-xs-6">
            <span>Made With A lot Of Coffee And Love By <a href="#">Mahmoud Shiref</a></span>
          </div>
          <div class="col-xs-6 social">
            <a href="mailto:lord.zukoh@gmail.com"><i class="fa fa-telegram"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-google-plus"></i></a>
            <a href="https://github.com/MahmoudShiref"><i class="fa fa-github"></i></a>
          </div>
        </div>
      </div>
    </footer>
    <!-- Ending Footer -->
    <script src="js/script.js"></script>
  </body>
</html>
