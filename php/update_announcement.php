<?php
    require 'connect_db.php';

    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    } 

    if (!isset($_POST['title']) | !isset($_POST['description']) | !isset($_POST['submit'])){ 
        header("Location: ../update_announcement.php?error=credential_error");  
        exit();
    }

    if (!strlen($_POST['title']) | !strlen($_POST['description'])){ 
        header("Location: ../update_announcement.php?error=empty_error");  
        exit();
    }

    if(!$stmt = mysqli_stmt_init($conn)){    
        header("Location: ../my_announcement.php?error=db_connection_error");  
        exit();
    }

    // Controllo per update barca
    $sql = "UPDATE announcement SET title=?, description=? WHERE id_boat=? AND id_user=? AND id_ann=?";      
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../my_announcement.php?error=update_error");
        exit();
    }
    
    if(!mysqli_stmt_bind_param($stmt, "ssiii", $_POST['title'], $_POST['description'], $_POST['id_boat'], $_SESSION['userId'], $_POST['id_ann']))  
    {
        header("Location: ../my_announcement.php?error=update_error");
        exit();
    }
    
    if (!mysqli_stmt_execute($stmt))
    {
        header("Location: ../my_announcement.php?error=update_error");
        exit();
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: ../my_announcement.php?success=True");
    exit();    