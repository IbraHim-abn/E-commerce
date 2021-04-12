<?php
$q = $_POST['username'];
$Res="";


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

//like'$q%'
$stmt = $con->prepare("SELECT Username FROM users where Username = '$q' ");

$stmt->execute();

$NbrRow = $stmt->rowCount();

if($q!="" && strlen($q) >= 4){

if ($NbrRow > 0) {
 
echo "<strong class='text-dark'>This Username is already exist</strong>";

  }else{
      echo "";
  }
}
  


?>