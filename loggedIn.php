<?php
    //Hiding all errors
    error_reporting(0);
    ini_set('display_errors', 0);

    session_start();

    $diaryContent = "";

    if(array_key_exists("id", $_COOKIE)) {

        $_SESSION['id'] = $_COOKIE['id'];
    }

    //If logged in, conection with DB
    if(array_key_exists("id", $_SESSION)){
        
        include "conection.php";

        $query = "SELECT diary FROM `users` WHERE id =".mysqli_real_escape_string($link, $_SESSION["id"])." LIMIT 1";

        $row = mysqli_fetch_array(mysqli_query($link, $query));

        $diaryContent = $row['diary'];



    } else {

        header("Location: index.php");
    }

    include "header.php";
?>
    <!--Navbar-->
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand text-success">Secret Diary</a>
        <form class="form-inline">
            <button class="btn btn-success my-2 my-sm-0" type="submit" ><a id="logout" href='index.php?logout=1'>Log Out!</a></button>
        </form>
    </nav>
    
    <!--Content Diary-->
    <div class="container-fluid">
    <p style="float: left; color:white;"><small>Max. 1000 characters.</small></p> 
        <textarea id="diary" class="form-control" rows="15"><?php echo $diaryContent; ?></textarea>
    </div>

    
<?php
    include "footer.php";
?>