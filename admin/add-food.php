<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">

            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" placeholder="Food Title">
                </td>
            </tr>

            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5" placeholder="Food Description."></textarea>
                </td>
            </tr>

            <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price">
                </td>
            </tr>

            <tr>
                    <td>Select Image: </td>
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
                                //1.create sql to get all active category from database
                                $sql = "SELECT * FROM tbl_catagory WHERE active='Yes'";

                                //executing quary
                                $res = mysqli_query($conn,$sql);

                                //count rows to know about category
                                $count = mysqli_num_rows($res);

                                //
                                if($count>0)
                                {
                                    //we have category
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the details about categories
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>

                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                        <?php
                                    }
                                }
                                else
                                {
                                    //we dont have any category
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }


                                //2. display on dropdown
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            
            </table>

        </form>


        <?php

            //button is clicked?
            if(isset($_POST['submit']))
            {
                //add the food in database
                //echo "Clicked";

                //1.get data from database
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //radio button clicked?
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }

                //2.upload the image if selected
                //image clicked
                if(isset($_FILES['image']['name']))
                {
                    //get details of selected image
                    $image_name = $_FILES['image']['name'];

                    //check image selected?
                    if($image_name!="")
                    {
                        //image selected
                        //A. rename the image
                        //Get extension
                        $ext = end(explode('.', $image_name));

                        //create new name for image
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext;

                        //B. upload the image
                        //get the src &description path

                        //source path of current image
                        $src = $_FILES['image']['tmp_name'];

                        //description path
                        $dst = "../images/food/".$image_name;

                        //upload food image
                        $upload = move_uploaded_file($src, $dst);

                        //check image upload?
                        if($upload==false)
                        {
                            //
                            //
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            //stop the process
                            die();
                        }
                    }
                }
                else
                {
                    $image_name = "";
                }

                //3.insert into database

                //sql query to add foodfor numerical we do not need to pass value inside quotes
                //
                $sql2 = "INSERT INTO tbl_food SET
                title='$title',
                description='$description',
                price=$price,
                image_name='$image_name',
                category_id=$category,
                featured='$featured',
                active = '$active'
                ";

                //execute query
                $res2 = mysqli_query($conn, $sql2);
                //check sql query execute or not and data added or not
                //4.
                if($res2 == true)
                {
                    //query execute and category added
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                    //redirect to admin category page
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to add data
                    $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                    //redirect to admin category page
                    header('location:'.SITEURL.'admin/manage-food.php');
                }


            }

        ?>


    </div>
</div>

<?php include('partials/footer.php'); ?>