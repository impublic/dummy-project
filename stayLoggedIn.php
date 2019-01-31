<?php

    session_start();
    //$diaryContent="";

    if (array_key_exists("id", $_COOKIE) && $_COOKIE ['id']) {
        
        $_SESSION['id'] = $_COOKIE['id'];
        
    }

    if (array_key_exists("id", $_SESSION)) {
              
      include("connection.php");
      
      $query = "SELECT diary FROM `sell` WHERE id = ".mysqli_real_escape_string($con, $_SESSION['id'])." LIMIT 1";
      $row = mysqli_fetch_array(mysqli_query($con, $query));
 
      $diaryContent = $row['diary'];
      
    } else {
        
        header("Location: projectDiary.php");
        
    }

	include("header.php");

?>

  

  <a class="navbar-brand" href="#">Secret Diary</a>

 
      <a href ='projectDiary.php?logout=1'>
        <button class="btn btn-success-outline" type="submit">Logout</button></a>
    



    <div class="container-fluid" id="containerLoggedInPage">

        <textarea id="diary" class="form-control"><?php echo $diaryContent;?></textarea>
    </div>
<?php
    
    include("footer.php");
?>