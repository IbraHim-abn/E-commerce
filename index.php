<?php
session_start();

$PageTitle = "Shop";

include 'init.php';

?>


<div class="my-ads block">
        <div class="container">
            <div class="card border-info">
                    <div class="card-body">
             
                         <div class="row items-index">
                                <?php
                                $getUser = $con->prepare("SELECT * FROM items order by Cat_ID ");

                                $getUser->execute(array());
                               
                                $Items = $getUser->fetchAll();


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
                                                                <i class="fa fa-cart-arrow-down"></i> 
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


<?php

include $temp.'footer.php'; 

?>