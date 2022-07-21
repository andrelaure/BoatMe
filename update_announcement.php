<?php
    require "header.php";
    require 'php/connect_db.php';
?>

<section class="section-css width_my_show_profile row a">
    <form action="./php/update_announcement.php" class="form-css" method="POST">
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
                    case 'update_error':
                        echo '<div class="alert alert-danger" role="alert">
                        Ops! Non hai aggiornato il tuo annuncio.
                        </div>';
                        break;
                    
                }
            }

            if(!$stmt = mysqli_stmt_init($conn)){    
                echo'"db_connection_error"';  
                exit();
            }

            $sql = "SELECT title, description FROM announcement WHERE id_user = ? AND id_boat = ? AND id_ann = ?";
            if (!mysqli_stmt_prepare($stmt, $sql))
            {
                header("Location: ../my_announcement.php?error=addannouncement_error");
                exit();
            }

            if(!mysqli_stmt_bind_param($stmt, "iii", $_SESSION['userId'], $_POST['id_boat'], $_POST['id_ann']))  // + foto
            {
                header("Location: ../my_announcement.php?error=addannouncement_error");
                exit();
            }
            
            if (!mysqli_stmt_execute($stmt))
            {
                header("Location: ../my_announcement.php?error=addannouncement_error");
                exit();
            }

            if (!$result = mysqli_stmt_get_result($stmt)){
                header("Location: ../my_boats.php?error=updateboat_error");
                exit(); 
            }
            
            if ($row = mysqli_fetch_assoc($result))
            {

    
                echo 
                    '<div class="form-group">
                        <label for="title">Modello barca</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Inserisci il modello della barca" value="'.htmlspecialchars($row['title']).'">
                    </div>

                    <div class="form-group">
                        <label for="description">Descrizione</label>
                        <textarea type="text" name="description" class="form-control" id="description" placeholder="Inserisci la descrizione">'.htmlspecialchars($row['description']).'</textarea>
                    </div>
                    
                    <div class="form-group" hidden>
                        <label for="id_user">userId</label>
                        <input type="text" name="id_user" class="form-control" id="id_user" value="'.$_SESSION['userId'].'">
                    </div>

                    <div class="form-group" hidden>
                        <label for="id_boat">id_boat</label>
                        <input type="text" name="id_boat" class="form-control" id="id_boat" value="'.$_POST['id_boat'].'">
                    </div>

                    <div class="form-group" hidden>
                        <label for="id_ann">id_ann</label>
                        <input type="text" name="id_ann" class="form-control" id="id_ann" value="'.$_POST['id_ann'].'">
                    </div>
                ';

            }

        ?>

        

        <input type="submit" name="submit" value ="Modifica Barca" class="btn btn-outline-primary">
    </form>
</section>

<?php 
    require "footer.php";
?>