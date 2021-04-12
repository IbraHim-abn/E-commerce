<?php
session_start();

$PageTitle = "Shop";

include 'init.php';

?>

<div class="container">

  <h2 class="text-center"><?php if(isset($_GET['n'])){ echo str_replace('-' ,' ', $_GET['n'])." Items";} ?></h2>
     <div class="row item-cat">
              <?php
$Items ='';
if(isset($_GET['q'])){

    $Items = getItems('Cat_ID', $_GET['q'],'Approvable');

}

        if(!empty($Items)){
            ?>
<div class="my-ads block">
        <div class="container">
            <div class="card border-info  bg-light">
                    <div class="card-body">
             
                         <div class="row items-cat ">

<?php

            foreach($Items as $item){

               ?>

                <div class="col-sm-6 col-md-4 ">
                    
                    <div class="thumbnail item-box" >
                    
                        <span class="price-tag"><?php echo $item['Price'];?></span>
                        
                        <center><img src="item.jpg" alt="" style="width:100%;height:260px"/></center>

                        <div class="caption">
                        
                            <a href="Items.php?itemid=<?php echo $item['Item_ID'];?>" >
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

                ?>

                        </div>
                    
                    </div>
       
       
               </div> 
               
           </div>
                           
        </div>

                <?php

        }else{

            ?>
     </div>
              <div class="div-cat"> 

               <center>  <span  id="empty-item"> <strong>Sorry There is no item to show 😢 </strong></span>  </center>
                
              </div>

            <?php

        }



  ?>

</div>

<?php

include $temp.'footer.php'; 

?>