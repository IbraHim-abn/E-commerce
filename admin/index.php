<?php
session_start();
$noNavBar ="";
$PageTitle = "Login";
include 'init.php';

if(isset($_SESSION['Username'])){
header('Location:dashboard.php');
}


//check if user coming from the http request method post
$msg="";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
$Username = $_POST['user'];
$Password = $_POST['pass'];
//hashed password
$hashedPass = sha1($Password);
//check if the  user is exist in database
$stmt = $con->prepare("SELECT UserID, Username , Password FROM users WHERE Username= ? AND Password = ? AND GrouID = 1 LIMIT 1");
$stmt->execute(array($Username,$hashedPass));
$row = $stmt->fetch();
$NbrRow = $stmt->rowCount();
//if $NbrRow > 0 then the database contain a record with this username and password 
if($NbrRow>0){
    $_SESSION['Username']= $Username; //Register  username in session 
    $_SESSION['UserID']= $row['UserID']; //Register  UserID in session 
    header('Location:dashboard.php');  //Redirecting to dashboad page
    exit();
}else{
    $msg = "<div class='alert alert-danger'> Username or password is <strong>incorrect !</strong></div>";
}
}
?>
<center>
<div class="container col-sm-12 col-lg-3 col-md-5">
<form class="login mt-5" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <h3 class="text-center mb-4">Sign in</h3>
<input class="form-control form-control-sm" type="text" name="user" placeholder="Username.." autocomplete="off" />
<input class="form-control form-control-sm" type="password" name="pass" placeholder="Password.." autocomplete="off" />
<input class="btn col-12 btn-sm" type="submit" name="" value="Login" />
<?php echo $msg; ?>
</form>
</div>
</center>
<?php include $temp.'footer.php'; ?>