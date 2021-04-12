<?php
session_start();

$PageTitle = "Profile";

include 'init.php';

if(isset($_SESSION['user'])){

   // print_r($_SESSION);

    
$getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");

$getUser->execute(array($sessionUser));

$infos = $getUser->fetch();

?>

<!--<h2 class="text-center text-success">My Profile</h2>-->

    <div class="information block">
        <div class="container">
            <div class="card border-info">
                    <div class="card-header bg-muted"><b>My informations</b></div>
                    <div class="card-body">

                         <ul class="list-unstyled">
                            <li>
                                 <i class="fa fa-unlock-alt fa-fw"></i>
                                 <span>UserName</span> : <?php echo $infos['Username'];  ?>
                            </li>
                            <li>
                                 <i class="fa fa-envelope-o fa-fw"></i>
                                 <span>Email</span> : <?php echo $infos['Email'];  ?>
                            </li>
                            <li>
                                 <i class="fa fa-user fa-fw"></i>
                                 <span>Full Name</span> : <?php echo $infos['FullName'];  ?>
                            </li>
                            <li>
                                 <i class="fa fa-calendar fa-fw"></i>
                                 <span>Registered Date</span> : <?php echo $infos['Date'];  ?>
                            </li>
                            <li>
                                 <i class="fa fa-tags fa-fw"></i>
                                 <span>Fav Category</span> :
                            </li>
                        </ul>

                    </div>
            </div>
        </div>
    </div>


    <div class="my-ads block">
        <div class="container">
            <div class="card border-info">
                    <div class="card-header bg-muted"><b>My Ads</b></div>
                    <div class="card-body">
                   
                         <div class="row profile-items">
                                <?php
                                $Items = getItems('Member_ID', $infos['UserID'],"Approvable");


                                if(!empty($Items)){
                                    foreach($Items as $item){

                                                    if($item['Approvable'] == 1 ){


                                                        ?>
                                                    <div class="col-sm-6 col-md-4">
                                                        <div class="thumbnail item-box" >
                                                            <span class="price-tag"><?php echo $item['Price'];?></span>
                                                            <center><img src="item.jpg" alt="" style="width:100%;height:200px"/></center>
                                                            <div class="caption">
                                                                <a href="Items.php?itemid=<?php echo $item['Item_ID'];?> ">
                                                                    <h3><?php echo $item['Name_item'];?></h3>
                                                                </a>
                                                                <p><?php echo $item['Description_item'];?></p>
                                                                <div class="date">
                                                                  <?php echo $item['Ads_Date']; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                <?php


                                                    }else{

                                                        echo' <div class="alert alert-warning mt-2"> ';
                                                            echo "<strong>The item [ <span class='text-primary'>".$item['Name_item']."</span> ] is not yet aprovable  😢 </strong>" ;
                                                        echo' </div>'; 
                                                        }
                                          

                                        }
                                        
                                    }else{
                                    ?>
                        
                                    <div class="alert alert-warning"> 
                                    <strong>Sorry There is no item 😢 </strong><b> <a href="NewAd.php" >New ad <i class="fa fa-plus"></i> </a></b>
                                    </div>
                                    <?php
                                }


                                ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>




    <div class="my-comments mb-3 block">
        <div class="container">
            <div class="card border-info">
                    <div class="card-header bg-muted"><b>Latest 3 comments </b></div>
                    <div class="card-body">


                    <!-- show comments -->
    <?php
          
          $stmt3 = $con->prepare("SELECT * FROM comments inner join
          users on (comments.c_member = users.UserID)
          inner join
          items on (items.Item_ID = comments.c_item)
           WHERE   comments.c_status = 1  and Username = ? order by c_id desc limit 3");
          $stmt3->execute(array($sessionUser));
          $AllComments = $stmt3->fetchAll();
          foreach($AllComments as $Comm_ent){
             
            ?>
                <div class="row show-comments mb-4">
                
                <span class="text-primary"> for :

                     <a href="Items.php?itemid=<?php echo $Comm_ent['c_item'];?>">
                         <b><?php echo $Comm_ent['Name_item'];?> </b>
                     </a>   
                </span>
                    <div class="item-comments bg-light">
                        <?php 
                            echo $Comm_ent['c_comment'];
                        ?>
                    </div>
                    <div class="date">
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

                    
                    </div>
            </div>
        </div>
    </div>

<?php

}else{

    header('Location:login.php');

}
include $temp.'footer.php'; 

?>