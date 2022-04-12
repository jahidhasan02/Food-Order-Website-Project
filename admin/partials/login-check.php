<?php

    //authoraization - access control
    //check whether the user is logged in or not
    if(!isset($_SESSION['user'])) //if user sesson is not set
    {
        //user is not log in
        //redirect to login page with message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin Pannel.</div>";
        //redirct to login page
        header('location:'.SITEURL.'admin/login.php');
    }

?>