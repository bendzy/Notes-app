<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="styling.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Arvo">

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        #container{
            margin-top:100px;
        }

        #allNotes, #done {
            display: none;
        }
        .buttons {
            margin-bottom: 20px;
        }
        textarea {
            width:100%;
            max-width:100%;
            font-size:16px;
            line-height: 1.5em;
            border-left-width: 20px;
            border-color:rgb(29,104,158);

        }
        tr{
            cursor: pointer;    
        }
    </style>
</head>
<body>


<!--Navigation bar -->
<nav role="navigation" class="navbar navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand">
                Profile
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
                <li><a href="#">Profile</a></li>
                <li><a href="#">Help</a></li>
                <li><a href="#">Contact us</a></li>
                <li  class="active"><a href="#">My Notes</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a  href="#loginModal" >Logged in as <b>username</b></a></li>
                <li><a  href="#loginModal" >Log out</a></li>

            </ul>
        </div>
    </div>
</nav>


<!-- Container-->
<div id="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">    <!-- skip 3 colums and use next 6 -->
           <h2>General Account Settings:</h2>
            <div class="table-responsive">
                <table class="table table-hover table-condensed  table-bordered">
                    <tr data-target="#updateUsername" data-toggle="modal">
                        <td>Username </td>
                        <td> value </td>
                    </tr>

                    <tr data-target="#updateEmail" data-toggle="modal">
                        <td>Email </td>
                        <td>Value  </td>
                    </tr>

                    <tr>
                        <td data-target="#updatePassword" data-toggle="modal">Password </td>
                        <td> hidden </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- UPDATE EMAIL MODAL -->

<div class="modal" id="updateEmail" role="dialog" aria-labelledby="loginModal" aria-hidden="true">

    <form method="post" id="updateEmailform">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"></div>
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 id="loginModal">Email :</h4>

                <div class="modal-body">
                    <div class="form-group">

                        <!-- Sign up meesage errors -->
                        <div id="loginMessage">

                        </div>
                        <div class="form-group">
                            <label for="loginemail" >Enter new email</label>
                            <input type="email" name="email" id=email" class="form-control" maxlength="50" value="UsernameValue">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input class="btn blue" name="login" type="submit" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Cancel</button>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- UPDATE USERNAME MODAL -->

<div class="modal" id="updateUsername" role="dialog" aria-labelledby="loginModal" aria-hidden="true">

    <form method="post" id="updateUsernameform">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"></div>
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 id="loginModal">Edit username :</h4>

                <div class="modal-body">
                    <div class="form-group">

                        <!-- Sign up meesage errors -->
                        <div id="loginMessage">

                        </div>
                        <div class="form-group">
                            <label for="loginemail" >Username</label>
                            <input type="text" name="username" id="username" class="form-control" maxlength="50" value="UsernameValue">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input class="btn blue" name="login" type="submit" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Cancel</button>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- UPDATE PASSWORD PASSWORD MODAL -->

<div class="modal" id="updatePassword" role="dialog" aria-labelledby="forgotpasswordModal" aria-hidden="true">

    <form method="post" id="updatePasswordForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"></div>
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 id="forgotpasswordModal">Enter Current and New Password: </h4>

                <div class="modal-body">
                    <div class="form-group">

                        <!-- Sign up meesage errors -->
                        <div id="forgotMessage">

                        </div>
                        <div class="form-group">
                            <label for="currentPassword" class="sr-only">Your Current Password</label>
                            <input type="password" name="currentpassword" id="currentpassword" class="form-control" placeholder="Current Password" maxlength="50">
                        </div>

                        <div class="form-group">
                            <label for="password" class="sr-only">Choose a Passwrod</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Choose a Password" maxlength="50">
                        </div>

                        <div class="form-group">
                            <label for="password2" class="sr-only">Confirm Password</label>
                            <input type="password" name="password2" id="password2" class="form-control" placeholder="Confirm Password" maxlength="50">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn blue" name="login" type="submit" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> Cancel</button>

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
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>

<script>
    // navbar collapse fix

    $(document).on('click',function(){
        $('.collapse').collapse('hide');
    })



</script>