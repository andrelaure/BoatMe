<?php
    require "header.php";
?>

<section class="section-css">
    <form action="./php/login.php" class="form-css" method = "POST"> 
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
        }
    }

    if(isset($_GET['success'])){
        echo "<div class='alert alert-success' role='alert'>
                    Complimenti! L'operazione è avvenuta con successo!
                </div>";
    }

?>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="Inserisci Email">
    </div>

    <div class="form-group">
        <label for="pass">Password</label>
        <input type="password" name="pass" class="form-control" id="pass" placeholder="Password">
    </div>

    <div>
        Non sei ancora registrato?  <a href="register.php">Registrati</a>
    </div>

    <div>
        Non ricordi la password?  <a href="new_password.php">Recupera la tua password</a>
    </div>
   
    <br>
    <input type="submit" name="submit" value ="Accedi" class="btn btn-primary">
    </form>
</section>

<?php
    require "footer.php";
?>