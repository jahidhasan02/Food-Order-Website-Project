<?php include('partials/menu.php'); ?>

<?php
    //
    if(isset($_GET['id']))
    {
        //echo "Getting the data";
        $id = $_GET['id'];

        //
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        //
        $res2 = mysqli_query($conn, $sql2);
        
        //
        $row2 = mysqli_fetch_assoc($res2);

        //
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];

    }
    else
    {
        //
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>


<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">

            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                </td>
            </tr>

            <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image: </td>
                <td>
                    <?php
                        if($current_image == "")
                        {
                            //
                            echo "<div class='error'>Image not Added.</div>";
                        }
                        else
                        {
                            //
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                            <?php
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td>Select New Image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Category: </td>
                <td>
                    <select name="category">

                        <?php
                            //to display categories from database
                             $sql = "SELECT * FROM tbl_catagory WHERE active='Yes'";
                            //executing quary
                            $res = mysqli_query($conn, $sql);
                            //count rows to know about category
                            $count = mysqli_num_rows($res);

                                //
                                if($count>0)
                                {
                                    //we have category
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $category_title = $row['title'];
                                        $category_id = $row['id'];

                                        //echo "<option value='$category_id'>$category_title</option>";
                                        ?>
                                        <option <?php if($current_category==$category_id){echo "Selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //we dont have any catagory
                                    echo "<option value='0'>Category not Found.</option>";
                                }

                            ?>

                    </select>
                </td>
            </tr>

            <tr>
                <td>Featured: </td>
                <td>
                    <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                    <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                </td>
            </tr>

            <tr>
                <td>Active: </td>
                <td>
                    <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                    <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                </td>
            </tr>

        </table>

        </form>

        <?php

            if(isset($_POST['submit']))
            {
                //

                //1.
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2.

                //
                if(isset($_FILES['image']['name']))
                {
                    //
                    $image_name = $_FILES['image']['name'];

                    //
                    if($image_name !="")
                    {
                        //
                        //

                        //Auto rename our image
                        $ext = end(explode('.', $image_name));
                        //rename the image
                        $image_name = "Food_Name_".rand(000,999).'.'.$ext;
                        
                        //
                        $src_path = $_FILES['image']['tmp_name'];
                        $dest_path = "../images/food/".$image_name;

                        //finally upload the image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        //check wehthe the image is uploaded or not
                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload'] ="<div class='error'>Failed to Upload New Image.</div>";
                            //redirect to add category page
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //Stop the process
                            die();
                        }

                        //B
                        if($current_image!="")
                        {
                            //
                            //
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);

                            //
                            if($remove==false)
                            {
                                //
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current Image.</div>";
                                //
                                header('location:'.SITEURL.'admin/manage-food.php');
                                //
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }



                //4.
                $sql3 = "UPDATE tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id ='$category',
                featured = '$featured',
                active = '$active'
                WHERE id=$id
                ";

                //
                $res3 = mysqli_query($conn, $sql3);
                //
                if($res3==true)
                {
                    //
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //
                    $_SESSION['update'] = "<div class='error'>Failes to Update Food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }


            }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>