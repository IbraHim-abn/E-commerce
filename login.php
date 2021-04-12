<?php
ob_start();
session_start();

$PageTitle = "Login&signup";

include "init.php";

if(isset($_SESSION['user'])){
  
    header('Location:index.php');


    }

    
//check if user coming from the http request method post

/*if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if( isset($_POST['signup']) ){

  $user = $_POST['username'];
  $email = $_POST['email'];
  $pass1 = $_POST['pass1'];
  $pass2 = $_POST['pass2'];

    //validate the form
  $formErrors = array();

            if(strlen($user) < 4){
                $formErrors[] = "<div class='container alert alert-warning'>Username cant be less than <strong> 4 caracters </strong> </div>";
            }

            if(empty($user)){
                $formErrors[] = "<div  class='container alert alert-warning'>Username cant be <strong> Empty </strong> </div>";
            }

            if(empty($email)){
                $formErrors[] = "<div  class='container alert alert-warning'>Email cant be <strong> Empty </strong> </div>";            
            }

            if($pass1 != $pass2){
                $formErrors[] = "<div  class='container alert alert-danger'>Passwords are  <strong>Defferent </strong> </div>";   
            }


           

if(empty($formErrors)){

//sql statement

$stmt = $con->prepare("INSERT INTO users(Username, Password, Email , Date , RegStatus)

 VALUES (?,?,?,now(),0)");
   
//EXECUTE

  $stmt->execute(array($user ,sha1($pass1) ,$email));

$nbrRow =  $stmt->rowCount();

if($nbrRow>0){

echo"
<center><div class=' text-center alert alert-success col-lg-6 col-md-12 col-sm-12 mt-5 '>
  <strong>Succesfully !</strong> You have to login now
</div>
</center>
";


}

}
       

    }    

}*/
?>


<div class="container login-page">

<h2 class="text-center">
    <span id="spanlogin" class="selected"  data-class="login">Login</span> |
     <span id="spansignup"  data-class="signup">Signup</span>
</h2>


<center>
<div id="successmsg">
        
</div>
</center>


<!-- form login -->

  <form id="login" class="login" >
      <input
       id="usernameLogin"
       class="form-control" 
       type="text" 
       name="username" 
       placeholder="Username" 
       autocomplete="off"
       required
       />
      <input 
      class="form-control" 
      type="password" 
      name="password" 
      placeholder="Password" 
      autocomplete="new-password"
      
      />

      <input id="btnlogin" class="btn btn-success w-100" name="login"  readonly value="Login"/>


      <!--Div show err msg -->
      <div id="errmsg">
          
      </div>
   


  </form>

  <!-- end form login -->

  <!-- start form signup -->


  <form  id="signup" class="signup">
      <input
       id="username"
       class="form-control" 
       type="text" 
       name="username" 
       placeholder="Username" 
       autocomplete="off"
       />
       <input type="hidden" value="" name="userExist" id="hideinput"/>

       <div id="res" class="bg-warning text-center mb-2">
    
        </div>
      <input 
      class="form-control" 
      type="email" 
      name="email" 
      placeholder="email" 
      autocomplete="new-password"
      />
      <div id="mailErr" class="text-danger">
     
      </div>

      <input 
      class="form-control" 
      type="password" 
      name="pass1" 
      id="pass1"
      placeholder="Password" 
      autocomplete="new-password"
      />
      <input 
      class="form-control" 
      type="password" 
      name="pass2" 
      id="pass2"
      placeholder="confirm Password" 
      autocomplete="new-password"
      />
     <p id="passStatus" class=''></p>

      <input id="signup"  class="btn btn-primary w-100 text-light" name="signup" readonly value="Sign up"/>

            <center>
                 <div id="errsignup">

                </div>
            </center>
   
  </form>

  <!-- end form signup -->


</div>


<?php

include $temp.'footer.php'; 

ob_end_flush();
?>