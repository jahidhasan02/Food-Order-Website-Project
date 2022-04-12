<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php
            if(isset($_SESSION['add'])) //checking whether the Sesssion is set or not
            {
                echo $_SESSION['add']; //Displaying Session message
                unset($_SESSION['add']); //Removing Session message
            }
        ?>
        
        <form action="" method="POST">
            
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Your password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>


    </div>
</div>

<?php include('partials/footer.php'); ?>


<?php
    //process the value from Form and Save it in Database

    //Check wheather the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        //Button Clicked
        //echo "Button Clicked":

        //1. Get the data from Form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);  //Password encryption with MD5

        //2. SQL Query to save the data into database
        $sql = "INSERT INTO tbl_admin SET
        full_name = '$full_name',
        username = '$username',
        password = '$password'
        ";

        //3. Executing Query and saving data into Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //4. Check whethere the (Query is Execute) data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            //data Inserted
            //echo "Data Inserted";
            //Crate a session variable to Display message
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
            //Redirect page to Manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //Failed to Insert data
            //echo "Fail to insert data";
            //Crate a session variable to Display message
            $_SESSION['add'] = "<div class='error'>Failed to Add Admin</div>";
            //Redirect page to Add Admine
            header("location:".SITEURL.'admin/add-admin.php');
        }

    }

?>