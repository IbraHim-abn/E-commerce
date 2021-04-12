<?php
/*
===================================================================
= Manage Comments Pages
= you can Approve | Edit | Delete Comments from here
===================================================================*/
session_start();
$PageTitle="Comments";
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

  $condition = "1 = 1";

  if(isset($_GET['comment'])){

    $condition = "c_id = ".$_GET['comment'];


  }

if(isset($_GET['item'])){

    $condition = "c_item = ".$_GET['item'];

}

  

  //select comments
 $stmt = $con->prepare("SELECT * FROM `comments` inner join items 
on (comments.c_item = items.Item_ID)
inner join users on (comments.c_member = users.UserID)
 where $condition") ;  

 //execute

 $stmt->execute();

 //Assign to variables

 $rows = $stmt->fetchAll();

 $nbr_row = $stmt->rowCount();

if($nbr_row > 0){

?> 

  <h2 class='text-center'>
  <i class="fa fa-comments-o" ></i> Comments (
  <?php echo count_items2("c_id" , "comments",'0 = 0') ;?>
  )</h2> 
<div class='container'>
<div class="row col-lg-12"> 
              <?php 
              foreach($rows as $row){
                ?>

        <!--Start Comment -->
<?php
if($nbr_row == 1){

echo '<div class="p-2 col-lg-12">';

}else{

echo '<div class="p-2 col-lg-6">';
  
}
?>

        
        <?php 
            echo "<i class='fa fa-user'></i> <b>Member : </b><span class='text-primary' >".$row['Username']."</span> <br>"; 
            echo "<i class='fa fa-tag'></i> <b>Item : </b><span class='text-primary' >".$row['Name_item']."</span>"; 
          ?>
                <div>
                  <textarea readonly="readonly" style="height:100px" name="c_comment" class="form-control form-control-sm w-70" id="colFormLabel" ><?php echo $row['c_comment'] ?></textarea>
                </div>
                <div class="row">
                     <div class="text-start w-50 text-muted">
                     Date : <?php echo $row['c_date']; ?>
                     </div>
                    <div class="text-end w-50">
                       <b>
                  <?php

                       if($row['c_status'] == 0){

              echo " <a href='?do=approve&c_id=".$row['c_id']."'><i class='fa fa-check-circle'></i> Approve</a> ";
                 
                        }else{

              echo " <a href='?do=disapprove&c_id=".$row['c_id']."'><i class='fa fa-ban'></i> Disapprove</a> ";
                
                          }
                  ?>

            &nbsp;&nbsp;  
            <a class="Confirm" href="<?php echo "?do=Delete&c_id=".$row['c_id']."";    ?>"><i class="fa fa-close"></i>Delete</a>&nbsp;&nbsp;
            <a href="<?php echo "?do=Edit&c_id=".$row['c_id']."";    ?>"><i class="fa fa-edit"></i>Edit</a>
                      </b>
                    </div>
                    </div>
        </div>

        <!-- End comment -->




              <?php
              }
              ?>
       
     </div>
    </div>
    <div class="col-lg-4 col-md-6"> 
  </div>
  <?php
}else{
  echo "<h2 class='text-center mt-5'>Comments is epmty :( </h2>";
   
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

 $c_id = isset($_GET['c_id']) && is_numeric($_GET['c_id']) ? intval($_GET['c_id']) : 0 ;

 //search in database  if this userID exist
 $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ? ");

 //execute
 $stmt->execute(array($c_id));


 //get numRows
 $NbrRow = $stmt->rowCount();


 if($NbrRow>0){

$stmt = $con->prepare("DELETE FROM comments WHERE c_id = ? ");

$stmt->execute(array($c_id));

if(isset($_SERVER['HTTP_REFERER'])){

    $link = $_SERVER['HTTP_REFERER'] ;

    header('refresh:0;url='.$link.'');

}else{

    header('Location:comments.php');

}



} else{

echo "<center><div style='background-color:#ffabb3 ; box-shadow: 0px 0px 15px red; ' class='m-5 col-lg-6 col-md-6 col-sm-12 text-muted p-4 rounded'><b>UserID not found! <a href='comments.php' >Retour</a></b></div></center>";
  
    } 
/*********************************************************************************************************************************
 *                                      Start  Approve  Comment
 **********************************************************************************************************************************/

  }elseif( $do == 'approve'){

 //check if the c_id  is valid & numiric and get iteger value (itval) of it 
 $c_id = isset($_GET['c_id']) && is_numeric($_GET['c_id']) ? intval($_GET['c_id']) : 0 ;

 //search in database  if this c_id exist
 $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ? ");

 //execute
 $stmt->execute(array($c_id));


 //get numRows
 $NbrRow = $stmt->rowCount();


 if($NbrRow>0){

$stmt = $con->prepare("UPDATE comments set c_status = 1 WHERE c_id = ? ");

$stmt->execute(array($c_id));

if(isset($_SERVER['HTTP_REFERER'])){

    $link = $_SERVER['HTTP_REFERER'] ;

    header('refresh:0;url='.$link.'');

}else{

    header('Location:comments.php');

}

} else{

echo "<center><div style='background-color:#ffabb3 ; box-shadow: 0px 0px 15px red; ' class='m-5 col-lg-6 col-md-6 col-sm-12 text-muted p-4 rounded'><b>Comments not found! <a href='comments.php' >Retour</a></b></div></center>";
  
    } 

 /*********************************************************************************************************************************
 *                                      Start   Disapprove  comment
 **********************************************************************************************************************************/


  }elseif( $do == 'disapprove'){

    //check if the userID is valid & numiric and get iteger value (itval) of it 
    $c_id = isset($_GET['c_id']) && is_numeric($_GET['c_id']) ? intval($_GET['c_id']) : 0 ;
   
    //search in database  if this userID exist
    $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ? ");
   
    //execute
    $stmt->execute(array($c_id));
   
   
    //get numRows
    $NbrRow = $stmt->rowCount();
   
   
    if($NbrRow>0){
   
   $stmt = $con->prepare("UPDATE comments set c_status = 0 WHERE c_id = ? ");
   
   $stmt->execute(array($c_id));
 
   if(isset($_SERVER['HTTP_REFERER'])){

    $link = $_SERVER['HTTP_REFERER'] ;

    header('refresh:0;url='.$link.'');

}else{

    header('Location:comments.php');

}

  

   
   } else{
   
   echo "<center><div style='background-color:#ffabb3 ; box-shadow: 0px 0px 15px red; ' class='m-5 col-lg-6 col-md-6 col-sm-12 text-muted p-4 rounded'><b>Comments not found! <a href='comments.php' >Retour</a></b></div></center>";
     
       } 


/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- END DISAPPROVE Comment -->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
*/

}elseif($do == 'Edit'){ // Edit Page 
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- Start Edit Comment -->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
*/

 //check if the c_id is valid & numiric and get iteger value (itval) of it 
 $c_id = isset($_GET['c_id']) && is_numeric($_GET['c_id']) ? intval($_GET['c_id']) : 0 ;

 //search in database  if this c_id exist
 $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");

 //execute
 $stmt->execute(array($c_id));

 //fetch
 $row = $stmt->fetch();

 //get numRows
 $NbrRow = $stmt->rowCount();

 //if $NbrRow > 0 then the database contain a record with this username and password 


 if($NbrRow>0){

?>
    
    <h2 class="text-center mt-2 text-muted"><i class="fa fa-comments-o" ></i> Edit Comment </h2>

    <div class="container">
<center>

       <form class="form-horizontal col-md-6 col-lg-6" id="Form-Edit" action="?do=Update" method="POST">

       <input type="hidden" name="c_id" value="<?php echo $row['c_id'] ?>" />
        <!--Start Comment -->
        <div class="row mb-2">
                <label for="colFormLabel" class=" col-form-label-sm text-start col-lg-3"><b>Comment : </b></label>
                <div class="col-lg-9">
                <textarea style="height:150px" name="c_comment" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="Describe the item from here" ><?php echo $row['c_comment'] ?></textarea>
            </div>
        </div>  
        <!-- End comment -->
           
              <div class="float-end">
                <input type="submit" name="submit" value="Update" class="btn btn-primary btn-sm" id="colFormLabel" placeholder="">
              </div>

       </form>
       
</center>

    </div>



<?php

} else{
 
    $msg = "<div style='box-shadow: 0px 0px 10px red;' class='mb-2 col-lg-6 col-md-6 col-sm-12 text-muted p-4 rounded alert alert-danger'><strong>Comments not Found <a href='dashboard.php' >Go Back </a> </strong>   </div>";
   
     } 


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
    $c_id = $_POST['c_id'];
    $comment = $_POST['c_comment'];
  
    //validate the form
    $formErrors = array();

   
    
    
    if(empty($comment)){
      $formErrors[] = "<div style='box-shadow: 0px 0px 10px red;' class='container alert alert-danger'>Comment cant be <strong> Empty </strong> </div>";
    }
    

    foreach($formErrors as $Error){
      echo $Error;
    }

    if(empty($formErrors)){
try{
   //sql statement
   $stmt = $con->prepare("UPDATE comments SET c_comment = ? WHERE c_id = ? ");
   
   //EXECUTE
   $stmt->execute(array($comment,$c_id));


 $nbrRow =  $stmt->rowCount();

echo "
<div class='alert alert-success col-lg-12 col-md-12 col-sm-12 '>
  <strong>Comment Updated</strong>
</div>
";

}catch(Exception $e){

echo "
<div class='alert alert-success col-lg-12 col-md-12 col-sm-12 '>
  <strong>Username is already exist !</strong>You will redirected to edit member  after 3 seconds  !
  <div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>
</div>
";
header('refresh:3;url=comments.php?do=Edit&c_id='.$c_id);

}


    
 

  }else{
    echo "<a href='?do=Edit&c_id= $c_id' class='btn btn-primary' btn-sm>Retour</a>";

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

