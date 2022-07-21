<?php
    require "header.php";
?>

<section class="section-css">
    <form action="./php/new_password.php" class="form-css" method = "POST"> 
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
            case 'new_pass_error':
                echo "<div class='alert alert-danger' role='alert'>
                Ops! E' successo qualocsa di strano!
                </div>";
                break;
            case 'email_error':
                echo '<div class="alert alert-danger" role="alert">
                La mail inserita non è valida!
                </div>';
                break;    
        }
    }

    if(isset($_GET['success'])){
        echo '<div class="alert alert-success" role="alert">
                    Email inviata con successo. Controlla la tua mail.
                </div>';
    }

?>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="Inserisci Email">
    </div>
   
    <br>
    <input type="submit" name="submit" value ="Richiedi cambio password" class="btn btn-primary">
    </form>
</section>

<?php
    require "footer.php";
?>