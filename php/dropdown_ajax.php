<?php
    require "./connect_db.php";

    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    }    


    echo '<div class="dropdown">
        <select name="selected_boat" id="myDropdown" class="dropdown-content">';        

    $sql = "SELECT name, id_boat FROM boat WHERE id_user = ".$_SESSION['userId'];
    if (!$query = mysqli_query($conn, $sql))
        {
            header("Location: index.php");
            exit();
        }

    if ($query){
        $result = mysqli_num_rows($query);
    }else
        $result = 0;

    if ($result > 0)
    {
        while($row = mysqli_fetch_assoc($query)){
            echo '<option value="'.$row['id_boat'].'">'.$row['name'].'</option>';
        }

    }
    else
    {
        echo'Non hai barche!';
    };

    echo'
        </select>
        </div>';
?>