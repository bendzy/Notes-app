<?php
/**
 * Created by PhpStorm.
 * User: bendz
 * Date: 19. 10. 2016
 * Time: 12:18
 */

$link = mysqli_connect("localhost","root","","onlinenotes") ;

if(mysqli_connect_error()) {
    die("Error unable to connect to Datababse : ".mysqli_connect_error());
}




?>