<?php
    require 'connect_db.php';

    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    } 
    
    if (!isset($_POST['boatname']) | !isset($_POST['characteristic']) | !isset($_POST['category']) | !isset($_POST['photo_path']) | !isset($_POST['submit'])){ 
        header("Location: ../add_boat.php?error=credential_error");  
        exit();
    }

    if (!strlen($_POST['boatname']) | !strlen($_POST['characteristic']) | !strlen($_POST['category']) | !isset($_POST['photo_path'])){ 
        header("Location: ../add_boat.php?error=empty_error");  
        exit();
    }

    if(!$stmt = mysqli_stmt_init($conn)){    
        header("Location: ../my_boats.php?error=db_connection_error");  
        exit();
    }    
    
    //Controllo per nuova barca
    $sql = "INSERT INTO boat VALUES (default, ?, ?, ?, ?, ?)"; //name, characteristic, category, user_id, photo_path
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../my_boats.php?error=addboat_error");
        exit();
    }
    
    if(!mysqli_stmt_bind_param($stmt, "sssis", $_POST['boatname'], $_POST['characteristic'], $_POST['category'], $_SESSION['userId'], $_POST['photo_path']))  
    {
        header("Location: ../my_boats.php?error=addboat_error");
        exit();
    }
    
    if (!mysqli_stmt_execute($stmt))
    {
        header("Location: ../my_boats.php?error=addboat_error");
        exit();
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: ../my_boats.php?success=True");
    exit();
    