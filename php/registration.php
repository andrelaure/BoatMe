<?php
    require "connect_db.php";

    if (!isset($_POST['firstname']) | !isset($_POST['lastname']) | !isset($_POST['email']) | !isset($_POST['pass']) | !isset($_POST['confirm']) | !isset($_POST['submit'])){
        header("Location: ../register.php?error=credential_error");  
        exit();
    }

    if (!strlen($_POST['firstname']) | !strlen($_POST['lastname']) | !strlen($_POST['email']) | !strlen($_POST['pass']) | !strlen($_POST['confirm'])){
        header("Location: ../register.php?error=empty_error");  
        exit();
    }

    if (strlen($_POST['pass']) < 8){
        header("Location: ../register.php?error=pass_error1");  
        exit();
    }

    if (strcmp($_POST['pass'], $_POST['confirm']) != 0){
        header("Location: ../register.php?error=pass_error2");  
        exit();
    }


    if(!$stmt = mysqli_stmt_init($conn)){
        header("Location: ../register.php?error=db_connection_error");  
        exit();
    }

    if(!$hashedPwd = password_hash($_POST['pass'], PASSWORD_DEFAULT))
        {
            header("Location: ../register.php?error=registration_error");
            exit();
        }

    $sql = "INSERT INTO users VALUES (default, ?, ?, default, ?, ?)"; //id, first, last, nickname, email, pass, confirm

    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../register.php?error=registration_error");
        exit();
    }

    if(!mysqli_stmt_bind_param($stmt, "ssss", $_POST['firstname'], $_POST['lastname'], $_POST['email'], $hashedPwd))
    {
        header("Location: ../register.php?error=registration_error");
        exit();
    }

    if (!mysqli_stmt_execute($stmt))
    {
        header("Location: ../register.php?error=registration_error");
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: ../login.php?success=True");
    exit();
