<?php
session_start();
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

//function to get userid 
function getUserID($Username){
    global $con;
    $userId='';
   $stmt3 = $con->prepare("SELECT  UserID  FROM  users WHERE Username  = ? ");
       $stmt3->execute(array($Username));
       $rows = $stmt3->fetchAll();    
                    foreach($rows as $row) {

                       $userId = $row['UserID'];

                                            }

                       return $userId;
                           }


if(isset($_SESSION['user'])){

/*
**
********************************Start inserting data ***********************
**
*/


if( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    //Get variables
    $name      = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $desc      = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $price     = $_POST['price']."$";
    $country   = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
    $status    = $_POST['status'];
    $member    = $_SESSION['uId'];
    $categorie = $_POST['categorie'];
 
     $arrayErrors = array();



        if(empty($name)){

            $arrayErrors[] = "<div class='alert alert-warning' ><strong>Name cant be empty</strong></div>";

        }elseif(strlen($name) < 4){

            $arrayErrors[] = "<div class='alert alert-warning' ><strong>Name cant be less than 4 caracters</strong></div>";

        }


        if(empty($desc)){

            $arrayErrors[] = "<div class='alert alert-warning' ><strong>The description cant be empty</strong></div>";

        }elseif(strlen($desc) < 8){

            $arrayErrors[] = "<div class='alert alert-warning' ><strong>The description cant be less than 8 characters</strong></div>";

        }


        if(!is_numeric($price) && $price > 0){  // Nothings to do

            $A = "";

        }else{ //Print the error message

            $arrayErrors[] = "<div class='alert alert-warning' ><strong>The price is not valid </strong></div>";

        }

        if(empty($country)){

            $arrayErrors[] = "<div class='alert alert-warning' ><strong>Country cant be empty</strong></div>";

        }


        if($status == "0"){

            $arrayErrors[] = "<div class='alert alert-warning' ><strong>You must choose a status</strong></div>";
        }

        if($categorie == 0){

            $arrayErrors[] = "<div class='alert alert-warning' ><strong>You Must chose the category</strong></div>";

            }
         

            if(empty($arrayErrors)){


                
//Insert category info into database

$sql  = "INSERT INTO items 
(Name_Item , Description_item , Price , Ads_Date , Country_Made , Status , Member_ID , Cat_ID , Approvable)
VALUES (?,?,?,now(),?,?,?,?,0)";

$stmt = $con->prepare($sql);

$stmt->execute(array($name,$desc,$price,$country,$status,$member,$categorie));

$nbrRow = $stmt->rowCount();

if($nbrRow > 0){

echo "ok";

}

            }else{

                foreach($arrayErrors as $err){
                    echo $err;
                }


            }
          
            

}
/*
**
********************************end inserting data ***********************
**
*/


}else{

    header('Location:login.php');

}


?>