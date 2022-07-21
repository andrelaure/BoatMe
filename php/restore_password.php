<?php
    require 'connect_db.php';

    // Controllo delle variabili

    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    } 

    if (!isset($_POST['pass']) | !strlen($_POST['confirm']) | !isset($_POST['submit']) | !isset($_POST['token'])){
        header("Location: ../restore_password.php?error=credential_error");  
        exit();
    }

    if (!strlen($_POST['pass']) | !strlen($_POST['confirm']) | !strlen($_POST['token'])){
        header("Location: ../restore_password.php?error=empty_error");  
        exit();
    }

    if (strlen($_POST['pass']) < 8){
        header("Location: ../restore_password.php?error=pass_error1");  
        exit();
    }
    
    if (strcmp($_POST['pass'], $_POST['confirm']) != 0){
        header("Location: ../restore_password.php?error=pass_error2");  
        exit();
    }

    if(!$hashedPwd = password_hash($_POST['pass'], PASSWORD_DEFAULT)){
        header("Location: ../restore_password.php?error=credential_error");
        exit();
    }


    // Query per controllare se il token è presente nel DB

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

    $result = mysqli_stmt_get_result($stmt);
    
    if(!$id_user = mysqli_fetch_assoc($result)['id_user']){
        header("Location: ../restore_password.php?error=db_connection_error");  
        exit();
    }

    // Query di UPDATE password
    if(!$stmt = mysqli_stmt_init($conn)){    
        header("Location: ../restore_password.php?error=db_connection_error");  
        exit();
    }

    $sql = "UPDATE users SET password=? WHERE id=?";
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../restore_password.php?error=update_error");
        exit();
    }
    
    if(!mysqli_stmt_bind_param($stmt, "si", $hashedPwd, $id_user))
    {
        header("Location: ../restore_password.php?error=update_error");
        exit();
    }
    
    if (!mysqli_stmt_execute($stmt))
    {
        header("Location: ../restore_password.php?error=update_error");
        exit();
    }

    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: ../login.php?success=True");
    exit();