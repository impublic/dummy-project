<?php

    session_start();

    if (array_key_exists("content", $_POST)) {
        
        include("connection.php");
        
        $query = "UPDATE `sell` SET `diary` = '".mysqli_real_escape_string($con, $_POST['content'])."' WHERE id = ".mysqli_real_escape_string($con, $_SESSION['id'])." LIMIT 1";
        
        mysqli_query($con, $query);
        
    }

?>
