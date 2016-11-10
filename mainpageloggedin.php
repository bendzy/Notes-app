<?php
session_start();
//check if session and redirect to index.php
if (!isset($_SESSION['user_id'])) {

    header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>My notes</title>

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
    <script src ="mynotes.js"></script>
    <![endif]-->
    <style>
        #container{
            margin-top:130px;
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

        .noteheader {
            border: 1px solid grey;
            border-radius: 5px;
            margin-bottom: 15px;
            cursor: pointer;
            padding 0 10px;
            background: linear-gradient(#FFFFFF,#ECEAE7);
        }
        .text {
            font-size: 20px;
            overflow: hidden;
            white-space:nowrap;
            text-overflow: ellipsis;
        }
        .timetext {
            font-size: 14px;
            overflow: hidden;
            white-space:nowrap;
            text-overflow: ellipsis;  
        }

    </style>
</head>
<body>


<!--Navigation bar -->
<nav role="navigation" class="navbar navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand">
                My Notes
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
                <li><a  href="index.php?logout=1" >Log out</a></li>

            </ul>
        </div>
    </div>
</nav>


<!-- Container-->
<div id="container">
     <!-- ALERT MESSAGE -->
    <div id='alert' class="alert alert-danger collapse"> 
            <a class="close" data-dissmis='alert'>
                 &times;
            </a>

            <p id='alertContent'></p>
    </div>
      
    <div class="row">
     <div class="col-md-offset-3 col-md-6">    <!-- skip 3 colums and use next 6 -->
            <div class="buttons">
                <button type="button" id="addNote" class="btn btn-lg blue">Add Note</button>
                <button type="button" id="edit" class="btn btn-lg blue pull-right">Edit</button>
                <button type="button" id="done" class="btn green btn-lg pull-right ">Done</button>
                <button type="button" id="allNotes" class="btn btn-lg blue">All Notes</button>
            </div>

            <div id="notepad">
                <textarea rows="15" ></textarea>

            </div>

            <div id="notes" class="notes">
                <!-- ajax call to retrive notes from mysql -->
            </div>

        </div>
    </div>
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

    $('#notepad').hide();

</script>