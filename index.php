<?php
session_start();
include 'connection.php';
include "logout.php";

//remember me
 include ('rememberme.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Online notes </title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="styling.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Arvo">

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <script src="index.js"></script>

    <![endif]-->
</head>
<body>


<!--Navigation bar -->
<nav role="navigation" class="navbar navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand">
                Online Notes
            </a>

            <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                <span class="sr-only">
                    Toggle navigation
                </span>
                <span class="icon-bar">

                </span>
                <span class="icon-bar">

                </span>
                <span class="icon-bar">

                </span>
            </button>
        </div>

        <div class="navbar-collapse collapse" id="navbarCollapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Help</a></li>
                <li><a href="#">Contact us</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a  href="#loginModal" data-toggle="modal">Login</a></li>

            </ul>
        </div>
    </div>
</nav>


<!-- JUMBOTRON     -->
<div class="jumbotron" id="myContainer">
    <h1>Online Notes App</h1>

    <p>Your Notes with you wherever you go</p>
    <p> Easy to use, protects all your notes!</p>

   <button type="button" class="btn btn-lg blue signup" data-target="#singupModal" data-toggle="modal">Sing up for free</button>

</div>





<!-- SIGN UP MODAL -->

<div class="modal" id="singupModal" role="dialog" aria-labelledby="singupModal" aria-hidden="true">

    <form method="post" id="singupform">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"></div>
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 id="singupModal">Sign up today and start using app</h4>
                <div class="modal-body">
                    <div class="form-group">

                        <!-- Sign up meesage errors -->
                        <div id="signupMessage">
                        
                        </div>

                        <label for="username" class="sr-only">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username" maxlength="30">
                    </div>

                    <div class="form-group">
                        <label for="email" class="sr-only">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email Adress" maxlength="50">
                    </div>

                    <div class="form-group">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Choose a password" maxlength="20">
                    </div>

                    <div class="form-group">
                        <label for="password2" class="sr-only">Confirm Password</label>
                        <input type="password" name="password2" id="password2" class="form-control" placeholder="Confirm password" maxlength="20">

                    </div>
                </div>

                <div class="modal-footer">
                    <input class="btn blue" name="signup" type="submit" value="Sign up">
                    <button type="button" class="btn btn-default" data-dismiss="modal"> Cancel</button>

                </div>
            </div>
        </div>
    </form>
</div>

<!-- LOGIN IN MODAL -->

<div class="modal" id="loginModal" role="dialog" aria-labelledby="loginModal" aria-hidden="true">

    <form method="post" id="loginform">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"></div>
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 id="loginModal">Login :</h4>

                <div class="modal-body">
                    <div class="form-group">

                        <!-- Login meesage errors -->
                        <div id="loginMessage">

                        </div>
                        <div class="form-group">
                            <label for="loginemail" class="sr-only">Email</label>
                            <input type="email" name="loginemail" id="loginemail" class="form-control" placeholder="Email Adress" maxlength="50">
                        </div>

                        <div class="form-group">
                            <label for="loginpassword" class="sr-only">Password</label>
                            <input type="password" name="loginpassword" id="loginpassword" class="form-control" placeholder="Password" maxlength="20">
                        </div>

                        <div class="checkbox">
                            <label><input type="checkbox" name="rememberme" id="rememberme">Remember me</label>

                            <a class="pull-right " style="cursor: pointer;" data-dismiss="modal" href="#forgotpasswordModal" data-toggle="modal">Forgot Password ?</a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn blue" name="login" type="submit" value="Login">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Cancel</button>
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#singupModal" data-toggle="modal"> Register</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- FORGOT PASSWORD MODAL -->

<div class="modal" id="forgotpasswordModal" role="dialog" aria-labelledby="forgotpasswordModal" aria-hidden="true">

    <form method="post" id="forgotpasswordform">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"></div>
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 id="forgotpasswordModal">Forgot Password ? Enter your email address : </h4>

                <div class="modal-body">
                    <div class="form-group">

                        <!-- Sign up meesage errors -->
                        <div id="forgotPasswordMessage">

                        </div>
                        <div class="form-group">
                            <label for="forgotemail" class="sr-only">Email</label>
                            <input type="email" name="forgotemail" id="forgotemail" class="form-control" placeholder="Email Adress" maxlength="50">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn blue" name="login" type="submit" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Cancel</button>
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#singupModal" data-toggle="modal"> Register</button>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



<!--- FOOTER -->

<div class="footer">
    <div class="container">
        <p> bENJAMIN DIzdarević   &copy; 2015 - <?php $today = date('Y');echo $today;?>  </p>
    </div>
</div>

</body>
</html>

<script>
    // navbar collapse fix

    $(document).on('click',function(){
        $('.collapse').collapse('hide');
    })



</script>