<?php
    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    unset($_SESSION['userId']);
    session_destroy();
    header("Location: ../index.php");  
    exit();
?>