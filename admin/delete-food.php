<?php
    //
    include('../config/constants.php');

    //echo "Delete Food Page";

    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //
        //

        //1.
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2.
        //
        if($image_name !="")
        {
            //
            //
            $path = "../images/food/".$image_name;

            //
            $remove = unlink($path);

            //
            if($remove==false)
            {
                //
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image.</div>";
                //
                header('location:'.SITEURL.'admin/manage-food.php');
                //
                die();
            }

        }

        //3.
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        //
        $res = mysqli_query($conn, $sql);

        //
        //
        if($res==true)
        {
            //
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //
            $_SESSION['delete'] = "<div class='error'>Failed to Deleted Food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }



    }
    else
    {
        //redirect to manage-category page
        //
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorize Access.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>