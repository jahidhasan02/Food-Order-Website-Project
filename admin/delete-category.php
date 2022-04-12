<?php
    //include constants file
    include('../config/constants.php');

    //echo "Delete page";
    //check whether the id and image-name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get the value and delete
        //echo "Get Value and Delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //
        if($image_name !="")
        {
            //
            $path = "../images/category/".$image_name;
            //
            $remove = unlink($path);

            //
            if($remove==false)
            {
                //
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";
                //
                header('location:'.SITEURL.'admin/manage-category.php');
                //
                die();
            }
        }

        //
        //
        $sql = "DELETE FROM tbl_catagory WHERE id=$id";

        //
        $res = mysqli_query($conn, $sql);

        //
        if($res==true)
        {
            //
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
            //
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //
            $_SESSION['delete'] = "<div class='error'>Failed to Deleted Category.</div>";
            //
            header('location:'.SITEURL.'admin/manage-category.php');
        }

    }
    else
    {
        //redirect to manage-category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>