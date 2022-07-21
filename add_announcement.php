<?php
    require "header.php";
    require 'php/connect_db.php';
?>


<section class="section-css width_my_show_profile row">
    <form action="./php/add_announcement.php" class="form-css" method="POST">
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
                    case 'addannouncement_error':
                        echo '<div class="alert alert-danger" role="alert">
                        Ops! Non hai aggiunto nessun annuncio.
                        </div>';
                        break;
                    
                }
            }
            
        ?>

        <div class="form-group">
            <label for="title">Titolo annuncio</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Inserisci il titolo" >
        </div>

        <div class="form-group">
            <label for="description">Descrizione</label>
            <textarea  type="text" name="description" class="form-control" id="description" placeholder="Inserisci la descrizione" > </textarea>
        </div>

        <button type="button" id="dropdown_ajax" > Seleziona la tua barca </button>
        <div id="drop"></div>
        <script>
            $(document).ready(function(){
                $(document).on('click','#dropdown_ajax', function(){
                    $.post('./php/dropdown_ajax.php', {try : ""}, function(result){
                        $('#drop').html(result);
                        $('#myDropdown').show();
                    });
                });
            });
            
        </script>


        <br>
        <input type="submit" name="submit" value ="Aggiungi annuncio" class="btn btn-outline-primary">
    </form>
</section>

<?php 
    require "footer.php";
?>