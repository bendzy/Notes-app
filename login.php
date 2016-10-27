<?php
/**
 * Created by PhpStorm.
 * User: bendz
 * Date: 19. 10. 2016
 * Time: 01:30
 */

session_start();
include "connection.php";

    //erros message
    $missingEmail = '<p><strong>Please enter your email address !</strong></p>';
    $missingPassword = '<p><strong>Please enter your password !</strong></p>';
    $errors = '';

    //email
    if (empty($_POST["loginemail"]) ) {
        $errors .= $missingEmail;
    } else {
        $email = filter_var($_POST["loginemail"], FILTER_SANITIZE_EMAIL);
    }
    //checking combination of email and password so we dont need any aditional email check

        //password
    if (empty($_POST["loginpassword"]) ) {
        $errors .= $missingPassword;
    } else {
        $password = filter_var($_POST["loginpassword"], FILTER_SANITIZE_STRING);
    }

    //if errors
    if ($errors) {
        $resultMessage = "<div class='alert alert-danger'>$errors</div>";
        echo $resultMessage;
    }else {
      //No errors

        $email = mysqli_real_escape_string($link,$email);
        $password = @mysqli_real_escape_string($link,$password);
        $password = hash('sha256',$password);


        $sql = "SELECT * FROM user WHERE (email = '$email' AND password = '$password' AND activation = 'activated')";

        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo "<div class='alert alert-danger'>Error running the query</div>";
            exit;
        }

        $count = mysqli_num_rows($result);

            if($count != 1) {
                echo "<div class='alert alert-danger'>Wrong username or password</div>";
                exit;
            }else {
                $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];

                    //remember me box
                    if(empty($_POST['rememberme'])) {
                        echo "success";
                        exit;
                    }else {
                        //kreiramo avtentifikatorja v HEX zapisu
                        $authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));
                        $authentificator2 = (openssl_random_pseudo_bytes(20));

                        function f1($a,$b) {
                            $c = $a .",". bin2hex($b);
                            return $c;
                        }

                        $cookieValue = f1($authentificator1,$authentificator2);
                        //store them in cookie
                        setcookie(
                            "rememberme",
                            $cookieValue,
                            time() + 1296000  //15 days in seconds
                        );

                        function f2($a) {
                            $b = hash('sha256',$a);
                            return $b;
                        }

                        $f2authentificator2 = f2($authentificator1);
                        $user_id = $_SESSION['user_id'];
                        $expiration = date('Y-m-d H:i:s', time() + 1296000);
                        $sql = "INSERT INTO rememberme('authentificator1','expires','f2authentificator2','user_id') VALUES ('$authentificator1','$expiration','$f2authentificator2','$user_id')";

                        if( !mysqli_query($link,$sql)) {
                            echo mysqli_error($link);
                            echo "<div class='alert alert-danger'>There was an error storing data to remember you next time</div>";

                        }else {
                            echo "success";
                        }
                    }
            }
    }
?>

