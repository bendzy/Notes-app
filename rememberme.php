<?php
/**
 * Created by PhpStorm.
 * User: bendz
 * Date: 19. 10. 2016
 * Time: 01:30
 */
    //if user is not logged in % remember cookie exists
    if(! isset($_SESSION["user_id"]) && !empty($_COOKIE["rememberme"]) ) {
        //f1 COOKIE $a .",". bin2hex($b);
        // f2 hash('sha256',$a)

        //extract values from cookie
        list($authentificator1, $authentificator2) = explode(',',$_COOKIE["rememberme"]);
        $authentificator2 = hex2bin($authentificator2);
        $f2authentificator2 = hash('sha256',$authentificator2);

        $sql = "SELECT * FROM rememberme WHERE authentificator1 ='$authentificator1'";
            $result = mysqli_query($link,$sql);
            if( !$result) {
                echo mysqli_error($link);
                echo "<div class='alert alert-danger'>There was an error running the query</div>";
                exit;
            }
            $count = mysqli_num_rows($result);
                if($count !== 1) {
                    echo '<div class="alert alert-danger">Remember me process failed</div>';
                    exit;
                }
                $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                    if (hash_equals($row['f2authentificator2'], $f2authentificator2)) {
                            $_SESSION['user_id'] = $row['user_id'];
                   }
    }
?>