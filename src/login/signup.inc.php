<?php

if (isset($_POST["submit"])) # Dette tjekker om submit knappen på frontend bliver trykket på.
{
    // Here we are grabbing the data from the form.
    $uid = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdRepeat"];
    $email = $_POST["email"];


    // Instantiate SignupController Class

    include "signup.classes.php";
    include "signup.controller.classes.php";
    
    $signup = new SignupController($uid, $pwd, $pwdRepeat, $email);


    // Running error handlers and user signup



    // Going back to frontpage


}