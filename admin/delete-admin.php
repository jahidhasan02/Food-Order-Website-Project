<?php

//Incluse constants.php file here
include('../config/constants.php');

// 1. get the ID of admin to be deleted
$id = $_GET['id'];

//2. create SQL query to delete Admin
$sql = "DELETE FROM tbl_admin WHERE id = $id";

//execute the quary
$res = mysqli_query($conn, $sql);

//check whether the query executed successfully or not
if($res==true)
{
    //query executed successfully and admin deleted
    //echo "Admin deleted";
    //create session variable to display message
    $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";
    //redirect to manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}
else
{
    // Failed to delete Admin
    //echo "Failed to deleted Admin";

    $_SESSION['delete'] = "<div class='error'>Failed to Deleted Admin. Try Again Later.</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');
}

//3. Redirect to manage Admin page with massage (Success/Error)

?>