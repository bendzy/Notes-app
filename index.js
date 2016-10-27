/**
 * Created by bendz on 19. 10. 2016.
 */
//All ajax code is here
$(document).ready(function(){

    /*Sign up for free  --> Sign up form Ajax Call */
    $("#singupform").submit(function(event){
        //prevent defult php from processing
        event.preventDefault();
        //collect user inputs
       var datatopost = $(this).serializeArray();
        //send them to signup.php
        $.ajax({
            url:"signup.php",
            type:"POST",
            data: datatopost,
            success: function(data){
                if(data) {
                    $("#signupMessage").html(data);
                }
            },
            error: function(data){
                $("#signupMessage").html("<div class='alert alert-danger'> There was an error with the Ajax Call." +
                    "Please try again later .</div>");
            }
        });
    });

    /*Log in --> Log in form Ajax Call */
    $("#loginform").submit(function(event){
        //prevent defult php from processing
        event.preventDefault();
        //collect user inputs
        var datatopost = $(this).serializeArray();
        //send them to signup.php
        $.ajax({
            url:"login.php",
            type:"POST",
            data: datatopost,
            success: function(data){
                console.log(data);
               if( data === "success") {
                   console.log("Logged in");
                   window.location.href = "mainpageloggedin.php";

               }

                //var data1 = $.trim(data);
                //if(data1 === "success") {
                //    window.location("http://localhost/notesapp/mainpageloggedin.php");
                //}else {
                //    console.log(data);
                //    $("#loginMessage").html(data);
                //
                //}
            },
            error: function(data){
                $("#loginMessage").html("<div class='alert alert-danger'> There was an error with the Ajax Call." +
                    "Please try again later .</div>");
            }

        });

    });

});
//Ajax call for sign up form


//Ajax call for the login form



//Ajax call for the forgot password form