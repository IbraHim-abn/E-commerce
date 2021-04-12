<?php 
session_start();
$PageTitle ="Dashboard";
if(isset($_SESSION['Username'])&&($_SESSION['UserID'])){

    include 'init.php';

$latestUsers = 3;    //Number of latests users

$thelatest = getLatests("*" , "users" , "UserID" , $latestUsers); //Latests users array

$latestItem = 3;    //Number of latests items

$thelatestItem = getLatestsItem("*" , "items" , "Item_ID" , $latestItem); //Latests items array

$latestsComments = getLatestsComments("*","comments","c_date");



   ?> 
   <!-- Start dashboard -->
   <div class="home-stats">
    <div class="container mt-3">
      <!--  <h2 class="text-center">Dashboard</h2> -->
        <div class="row text-center text-light" >

           <div class="col-md-3">
           <a href="members.php">
             <div class="stat st-members">
               <i class="fa fa-users"></i>
              <div class="info">
                <b> Total Members </b>
               <span>
      <?php echo count_items("UserID" , "users",'(RegStatus = 1 or RegStatus = 0 )') ?>
              </span>
              </div>
             </div>
             </a>
           </div>

           <div class="col-md-3">
           <a href="members.php?page=pending">
             <div class="stat st-pending">
             <i class="fa fa-user-plus"></i>
             <div  class="info">
               <b>Pending Members</b>
               <span>
     <?php echo count_items("UserID" , "users",'RegStatus = 0') ;?> 
               </span>
             </div>  
           </div>
           </a>
           </div>
  

           <div class="col-md-3">
           <a href="items.php">
             <div class="stat st-items">
             <i class="fa fa-tags"></i> 
             <div class="info">
               <b> Total Items</b>
               <span>
     <?php echo count_items2("Item_ID" , "items",'0 = 0') ;?>
               </span>
             </div>
             </div>
              </a>
           </div>


           <div class="col-md-3">
           <a href="comments.php">
             <div class="stat st-comments">
             <i class="fa fa-comments-o"></i> 
               <div class="info">
                <b>Total Comments</b> 
               <span>
               <?php echo count_items2("c_id" , "comments",'0 = 0') ;?>
               </span>
             </div>
            </div> 
            </a>
           </div>
      
        </div>              
 </div>
</div>
<div class="latest">        
 <div class="container">
   <div class="row">
      <div class="col-sm-6">
         <div class="panel panel-default">
              <div class="panel-heading">
                  <b><i class="fa fa-users"></i> Latest <?php //echo $latestUsers; ?> Registred Users </b>
                  <span  class="toggle-info pull-right">
                    <i class="fa fa-minus fa-lg"></i>
                  </span>
              </div>
              <div class="panel-body">
              <ul class="list-unstyled latest-users">
                <?php
                foreach ($thelatest as $user){
                echo "<li>";
                echo "<b>". $user['Username']."</b>";
                echo '<a href="members.php?do=Edit&userID='.$user['UserID'].'">';
                echo '<span class="btn btn-info text-light pull-right">';  
                echo '<i class="fa fa-edit"></i>Edit';
                echo '</span>';
                echo '</a>';
                if($user['RegStatus'] == 0){
                    echo '<a href="members.php?do=Activate&userID='.$user['UserID'].'&page=home">';
                    echo '<span class="btn btn-success text-light pull-right Confirm">';  
                    echo '<i class="fa fa-check-circle"></i> Activate';
                    echo '</span>';
                    echo '</a>';   
                }else{
                    echo '<a href="members.php?do=Deactivate&userID='.$user['UserID'].'&page=home">';
                    echo '<span class="btn btn-warning text-light pull-right Confirm">';  
                    echo '<i class="fa fa-check-circle"></i> deactivate';
                    echo '</span>';
                    echo '</a>';  
                }
                echo '</li>';
            }
                ?>
                </ul>
              </div>
         </div>
      </div>

      <div class="col-sm-6">
         <div class="panel panel-default">
              <div class="panel-heading">
                <b>  <i class="fa fa-tags"></i> Latest <?php // echo $latestItem; ?> Items</b>
                <span  class="toggle-info pull-right">
                    <i class="fa fa-minus fa-lg"></i>
                  </span>
              </div>
              <div class="panel-body">
                  
              <ul class="list-unstyled latest-users">
                <?php
                foreach ($thelatestItem as $item){
                echo "<li>";
                echo "<b>". $item['Name_item']."</b>";
                echo '<a href="items.php?do=Edit&itemid='.$item['Item_ID'].'">';
                echo '<span class="btn btn-info text-light pull-right">';  
                echo '<i class="fa fa-edit"></i>Edit';
                echo '</span>';
                echo '</a>';
                if($item['Approvable'] == 0){
                    echo '<a href="items.php?do=Approve&itemid='.$item['Item_ID'].'&d=dash">';
                    echo '<span class="btn btn-success text-light pull-right Confirm">';  
                    echo '<i class="fa fa-check-circle"></i> Approve';
                    echo '</span>';
                    echo '</a>';   
                }else{
                    echo '<a href="items.php?do=disapprove&itemid='.$item['Item_ID'].'&d=dash">';
                    echo '<span class="btn btn-warning text-light pull-right Confirm">';  
                    echo '<i class="fa fa-check-circle"></i> disapprove';
                    echo '</span>';
                    echo '</a>';  
                }
                echo '</li>';
            }
                ?>
                </ul>

              </div>
         </div>
      </div>
<!---- comments -->

   <div class="col-sm-6 mt-2 mb-5">
         <div class="panel panel-default">
              <div class="panel-heading">
                  <b><i class="fa fa-users"></i> Latest Comments </b>
                  <span  class="toggle-info pull-right">
                    <i class="fa fa-minus fa-lg"></i>
                  </span>
              </div>
              <div class="panel-body">
              <ul class="list-unstyled latest-users">
                <?php
                foreach ($latestsComments as $comment){
                   ?>

                  <div class="comments-latests row">

                    <div class="text-start text-primary">
                    
                        <?php  echo $comment['Username']; ?>
                    
                    </div>
                    <!--<div class="c_comm">-->
                        <a href="comments.php?comment=<?php echo $comment['c_id']; ?>">
                            <div class="comment">
                            <?php echo $comment['c_comment']; ?>
                            </div>
                        </a>
                    <!-- </div> -->
                  </div>

                   <?php
                  }
                ?>
                </ul>
              </div>
         </div>
   </div>

<!-- end comments --->




    </div>
  </div>
</div>
   <!-- End dashboard --> 
   <?php
    //footer
    include $temp.'footer.php'; 
}else{
        header('Location:index.php');
        exit();
}

?>