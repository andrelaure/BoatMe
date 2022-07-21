<?php
    require 'connect_db.php';

    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    } 

    if (!isset($_POST['title']) | !isset($_POST['description']) | !isset($_POST['selected_boat']) | !isset($_POST['submit'])){ 
        header("Location: ../add_announcement.php?error=credential_error");  
        exit();
    }

    if (!strlen($_POST['title']) | !strlen($_POST['description']) | !isset($_POST['selected_boat'])){ 
        header("Location: ../add_announcement.php?error=empty_error");  
        exit();
    }

    if(!$stmt = mysqli_stmt_init($conn)){    
        header("Location: ../my_announcement.php?error=db_connection_error");  
        exit();
    }    

    // Controllo id barca e id utente

    $sql = "SELECT * FROM boat WHERE id_boat=? AND id_user=?";
    if (!$error = mysqli_stmt_prepare($stmt, $sql))
    {   
        header("Location: ../my_announcement.php?error=addannouncement_error");
        exit();
    }
    
    if(!mysqli_stmt_bind_param($stmt, "ii", $_POST['selected_boat'], $_SESSION['userId']))  
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
        header("Location: ../my_announcement.php?error=addannouncement_error");
        exit(); 
    }
    
    
    if ( mysqli_fetch_row($result) > 0)
    {

        // Controlli per aggiungere una nuova barca
        $sql = "INSERT INTO announcement VALUES (default, ?, ?, ?, ?)"; //title, description, selected_boat, user_id       
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../my_announcement.php?error=addannouncement_error");
            exit();
        }
        
        if(!mysqli_stmt_bind_param($stmt, "ssii", $_POST['title'], $_POST['description'], $_POST['selected_boat'], $_SESSION['userId']))  
        {
            header("Location: ../my_announcement.php?error=addannouncement_error");
            exit();
        }
        
        if (!mysqli_stmt_execute($stmt))
        {
            header("Location: ../my_announcement.php?error=addannouncement_error");
            exit();
        }


    }
    else
    {
        header("Location: ../add_announcement.php?error=credential_error");  
        exit(); 
    }
    require 'mail_test.php';

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: ../my_announcement.php?success=True");
    exit();   