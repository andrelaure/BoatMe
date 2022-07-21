<?php
    require 'connect_db.php';

    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    } 

    // Iscrizione newsletter
    if (isset($_POST['add_news']))
    {
  
        // Controllo input
        if (!isset($_POST['news']) | !isset($_POST['submit'])){ 
            header("Location: ../show_profile.php?error=credential_error");  
            exit();
        }

        if (!strlen($_POST['news']) | !strlen($_POST['add_news'])){ 
            header("Location: ../show_profile.php?error=empty_error");  
            exit();
        }


        if(!$stmt = mysqli_stmt_init($conn)){    
            header("Location: ../show_profile.php?error=db_connection_error");  
            exit();
        }    
    
        $sql = "INSERT INTO newsletter VALUES (default, ?)"; // email_user
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../show_profile.php?error=addboat_error");
            exit();
        }
        
        if(!mysqli_stmt_bind_param($stmt, "s", $_POST['news']))  
        {
            header("Location: ../show_profile.php?error=addboat_error");
            exit();
        }
        
        if (!mysqli_stmt_execute($stmt))
        {
            header("Location: ../show_profile.php?error=addboat_error");
            exit();
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: ../show_profile.php?success=True");
        exit();

    // Disdire newsletter
    }elseif (isset($_POST['delete_news'])) 
    {
        // Controllo input
        if (!isset($_POST['news']) | !isset($_POST['submit'])){ 
            header("Location: ../show_profile.php?error=credential_error");  
            exit();
        }

        if (!strlen($_POST['news']) | !strlen($_POST['delete_news'])){ 
            header("Location: ../show_profile.php?error=empty_error");  
            exit();
        }


        if(!$stmt = mysqli_stmt_init($conn)){    
            header("Location: ../show_profile.php?error=db_connection_error");  
            exit();
        }    
    
        $sql = "DELETE FROM newsletter WHERE email_user = ?"; // email_user
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../show_profile.php?error=addboat_error");
            exit();
        }
        
        if(!mysqli_stmt_bind_param($stmt, "s", $_POST['news']))  
        {
            header("Location: ../show_profile.php?error=addboat_error");
            exit();
        }
        
        if (!mysqli_stmt_execute($stmt))
        {
            header("Location: ../show_profile.php?error=addboat_error");
            exit();
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: ../show_profile.php?success=True");
        exit();

    }else
    {
        header("Location: ../show_profile.php?error=credential_error");  
            exit();
    }   