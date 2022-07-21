<?php
    $DB_SERVERNAME = "localhost";
    $DB_USERNAME = "root";
    $DB_PASSWORD = "";
    $DB_NAME = "boatme";
    try {
        $conn = mysqli_connect($DB_SERVERNAME, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
    } catch (mysqli_sql_exception $e) {
        die("<div class='alert alert-danger' role='alert'>
             C'è stato un errore nella connessione!
            </div>");
    }
?>