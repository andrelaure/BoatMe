<?php
    require 'connect_db.php';

    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    } 

    // Controllo variabili
    if(!isset($_POST['search']) | !isset($_POST['submit']))
    {
        header("Location: ../index.php?credential_error");
        exit();
    }

    if (!strlen($_POST['search']))
    {
        header("Location: ../index.php?error=empty_error");  
        exit();
    }

    // Query
    if(!$stmt = mysqli_stmt_init($conn)){    
        header("Location: ../restore_password.php?error=db_connection_error");  
        exit();
    }

    $sql = "SELECT * FROM tokens WHERE token=?";       
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../restore_password.php?error=update_error");
        exit();
    }
    
    if(!mysqli_stmt_bind_param($stmt, "s", $_POST['token']))
    {
        header("Location: ../restore_password.php?error=update_error");
        exit();
    }
    
    if (!mysqli_stmt_execute($stmt))
    {
        header("Location: ../restore_password.php?error=update_error");
        exit();
    }