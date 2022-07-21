<?php
    require "header.php";
    require "./php/connect_db.php";
?>

<section class="section-css">
    <form action="./php/restore_password.php" class="form-css" method = "POST"> 
    <?php
    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_GET['error'])){
        switch($_GET['error']){
            case 'credential_error':
                echo '<div class="alert alert-danger" role="alert">
                    Ops, è successo qualcosa di strano!
                </div>';
                break;
            case 'empty_error':
                echo '<div class="alert alert-danger" role="alert">
                    I campi vuoti non sono validi!
                </div>';
                break;  
            case 'db_connection_error':
                echo "<div class='alert alert-danger' role='alert'>
                    Ops, è successo qualcosa di strano!.
                </div>";
                break;   
            case 'token_error':
                echo "<div class='alert alert-danger' role='alert'>
                    Ops, è successo qualcosa di strano!.
                </div>";
                break;  
            case 'update_error':
                echo "<div class='alert alert-danger' role='alert'>
                    Ops, è successo qualcosa di strano!.
                </div>";
                break;   
            case 'pass_error1':
                echo '<div class="alert alert-danger" role="alert">
                    La password deve esser lunga almeno 8 caratteri!
                </div>';
                break;    
            case 'pass_error2':
                echo '<div class="alert alert-danger" role="alert">
                    La password non corrisponde!
                </div>';
                break;    
        }
    }

    if (!isset($_GET['token'])){
        header("Location: ./restore_password.php?error=credential_error");  
        exit();
    }

    if(!$stmt = mysqli_stmt_init($conn)){    
        header("Location: ./restore_password.php?error=db_connection_error");  
        exit();
    } 

    $sql = "SELECT * FROM tokens WHERE token = ?";
    if (!$error = mysqli_stmt_prepare($stmt, $sql))
    {   
        header("Location: ./restore_password.php?error=token_error");
        exit();
    }
    
    if(!mysqli_stmt_bind_param($stmt, "s", $_GET['token']))  
    {
        header("Location: ./restore_password.php?error=token_error");
        exit();
    }
    
    if (!mysqli_stmt_execute($stmt))
    {
        header("Location: ./restore_password.php?error=token_error");
        exit();
    }

    $result = mysqli_stmt_get_result($stmt);
    if ( mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);
        echo'
            <div class="form-group">
                <label for="pass">Inserisci la nuova password</label>
                <input type="password" name="pass" class="form-control" id="pass" placeholder="Password">
            </div>

            <div class="form-group">
                <label for="confirm">Conferma Password</label>
                <input type="password" name="confirm" class="form-control" id="confirm" placeholder="Conferma Password">
            </div>

            <br>
            <input type="submit" name="submit" value ="Aggiorna password" class="btn btn-primary">
            <input type="hidden" name="token" value="'.$row['token'].'"/>
            </form>
        ';
    }else{
        echo'
            <div>
            <h2>Mi dispiace, si è verificato un errore. Prova di nuovo.</h2>
            </div>
        ';
    }
    ?>

</section>

<?php
    require "footer.php";
?>