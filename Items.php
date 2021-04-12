<?php

ob_start();

session_start();

$PageTitle = "Show items";

include 'init.php';

     //check if the userID is valid & numiric and get iteger value (itval) of it 

     $Item = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

     //search in database  if this userID exist
 
     $stmt = $con->prepare("SELECT * FROM items  
     inner join categories on(items.Cat_ID = categories.ID)
     inner join users on(items.Member_ID = users.UserID) 
     WHERE  Item_ID = ?  ");
 
     //execute
 
 $stmt->execute(array($Item));
 
     //fetch
 
 $rows = $stmt->fetch();

  //get row count

 $NbrRow = $stmt->rowCount();

 if($NbrRow > 0){

    echo '<h2 class="text-center">Item : '.$rows['Name_item'].'</h2>';

     ?>

<div class="container">
 <div class="row show-item">
   <div class="col-md-4 img-item">
     <img src="item.jpg" alt="" />
   </div>
   <div class="col-md-8 item-info">

    <!-- <h2 class="text-start text-primary ">       <?php //echo $rows['Name_item']; ?></h2>-->

     <p><?php echo $rows['Description_item']; ?></p>

     <ul class="list-unstyled">
       
        <li>
            <i class="fa fa-building fa-fw"></i> 
            <span>Country  </span>:
            <?php echo $rows['Country_Made']; ?>    
        </li>

        <li>
        <i class="fa fa-money fa-fw"></i> 
            <span>Price </span>:
            <?php echo $rows['Price']; ?>           
        </li>

        <li>
            <i class="fa fa-user fa-fw"></i>
            <span>By </span>:
            <a href="ShowProfile.php?Username=<?php echo $rows['Username'] ;?>"><?php echo $rows['Username']; ?> </a>       
        </li>

        <li>
            <i class="fa fa-tags fa-fw"></i>
            <span>Category </span>:
            <a href="categories.php?q=<?php echo $rows['ID']; ?>&n=<?php echo str_replace(' ', '-', $rows['Name']) ?>"><?php echo $rows['Name']; ?></a>  
        </li>

        <li>
            <i class="fa fa-calendar fa-fw"></i>
            <span>Added Date </span>:
            <?php echo $rows['Ads_Date']; ?>       
        </li>

     </ul>
     <button class="btn-buy btn btn-success"><i class="	fa fa-cart-arrow-down"></i> ADD TO BASKET</button>
   </div>
 </div>


     

    <hr class="custom-hr">

    <!-- add comment -->
<?php if(isset($_SESSION['user'])){ ?>



    <div class="row add-comments">
        <div class="col-md-3">
        <h4>Add your comment : </h4>
        </div>
        <div class="col-md-8">
            <div class="add-comment">
                    <form action="<?php echo $_SERVER['PHP_SELF']."?itemid=".$Item ?>" method="POST">
                        <textarea name="comment" class="form-control"></textarea>
                        <input class="btn btn-primary btn-add-comment" type="submit" value="past"/>
                    </form>
                    <div>
                    <?php
                    if($_SERVER['REQUEST_METHOD'] == "POST"){


                        // serach for UserID of Session['user']
                        $stmt2 = $con->prepare("SELECT * FROM users WHERE   Username = ?  ");
                                $stmt2->execute(array($_SESSION['user']));
                                $UserID = $stmt2->fetch();
                        //Get parameters
                        $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                        $c_item     = $rows['Item_ID'];
                        $c_member   = $UserID['UserID'];

                    


                        if(!empty($comment)){
                           
                            //Insert comment 

        $sql2  = "INSERT INTO comments (c_comment , c_status , c_date , c_item , c_member) VALUES (?,0,now(),?,?)";

                            $stmt3 = $con->prepare($sql2);

                            $stmt3->execute(array($comment,$c_item,$c_member));

                            $nbrRow1 = $stmt3->rowCount();

                            if($nbrRow1 > 0){

                               echo "<p class='alert alert-success mt-1'>comment added</p>"; 

                            }

                        }else{

                          ?>
                          <br><div class="errComment">
                             <p class="alert alert-danger col-md-12"> Comment cant be empty !</p>
                          </div>
                          <?php
                            
                        }

                    }
                    ?>
                    </div>
                   
            </div>
        </div>
        
    </div>


    <?php 
}else{
    ?>
    <div class="no-session-user alert alert-warning">
        <h5 class="text-center"><a href="login.php">Login</a> or <a href="login.php">Register</a> to comment !</h5>
        </div>
    <?php
}
?>
    <!-- end and comment -->
    <hr class="custom-hr">
    
    <h4 class="text-center hr-comments">Comments</h4>

    <hr class="custom-hr">

    <!-- show comments -->
    <?php
          
          $stmt3 = $con->prepare("SELECT * FROM comments inner join
          users on (comments.c_member = users.UserID) WHERE   comments.c_status = 1  and c_item = ?");
          $stmt3->execute(array($Item));
          $AllComments = $stmt3->fetchAll();
          foreach($AllComments as $Comm_ent){
             
            ?>
               <div class="row show-comments mt-3">
                
                        <a href="ShowProfile.php?Username=<?php  echo $Comm_ent['Username']; ?>">
                            <B><?php echo $Comm_ent['FullName']; ?></B>
                        </a>
                
                    <div class="item-comments col-md-9 col-sm-10 col-lg-8 bg-light">
                        <?php 
                            echo $Comm_ent['c_comment'];
                        ?>
                        
                    </div>
                    <div class="date col-md-9 col-sm-10 col-lg-8">
                            <?php echo $Comm_ent['c_date']; ?>
                    </div>
                </div>

            <?php

          }

          if(empty($AllComments)){

                           ?>

   <center  class="mt-5" >  <span id="empty-item"> <strong> There is no comment to show 😢 </strong></span>  </center>

                              
                          <?php

          }

          ?>
    

<!-- end show comments -->
 

    <?php

}else{

?>

   <div class="div-cat"> 

   <center>  <span  id="empty-item"> <strong>Sorry There is no such item 😢 </strong></span>  </center>

   </div>

<?php


}

?>
</div>
<?php
 /*-- footer --*/

include $temp.'footer.php'; 

ob_end_flush();

?>