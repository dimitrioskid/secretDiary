<?php
    //Conection with DB
    $link = mysqli_connect("sql304.epizy.com", "epiz_25116103", "v50UAJ9N9U", "epiz_25116103_diary");
        
        if (mysqli_connect_error()) {
            
            die ("Database Connection Error");
            
        }
?>        