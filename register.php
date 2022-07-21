<?php
    require "header.php";
?>
<section class="section-css">
    <form action="./php/registration.php" class="form-css" method="POST">
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
                Uno dei campi è vuoto!
                </div>';
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
?>
    <div class="form-group">
        <label for="firstname">Nome</label>
        <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Inserisci Nome">
    </div>

    <div class="form-group">
        <label for="lastname">Cognome</label>
        <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Inserisci Cognome">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="Inserisci Email">
    </div>

    <div class="form-group">
        <label for="pass">Password</label>
        <input type="password" name="pass" class="form-control" id="pass" placeholder="Password">
    </div>

    <div class="form-group">
        <label for="confirm">Conferma Password</label>
        <input type="password" name="confirm" class="form-control" id="confirm" placeholder="Conferma Password">
    </div>

    <input type="submit" name="submit" value ="Registrati" class="btn btn-outline-primary">
    </form>
</section>

<?php
    require "footer.php";
?>