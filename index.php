<?php
    //Hiding all errors
    error_reporting(0);
    ini_set('display_errors', 0);

    //Seting session and cookie
    session_start();

    $error = "";    

    if (array_key_exists("logout", $_GET)) {
        
        unset($_SESSION);
        setcookie("id", "", time() - 60*10);
        $_COOKIE["id"] = "";  
      
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location: loggedIn.php");
        
    }

    //On submit conecting and checking erorrs
    if (array_key_exists("submit", $_POST)) {
        
       include "conection.php";
        
        
        
        if (!$_POST['email']) {
            
            $error .= "An email address is required<br>";
            
        } 
        
        if (!$_POST['password']) {
            
            $error .= "A password is required<br>";
            
        } 
        
        if ($error != "") {
            
            $error = "<p>There were error(s) in your form:</p>".$error;
            
        } else {
            
            //If email exist
            if ($_POST['signUp'] == '1') {
            
                $query = "SELECT id FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";

                $result = mysqli_query($link, $query);

                if (mysqli_num_rows($result) > 0) {

                    $error = "That email address is taken.";

                } else {

                    $query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";

                    if (!mysqli_query($link, $query)) {

                        $error = "<p>Could not sign you up - please try again later.</p>";

                    } else {
                        
                        //Password protection
                        $query = "UPDATE `users` SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";

                        mysqli_query($link, $query);

                        $_SESSION['id'] = mysqli_insert_id($link);

                        if ($_POST['stayLoggedIn'] == '1') {

                            setcookie("id", mysqli_insert_id($link), time() + 60*10);

                        } 

                        //header("Location: loggedIn.php");
                        echo("<script>location.href = 'loggedIn.php';</script>");

                    }

                } 
                
            } else {
                    
                    $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                    $result = mysqli_query($link, $query);
                
                    $row = mysqli_fetch_array($result);
                
                    if (isset($row)) {
                        
                        $hashedPassword = md5(md5($row['id']).$_POST['password']);
                        
                        if ($hashedPassword == $row['password']) {
                            
                            $_SESSION['id'] = $row['id'];
                            
                            if ($_POST['stayLoggedIn'] == '1') {

                                setcookie("id", $row['id'], time() + 60*10);

                            } 

                            //header("Location:loggedIn.php"); 
                            echo("<script>location.href = 'loggedIn.php';</script>");
                                
                        } else {
                            
                            $error = "That email/password combination could not be found.";
                            
                        }
                        
                    } else {
                        
                        $error = "That email/password combination could not be found.";
                        
                    }
                    
                }
            
        }
        
        
    }

    
?>
<?php include "header.php"; ?>
        <div class="gitcode">
            <a href="https://github.com/ddarko91/secretdiary" class="btn btn-outline-light" target="_blank"><i class="fab fa-github"></i> View code</a>
        </div>
        <div class="clear"></div>

        <div class="container" >

        <h1>Secret Diary</h1>

        <p><strong>Store your thoughts permanently and securely.</strong></p>

            <!--Errors displaying-->
            <div id="error"><?php if($error !=""){echo '<div class="alert alert-warning">'.$error.'</div>';} ?></div>            
            
            <!--Sign up form-->
            <form method="post" id="signUpForm" class="col-sm-12">
                
                <p>Interested? Sign up now!</p>

                <input type="email" name="email" placeholder="Your Email" class="form-group col-sm-10"><br>
                
                <input type="password" name="password" placeholder="Password" class="form-group col-sm-10"><br>
                
                <input type="checkbox" name="stayLoggedIn" value=1> Stay Logged In! <sup>(10 min.)</sup> <br>
                
                <input type="hidden" name="signUp" value="1">
                    
                <input type="submit" name="submit" value="Sign Up!" class="btn btn-success"> <br>

                <p class="btn btn-primary"><a class="toggleForms ">Already have account? Log in!</a></p>

            </form> 

            
            <!--Log in form-->
            <form method="post" id="logInForm">

                <p>Log in usign your username and password.</p>

                <input type="email" name="email" placeholder="Your Email" class="form-group col-sm-10"> <br>
                
                <input type="password" name="password" placeholder="Password" class="form-group col-sm-10"> <br>
                
                <input type="checkbox" name="stayLoggedIn" value=1> Stay Logged In! <sup>(10 min.)</sup> <br>
                
                <input type="hidden" name="signUp" value="0"> 
                    
                <input type="submit" name="submit" value="Log In!" class="btn btn-success"> <br>

                <p class="btn btn-primary"><a class="toggleForms">Haven't registerd yet? Sign up!</a></p>

            </form>
        </div> 
        
<?php include "footer.php"; ?>        
