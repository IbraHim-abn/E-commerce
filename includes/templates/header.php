<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8" />
     <title><?php  p_title(); ?></title>
     <link rel="stylesheet" href="<?php echo $css;?>bootstrap.min.css"/>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <link rel="stylesheet" href="<?php echo $css;?>backend.css"/>

</head>
<body>

<div class="upper-bar">


<?php

if(isset($_SESSION['user'])){

echo '  <div class="container">';

echo "welcome mr ".$sessionUser." 
  <a class='btn btn-info text-light' href='profile.php'>My profile</a> 
  <a class='btn btn-danger text-light' href='logout.php'>logout</a> 
  <a class='btn btn-success text-light' href='NewAd.php'>New Ad</a>";

$UserStatus = CheckStatusUser($sessionUser);

if($UserStatus == 1) {

 // Account is not activated 
 echo "non activer";

}

echo '</div>';

}else{ ?>

<div class="container">


      <a href="login.php">

          <span class="pull-right"><b>Login or Signup</b></span>

      </a>

</div>
<br>
  <?php 

      }  

      ?>

</div>

<nav style="user-select: none;" class="navbar navbar-expand-lg navbar-light bg-info">
  <div class="container">
    <!--<a style="font-family: 'Comic Sans MS', cursive;border:1px solid gray;border-radius:5px;padding:2px;" class="navbar-brand" href="Dashboard.php">
      <img src="<?php echo $imgs."Logo1.svg"; ?>" alt="" width="50" height="40"><?php //echo lang('Home'); ?>
    </a>-->
  <a class="navbar-brand" href="index.php"><i class='fa fa-home'></i> <?php echo lang('Home'); ?></a> 
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav" > 
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Categories
          </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            
              <?php

            foreach(getCats() as $cats){

            echo "<li class='dropdown-item'>
                    <a href='categories.php?q=".$cats['ID']."&n=". str_replace(' ', '-', $cats['Name'])."' class='nav-link'>
                    " .$cats['Name']. "
                    </a>
                  </li>";

                            }

                ?>

            </ul>
        </li>
        <li class="nav-item">
           <a href="#" class="nav-link">About</a>
        </li>
        <li class="nav-item">
           <a href="#" class="nav-link">Contact us</a>
        </li>
      </ul>
      <form class="d-flex">
        <input name="s" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-light text-dark" type="submit"><b>Search</b></button>
      </form>
    </div>
  </div>
</nav>


