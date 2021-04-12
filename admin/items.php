<?php


/*
===================================================================
=                        Items Page
=               you can add | Edit | Delete Item
===================================================================
*/
session_start();

$PageTitle="Items";

if(isset($_SESSION['Username'])){

    include 'init.php';
 
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

/*
===================================================================
=                     Start Manage items
===================================================================
*/
if($do == 'Manage'){
    
$where = " where 1 = 1 ";

    if(isset($_POST['Name'])){

$where = "where Name_item = '".$_POST['Name']."'";


    }

        //select all users expect admins
       $stmt = $con->prepare("SELECT * FROM items  
       inner join categories on(items.Cat_ID = categories.ID)
       inner join users on(items.Member_ID = users.UserID)  
       $where
       ") ;  
      
       //execute
      
       $stmt->execute();
      
       //Assign to variables
      
       $rows = $stmt->fetchAll();
      
       $nbr_row = $stmt->rowCount();
      
      if($nbr_row > 0){
      
      ?> 
      
        <h2 class='text-center'><i class="fa fa-tags" ></i> Manage items</h2> 
      <div class='p-3 pt-0'>
     <a class='btn btn-primary btn-md  fw-bolder btn-sm' href='items.php?do=add'><i class='fa fa-user-plus'></i> New Item</a>
    
      <form class="d-flex p-1 w-50" method="post" action="items.php">
        <input name="Name" class="form-control me-2" type="search" placeholder="Search with name item" aria-label="Search">
        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
      </form>
 <?php
if(isset($_GET['q'])){
    if($_GET['q'] == "req"){
        echo "<strong class='text-danger p-1' >this item is not exist !</strong>";
    }
}
 ?>
        <div class='table-responsive'>
             <table  class='table table-bordered text-center '>
               <tr class="bg-dark text-light ">
                  <td class="fw-bolder">#ID</td>
                  <td class="fw-bolder">Name</td>
                  <td class="fw-bolder">Description</td>
                  <td class="fw-bolder">Price</td>
                  <td class="fw-bolder">Category</td>
                  <td class="fw-bolder">Added By</td>
                  <td class="fw-bolder">Adding Date</td>
                  <td class="fw-bolder">Country</td>
                  <td class="fw-bolder">Control</td>
               </tr>
             
                    <?php 
                    foreach($rows as $row){
                      echo "<tr><td class='bg-light'>".$row['Item_ID']."</td>";
                      echo "<td class='bg-light'>".$row['Name_item']."</td>";
                      echo "<td class='bg-light'>".$row['Description_item']."</td>";
                      echo "<td class='bg-light'>".$row['Price']."</td>";
                      echo "<td class='bg-light'>".$row['Name']."</td>";
                      echo "<td class='bg-light'>".$row['Username']."</td>";
                      echo "<td class='bg-light'>".$row['Ads_Date']."</td>";
                      echo "<td class='bg-light'>".$row['Country_Made']."</td>";

                      echo "<td class='bg-light'>";
                      echo " 
                      <a class='btn btn-info btn-sm text-light' href='?do=Edit&itemid=".$row['Item_ID']."'>
                      <i class='fa fa-edit'></i> Edit</a>
                      <a class='btn btn-danger btn-sm Confirm' href='?do=Delete&itemid=".$row['Item_ID']."'>
                      <i class='fa fa-close'></i> Delete</a> ";
                     
                      if($row['Approvable'] == 0){
                    echo " <a class='btn btn-success text-light btn-sm Confirm' href='?do=Approve&itemid=".$row['Item_ID']."'><i class='fa fa-check-circle'></i> Approve</a> ";
                         }else{
                    echo " <a class='btn btn-warning text-light btn-sm Confirm' href='?do=disapprove&itemid=".$row['Item_ID']."'><i class='fa fa-ban'></i> disapprove</a> ";
                             }
                         

  echo " <a class='btn btn-primary text-light btn-sm ' href='comments.php?item=".$row['Item_ID']."'><i class='fa fa-comments-o'></i> Comments</a> ";


                      echo "</td></tr>";
      
                    }
                    ?>
             
             </table>
          </div>
          <div class="col-lg-4 col-md-6"> 
            <?php 
             //ici buttom add item
             ?>
          </div>
        </div>
        <?php
      }else{

        if(isset($_POST['Name'])){
           
             header('Location:items.php?q=req');

                }else{

         echo "<h2 class='text-center'>Items is Empty</h2>";
        echo "<center><a class='btn btn-primary btn-md m-2 fw-bolder btn-sm' href='items.php?do=add'><i class='fa fa-user-plus'></i> New Item</a></center>";
         

                }
         
      }








}

/*
===================================================================
=                        End Manage item
===================================================================
*/
/*
===================================================================
=                        Start ADD item
===================================================================
*/
elseif($do == 'add'){


    ?>




    <h2 class="text-center text-muted"> Add New Item </h2>
    <div class="container">
    
    
    <center>
        <form class="form-horizontal col-md-6 col-lg-6" id="Form-Edit" action="?do=insert" method="POST">
            <!--Start name field-->
            <div class="row mb-2 p-0">
                    <label for="colFormLabel" class=" col-form-label-sm text-start col-lg-4">Name * : </label>
                    <div class="col-lg-8">
                            <input type="text" 
                                name="name" 
                                class="form-control form-control-sm w-70" 
                                id="colFormLabel" 
                                placeholder="Name of the item" />
                    </div>
            </div> 
            <!-- End name field-->
            
        <!--Start Description -->
        <div class="row mb-2">
                <label for="colFormLabel" class=" col-form-label-sm text-start col-lg-4">Description : </label>
                <div class="col-lg-8">
                <textarea name="description" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="Describe the item from here" ></textarea>
            </div>
        </div>  
        <!-- End Description -->
            
            <!--Start Price -->
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Price : </label>
                    <div class="col-lg-8">
                        <input  type="text"
                                name="price" 
                                class="form-control form-control-sm w-70"
                                id="colFormLabel"
                                placeholder="Price of the item" />
                   </div>
                </div>  
            <!-- End Price -->
            
            <!--Start Country -->
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Country : </label>
                    <div class="col-lg-8">
                        <input type="text"
                               name="country"
                               class="form-control form-control-sm w-70"
                               id="colFormLabel"
                               placeholder="Country of Made" />
                    </div>
                </div>  
            <!-- End Country -->


            <!--Start Status -->
            <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Status : </label>
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

            
            <!--Start Member -->
            <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Member : </label>
                <div class="col-lg-8">
                    <select name="member" class="form-select form-select-sm w-70" id="colFormLabel" > 
                    <option value="0">...</option>

                        <?php
                $stmt3 = $con->prepare("SELECT Username , UserID  FROM  users WHERE GrouID != 1 ORDER BY Username ASC ");
                $stmt3->execute();
                $rows = $stmt3->fetchAll();    
                             foreach($rows as $row) {
                              ?>
        <option value="<?php echo $row['UserID']; ?>"><?php echo $row['Username']; ?></option>
                              <?php
                             }
                        ?>
                    </select>     
                </div>
            </div>  
            <!-- End Member -->

            <!--Start Category -->
            <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Ctegory : </label>
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
            <!-- End Member -->
            
        
                <!--Start Btn -->
                <div class="col-lg-9 col-md-9 col-sm-12 float-lg-end float-sm-none m-1">
                    <input
                     style="margin-left: 16px;"
                     type="submit" 
                     name="submit" 
                     value="Add New Item" 
                     class="btn  btn-primary btn-sm w-75" 
                     id="colFormLabel" >
                </div>
    
                <!-- End btn -->
                
        </form>
        
    </center>
    
    </div>
    
    
    
    <?php


}

/*
===================================================================
=                        End Add item
===================================================================
*/

/*
===================================================================
=                        Start insert item
===================================================================
*/
elseif($do == 'insert'){



    echo "<div class='container text-center  mt-5'>";

    if( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    

    //Get variables

    $name      = $_POST['name'];
    $desc      = $_POST['description'];
    $price     = $_POST['price']."$";
    $country   = $_POST['country'];
    $status    = $_POST['status'];
    $member    = $_POST['member'];
    $categorie = $_POST['categorie'];
 



//check if the Name of category is not empty

if(!empty($name)){

if($status == "0"){

    echo " <center>";
    echo " <div class='alert alert-danger col-lg-6'>";
    echo " <strong>You Must choose the status</strong><br>";
    echo "You will redirected to edit it after 3 seconds ! &nbsp;<div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>";
    echo " </div>";
    echo "</center> ";
    if(isset($_SERVER['HTTP_REFERER'])){

        $link = $_SERVER['HTTP_REFERER'];

        header('refresh:3;url='.$link.''); 

    }else{

    header('refresh:3;url=items.php?do=add'); 

    }
}else{
    if($member == 0){

        echo " <center>";
    echo " <div class='alert alert-danger col-lg-6'>";
    echo " <strong>You Must choose a member </strong><br>";
    echo "You will redirected to edit it after 3 seconds ! &nbsp;<div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>";
    echo " </div>";
    echo "</center> ";
    if(isset($_SERVER['HTTP_REFERER'])){

        $link = $_SERVER['HTTP_REFERER'];

        header('refresh:3;url='.$link.''); 

    }else{

    header('refresh:3;url=items.php?do=add'); 

    }

    }else{

        if($categorie == 0){

            echo " <center>";
    echo " <div class='alert alert-danger col-lg-6'>";
    echo " <strong>You Must be choose category</strong><br>";
    echo "You will redirected to edit it after 3 seconds ! &nbsp;<div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>";
    echo " </div>";
    echo "</center> ";
    if(isset($_SERVER['HTTP_REFERER'])){

        $link = $_SERVER['HTTP_REFERER'];

        header('refresh:3;url='.$link.''); 

    }else{

    header('refresh:3;url=items.php?do=add'); 

    }

        }else{

//Insert category info into database

$sql  = "INSERT INTO items 
(Name_Item , Description_item , Price , Ads_Date , Country_Made , Status , Member_ID , Cat_ID , Approvable)
VALUES (?,?,?,now(),?,?,?,?,1)";

$stmt = $con->prepare($sql);

$stmt->execute(array($name,$desc,$price,$country,$status,$member,$categorie));

$nbrRow = $stmt->rowCount();
if($nbrRow > 0){
echo " <center>";
echo " <div class='alert alert-success col-lg-6'>";
echo " <strong>$nbrRow Record Inserted</strong>&nbsp;";
echo "</div>";
echo " <div class='alert alert-info col-lg-6'>";
echo "You will redirected to items page after 3 seconds ! &nbsp;<div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>";
echo " </div>";
echo "</center> ";
header('refresh:3;url=items.php');
}


        }
    }


}

}else{

    echo " <center>";
    echo " <div class='alert alert-danger col-lg-6'>";
    echo " <strong>Sorry Name of the item can't be empty</strong><br>";
    echo "You will redirected after 3 seconds ! &nbsp;<div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>";
    echo " </div>";
    echo "</center> ";
    header('refresh:3;url=items.php?do=add'); 

}



    }else{
        echo " <center>";
        echo " <div class='alert alert-danger col-lg-6'>";
        echo " <strong>Sorry you cant browse this page directly</strong><br>";
        echo "You will redirected after 3 seconds ! &nbsp;<div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>";
        echo " </div>";
        echo "</center> ";
        header('refresh:3;items.php'); 
    }

    echo "</div>";





}

/*
===================================================================
=                        end insert item
===================================================================
*/

/*
===================================================================
=                        Start edit item
===================================================================
*/
elseif($do == 'Edit'){


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

    //get numRows

$NbrRow = $stmt->rowCount();

    //if $NbrRow > 0 then the database contain a record with this username and password 

if($NbrRow>0){

    $Categ_code = $rows['Cat_ID'];
      $Categ_name = $rows['Name'];

       ?>
 
 <h2 class="text-center text-muted"> <i class="fa fa-edit"></i> Edit Item </h2>
    <div class="container">
    
    
    <center>
        <form class="form-horizontal col-md-6 col-lg-6" id="Form-Edit" action="?do=update&itemid=<?php echo $Item ?>" method="POST">
            <!--Start name field-->
            <div class="row mb-2 p-0">
                    <label for="colFormLabel" class=" col-form-label-sm text-start col-lg-4">Name * : </label>
                    <div class="col-lg-8">
                            <input type="text" 
                                name="name" 
                                class="form-control form-control-sm w-70" 
                                id="colFormLabel" 
                                value ="<?php echo $rows['Name_item']; ?>"
                                 />
                    </div>
            </div> 
            <!-- End name field-->
            
        <!--Start Description -->
        <div class="row mb-2">
                <label for="colFormLabel" class=" col-form-label-sm text-start col-lg-4">Description : </label>
                <div class="col-lg-8">
<textarea name="description" class="form-control form-control-sm w-70">
<?php echo "".$rows['Description_item']; ?>
</textarea>
            </div>
        </div>  
        <!-- End Description -->
            
            <!--Start Price -->
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Price : </label>
                    <div class="col-lg-8">
                        <input  type="text"
                                name="price" 
                                class="form-control form-control-sm w-70"
                                id="colFormLabel"
                                placeholder="Price of the item"
                                value ="<?php echo $rows['Price']; ?>" />
                   </div>
                </div>  
            <!-- End Price -->
            
            <!--Start Country -->
                <div class="row mb-2">
                    <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Country : </label>
                    <div class="col-lg-8">
                        <input type="text"
                               name="country"
                               class="form-control form-control-sm w-70"
                               id="colFormLabel"
                               placeholder="Country of Made"
                               value ="<?php echo $rows['Country_Made']; ?>" />
                    </div>
                </div>  
            <!-- End Country -->


            <!--Start Status -->
            <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Status : </label>
                <div class="col-lg-8">
                    <select 
                            name="status"
                            class="form-select form-select-sm w-70"
                            id="colFormLabel" >
                               <option value="<?php echo $rows['Status']; ?>"><?php echo $rows['Status']; ?></option>
                               <?php
                               
                                if($rows['Status'] != "New"){
                                    echo '<option value="New">New</option>';
                                }

                                if($rows['Status'] != "Like New"){
                                    echo '<option value="Like New">Like New</option>';
                                }

                                if($rows['Status'] != "Old"){
                                    echo '<option value="Old">Old</option>';
                                }

                                if($rows['Status'] != "Very Old"){
                                    echo '<option value="Very Old">Very Old</option>';
                                }

                               ?>
                               
                               
                               
                               
                    </select>     
                </div>
            </div>  
            <!-- End Country -->

            
            <!--Start Member -->
            <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Member : </label>
                <div class="col-lg-8">
                    <select name="member" class="form-select form-select-sm w-70" id="colFormLabel" > 
                    <option value="<?php echo $rows['UserID']; ?>"><?php echo $rows['Username']; ?></option>

                        <?php
                $stmt3 = $con->prepare("SELECT Username , UserID  FROM  users WHERE GrouID != 1 and UserID != ? ORDER BY Username ASC ");
                $stmt3->execute(array($rows['UserID']));
                $rows = $stmt3->fetchAll();    
                             foreach($rows as $row) {
                              ?>
        <option value="<?php echo $row['UserID']; ?>"><?php echo $row['Username']; ?></option>
                              <?php
                             }
                        ?>
                    </select>     
                </div>
            </div>  
            <!-- End Member -->

            <!--Start Category -->
            <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Ctegory : </label>
                <div class="col-lg-8">
                    <select name="categorie" class="form-select form-select-sm w-70" id="colFormLabel" > 
                    <option value="<?php echo $Categ_code; ?>"><?php echo $Categ_name; ?></option>

                        <?php
                $stmt3 = $con->prepare("SELECT ID , Name  FROM  categories WHERE ID != ?  ORDER BY Name ASC ");
                $stmt3->execute(array($Categ_code));
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
            <!-- End Member -->
            
        
                <!--Start Btn -->
                <div class="col-lg-9 col-md-9 col-sm-12 float-lg-end float-sm-none m-1">
                    <input
                     style="margin-left: 16px;"
                     type="submit" 
                     name="submit" 
                     value="Update" 
                     class="btn  btn-primary btn-sm w-75" 
                     id="colFormLabel" >
                </div>
    
                <!-- End btn -->
                
        </form>
        
    </center>

</div>
<?php

                                                
}else{
    ?>
<div class="mt-5 container alert alert-danger text-center"><strong>Err 404 : not found Item</strong></div>
    <?php
}



}

/*
===================================================================
=                        end insert item
===================================================================
*/

/*
===================================================================
=                        Start update item
===================================================================
*/

elseif($do == 'update'){


//check if the user is coming from edit page and HTTP REQUEST IS POST

if( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    //Get variables from the form
    $itemId    = $_GET['itemid']; 
    $name      = $_POST['name'];
    $desc      = $_POST['description'];
    $price     = $_POST['price'];
    $country   = $_POST['country'];
    $status    = $_POST['status'];
    $member    = $_POST['member'];
    $categorie = $_POST['categorie'];


//echo $name ."<br>". $desc ."<br>". $price ."<br>". $country ."<br>". $status ."<br>". $member ."<br>". $categorie ;

 //sql statement

 $stmt = $con->prepare(" UPDATE items SET 
 Name_item           = ? ,
 Description_item    = ? ,
 Price               = ? ,
 Country_Made        = ? ,
 Status              = ? ,
 Cat_ID              = ? ,
 Member_ID           = ? 
                         WHERE Item_ID = ? ");

//EXECUTE

$stmt->execute(array($name ,$desc ,$price ,$country ,$status,$categorie,$member,$itemId));

$nbrRow =  $stmt->rowCount();

echo "<center>";
echo "<div class='alert alert-success col-lg-6 mt-5'>";
echo $nbrRow." Record(s) <strong>Updated </strong> ";
echo "</div>";
/*echo "<div class='alert alert-info col-lg-6 '>";
echo "You will be redirected to categories page after 3 seconds <div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>";
echo "</div>";
*/
echo "</center>";

header('refresh:2;url=items.php');

}


}

/*
===================================================================
=                        end update item
===================================================================
*/

/*
===================================================================
=                        Start Delete item
===================================================================
*/

elseif($do == 'Delete'){

    //check if the userID is valid & numiric and get iteger value (itval) of it 
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
   
    //search in database  if this userID exist
    $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ? ");
   
    //execute
    $stmt->execute(array($itemid));
   
   
    //get numRows
    $NbrRow = $stmt->rowCount();
   
   
    if($NbrRow>0){
   
   $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = ? ");
   
   $stmt->execute(array($itemid));
   
    header('Location:items.php');
  
   } else{
   
   echo "<center><div style='background-color:#ffabb3 ; box-shadow: 0px 0px 15px red; ' class='m-5 col-lg-6 col-md-6 col-sm-12 text-muted p-4 rounded'><b>UserID not found! <a href='members.php' >Retour</a></b></div></center>";
     
       } 

}


/*
===================================================================
=                        end delete item
===================================================================
*/

/*
===================================================================
=                        start approve item
===================================================================
*/

elseif($do == 'Approve'){



    //check if the userID is valid & numiric and get iteger value (itval) of it 
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
   
    //search in database  if this userID exist
    $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ? ");
   
    //execute
    $stmt->execute(array($itemid));
   
   
    //get numRows
    $NbrRow = $stmt->rowCount();
   
   
    if($NbrRow>0){
   
   $stmt = $con->prepare("UPDATE items set Approvable = 1 WHERE Item_ID = ? ");
   
   $stmt->execute(array($itemid));
            
            if(isset($_GET['d']) && $_GET['d'] == "dash"){

                header('Location:dashboard.php');

            }else{
                
                header('Location:items.php');

                }
  
   } else{
   
   echo "<center><div style='background-color:#ffabb3 ; box-shadow: 0px 0px 15px red; ' class='m-5 col-lg-6 col-md-6 col-sm-12 text-muted p-4 rounded'><b>UserID not found! <a href='members.php' >Retour</a></b></div></center>";
     
       } 



}

/*
===================================================================
=                        end approve item
===================================================================
*/

/*
===================================================================
=                        start disapprove item
===================================================================
*/

elseif($do == 'disapprove'){





    //check if the userID is valid & numiric and get iteger value (itval) of it 
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
   
    //search in database  if this userID exist
    $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ? ");
   
    //execute
    $stmt->execute(array($itemid));
   
   
    //get numRows
    $NbrRow = $stmt->rowCount();
   
   
    if($NbrRow>0){
   
   $stmt = $con->prepare("UPDATE items set Approvable = 0 WHERE Item_ID = ? ");
   
   $stmt->execute(array($itemid));

   if(isset($_GET['d']) && $_GET['d'] == "dash"){
                header('Location:dashboard.php');

            }else{
                header('Location:items.php');
                 }
  
   } else{
   
   echo "<center><div style='background-color:#ffabb3 ; box-shadow: 0px 0px 15px red; ' class='m-5 col-lg-6 col-md-6 col-sm-12 text-muted p-4 rounded'><b>UserID not found! <a href='members.php' >Retour</a></b></div></center>";
     
       } 


}

/*
===================================================================
=                        end dispprove item
===================================================================
*/

//footer
include $temp.'footer.php'; 
}else{
    header('Location:index.php');
}
?>
