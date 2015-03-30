<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);
    if ($name == "" OR $email == "" OR $message == "") {
        echo "You must specify a value for name, email address, and message.";
        exit;
    }
    foreach( $_POST as $value ){
        if( stripos($value,'Content-Type:') !== FALSE ){
            echo "There was a problem with the information you entered.";
            exit;
        }
    }
    if ($_POST["address"] != "") {
        echo "Your form submission has an error.";
        exit;
    }
    require_once("inc/phpmailer/class.phpmailer.php");
    $mail = new PHPMailer();

    if (!$mail->ValidateAddress($email)){
        echo "You must specify a valid email address.";
        exit;
    }
    $email_body = "";
    $email_body = $email_body . "Name: " . $name . "<br>";
    $email_body = $email_body . "Email: " . $email . "<br>";
    $email_body = $email_body . "Message: " . $message;

    $mail->SetFrom($email, $name);
    $address = "ccarlson@jcpowerrental.com";
    $mail->AddAddress($address, "JC Power contact form request");
    $mail->Subject    = "JC Power | " . $name;
    $mail->MsgHTML($email_body);

    if(!$mail->Send()) {
      echo "There was a problem sending the email: " . $mail->ErrorInfo;
      exit;
    }

    header("Location: contact.php?status=thanks");
    exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
     <meta charset="utf-8">
    <title>Contact Us</title>
    <link rel="stylesheet" href="normalize.css">
     <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="main.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body >
    <header class="main-header">
      <a href="index.php" id="logo" >
        <img src="images/jcPower_Logo_102414_BLACK.png" alt="logo">
      </a>
       <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="prods.php">Equipment</a></li>
        <li><a href="contact.php"class="selected">Contact</a></li> 
      </ul>
      </nav>
	</header>
    <div id="contact_bg">
	<div id="wrapper">
	<section>
                    <?php if (isset($_GET["status"]) AND $_GET["status"] == "thanks") { ?>
                        <p>Thanks for the email! We&rsquo;ll be in touch shortly!</p>
                    <?php } else { ?>
                        <form method="post" id="no-mobile-form" action="contact.php">
                            <table>
                                <tr>
                                    <th>
                                        <label for="name">Name</label>
                                    </th>
                                    <td>
                                        <input type="text" name="name" id="name">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="email">Email</label>
                                    </th>
                                    <td>
                                        <input type="text" name="email" id="email">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="message">Message</label>
                                    </th>
                                    <td>
                                        <textarea name="message" id="message"></textarea>
                                    </td>
                                </tr>
                                <tr style="display: none;">
                                    <th>
                                        <label for="address">Address</label>
                                    </th>
                                    <td>
                                        <input type="text" name="address" id="address">
                                        <p>Please leave this field blank.</p>
                                    </td>
                                </tr>
                            </table>
                            <input type="submit" value="Send">
                        </form>
                    <?php } ?>
	</section>
    </div>
    </div>
  <?php
include('inc/footer.php'); ?>
	