<?php 
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