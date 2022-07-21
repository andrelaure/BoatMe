<?php
    require "header.php";
    require 'php/connect_db.php';
?>

<section class="section-css width_my_show_profile row a">
    <form action="./php/update_boat.php" class="form-css" method="POST">
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
                    case 'db_connection_error':
                        echo '<div class="alert alert-danger" role="alert">
                        Ops, è successi qualcosa di strano!
                        </div>';
                    case 'update_error':
                        echo '<div class="alert alert-danger" role="alert">
                        Ops! Non hai aggiornato la tua barca.
                        </div>';
                        break;
                    
                }
            }

            if(!$stmt = mysqli_stmt_init($conn)){    
                header("Location: ../my_boats.php?error=db_connection_error");  
                exit();
            } 

            $sql = "SELECT name, characteristic, category, photo_path FROM boat WHERE id_user = ? AND id_boat = ?";
            if (!mysqli_stmt_prepare($stmt, $sql))
            {
                header("Location: ../my_boats.php?error=updateboat_error");
                exit();
            }

            if(!mysqli_stmt_bind_param($stmt, "ii", $_SESSION['userId'], $_POST['id_boat']))  
            {
                header("Location: ../my_boats.php?error=updateboat_error");
                exit();
            }
            
            if (!mysqli_stmt_execute($stmt))
            {
                header("Location: ../my_boats.php?error=updateboat_error");
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
                        <label for="boatname">Modello barca</label>
                        <input type="text" name="boatname" class="form-control" id="boatname" placeholder="Inserisci il modello della barca" value="'.htmlspecialchars($row['name']).'">
                    </div>

                    <div class="form-group">
                        <label for="characteristic">Descrizione</label>
                        <textarea type="text" name="characteristic" class="form-control" id="characteristic" placeholder="Inserisci la descrizione">'.htmlspecialchars($row['characteristic']).'</textarea>
                    </div>

                    <div class="form-group">
                        <label for="category">Categoria</label>
                        <input type="category" name="category" class="form-control" id="category" placeholder="Inserisci la categoria" value="'.htmlspecialchars($row['category']).'">
                    </div>

                    <div class="form-group">
                        <label for="photo_path">Path foto barca</label>
                        <input type="text" name="photo_path" class="form-control" id="photo_path" placeholder="Inserisci il path della foto" value="'.htmlspecialchars($row['photo_path']).'">
                    </div>
                    
                    <div class="form-group" hidden>
                        <label for="id_user">userId</label>
                        <input type="text" name="id_user" class="form-control" id="id_user" value="'.$_SESSION['userId'].'">
                    </div>

                    <div class="form-group" hidden>
                        <label for="id_boat">userId</label>
                        <input type="text" name="id_boat" class="form-control" id="id_boat" value="'.$_POST['id_boat'].'">
                    </div>
                    ';

            }

            mysqli_stmt_close($stmt);
            mysqli_close($conn);
           //  header("Location: ../my_boats.php?success=True");
            
        ?>

        

        <input type="submit" name="submit" value ="Modifica Barca" class="btn btn-outline-primary">
    </form>
</section>

<?php 
    require "footer.php";
?>