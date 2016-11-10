/**
 * Created by bendz on 19. 10. 2016.
 */
//All ajax code is here

$(document).ready(function(){

    /*Sign up for free  --> ajax call */
    $('#singupform').submit(function(event){
        event.preventDefault(); // prevent php default form processing
        var data =  $(this).serializeArray();
        $.ajax({
             url: "signup.php",
             type: "POST",
             data: data,
                success:function(data){
                   if(data) {
                       $("#signupMessage").html(data);
                   }
                },
                error: function(){
                    $("#signupMessage").html("<div class='alert alert-danger'>There was an error with Ajax Call. Please" +
                        "try again later</div>");
                }
        });
    });

       /*Login   --> ajax call */
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
               if( data === "success") {
                   window.location.href = "mainpageloggedin.php";
               }
               else {
                $('#loginMessage').html(data);
               }
            },
            error: function(data){
                $("#loginMessage").html(data);
            }

        });

    });


       /*Forgot password   --> ajax call */
   $("#forgotpasswordform").submit(function(event){
        //prevent defult php from processing
        event.preventDefault();
        //collect user inputs
        var datatopost = $(this).serializeArray();
        //send them to signup.php
        $.ajax({
            url:"forgotpassword.php",
            type:"POST",
            data: datatopost,
            success: function(data){
              $("#forgotPasswordMessage").html(data);
          },
            error: function(data){
                $("#signupMessage").html(data);
            }

        });

    });

});

