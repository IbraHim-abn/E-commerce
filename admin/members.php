<?php
/*
===================================================================
= Manage Members Pages
= you can add | Edit | Delete Members from here
===================================================================*/
session_start();
$PageTitle="Members";
if(isset($_SESSION['Username'])){

    //Header , Engish ...

    include 'init.php';

   //Content
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

// Check wahat $do is equals and redirecting 
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- Start Manage Page -->
----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
*/
if($do == 'Manage'){ //Manage page
$pending = '';
$page = '';
if( (isset($_GET['page'])) && ($_GET['page']  == 'pending') ){
  $pending = 'AND RegStatus = 0';
  $page = 'pending';
}else{
  $page = 'normal';
}
  //select all users expect admins
 $stmt = $con->prepare("SELECT * FROM users where GrouID != 1 $pending") ;  

 //execute

 $stmt->execute();

 //Assign to variables

 $rows = $stmt->fetchAll();

 $nbr_row = $stmt->rowCount();

if($nbr_row > 0){

?> 

  <h2 class='text-center'>Manage Members <i class="fa fa-users" ></i></h2> 
<div class='container'>
  <?php
  if($page=='normal'){
    echo "<a class='btn btn-primary btn-md m-2 fw-bolder btn-sm' href='members.php?do=Add'><i class='fa fa-user-plus'></i> New Member</a>";
       }
  ?>
    <div class='table-responsive'>
       <table  class='table table-bordered text-center '>
         <tr class="bg-dark text-light ">
            <td class="fw-bolder">#ID</td>
            <td class="fw-bolder">Username</td>
            <td class="fw-bolder">Email</td>
            <td class="fw-bolder">Full Name</td>
            <td class="fw-bolder">Registred Date</td>
            <td class="fw-bolder">Controle</td>
         </tr>
       
              <?php 
              foreach($rows as $row){
                echo "<tr><td class='bg-light'>".$row['UserID']."</td>";
                echo "<td class='bg-light'>".$row['Username']."</td>";
                echo "<td class='bg-light'>".$row['Email']."</td>";
                echo "<td class='bg-light'>".$row['FullName']."</td>";
                echo "<td class='bg-light'>".$row['Date']."</td>";
                echo "<td class='bg-light'>";
                if($page=='normal'){
               echo " 
                <a class='btn btn-info btn-sm text-light' href='?do=Edit&userID=".$row['UserID']."'><i class='fa fa-edit'></i> Edit</a>
                <a class='btn btn-danger btn-sm Confirm' href='?do=Delete&userID=".$row['UserID']."'><i class='fa fa-close'></i> Delete</a> ";
                }
                   if($row['RegStatus'] == 0){
              echo " <a class='btn btn-success text-light btn-sm Confirm' href='?do=Activate&page=$page&userID=".$row['UserID']."'><i class='fa fa-check-circle'></i> Activate</a> ";
                   }else{
              echo " <a class='btn btn-warning text-light btn-sm Confirm' href='?do=Deactivate&userID=".$row['UserID']."'><i class='fa fa-ban'></i> Deactivate</a> ";
                
                   }
                echo "</td></tr>";

              }
              ?>
       
       </table>
    </div>
    <div class="col-lg-4 col-md-6"> 
      <?php 
       //ici
       ?>
    </div>
  </div>
  <?php
}else{
  echo "<h2 class='text-center'>Aucune Member</h2>";
  echo "<center><a class='btn btn-primary btn-md m-2 fw-bolder btn-sm' href='members.php?do=Add'><i class='fa fa-user-plus'></i> New Member</a></center>";
    
}
  /*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- End Manage Page -->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
*/

/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- End Manage Page -->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
*/
/*********************************************************************************************************************************
 *                                      Start   Delete Member
 **********************************************************************************************************************************/
}elseif($do == 'Delete'){

 //check if the userID is valid & numiric and get iteger value (itval) of it 
 $userid = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0 ;

 //search in database  if this userID exist
 $stmt = $con->prepare("SELECT Username , Password , Email ,FullName FROM users WHERE UserID = ? AND GrouID != 1");

 //execute
 $stmt->execute(array($userid));


 //get numRows
 $NbrRow = $stmt->rowCount();


 if($NbrRow>0){

$stmt = $con->prepare("DELETE FROM users WHERE UserID = ? AND GrouID != 1 LIMIT 1");

$stmt->execute(array($userid));

header('Location:members.php');

} else{

echo "<center><div style='background-color:#ffabb3 ; box-shadow: 0px 0px 15px red; ' class='m-5 col-lg-6 col-md-6 col-sm-12 text-muted p-4 rounded'><b>UserID not found! <a href='members.php' >Retour</a></b></div></center>";
  
    } 
/*********************************************************************************************************************************
 *                                      Start  Activate  Member
 **********************************************************************************************************************************/

  }elseif( $do == 'Activate'){

 //check if the userID is valid & numiric and get iteger value (itval) of it 
 $userid = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0 ;

 //search in database  if this userID exist
 $stmt = $con->prepare("SELECT Username , Password , Email ,FullName FROM users WHERE UserID = ? AND GrouID != 1");

 //execute
 $stmt->execute(array($userid));


 //get numRows
 $NbrRow = $stmt->rowCount();


 if($NbrRow>0){

$stmt = $con->prepare("UPDATE users set RegStatus = 1 WHERE UserID = ? AND GrouID != 1 LIMIT 1");

$stmt->execute(array($userid));
if((isset($_GET['page']))&&($_GET['page'] == 'pending')){
header('Location:members.php?page=pending');
}elseif((isset($_GET['page']))&&($_GET['page'] == 'home')){
header('Location:dashboard.php');
}else{
header('Location:members.php');
}
} else{

echo "<center><div style='background-color:#ffabb3 ; box-shadow: 0px 0px 15px red; ' class='m-5 col-lg-6 col-md-6 col-sm-12 text-muted p-4 rounded'><b>UserID not found! <a href='members.php' >Retour</a></b></div></center>";
  
    } 

 /*********************************************************************************************************************************
 *                                      Start   Deactivate  Member
 **********************************************************************************************************************************/


  }elseif( $do == 'Deactivate'){

    //check if the userID is valid & numiric and get iteger value (itval) of it 
    $userid = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0 ;
   
    //search in database  if this userID exist
    $stmt = $con->prepare("SELECT Username , Password , Email ,FullName FROM users WHERE UserID = ? AND GrouID != 1");
   
    //execute
    $stmt->execute(array($userid));
   
   
    //get numRows
    $NbrRow = $stmt->rowCount();
   
   
    if($NbrRow>0){
   
   $stmt = $con->prepare("UPDATE users set RegStatus = 0 WHERE UserID = ? AND GrouID != 1 LIMIT 1");
   
   $stmt->execute(array($userid));
   
   if((isset($_GET['page']))&&($_GET['page'] == 'pending')){
    header('Location:members.php?page=pending');
    }elseif((isset($_GET['page']))&&($_GET['page'] == 'home')){
    header('Location:dashboard.php');
    }else{
    header('Location:members.php');
    }
   
   } else{
   
   echo "<center><div style='background-color:#ffabb3 ; box-shadow: 0px 0px 15px red; ' class='m-5 col-lg-6 col-md-6 col-sm-12 text-muted p-4 rounded'><b>UserID not found! <a href='members.php' >Retour</a></b></div></center>";
     
       } 


}elseif($do == 'Add'){  //Add Member
?> 

<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- Start ADD Member -->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

    <h2 class="text-center text-muted"> New Member <i class="fa fa-user-plus" ></i> </h2>
<div class="container">


<center>
       <form class="form-horizontal col-md-6 col-lg-6" id="Form-Edit" action="?do=insert" method="POST">
           <!--Start Username -->
           <div class="row mb-2 p-0">
                <label for="colFormLabel" class=" col-form-label-sm text-start col-lg-4">Username</label>
                <div class="col-lg-8">
                <input minlength="4" type="text" value="<?php if(isset($_SESSION['user'])){echo $_SESSION['user'];unset($_SESSION['user']); } ?>" name="username" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="" autocomplete="new-password">
              </div>
           </div> 
           <!-- End Username -->
           <?php if(isset($_SESSION['Check_username']) ) { 
              echo $_SESSION['Check_username'];
              unset($_SESSION['Check_username']);
             
            }
            if(isset($_SESSION['Check_username2'])){
              echo $_SESSION['Check_username2'];
              unset($_SESSION['Check_username2']);
            }
            ?>
          <!--Start Password -->
            <div class="row mb-2">
                <label for="colFormLabel" class=" col-form-label-sm text-start col-lg-4">Password</label>
                <div class="col-lg-8">
                <input minlength="6" type="password" value="<?php if(isset($_SESSION['pass1'])){echo $_SESSION['pass1'];unset($_SESSION['pass1']); } ?>" name="password1" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="" autocomplete="new-password">
              </div>
           </div>  
           <!-- End Password -->
            <!--Start confirm Password -->
            <div class="row mb-2">
                <label for="colFormLabel" class=" col-form-label-sm text-start col-lg-4">Confirm Password</label>
                <div class="col-lg-8">
                <input minlength="6" type="password" value="<?php if(isset($_SESSION['pass2'])){echo $_SESSION['pass2'];unset($_SESSION['pass2']); } ?>" name="password2" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="" autocomplete="new-password">
              </div>
           </div>  
           <!-- End confirm Password -->
           <!-- CHECK PASSWORD -->
           
         
           <?php if(isset($_SESSION['Check_pass'])){ 
              echo $_SESSION['Check_pass'];
              unset($_SESSION['Check_pass']);}
            ?>
           
           <!-- end check password -->
        <!--Start Email -->
            <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Email</label>
                <div class="col-lg-8">
                <input type="email" value="<?php if(isset($_SESSION['email'])){echo $_SESSION['email'];unset($_SESSION['email']); } ?>" name="email" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="">
              </div>
           </div>  
           <!-- End Email -->
            <!-- CHECK Email -->
            <?php if(isset($_SESSION['Check_email'])){ 
              echo $_SESSION['Check_email'];
              unset($_SESSION['Check_email']);}
            ?>
           <!-- end check Email -->
        <!--Start FullName -->
          <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Full name</label>
                <div class="col-lg-8">
                <input minlength="4" type="text" value="<?php if(isset($_SESSION['name'])){echo $_SESSION['name'];unset($_SESSION['name']); } ?>" name="fullName" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="">
              </div>
           </div>  
        <!-- End FullName -->
        <!-- CHECK Email -->
        <?php if(isset($_SESSION['Check_name'])){ 
              echo $_SESSION['Check_name'];
              unset($_SESSION['Check_name']);}

              if(isset($_SESSION['Check_name2'])){ 
                echo $_SESSION['Check_name2'];
                unset($_SESSION['Check_name2']);}
            ?>
           <!-- end check Email -->
             <!--Start Btn 
              <div class="col-lg-9 col-md-9 col-sm-12 float-lg-end float-sm-none m-1">
                <input type="submit" name="submit" value="Add" class="btn btn-primary btn-sm w-50" id="colFormLabel" placeholder="">
              </div>

            End btn -->
            <div class="row mb-2">
              <div class="col-lg-12 col-md-12 col-sm-12 float-lg-end float-sm-none m-1">
                <input type="submit" name="submit" value="Add" class="btn btn-primary btn-sm w-50" id="colFormLabel" placeholder="">
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 float-lg-end float-sm-none m-1">
                <a href='?do=Manage'  class="btn btn-danger btn-sm w-50" id="colFormLabel" >Back</a>
              </div>
           </div> 
       </form>
       
</center>

</div>

<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- End ADD Member -->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- Start  Insert Member -->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

<?php
}elseif($do == 'insert'){
?>
<center><div class='container col-sm-12 col-md-6 col-lg-6'>
  <?php if( $_SERVER['REQUEST_METHOD'] == 'POST' ){

      //Get parameters
      $user = $_POST['username'];
      $pass1 = $_POST['password1'];
      $pass2 = $_POST['password2'];
      $email = $_POST['email'];
      $name = $_POST['fullName'];
//Validate Username 

if(empty($user)) {

  $_SESSION['user']    = $user;
  $_SESSION['pass1']   = $pass1;
  $_SESSION['pass2']   = $pass2;
  $_SESSION['email']   = $email;
  $_SESSION['name']    = $name;
  $_SESSION['Check_username2'] = "<div class='row '>
  <div class='col-lg-4'>
 </div> 
 <label for='colFormLabel' class='text-danger col-form-label-sm text-start col-lg-8'><b>Username cant be empty</b></label>
</div> ";

}
if(strlen($user) < 4) {
  $_SESSION['user']    = $user;
  $_SESSION['pass1']   = $pass1;
  $_SESSION['pass2']   = $pass2;
  $_SESSION['email']   = $email;
  $_SESSION['name']    = $name;
  $_SESSION['Check_username'] = "<div class='row '>
  <div class='col-lg-4'>
 </div> 
 <label for='colFormLabel' class='text-danger col-form-label-sm text-start col-lg-8'><b>Username cant be less than 4 caracters</b></label>
</div> ";
}

if(strlen($user) > 15){
  $_SESSION['user']    = $user;
  $_SESSION['pass1']   = $pass1;
  $_SESSION['pass2']   = $pass2;
  $_SESSION['email']   = $email;
  $_SESSION['name']    = $name;
  $_SESSION['Check_username'] = "<div class='row'>
  <div class='col-lg-4'>
 </div> 
 <label for='colFormLabel' class='text-danger col-form-label-sm text-start col-lg-8'><b>Username cant be more than 15 caracters</b></label>
</div> ";
}
  //validate password
if(($pass1 === $pass2)&&($pass1!="")&&($pass2!="")){

 $check = check_item("Username","users",$user);
 if($check > 0){
  

  $_SESSION['user']    = $user;
  $_SESSION['pass1']   = $pass1;
  $_SESSION['pass2']   = $pass2;
  $_SESSION['email']   = $email;
  $_SESSION['name']    = $name;
   $_SESSION['Check_username2'] = "<div class='row mb-2'>
    <div class='col-lg-4'>
   </div> 
   <label for='colFormLabel' class='text-danger col-form-label-sm text-start col-lg-8'><b>Username is already exist !</b></label>
 </div> "; 
 header('Location:members.php?do=Add');


}else{

//sql statement
$stmt = $con->prepare("INSERT INTO users(Username, Password, Email , FullName , Date , RegStatus) VALUES (?,?,?,?,now(),1)");
   
//EXECUTE
  $stmt->execute(array($user ,sha1($pass1) ,$email ,$name));
$nbrRow =  $stmt->rowCount();

if($nbrRow>0){
echo"
<div class='alert alert-success col-lg-12 col-md-12 col-sm-12 mt-5 '>
  <strong>$nbrRow Row Inserted</strong>You will redirected to members page after 3 seconds  !
  <div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>
</div>
";
header('refresh:3;url=members.php');

}


  }


}elseif(($pass1=="")||($pass2=="")){
  $_SESSION['user']    = $user;
  $_SESSION['pass1']   = $pass1;
  $_SESSION['pass2']   = $pass2;
  $_SESSION['email']   = $email;
  $_SESSION['name']    = $name;
   $_SESSION['Check_pass'] = "<div class='row mb-2'>
    <div class='col-lg-4'>
   </div> 
   <label for='colFormLabel' class='text-danger col-form-label-sm text-start col-lg-8'><b>Passwords cant be empty</b></label>
 </div> "; 
   header('Location:members.php?do=Add');
}else{
 $_SESSION['user']    = $user;
 $_SESSION['pass1']   = $pass1;
 $_SESSION['pass2']   = $pass2;
 $_SESSION['email']   = $email;
 $_SESSION['name']    = $name;
  $_SESSION['Check_pass'] = "<div class='row mb-2'>
   <div class='col-lg-4'>
  </div> 
  <label for='colFormLabel' class='text-danger col-form-label-sm text-start col-lg-8'><b>Different passwords</b></label>
</div> "; 
  header('Location:members.php?do=Add');
}
//validate email
if(empty($email)){
  $_SESSION['user']    = $user;
  $_SESSION['pass1']   = $pass1;
  $_SESSION['pass2']   = $pass2;
  $_SESSION['email']   = $email;
  $_SESSION['name']    = $name;
  $_SESSION['Check_email'] = "<div class='row mb-2'>
  <div class='col-lg-4'>
 </div> 
 <label for='colFormLabel' class='text-danger col-form-label-sm text-start col-lg-8'><b>email cant be empty</b></label>
</div> ";
  header('Location:members.php?do=Add');
}
//validate full name
if(empty($name)){
  $_SESSION['user']    = $user;
  $_SESSION['pass1']   = $pass1;
  $_SESSION['pass2']   = $pass2;
  $_SESSION['email']   = $email;
  $_SESSION['name']    = $name;
  $_SESSION['Check_name'] = "<div class='row '>
  <div class='col-lg-4'>
 </div> 
 <label for='colFormLabel' class='text-danger col-form-label-sm text-start col-lg-8'><b>fullName cant be empty</b></label>
</div> ";
  header('Location:members.php?do=Add');

}

if(strlen($name) < 4){
  $_SESSION['user']    = $user;
  $_SESSION['pass1']   = $pass1;
  $_SESSION['pass2']   = $pass2;
  $_SESSION['email']   = $email;
  $_SESSION['name']    = $name;
  $_SESSION['Check_name2'] = "<div class='row'>
  <div class='col-lg-4'>
 </div> 
 <label for='colFormLabel' class='text-danger col-form-label-sm text-start col-lg-8'><b>fullName cant be less than 4 caracters</b></label>
</div> ";
  header('Location:members.php?do=Add');

}



}else{

  echo "<div style='box-shadow: 0px 0px 10px red;' class='m-5 alert alert-danger  p-4 rounded'><b>Sorry you cant browse this page Directly <a href='members.php?do=Add'>Retour</a></b></div>";
  ?>
  </div></center>
  <?php
    }
  /*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- END INSERT MEMBER -->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
*/
}elseif($do == 'Edit'){ // Edit Page 
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- Start Edit Member -->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
*/

 //check if the userID is valid & numiric and get iteger value (itval) of it 
 $userid = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0 ;

 //search in database  if this userID exist
 $stmt = $con->prepare("SELECT Username , Password , Email ,FullName FROM users WHERE UserID = ?");

 //execute
 $stmt->execute(array($userid));

 //fetch
 $row = $stmt->fetch();

 //get numRows
 $NbrRow = $stmt->rowCount();

 //if $NbrRow > 0 then the database contain a record with this username and password 
 $userName = "";
 $pass = "";
 $email = "";
 $fullName = "";
 $msg ="";

 if($NbrRow>0){

 $userName = $row['Username'];
 $pass     = $row['Password'];
 $email    = $row['Email'];
 $fullName = $row['FullName'];

 //$msg = "<div style='background-color:#7af1a4 ; box-shadow: 0px 0px 15px green; ' class=' col-lg-6 col-md-6 col-sm-12  text-muted p-4 rounded'><b>Succesfuly</b></div>";
 
} else{

    //$msg = "<div style='background-color:#ffabb3 ; box-shadow: 0px 0px 15px red; ' class='mb-2 col-lg-6 col-md-6 col-sm-12 text-muted p-4 rounded'><b>UserID not found! <a href='dashboard.php' >Retour</a></b></div>";
    
   $msg = "<div style='box-shadow: 0px 0px 10px red;' class='mb-2 col-lg-6 col-md-6 col-sm-12 text-muted p-4 rounded alert alert-danger'><strong>UserID not Found <a href='dashboard.php' >Go Back </a> </strong>   </div>";
  
    } 

?>
    
    <h2 class="text-center mt-2 text-muted"><i class="fa fa-edit" ></i> Edit Member </h2>

    <div class="container">
<center>
<?php  echo $msg;  //msg about status of userId ?>  
       <form class="form-horizontal col-md-6 col-lg-6" id="Form-Edit" action="?do=Update" method="POST">
         <input type="hidden" name="id" value="<?php echo $userid; ?>" >
           <!--Start Username -->
           <div class="row mb-2 p-0">
                <label for="colFormLabel" class=" col-form-label-sm text-start col-lg-3">Username</label>
                <div class="col-lg-9">
                <input type="text" value="<?php echo $userName; ?>" name="username" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="" autocomplete="new-password">
              </div>
           </div> 
           <!-- End Username -->
 <!-- CHECK Username -->
 <?php if(isset($_SESSION['User-name'])){ 
              echo $_SESSION['User-name'];
              unset($_SESSION['User-name']);}
            ?>
           <!-- end check Email -->


          <!--Start Password -->
            <div class="row mb-2">
                <label for="colFormLabel" class=" col-form-label-sm text-start col-lg-3">Password</label>
                <div class="col-lg-9">
                <input type="hidden" value="<?php echo $pass; ?>" name="Oldpassword" >
              
                <input type="password" value="" name="Newpassword" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="Leaving it blank means no changes" autocomplete="new-password">
              </div>
           </div>  
           <!-- End Password -->

        <!--Start Email -->
            <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-3">Email</label>
                <div class="col-lg-9">
                <input type="email" value="<?php echo $email; ?>" name="email" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="">
              </div>
           </div>  
           <!-- End Email -->

        <!--Start FullName -->
          <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-3">Full name</label>
                <div class="col-lg-9">
                <input type="text" value="<?php echo $fullName; ?>" name="fullName" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="">
              </div>
           </div>  
        <!-- End FullName -->
        

           <div class="row mb-2">
              <div class="col-lg-12 col-md-12 col-sm-12 float-lg-end float-sm-none m-1">
                <input type="submit" name="submit" value="Save" class="btn btn-primary btn-sm w-50" id="colFormLabel" placeholder="">
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 float-lg-end float-sm-none m-1">
                <a href='?do=Manage'  class="btn btn-danger btn-sm w-50" id="colFormLabel" >Back</a>
              </div>
           </div> 
       </form>
       
</center>

    </div>



<?php

}//end if edit
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- END Edit Member -->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
*/
elseif( $do  == 'Update') { //Update page
  /*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- Start Update Member -->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
*/

  echo "<h2 class='text-center pt-3'> Update page </h2>";
echo "<center><div class='container col-sm-12 col-md-6 col-lg-6'>";
  if( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    //Get parameters
    $id = $_POST['id'];
    $user = $_POST['username'];
    $email = $_POST['email'];
    $name = $_POST['fullName'];
    ///Password trick
    $PassWord = empty($_POST['Newpassword']) ? $_POST['Oldpassword'] : sha1($_POST['Newpassword']) ;

    //validate the form
    $formErrors = array();

    if(strlen($user) < 4){
      $formErrors[] = "<div style='box-shadow: 0px 0px 10px red;' class='container alert alert-danger'>Username cant be less than <strong> 4 caracters </strong> </div>";
    }
    if(strlen($user) > 20){
      $formErrors[] = "<div style='box-shadow: 0px 0px 10px red;' class='container alert alert-danger'>Username cant be more than <strong> 20 caracters </strong> </div>";
    }
    if(empty($user)){
      $formErrors[] = "<div style='box-shadow: 0px 0px 10px red;' class='container alert alert-danger'>Username cant be  <strong> Empty </strong> </div>";
    }
    if(empty($name)){
      $formErrors[] = "<div style='box-shadow: 0px 0px 10px red;' class='container alert alert-danger'>Full Name cant be <strong> Empty </strong> </div>";
    }
    if(empty($email)){
      $formErrors[] = "<div style='box-shadow: 0px 0px 10px red;' class='container alert alert-danger'>Email cant be  <strong> Empty </strong> </div>";
    }

    foreach($formErrors as $Error){
      echo $Error;
    }

    if(empty($formErrors)){
try{
   //sql statement
   $stmt = $con->prepare("UPDATE users SET Username = ? , Email = ? , FullName = ? ,Password = ? WHERE UserID = ? ");
   
   //EXECUTE
   $stmt->execute(array($user ,$email ,$name ,$PassWord ,$id));


 $nbrRow =  $stmt->rowCount();
if($nbrRow>=0){
  $groupID = check_item("GrouID" ,"users" ,$id);

if($groupID == 1){
  $_SESSION['Username'] =  $user;
}

$s = $nbrRow > 1 ? 's' : '' ;

echo "
<div class='alert alert-success col-lg-12 col-md-12 col-sm-12 '>
  <strong>$nbrRow Row$s Updated</strong>You will redirected to members page after 6 seconds  !
  <div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>
</div>
";

header('refresh:4;url=members.php');

}

}catch(Exception $e){

echo "
<div class='alert alert-success col-lg-12 col-md-12 col-sm-12 '>
  <strong>Username is already exist !</strong>You will redirected to edit member  after 3 seconds  !
  <div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>
</div>
";
header('refresh:3;url=members.php?do=Edit&userID='.$id);

}


    
 

  }else{
    echo "<a href='?do=Edit&userID= $id' class='btn btn-primary' btn-sm>Retour</a>";

  }
  

}else{

echo "<div style='box-shadow: 0px 0px 10px red;' class='alert alert-danger  p-4 rounded'><b>Sorry you cant browse this page Directly <a href='members.php?do=Edit?userID=$id'>Retour</a></b></div>";

  }
 echo "</div></center>";

}
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- End Update Member -->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
*/
    //footer
    include $temp.'footer.php'; 
}else{//end if isset(username)
        header('Location:index.php');
        exit();
}

?>

