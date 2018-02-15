<?php
ob_start();
session_start();
include 'db.php';
//$session_role2 = $_SESSION['role'];
$session_username2 = $_SESSION['username'];
$session_id = $_SESSION['id'];


if(!isset($_SESSION['username']))
{
header('location: login-admin.php');
}


if(isset($_POST['add_admin']))
{  
$date = time();
$username = mysqli_real_escape_string($con,strtolower($_POST['username']));
$username_trim = preg_replace('/\s+/','',$username);
$password = mysqli_real_escape_string($con,$_POST['password']); 
    
$firstname = mysqli_real_escape_string($con, $_POST['firstname']);
$middlename = mysqli_real_escape_string($con, $_POST['middlename']);
$lastname = mysqli_real_escape_string($con,$_POST['lastname']);
$email = mysqli_real_escape_string($con,strtolower($_POST['email']));   
$image = $_FILES['image']['name'];
$image_tmp = $_FILES['image']['tmp_name'];   
   
 
if($username != $username_trim)
{
echo "<script language='javascript'>alert('Don't use spaces in Username')</script>"; 
}
$check_query = "select * from tbl_admin where email = '$email' or username = '$username' ";
$check_run = mysqli_query($con, $check_query);    

if(mysqli_num_rows($check_run) > 0)
{
echo "<script language='javascript'>alert('Username or Email Already Exist')</script>"; 
} 
 
else
{
$password = md5($password);     
$insert_query = "INSERT INTO `tbl_admin` (`date`, `username`, `password`, `email`, `firstname`, `middlename`, `lastname`, `image`, `acct_status`) VALUES ('$date', '$username', '$password', '$email', '$firstname', '$middlename', '$lastname', '$image', 'activate')";
   
    
if(mysqli_query($con,$insert_query))
{  
echo "<script language='javascript'>alert('Administrator Account has been Added')</script>";    
header("refresh:1; homepage-admin.php");   
    
//$image_check   = "select * from tbl_admin order by id desc limit 1";
//$image_run     = mysqli_query($con, $image_check);
//$image_row     = mysqli_fetch_array($image_run);
//$check_image   = $image_row['image'];
    
$path = "system-img/$image";

if(move_uploaded_file($image_tmp, $path))
{
copy($path, "$path"); 
}               
}
   
else
{
echo "<script language='javascript'>alert('Something Wrong in the Code')</script>"; 
}
}
} 
//Add Admin Account
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <title>Admin Control</title>
    
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

<link rel="icon" type="image/png" href="images/tmp-icon.png">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/font-awesome.css">
<!--<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">--> 
<?php 
include("css-all/useradmin-css.php");
include("inc/datatabletop.php");
?>

</head>

<body>
<?php include("inc/navbar.php"); ?>

<div class="container-fluid">
<div class="col-md-4">
<?php include("inc/sidebar-admin.php"); ?>    
</div> 

<div class="col-md-8">
<div class="panel panel-success">
<div class="panel-body">                                        

<h1 style="color:red;text-align:center;">B L A N K</h1>
</div> <!--panel body end-->                                
</div> <!--panel end-->   
</div> <!--md-8 end-->            
</div> <!--container end-->



<?php 
include("inc/bot/javascript.php"); //BOOTSTRAP AND CHECKBOX
include ("datatable/datatable-bot.php"); //Datatable
?> 

</body>
</html>