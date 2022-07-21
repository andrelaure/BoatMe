<?php
    require "header.php";
    require 'php/connect_db.php';
?>


<section class="section-css width_my_show_profile row">
    <form action="./php/add_boat.php" class="form-css" method="POST">
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
                    case 'addboat_error1':
                        echo '<div class="alert alert-danger" role="alert">
                        Ops! Non hai aggiunto nessuna barca.
                        </div>';
                        break;
                    
                }
            }
        ?>

        <div class="form-group">
            <label for="boatname">Modello barca</label>
            <input type="text" name="boatname" class="form-control" id="boatname" placeholder="Inserisci il modello della barca" >
        </div>

        <div class="form-group">
            <label for="characteristic">Descrizione</label>
            <textarea  type="text" name="characteristic" class="form-control" id="characteristic" > </textarea>
        </div>

        <div class="form-group">
            <label for="category">Categoria</label>
            <select class="form-control" name="category" id="category" >
                <option value="Barca a vela">Barca a vela</option>
                <option value="Barca a motore">Barca a motore</option>
                <option value="Tavole a vela">Tavole a vela</option>
                <option value="Pedalò">Pedalò</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="photo_path">Path foto barca</label>
            <input type="text" name="photo_path" class="form-control" id="photo_path" placeholder="Inserisci il path della foto" >
        </div>

        <input type="submit" name="submit" value ="Aggiungi Barca" class="btn btn-outline-primary">
    </form>
</section>

<?php 
    require "footer.php";
?>