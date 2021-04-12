<?php
session_start();

$PageTitle = "Profile";

include 'init.php';

if (isset($_GET['Username'])){

    
    if((isset($_SESSION['user'])) && ($_SESSION['user'] === $_GET['Username']) ){
header('Location:profile.php');
    }


    $User_num = $_GET['Username'];


   // print_r($_SESSION);

    
$getUser = $con->prepare("SELECT * FROM users WHERE Username= ?");

$getUser->execute(array($User_num));

$infos = $getUser->fetch();

$nbrRow = $getUser->rowCount();

if($nbrRow > 0){





?>


    <div class="information block">
        <div class="container">
            <div class="card border-info">
                    <div class="card-header bg-muted"><b>My informations</b></div>
                    <div class="card-body">

                         <ul class="list-unstyled">
                            
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
                    <div class="card-header bg-muted"><b>Ads</b></div>
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


                                                    }
                                          

                                        }
                                        
                                    }
                                    ?>
                        
                        </div>
                    </div>
            </div>
        </div>
    </div>



<?php

}else{

     echo "User not found";

}


}else{

    echo "No user";

}

include $temp.'footer.php'; 

?>