<?php
session_start();

    $error = "";  

    if (array_key_exists("logout", $_GET)) {
        
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";  
        
        session_destroy();
        
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location:stayLoggedIn.php");
        
    }


	
	if(array_key_exists("submit",$_POST)){
include("connection.php");

if(!$_POST['Email']){
	$error .= "An email address is Required<br>";
}
if(!$_POST['password'])
{
	$error .="A password Field is Required<br>";
}
if($error != ""){
	$error ="<p>There were error in Your form:</p>.$error";
}else{
	if($_POST['Signup'] =='1'){
	$query = "SELECT `id` FROM `sell` WHERE Email = '".mysqli_real_escape_string($con, $_POST['Email'])."'";
            
            $result = mysqli_query($con, $query);
            
            if (mysqli_num_rows($result) > 0) {
                
                echo "<p>That email address has already been taken.</p>";
                
            } else  {
                
                $query = "INSERT INTO `sell` (`Email`, `password`) VALUES ('".mysqli_real_escape_string($con, $_POST['Email'])."', 
				'".mysqli_real_escape_string($con, $_POST['password'])."')";
                
                if (!mysqli_query($con, $query)) {
                    
                    $error.= "<p>There was a problem signing you up - please try again later.</p>";
                    
                    
}else{
	$query = "UPDATE `sell` SET password = '".md5(md5(mysqli_insert_id($con)).$_POST['password'])."' WHERE id=
				".mysqli_insert_id($con)." LIMIT 1";
				mysqli_query($con,$query);
				$_SESSION['id'] = mysqli_insert_id($con);
				if($_POST['stayLoggedIn'] == '1'){
					setcookie("id",mysqli_insert_id($con),time(),+60 +60 +24 *365);
				}
				header("Location:stayLoggedIn.php");
}
}
}else{
	$query = "SELECT `id` FROM `sell` WHERE Email = '".mysqli_real_escape_string($con, $_POST['Email'])."'";
	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result);
	if(isSet($row)){
		$hashpassword = md5(md5($row['id']).$_POST['password']);
		//if hash password is equal to save password
		if($hashpassword  == $row['password'])
		{
			$_SESSION['id'] = $row['id'];
			if($_POST['stayLoggedIn'] == '1'){
					setcookie("id",$row['id'],time(),+ 60 +60 +24 *365);
				}
				header("Location:stayLoggedIn.php");
}else{
			$error = "That Email/password couldnt be found.";
		}
		}else{
			$error = "That Email/password couldnt be found.";
		}
		
				
            
}
	}
	
	}
	
?>
<?php include("header.php"); ?>

  <div class="container" id="homepagecontainer">
   <h1>Secret Diary</h1>
   <p><strong>Store your thought permanently and securely</p></strong>
   <div id="error"><?php if ($error!="") {
    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    
} ?></div>

<form method= "post" id ="signupform">
<p>Interested ?signup Now!</p>

<div class = "form-group">
<input class="form-control" type="Email" name="Email" placeholder="Your Email">
</div>
<div class = "form-group">
    <input class="form-control"type="password" name="password">
</div>
<div class = "checkbox">
<label>
    <input type="checkbox" name="stayLoggedin" value=1>
	stayLoggedin
	</label>
</div>
<div class = "form-group">
    <input type ="hidden" name ="Signup" value="1">
    <input class="btn btn-success" type="submit" name="submit" value="signup!">
</div>
<p><a class="toggleforms">log in!</a></p>
</form>

<form method= "post" id = "loginForm">
<p>Log in using your username and password.</p>
<div class = "form-group">
<input class="form-control" type="Email" name="Email" placeholder="Your Email">
</div>
<div class = "form-group">
<input class="form-control" type="password" name="password">
</div>
<div class = "form-group">
<label>
<input type="checkbox" type="checkbox"name="stayLoggedin" value=1>
stayLoggedin
</label>
</div>
<div class = "form-Group">
<input type ="hidden" name ="sign up" value="0">
<input class="btn btn-success" type="submit" name="submit" value="Login!">
</div>
<p><a class="toggleforms">Signup!</a></p>
</form>
</div>
<?php include("footer.php"); ?>
    
