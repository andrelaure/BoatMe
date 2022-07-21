<?php
    require 'connect_db.php';

    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    } 

    // Controllo input

    if (!isset($_POST['firstname']) | !isset($_POST['lastname']) | !isset($_POST['email']) | !isset($_POST['submit'])){
        header("Location: ../show_profile.php?error=credential_error");  
        exit();
    }

    if (!strlen($_POST['firstname']) | !strlen($_POST['lastname']) | !strlen($_POST['email'])){
        header("Location: ../show_profile.php?error=empty_error");  
        exit();
    }

    if(!$stmt = mysqli_stmt_init($conn)){    
        header("Location: ../show_profile.php?error=db_connection_error");  
        exit();
    }


    // Query
    $sql = "UPDATE users SET firstname=?, lastname=?, email=?, nickname=? WHERE id=?";
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../show_profile.php?error=update_error");
        exit();
    }
    
    if(!mysqli_stmt_bind_param($stmt, "sssss", $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['nick'], $_SESSION['userId']))
    {
        header("Location: ../show_profile.php?error=update_error");
        exit();
    }
    
    if (!mysqli_stmt_execute($stmt))
    {
        header("Location: ../show_profile.php?error=update_error");
        exit();
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: ../show_profile.php?success=True");
    exit();