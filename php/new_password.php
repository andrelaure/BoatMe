<?php
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';
    require '../PHPMailer/src/Exception.php';
    require_once 'connect_db.php';
    use PHPMailer\PHPMailer\PHPMailer;

    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    } 

    if (!isset($_POST['email']) | !isset($_POST['submit'])){ 
        header("Location: ../new_password.php?error=credential_error");  
        exit();
    }

    if (!strlen($_POST['email'])){ 
        header("Location: ../new_password.php?error=empty_error");  
        exit();
    }


    if(!$stmt = mysqli_stmt_init($conn)){    
        header("Location: ../new_password.php?error=db_connection_error");  
        exit();
    } 


    
    $sql = "SELECT * FROM users WHERE email = ?";
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../new_password.php?error=new_pass_error");
        exit();
    }
    
    if(!mysqli_stmt_bind_param($stmt, "s", $_POST['email']))  
    {
        header("Location: ../new_password.php?error=new_pass_error");
        exit();
    }
    
    if (!mysqli_stmt_execute($stmt))
    {
        header("Location: ../new_password.php?error=new_pass_error");
        exit();
    }

    $result = mysqli_stmt_get_result($stmt);

    if ( mysqli_num_rows($result) > 0)
    {

        // Creazione del token
        $n=32;
        function randToken($n) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
          
            for ($i = 0; $i < $n; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }
          
            return $randomString;
        }
        $token = randToken($n);
        $expiring_date = date('Y-m-d', strtotime("+2 day"));
        $current_date = date("Y-m-d");
        $id_user = mysqli_fetch_assoc($result)['id'];

        // Query per canellare i token scaduti (expiring_date)
        $sql = "DELETE FROM tokens WHERE expiring_date < '2022-07-12'";         

        // Query per aggiungere il nuovo token
        $sql = "INSERT INTO tokens VALUES (default, '".$token."', '".$expiring_date."', ".$id_user.")"; //id, token, expiring_date, id_user

        if (!$query = mysqli_query($conn, $sql))
            {
                header("Location: ../index.php");
                exit();
            }

        // Invio della mail
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'boatme2022@gmail.com';
        $mail->Password = 'utnyldnzmznscvde';
        //$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mailContent = "<h1>Richiesta di cambio password</h1>
            <p>Ci risulta la tua richiesta di recupero della password. Se non sei stato tu allora ti vogliono fregare l'account.
            <br>
            Se invece vuoi veramente recuperare la password </p>
            
            <a href='http://localhost/labo_finale/restore_password.php?token=".$token."' rel='stylesheet'><p>clicca qui</p></a>";

        $mail->setFrom('boatme2022@gmail.com', 'Boatme');
        $mail->Subject = "Cambio password";
        $user_email = $_POST['email']; 
    
        $mail->addAddress($user_email);
        $mail->Body = $mailContent;
        $mail->IsHTML(true);   

        try {
            $mail->send();
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: ../new_password.php?success=True");  
            exit();

        } catch (Exception $e) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            echo "Mailer Error: ({$user_email}) {$mail->ErrorInfo}\n";
        }

        $mail->smtpClose();

    }else{
        header("Location: ../new_password.php?error=email_error");  
        exit();
    }