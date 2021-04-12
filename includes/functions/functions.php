<?php 

        //function to get userid 
        function getUserID($Username){
             global $con;
             $userId='';
            $stmt3 = $con->prepare("SELECT  UserID  FROM  users WHERE Username  = ? ");
                $stmt3->execute(array($Username));
                $rows = $stmt3->fetchAll();    
                             foreach($rows as $row) {

                                $userId = $row['UserID'];

                                                     }

                                return $userId;
                                    }



       //Function get categories  
       function getCats(){
        global $con;
        $getCat = $con->prepare("SELECT * FROM categories WHERE Visibility = 0 order by ID asc");
        $getCat->execute();
        $cats = $getCat->fetchAll();
        return $cats; 
        }
    

         //Function to get Items from database  
       function getItems($where,$value,$order){
        global $con;
        $getItems = $con->prepare("SELECT * FROM items where $where = ?  order by $order desc");
        $getItems->execute(array($value));
        $items = $getItems->fetchAll();
        return $items; 
        }


       //Function to get comment from database  
       function getComments($value){
        global $con;
        $getComments = $con->prepare("SELECT * FROM comments inner join users 
        on(comments.c_member = users.UserID)
         where Username = ? and c_status = 1 order by c_id desc");

        $getComments->execute(array($value));
        $Comments = $getComments->fetchAll();
        return $Comments; 
        }


//function to check the regstatus of the user
//users deactivated

function CheckStatusUser($user){

    global $con;

$stmt = $con->prepare("SELECT  Username , RegStatus FROM users WHERE Username= ? AND RegStatus = 0 ");

$stmt->execute(array($user));

$status = $stmt->rowCount();

return $status;

}








/* functions of admin  */

///Page Title 
function p_title(){
global $PageTitle ;
    if(isset($PageTitle)){
        echo $PageTitle;
    }else{
        echo 'Default';
    }
}

//Function chek if the item exist in data base or not
function check_item($select ,$table ,$value){
    global $con;
    $statement = $con->prepare("SELECT $select FROM $table WHERE $select = ?");
    $statement->execute(array($value));
    $count = $statement->rowCount();
    return $count;
}
//CHECK NUMBER OF ITEMS Functions
function count_items($item , $table ,$where){
global $con;
$stmt2 = $con->prepare("SELECT COUNT($item) from $table WHERE $where AND GrouID != 1");
$stmt2->execute();
return $stmt2->fetchColumn();
}
//Function get latest items 
function getLatests($select , $table , $order , $limit = 3){
global $con;
$stmt3 = $con->prepare("SELECT $select FROM $table WHERE GrouID != 1 ORDER BY $order DESC LIMIT $limit");
$stmt3->execute();
$rows = $stmt3->fetchAll();
return $rows; 
}
//Count items
//CHECK NUMBER OF ITEMS Functions
function count_items2($item , $table ,$where){
    global $con;
    $stmt2 = $con->prepare("SELECT COUNT($item) from $table WHERE $where");
    $stmt2->execute();
    return $stmt2->fetchColumn();
    }

    //Function get latest items 
function getLatestsItem($select , $table , $order , $limit = 3){
    global $con;
    $stmt3 = $con->prepare("SELECT $select FROM $table  ORDER BY $order DESC LIMIT $limit");
    $stmt3->execute();
    $rows = $stmt3->fetchAll();
    return $rows; 
    }

        //Function get latest comments 
function getLatestsComments($select , $table , $order , $limit = 3){
    global $con;
    $stmt4 = $con->prepare("SELECT $select FROM $table inner join items 
    on (comments.c_item = items.Item_ID)
    inner join users on (comments.c_member = users.UserID)
      ORDER BY $order ASC LIMIT $limit");
    $stmt4->execute();
    $rows = $stmt4->fetchAll();
    return $rows; 
    }














?>