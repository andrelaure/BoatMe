<?php
    require "header.php";
    require 'php/connect_db.php';
?>
<section class="section-css width_my_profile">
    <form action="./php/update_profile.php" class="form-css width_my_show_profile" method="POST">
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
            case 'update_error':
                echo '<div class="alert alert-danger" role="alert">
                    Ops, è successo qualcosa di strano!
                </div>';
                break;
            
        }
    }

    $sql = "SELECT firstname, lastname, email, nickname FROM users WHERE id = ".$_SESSION['userId'];
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
       $row = mysqli_fetch_assoc($query);
        
        echo 
        '<div class="form-group">
            <label for="firstname">Nome</label>
            <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Inserisci Nome" value="'.htmlspecialchars($row['firstname']).'">
        </div>

        <div class="form-group">
            <label for="lastname">Cognome</label>
            <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Inserisci Cognome" value="'.htmlspecialchars($row['lastname']).'">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Inserisci Email" value="'.htmlspecialchars($row['email']).'">
        </div>

        <div class="form-group">
            <label for="nick">Nickname</label>
            <input type="text" name="nick" class="form-control" id="nick" placeholder="" value="'.htmlspecialchars($row['nickname']).'">
        </div>

        <div class="form-group" hidden>
            <label for="id">userId</label>
            <input type="text" name="id" class="form-control" id="id" value="'.$_SESSION['userId'].'">
        </div>
         ';

    }
    else
    {
        header("Location: php/logout.php");
    }

    echo'<input type="submit" name="submit" value ="Modifica" class="btn btn-outline-primary">
    </form>';

    // Iscrizione newsletter
    $sql = "SELECT * FROM newsletter WHERE email_user='".$row['email']."'";

    if (!$query = mysqli_query($conn, $sql)){
        header("Location: index.php");
        exit();
       
    }
        
    if ($query){
        $result = mysqli_num_rows($query);
    }else
        $result = 0;
    

    if ($result > 0){
        echo'
            <form action="./php/join_newsletter.php" class="form-css width_my_show_profile" method="POST">
                <div class="form-group">
                    <label for="news">Voglio disdire la newsletter</label>
                    <br>
                    <input hidden type="email" name="news" id="news" value="'.htmlspecialchars($row['email']).'">
                    <input hidden type="text" name="delete_news" id="delete_news" value="delete_news">
                </div>
                <input type="submit" name="submit" value ="Disiscriviti" class="btn btn-outline-warning">
            </form>
        ';
      }
      else{
        echo'        
            <form action="./php/join_newsletter.php" class="form-css width_my_show_profile" method="POST">
                <div class="form-group">
                    <label for="news">Voglio ricevere newsletter</label>
                    <br>
                    <input hidden type="email" name="news" id="news" value="'.htmlspecialchars($row['email']).'">
                    <input hidden type="text" name="add_news" id="add_news" value="add_news">
                </div>
                <input type="submit" name="submit" value ="Iscriviti" class="btn btn-outline-primary">
            </form>
        ';
      }

      echo'        
        <form action="./php/delete_user.php" class="form-css width_my_show_profile" method="POST">
            <div class="form-group">
                <label for="del_user">Voglio cancellare il mio account</label>
                <br>
                <input hidden type="id" name="userId" id="userId" value="'.htmlspecialchars($_SESSION['userId']).'">
            </div>
            <input type="submit" name="submit" value ="Elimina account" class="btn btn-outline-danger">
        </form>
    ';


    ?>
</section>


<?php 
    require "footer.php";
?>