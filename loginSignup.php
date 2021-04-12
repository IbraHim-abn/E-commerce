<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){

//connection
$dsn    = 'mysql:host=localhost;dbname=shop';
$user   = 'root';
$pass   = '';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' ,
);

try{
    $con = new PDO($dsn, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo 'Failed To Connect : '.$e->getMessage();
}
//end connection




    //USER login
    if(isset($_POST['login'])){



        $Username = $_POST['username'];

        $Password = $_POST['password'];

        //hashed password

        $hashedPass = sha1($Password);

        //check if the  user is exist in database

        $stmt = $con->prepare("SELECT  UserID ,Username , Password FROM users WHERE Username= ? AND Password = ? ");

        $stmt->execute(array($Username,$hashedPass));
        
        $uID = $stmt->fetch();

        $NbrRow = $stmt->rowCount();


        //if $NbrRow > 0 then the database contain a record with this username and password 

        if($NbrRow>0){

       
            $_SESSION['user'] = $Username; //Register  username in session 

            $_SESSION['uId'] = $uID['UserID']; //Register  UserID in session 

            header('Location:index.php');  //Redirecting to index page

        

        }else{

            echo '<div class="alert alert-danger text-center">Username or password is <strong>incorrect !</strong></div>';

        }


    //USER sigN up

    }else{

        $user = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $email = filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL);
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];
        $UserExist = $_POST['userExist'];

  //start validate the form
        $formErrors = array();

        //sql statement

        $getUsername = $con->prepare("SELECT * FROM users WHERE Username = ? ");
        
        //EXECUTE

        $getUsername->execute(array($user));

        $nbrUsers =  $getUsername->rowCount();

                if($nbrUsers > 0){

                    $formErrors[] = "<div  class='container alert alert-warning'>Username is <strong> already exist </strong> </div>";

                }

  //start  Validation of the username


if($UserExist == "Exist"){

    $formErrors[] = "<div  class='container alert alert-warning'>Username is <strong> already exist </strong> </div>";
}

  if(empty($user)){

    $formErrors[] = "<div  class='container alert alert-warning'>Username cant be <strong> Empty </strong> </div>";
  
}elseif(strlen($user) < 4){

      $formErrors[] = "<div class='container alert alert-warning'>Username cant be less than <strong> 4 caracters </strong> </div>";
  }

  //start  Validation of the email

  if(empty($email)){

      $formErrors[] = "<div id='errMail'  class='container alert alert-warning'>Email cant be <strong> Empty </strong> </div>";            
  
    }elseif(filter_var($email, FILTER_VALIDATE_EMAIL) != true ){

    $formErrors[] = "<div id='errMail'  class='container alert alert-warning'>This Email is <strong> not valid ! </strong> </div>";            
 
  }

  //start  Validation of password


if($pass1 == ""){

    $formErrors[] = "<div  class='container alert alert-warning'>password cant be <strong> Empty </strong> </div>";   

}elseif($pass2 == ""){

    $formErrors[] = "<div  class='container alert alert-warning'>You have to <strong> confirm the password </strong>  </div>";   
}

  if($pass1 != $pass2){

      $formErrors[] = "<div  class='container alert alert-warning'>Passwords are  <strong>Defferent </strong> </div>";   
  
    }


//end validation


  // if the array of errors is empty then ... INSERT DATA


     if(empty($formErrors)){

                        //sql statement

                        $stmt = $con->prepare("INSERT INTO users(Username, Password, Email , Date , RegStatus)

                        VALUES (?,?,?,now(),0)");
                        
                        //EXECUTE

                        $stmt->execute(array($user ,sha1($pass1) ,$email));

                        $nbrRow =  $stmt->rowCount();

                                if($nbrRow>0){

                                    echo "Ok";

                                }

    }else{

  //  if the array contain some errs then print it


        foreach($formErrors as $Error){

            echo $Error;
            
            }

        

    }



    }

}else{

    header('Location:login.php');

}

?>