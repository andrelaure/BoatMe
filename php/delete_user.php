<?php
    require 'connect_db.php';

    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    } 


    if (!isset($_POST['userId'])){ 
        header("Location: ../show_profile.php?error=credential_error");  
        exit();
    }

    if (!strlen($_POST['userId'])){ 
        header("Location: ../show_profile.php?error=empty_error");  
        exit();
    }

    if(!$stmt = mysqli_stmt_init($conn)){    
        header("Location: ../show_profile.php?error=db_connection_error");  
        exit();
    } 

    //Query per delete user
    $sql = "DELETE FROM users WHERE id=?"; 
  
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../show_profile.php?error=delete_error1");
        exit();
    }
    
    if(!mysqli_stmt_bind_param($stmt, "i", $_SESSION['userId'])) 
    {
        header("Location: ../show_profile.php?error=delete_error2");
        exit();
    }
    
    if (!mysqli_stmt_execute($stmt))
    {
        header("Location: ../show_profile.php?error=delete_error");
        exit();
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: ../index.php?success=True");
    exit();    