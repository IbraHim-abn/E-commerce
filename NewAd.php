<?php
session_start();

$PageTitle = "Create new ad";

include 'init.php';

if(isset($_SESSION['user'])){

/*
**
********************************Start inserting data ***********************
**
*/



/*
**
********************************end inserting data ***********************
**
*/



/*
**
******************************** Start create new ad ***********************
**
*/


    
$getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");

$getUser->execute(array($sessionUser));

$infos = $getUser->fetch();

?>

<h2 class="text-center">Create New Ad</h2>

    <div class="information block mb-5">
        <div class="container">
            <div class="card border-info">
                    <div class="card-header bg-muted"><b>Create new Ad</b></div>
                    <div class="card-body">
<div id="showErrs">

</div>
                        <div class="row">
                            <div class="col-md-8"><!-- start  div form -->

 <form class="form-horizontal" id="formCreateNewAd">

             <!--Start name field-->
            <div class="row mb-2 p-0">
                    <label for="colFormLabel" class="col-form-label-sm col-lg-4">Name  </label> :
                    <div class="col-lg-8">
                            <input type="text" 
                                name="name" 
                                class="form-control form-control-sm w-70 live vider" 
                                id="colFormLabel" 
                                placeholder="Name of the item"
                                data-class=".live-title" />
                    </div>
            </div> 
            <!-- End name field-->
            
        <!--Start Description -->
        <div class="row mb-2">
                <label for="colFormLabel" class=" col-form-label-sm  col-lg-4">Description </label> :
                <div class="col-lg-8">
                <textarea name="description" class="form-control form-control-sm w-70 live vider" id="colFormLabel" placeholder="Describe the item from here" data-class=".live-desc" ></textarea>
            </div>
        </div>  
        <!-- End Description -->
            
            <!--Start Price -->
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-form-label-sm  col-lg-4">Price </label> :
                    <div class="col-lg-8">
                        <input  type="text"
                                name="price" 
                                class="form-control form-control-sm w-70 live vider"
                                id="colFormLabel"
                                placeholder="Price of the item"
                                data-class=".live-price" />
                   </div>
                </div>  
            <!-- End Price -->
            
            <!--Start Country -->
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-form-label-sm  col-lg-4">Country  </label> :
                    <div class="col-lg-8">
                        <input type="text"
                               name="country"
                               class="form-control form-control-sm w-70 vider"
                               id="colFormLabel"
                               placeholder="Country of Made" />
                    </div>
                </div>  
            <!-- End Country -->


            <!--Start Status -->
            <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm  col-lg-4">Status  </label> :
                <div class="col-lg-8">
                    <select 
                            name="status"
                            class="form-select form-select-sm w-70"
                            id="colFormLabel" >
                             
                               <option value="0">...</option>
                               <option value="New">New</option>
                               <option value="Like New">Like New</option>
                               <option value="Old">Old</option>
                               <option value="Very Old">Very Old</option>

                    </select>     
                </div>
            </div>  
            <!-- End Country -->

            <!--Start Category -->
            <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm  col-lg-4">Ctegory  </label> :
                <div class="col-lg-8">
                    <select name="categorie" class="form-select form-select-sm w-70" id="colFormLabel" > 
                    <option value="0">...</option>

                        <?php
                $stmt3 = $con->prepare("SELECT ID , Name  FROM  categories  ORDER BY Name ASC ");
                $stmt3->execute();
                $rows = $stmt3->fetchAll();    
                             foreach($rows as $row) {
                              ?>
            <option value="<?php echo $row['ID']; ?>"><?php echo $row['Name']; ?></option>
                              <?php
                             }
                        ?>
                    </select>     
                </div>
            </div>  
          
        
                <!--Start Btn -->
                <div class=" col-md-8 float-lg-end mt-4">
                    <input
                        readonly
                        value="Add New Item" 
                        class="btn  btn-primary btn-sm w-50" 
                        id="CreateNewAd" />
                </div>
    
                <!-- End btn -->
                
        </form>

                            
                            </div><!-- end  div form -->
                            <div class="col-md-4"><!-- start  div showitem -->
                              
                                <div class="thumbnail item-box" >
                                    <p class="price-tag">$<span class="live-price">0</span></p>
                                    <center><img src="item.jpg" alt="" style="width:90%;height:250px"/></center>
                                    <div class="caption">
                                        <a href="#" >
                                            <h3 class="live-title">Name of the item</h3>
                                        </a>
                                        <p class="live-desc">Description</p>
                                    </div>
                                </div>

                             </div><!-- end  div showitem -->
                        </div>

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