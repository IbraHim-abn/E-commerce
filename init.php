<?php 
//Connect to data base
include 'admin/Connect.php';

$sessionUser = '';

    if(isset($_SESSION['user'])){

    $sessionUser = $_SESSION['user'];

    }

//Routes
//Template
$temp   = 'includes/templates/';
//Functions
$func   = 'includes/functions/';
//Libraries
$lib    = 'includes/libraries';
//Langues
$langu  = 'includes/languages/';
//languages
//layout / css
$css = 'layout/CSS/';
//layout / js
$js = 'layout/js/';
//layout / images
$imgs = 'layout/images/';
//Files Important
include $func.'functions.php';
 include $langu.'english.php';
 include $temp.'header.php';

?>