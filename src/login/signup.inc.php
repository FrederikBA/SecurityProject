<?php

if (isset($_POST["submit"])) # Dette tjekker om submit knappen på frontend bliver trykket på.
{
    // Here we are grabbing the data from the form.
    $uid = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdRepeat"];
    $name = $_POST["name"];
    $email = $_POST["email"];


    // Instantiate SignupController Class

    ## OBS: Det skal stå i denne rækkefølge ellers vil det ikke virke. ##
    include 'src/Database/Connector.php';
    include "signup.classes.php";
    include "signup.controller.classes.php";
    
    
    $signup = new SignupController($uid, $pwd, $pwdRepeat, $email);


    // Running error handlers and user signup

    $signup->signupUser();

    // Going back to frontpage
    header("location: ../../public/index.php?error=none");


}