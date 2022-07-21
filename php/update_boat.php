<?php
    require 'connect_db.php';

    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    } 

    if (!isset($_POST['boatname']) | !isset($_POST['characteristic']) | !isset($_POST['category']) | !isset($_POST['photo_path']) | !isset($_POST['submit'])){ 
        header("Location: ../update_boat.php?error=credential_error");  
        exit();
    }

    if (!strlen($_POST['boatname']) | !strlen($_POST['characteristic']) | !strlen($_POST['category']) | !isset($_POST['photo_path'])){ 
        header("Location: ../update_boat.php?error=empty_error");  
        exit();
    }

    if(!$stmt = mysqli_stmt_init($conn)){    
        header("Location: ../update_boat.php?error=db_connection_error");  
        exit();
    } 

    //Controllo per update barca
    $sql = "UPDATE boat SET name=?, characteristic=?, category=?, photo_path=? WHERE id_boat=? AND id_user=?";      
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../update_boat.php?error=update_error");
        exit();
    }
    
    if(!mysqli_stmt_bind_param($stmt, "ssssii", $_POST['boatname'], $_POST['characteristic'], $_POST['category'], $_POST['photo_path'], $_POST['id_boat'], $_SESSION['userId'])) 
    {
        header("Location: ../update_boat.php?error=update_error");
        exit();
    }
    
    if (!mysqli_stmt_execute($stmt))
    {
        header("Location: ../update_boat.php?error=update_error");
        exit();
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: ../my_boats.php?success=True");
    exit();    