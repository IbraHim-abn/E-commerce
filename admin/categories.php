<?php


/*===================================================================
= Category Page
= you can add | Edit | Delete category
===================================================================*/
session_start();

$PageTitle="Categories";

if(isset($_SESSION['Username'])){

    include 'init.php';

   echo  '<div class="CtaegoriesPage">'; 

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


if($do == 'Manage'){

    $sort = 'ASC';   

    $sort_array = array('ASC','DESC');

    if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){

        $sort = $_GET['sort'];
    }

/*******************************************************************************************************************************
**************************************************** Start Category page *********************************************************
********************************************************************************************************************************/
$statm = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");

$statm->execute();

$nbrRow = $statm->rowCount();

$cats   = $statm->fetchAll(); ?>
<h2 class="text-center"><i class="fa fa-edit" ></i> Manage categories</h2>

 <div class="container categories">

 <a href="?do=Add" class="btn btn-primary text-light mb-2 btn-sm"><b>Add Category <i class="fa fa-plus" ></i></b></a>

    <div class="panel panel-default">
        <div class="panel-heading"><b><i class="fa fa-edit"></i> Manage Categories</b>
           <div class="pull-right options">
              <i class="fa fa-sort"></i> Ordering : 
              [ <a class="<?php if($sort =='ASC'){echo 'order-active';} ?>" href="?sort=ASC">Asc</a> |
               <a class="<?php if($sort =='DESC'){echo 'order-active';} ?>" href="?sort=DESC">Desc</a> ]
               &nbsp; &nbsp; <i class="fa fa-eye"></i> View :
              [
                <span data-view="full" class="order-active" >Full</span> |
                <span data-view="classic" >Classic</span>

                ]          
            </div>  
        </div>
        <div class="panel-body">
            <?php

              foreach ($cats as $cat) {

echo "<div class='cat'>";

            echo "<h4>";
                echo $cat['Name'];               
            echo "</h4>";

echo " <div class='full-view'> ";
                        echo "<p>";
                            if($cat['Description'] == ''){
                                echo 'The description is empty !';
                            }else{
                                echo $cat['Description'];
                            }
                        echo "</p>";


             echo "<span class='btn btn-sm text-center visibility'>";
                if($cat['Visibility'] == 0){
                    echo '<i class="fa fa-check"></i>  visible  ';
                }else{
                    echo "<i class='fa fa-ban'></i>  Hidden   ";
                }
             echo "</span>"; 


                            echo "<span class='btn btn-sm text-center commenting'>";
                                if($cat['Allow_comments'] == 0 ){
                                    echo "<i class='fa fa-comments-o'></i> Comments allowed  ";
                                }else{
                                    echo "<i class='fa fa-ban'></i> Comments not allowed  ";
                                }
                            echo "</span>"; 


             echo "<span class='btn btn-sm text-center advertises'>";
                if($cat['Allow_ads'] == 0){
                    echo "<i class='fa fa-check'></i> ads allowed  ";
                }else{
                    echo "<i class='fa fa-ban'></i>  ads not allowed  ";
                }
            echo "</span>";

echo "<div class='pull-right'>";

            echo '<a href="?do=Delete&Categ='.$cat['ID'].'" class="btn btn-danger btn-sm text-light pull-right Confirm">';  
            echo '<i class="fa fa-close"></i>Delete';
            echo '</a>';


            echo '<a href="?do=Edit&Categ='.$cat['ID'].'" class="btn btn-info btn-sm text-light pull-right">';  
                echo '<i class="fa fa-edit"></i>Edit';
                echo '</a>';
echo "</div>";

           
           echo "</div>";//end div full-view

          
           
echo "</div>";//end div cat
            }

if($nbrRow < 1){

    echo "<h3 class='text-center text-muted'>Empty</h3>";
}
            ?>
        </div>
    </div>
</div>

<?php




/*******************************************************************************************************************************
**************************************************** End Category page *********************************************************
********************************************************************************************************************************/


}elseif($do == 'Add'){ 

/*******************************************************************************************************************************
**************************************************** Start Add Category *********************************************************
********************************************************************************************************************************/
?>




<h2 class="text-center text-muted"> New Categoey <i class="fa fa-plus" ></i></h2>
<div class="container">


<center>
    <form class="form-horizontal col-md-6 col-lg-6" id="Form-Edit" action="?do=insert" method="POST">
        <!--Start name field-->
        <div class="row mb-2 p-0">
                <label for="colFormLabel" class=" col-form-label-sm text-start col-lg-4">Name * : </label>
                <div class="col-lg-8">
                <input type="text" value="" name="name" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="Name of the Category" autocomplete="new-password">
            </div>
        </div> 
        <!-- End name field-->
        
        <!--Start Description -->
            <div class="row mb-2">
                <label for="colFormLabel" class=" col-form-label-sm text-start col-lg-4">Description : </label>
                <div class="col-lg-8">
                <textarea name="description" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="Describe the category from here" ></textarea>
            </div>
        </div>  
        <!-- End Description -->
        
        <!--Start Ordering -->
            <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Ordering : </label>
                <div class="col-lg-8">
                <input type="text"  name="ordering" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="Number To Arrange The Categorie">
            </div>
        </div>  
        <!-- End Ordering -->
        
        <!--Start visibility field-->
        <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Visible : </label>
                <div class="col-lg-8">
                <div class="text-start">
                    <input id="vis-yes" type="radio" name="visibility" value="0" checked />
                    <label for="vis-yes">Yes</label> &nbsp;
                    <input id="vis-no" type="radio" name="visibility"  value="1" />
                    <label for="vis-no">No</label>
                </div>
                <div>
                
                </div>
                </div>
        </div>  
        <!-- End visibility field -->

        <!--Start allow commentng field -->

        <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Allow Commenting : </label>
                <div class="col-lg-8">
                <div class="text-start">
                    <input id="com-yes" type="radio" name="comments" value="0"  checked />
                    <label for="com-yes">Yes</label> &nbsp;
                    <input id="com-no" type="radio" name="comments" value="1" />
                    <label for="com-no">No</label>
                </div>
                <div>
                
                </div>
                </div>
        </div>  

        <!-- end allow commenting field -->

        
        <!--Start allow Ads field -->

        <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Allow Ads :</label>
                    <div class="col-lg-8">
                        <div class="text-start">
                            <input id="ads-yes" type="radio" name="ads" value="0"  checked />
                            <label for="ads-yes">Yes</label> &nbsp;
                            <input id="ads-no" type="radio" name="ads" value="1" />
                            <label for="ads-no">No</label>
                        </div>
                    <div>
                </div>
            </div>
        </div> 

        <!-- end allow Ads field -->
    
            <!--Start Btn -->
            <div class="col-lg-9 col-md-9 col-sm-12 float-lg-end float-sm-none m-1">
                <input type="submit" name="submit" value="Add Category" class="btn btn-primary btn-sm w-75" id="colFormLabel" placeholder="">
            </div>

            <!-- End btn -->
            
    </form>
    
</center>

</div>



<?php
/*******************************************************************************************************************************
**************************************************** End Add Category *********************************************************
********************************************************************************************************************************/


}elseif($do == 'insert'){

/*******************************************************************************************************************************
**************************************************** Start Insert Category *********************************************************
********************************************************************************************************************************/

    echo "<div class='container text-center  mt-5'>";

    if( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    

    //Get variables

    $name      = $_POST['name'];
    $desc      = $_POST['description'];
    $order     = $_POST['ordering'];
    $visible   = $_POST['visibility'];
    $comments  = $_POST['comments'];
    $ads       = $_POST['ads'];

//check if the Name of category is not empty

if(!empty($name)){


//Check if the name of this categoery is exist or not

    $check = check_item("Name","categories",$name);

    if($check == 1){

        echo " <center>";
        echo " <div class='alert alert-danger col-lg-6'>";
        echo " <strong>Sorry this category is already exist </strong><br>";
        echo " </div>";
        echo " <div class='alert alert-info col-lg-6'>";
        echo "You will redirected to change it after 3 seconds ! &nbsp;<div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>";
        echo " </div>";
        echo "</center> ";
        header('refresh:3;categories.php?do=Add'); 

    }else{

//Insert category info into database

$sql  = "INSERT INTO categories 
(Name , Description , Ordering , Visibility , Allow_comments , Allow_ads)
VALUES (?,?,?,?,?,?)";

$stmt = $con->prepare($sql);

$stmt->execute(array($name,$desc,intval($order),$visible,$comments,$ads));

$nbrRow = $stmt->rowCount();
if($nbrRow > 0){
echo " <center>";
echo " <div class='alert alert-success col-lg-6'>";
echo " <strong>$nbrRow Record Inserted</strong>&nbsp;";
echo "</div>";
echo " <div class='alert alert-info col-lg-6'>";
echo "You will redirected after 3 seconds ! &nbsp;<div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>";
echo " </div>";
echo "</center> ";
header('refresh:3;categories.php?');
}
    }



}else{

    echo " <center>";
    echo " <div class='alert alert-danger col-lg-6'>";
    echo " <strong>Sorry Name of the category cant be empty</strong><br>";
    echo "You will redirected after 3 seconds ! &nbsp;<div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>";
    echo " </div>";
    echo "</center> ";
    header('refresh:3;categories.php?do=Add'); 

}



    }else{
        echo " <center>";
        echo " <div class='alert alert-danger col-lg-6'>";
        echo " <strong>Sorry you cant browse this page directly</strong><br>";
        echo "You will redirected after 3 seconds ! &nbsp;<div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>";
        echo " </div>";
        echo "</center> ";
        header('refresh:3;categories.php'); 
    }

    echo "</div>";


/*******************************************************************************************************************************
**************************************************** End Insert Category *********************************************************
********************************************************************************************************************************/

}elseif($do == 'Edit'){

/*******************************************************************************************************************************
**************************************************** Start Edit Category *********************************************************
********************************************************************************************************************************/

 //check if the userID is valid & numiric and get iteger value (itval) of it 

 $id = isset($_GET['Categ']) && is_numeric($_GET['Categ']) ? intval($_GET['Categ']) : 0 ;

 //search in database  if this userID exist

 $stmt = $con->prepare("SELECT  ID , Name , Description , Ordering , Visibility , Allow_comments ,Allow_ads FROM categories WHERE ID = ?");

 //execute

 $stmt->execute(array($id));

 //fetch

 $rows = $stmt->fetch();

 //get numRows

 $NbrRow = $stmt->rowCount();

 //if $NbrRow > 0 then the database contain a record with this username and password 


 if($NbrRow>0){//id found
?>


<h2 class="text-center text-muted"><i class="fa fa-edit" ></i> Edit Category </h2>
<div class="container">


<center>
    <form class="form-horizontal col-md-6 col-lg-6" id="Form-Edit" action="?do=update" method="POST">
        <!--Start name field-->
        <input type="hidden" name="id" value="<?php echo $rows['ID']; ?>" />
        <div class="row mb-2 p-0">
                <label for="colFormLabel" class=" col-form-label-sm text-start col-lg-4">Name * : </label>
                <div class="col-lg-8">
                <input type="text" value="<?php echo $rows['Name']; ?>" name="name" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="Name of the Category" autocomplete="new-password">
                <input type="hidden" value="<?php echo $rows['Name']; ?>" name="Oldname" />
            </div>
        </div> 
        <!-- End name field-->
        
        <!--Start Description -->
            <div class="row mb-2">
                <label for="colFormLabel" class=" col-form-label-sm text-start col-lg-4">Description : </label>
                <div class="col-lg-8">
                <textarea name="description"  class="form-control form-control-sm w-70" id="colFormLabel" placeholder="Describe the category from here" ><?php echo $rows['Description']; ?></textarea>
            </div>
        </div>  
        <!-- End Description -->
        
        <!--Start Ordering -->
            <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Ordering : </label>
                <div class="col-lg-8">
                <input type="text" value="<?php  echo $rows['Ordering']; ?>"  name="ordering" class="form-control form-control-sm w-70" id="colFormLabel" placeholder="Number To Arrange The Categorie">
            </div>
        </div>  
        <!-- End Ordering -->
        
        <!--Start visibility field-->
        <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Visible : </label>
                <div class="col-lg-8">
                <div class="text-start">
                    <?php 
                    if($rows['Visibility'] == 0){
                      ?>
                    
                    <input id="vis-yes" type="radio" name="visibility" value="0" checked />
                    <label for="vis-yes">Yes</label> &nbsp;
                    <input id="vis-no" type="radio" name="visibility"  value="1" />
                    <label for="vis-no">No</label>
                      
                      <?php
                    }else{
                     ?>
                      
                        <input id="vis-yes" type="radio" name="visibility" value="0"  />
                        <label for="vis-yes">Yes</label> &nbsp;
                        <input id="vis-no" type="radio" name="visibility"  value="1" checked />
                        <label for="vis-no">No</label>
                          
                     <?php
                    }
                    ?>
                   
                </div>
                <div>
                
                </div>
                </div>
        </div>  
        <!-- End visibility field -->

        <!--Start allow commentng field -->

        <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Allow Commenting : </label>
                <div class="col-lg-8">
                <div class="text-start">
                    <?php
                    if($rows['Allow_comments'] == 0){
                        ?>
                    <input id="com-yes" type="radio" name="comments" value="0"  checked />
                    <label for="com-yes">Yes</label> &nbsp;
                    <input id="com-no" type="radio" name="comments" value="1" />
                    <label for="com-no">No</label>
                    <?php
                    }else {
                        ?>
                        <input id="com-yes" type="radio" name="comments" value="0"   />
                    <label for="com-yes">Yes</label> &nbsp;
                    <input id="com-no" type="radio" name="comments" value="1" checked />
                    <label for="com-no">No</label>
                      <?php
                          }
                        ?>
                </div>
                <div>
                
                </div>
                </div>
        </div>  

        <!-- end allow commenting field -->

        
        <!--Start allow Ads field -->

        <div class="row mb-2">
                <label for="colFormLabel" class="col-form-label-sm text-start col-lg-4">Allow Ads :</label>
                    <div class="col-lg-8">
                        <div class="text-start">
                            <?php
                            if($rows['Allow_ads'] == 0){
                            ?>
                            <input id="ads-yes" type="radio" name="ads" value="0"  checked />
                            <label for="ads-yes">Yes</label> &nbsp;
                            <input id="ads-no" type="radio" name="ads" value="1" />
                            <label for="ads-no">No</label>
                            <?php
                            }else{
                            ?>
                            <input id="ads-yes" type="radio" name="ads" value="0"   />
                            <label for="ads-yes">Yes</label> &nbsp;
                            <input id="ads-no" type="radio" name="ads" value="1" checked />
                            <label for="ads-no">No</label>
                            <?php
                            }
                            ?>
                            
                        </div>
                    <div>
                </div>
            </div>
        </div> 

        <!-- end allow Ads field -->
    
            <!--Start Btn -->
            <div class="col-lg-9 col-md-9 col-sm-12 float-lg-end float-sm-none m-1">
                <input type="submit" name="submit" value="Save" class="btn btn-primary btn-sm w-75" id="colFormLabel" placeholder="">
            </div>

            <!-- End btn -->
            
    </form>
    
</center>

</div>


<?php
} else{ //ID not found

 header('Location:categories.php');

    } 

?>

<?php
/*******************************************************************************************************************************
**************************************************** End Edit Category *********************************************************
********************************************************************************************************************************/

}elseif($do == 'update'){

/*******************************************************************************************************************************
**************************************************** Start update Category *********************************************************
********************************************************************************************************************************/

//check if the user is coming from edit page and HTTP REQUEST IS POST

if( $_SERVER['REQUEST_METHOD'] == 'POST' ){

            //Get variables from the form
            $id        = $_POST['id'];
            $name      = $_POST['name'];
            $Oldname   = $_POST['Oldname'];
            $desc      = $_POST['description'];
            $order     = $_POST['ordering'];
            $visible   = $_POST['visibility'];
            $comments  = $_POST['comments'];
            $ads       = $_POST['ads'];    

    if($name == $Oldname){ // check if the user entred same name

                    //sql statement

                    $stmt = $con->prepare("UPDATE categories SET   Name           = ? ,
                                                                    Description    = ? ,
                                                                    Ordering       = ? ,
                                                                    Visibility     = ? ,
                                                                    Allow_comments = ? ,
                                                                    Allow_ads      = ? 

                                                                                        WHERE ID = ? ");
                    
                    //EXECUTE

                    $stmt->execute(array($name ,$desc ,$order ,$visible ,$comments,$ads,$id));

                    $nbrRow =  $stmt->rowCount();

                    echo "<center>";
                            echo "<div class='alert alert-success col-lg-6 mt-5'>";
                                echo $nbrRow." Record(s) <strong>Updated </strong> ";
                            echo "</div>";
                            echo "<div class='alert alert-info col-lg-6 '>";
                                echo "You will be redirected to categories page after 3 seconds <div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>";
                            echo "</div>";
                    echo "</center>";

                        header('refresh:3;url=categories.php');

    }else{

        //Check if the name of this categoery is exist or not

        $check = check_item("Name","categories",$name);

            if($check == 1){//if name of the cat is already exist then :
                
                    echo "<center>";
                        echo "<div class='alert alert-danger col-lg-6 mt-5'>";
                            echo "Sorry This name is<strong> already exist </strong> !";
                        echo "</div>";
                        echo "<div class='alert alert-info col-lg-6 mt-5'>";
                        echo "You will be redirected to edit it after 3 seconds <div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>";
                    echo "</div>";
                    echo "</center>";

                        if(isset($_SERVER['HTTP_REFERER'])){

                            $link = $_SERVER['HTTP_REFERER'] ;

                            header('refresh:3;url='.$link.'');

                        }else{

                            header('Locations:categories.php');

                        }    

            }else{//if not :

                    //sql statement

                    $stmt = $con->prepare("UPDATE categories SET   Name           = ? ,
                                                                    Description    = ? ,
                                                                    Ordering       = ? ,
                                                                    Visibility     = ? ,
                                                                    Allow_comments = ? ,
                                                                    Allow_ads      = ? 

                                                                                        WHERE ID = ? ");

                    //EXECUTE

                    $stmt->execute(array($name ,$desc ,$order ,$visible ,$comments,$ads,$id));

                    $nbrRow =  $stmt->rowCount();

                    echo "<center>";
                            echo "<div class='alert alert-success col-lg-6 mt-5'>";
                                echo $nbrRow." Record(s) <strong>Updated </strong> ";
                            echo "</div>";
                            echo "<div class='alert alert-info col-lg-6 '>";
                                echo "You will be redirected to categories page after 3 seconds <div class='spinner-border spinner-border-sm ms-auto' role='status' aria-hidden='true'></div>";
                            echo "</div>";
                    echo "</center>";

                        $link = $_SERVER['HTTP_REFERER'] ;

                        header('refresh:3;url=categories.php');

            }


    }


}else{//if the user is not coming from edit page we will redireted to categories Page

 header('Location:categories.php');   

}

/*******************************************************************************************************************************
**************************************************** End Update Category *********************************************************
********************************************************************************************************************************/

}elseif($do == 'Delete'){
    
/*******************************************************************************************************************************
**************************************************** Start Delete Category *********************************************************
********************************************************************************************************************************/

//check if the ID is valid & numiric and get integer value (itval) of it 
 $id = isset($_GET['Categ']) && is_numeric($_GET['Categ']) ? intval($_GET['Categ']) : 0 ;

//search in database  if this ID exist
$stmt = $con->prepare("SELECT ID FROM categories WHERE ID = ? ");

//execute
$stmt->execute(array($id));

//get numRows
$NbrRow = $stmt->rowCount();


if($NbrRow>0){


    $stmt = $con->prepare("DELETE FROM categories WHERE ID = ? LIMIT 1");

    $stmt->execute(array($id));
    

    echo "<center>";
            echo "<div class='alert alert-info col-lg-6 m-5'>";
                echo '<h3>Deleting</h3>';
                echo '<div class="spinner-grow spinner-grow-sm" role="status">';
                echo '<span class="visually-hidden">Loading...</span>';
                echo '</div>';
                echo '<div class="spinner-grow spinner-grow-sm" role="status">';
                echo '<span class="visually-hidden">Loading...</span>';
                echo '</div>';
                echo '<div class="spinner-grow spinner-grow-sm" role="status">';
                echo '<span class="visually-hidden">Loading...</span>';
                echo '</div>';
            echo "</div>";
    echo "</center>";


    header('refresh:3;url=categories.php');
    

}
/*******************************************************************************************************************************
**************************************************** End Delete Category *********************************************************
********************************************************************************************************************************/

}


echo "</div>";
//footer

include $temp.'footer.php'; 
}else{

    header('Location:index.php');
}
?>