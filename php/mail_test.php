<?php
  require '../PHPMailer/src/PHPMailer.php';
  require '../PHPMailer/src/SMTP.php';
  require '../PHPMailer/src/Exception.php';
  use PHPMailer\PHPMailer\PHPMailer;

  require_once 'connect_db.php';

  $mail = new PHPMailer();
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'boatme2022@gmail.com';
  $mail->Password = 'utnyldnzmznscvde';
  //$mail->SMTPSecure = 'tls';    // secure transfer enabled REQUIRED for Gmail
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  $mail->Port = 465;
  $mail->SMTPKeepAlive = true; 

  $mailContent = "<h1>Nuovi annunci disponibili</h1>
      <p>Corri a vedere i nuovi annunci sul nostro sito! Affrettati a prenotare il tuo giro in barca! Bla Bla Bla</p>
      <a href='http://localhost/labo_finale/dashboard.php' rel='stylesheet'><p>Visita il sito</p></a>";
  
  
  $mail->setFrom('boatme2022@gmail.com', 'Boatme');
  $mail->Subject = "Nuovo annuncio";

  $user_email = array();

  $sql = "SELECT email_user FROM newsletter";
  if (!$query = mysqli_query($conn, $sql))
    {
      header("Location: index.php");
      exit();
    }
  
  if ($query){
    $result = mysqli_num_rows($query);
  }else
    $result = 0;

  if ($result > 0)
  {
    while($row = mysqli_fetch_assoc($query)){
      array_push($user_email, $row);
    }
  }
  
  foreach ($user_email as $user) {
    $mail->addAddress($user['email_user']);
    $mail->Body = $mailContent;
    $mail->IsHTML(true);   
  
    try {
        $mail->send();
        echo "Messaggio inviato a: ({$user['email_user']}) {$mail->ErrorInfo}\n";
    } catch (Exception $e) {
        echo "Mailer Error: ({$user['email_user']}) {$mail->ErrorInfo}\n";
    }
  
    $mail->clearAddresses();
  }
  
  $mail->smtpClose();