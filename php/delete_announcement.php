<?php
    require 'connect_db.php';

    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    } 


    if (!isset($_POST['id_ann'])){ 
        header("Location: ../my_annuncement.php?error=credential_error");  
        exit();
    }

    if (!strlen($_POST['id_ann'])){ 
        header("Location: ../my_annuncement.php?error=empty_error");  
        exit();
    }

    if(!$stmt = mysqli_stmt_init($conn)){    
        header("Location: ../my_annuncement.php?error=db_connection_error");  
        exit();
    } 

    //Query per delete barca
    $sql = "DELETE FROM announcement WHERE id_ann=? AND id_user=?"; 
  
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("Location: ../my_annuncement.php?error=delete_error");
        exit();
    }
    
    if(!mysqli_stmt_bind_param($stmt, "ii", $_POST['id_ann'], $_SESSION['userId'])) 
    {
        header("Location: ../my_annuncement.php?error=delete_error");
        exit();
    }
    
    if (!mysqli_stmt_execute($stmt))
    {
        header("Location: ../my_annuncement.php?error=delete_error");
        exit();
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: ../my_annuncement.php?success=True");
    exit();    