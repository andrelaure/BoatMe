<?php

    if (!isset($_POST['email']) | !isset($_POST['pass']) | !isset($_POST['submit'])){
        header("Location: ../login.php?error=credential_error");  
        exit();
    }

    if (!strlen($_POST['email']) | !strlen($_POST['pass'])){
        header("Location: ../login.php?error=empty_error");  
        exit();
    }

    require "connect_db.php";
    if(!$stmt = mysqli_stmt_init($conn)){
        header("Location: ../login.php?error=registration_error");  //da aggiungere errori
        exit();
    }

    $sql = "SELECT * FROM Users WHERE email = ?";


    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../login.php?error=registration_error");
        exit();
    }

    if(!mysqli_stmt_bind_param($stmt, "s", $_POST['email']))
    {
        header("Location: ../login.php?error=registration_error");
        exit();
    }

    if (!mysqli_stmt_execute($stmt))
    {
        header("Location: ../login.php?error=registration_error");
        exit();
    }


    if (!$result = mysqli_stmt_get_result($stmt)){
        header("Location: ../login.php?error=login_error");
        exit(); 
    }

    if ($row = mysqli_fetch_assoc($result))
    {
        // verifica password

        $pwdCheck = password_verify($_POST['pass'], $row['password']);
        if ($pwdCheck === false)
        {
            header("Location: ../login.php?error=credential_error");
            exit();
        }
        else
        {

            session_start();
            $_SESSION['userId'] = $row['id'];
            
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: ../index.php");
            exit();
        }
    }
    else
    {
        header("Location: ../login.php?error=credential_error");
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: ../login.php");
    exit();
