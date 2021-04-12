<nav style="user-select: none;" class="navbar navbar-expand-lg navbar-light bg-info">
  <div class="container">
    <!--<a style="font-family: 'Comic Sans MS', cursive;border:1px solid gray;border-radius:5px;padding:2px;" class="navbar-brand" href="Dashboard.php">
      <img src="<?php echo $imgs."Logo1.svg"; ?>" alt="" width="50" height="40"><?php //echo lang('Home'); ?>
    </a>-->
  <a class="navbar-brand" href="Dashboard.php"><i class='fa fa-home'></i> <?php echo lang('Home'); ?></a> 
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
       <!-- <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#"></a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" href="categories.php"><i class="fa fa-list-ul"></i> <?php echo lang('CATC'); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="items.php"><i class="fa fa-tags"></i>  <?php echo lang('ITEMS'); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="members.php"><i class="fa fa-users"></i> <?php echo lang('MEMBERS'); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comments.php"><i class="fa fa-comments-o"></i> <?php echo lang('COMMENTS'); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fa fa-area-chart"></i> <?php echo lang('STATISTICS'); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fa fa-file-text"></i> <?php echo lang('LOGS'); ?></a>
        </li>
       
      </ul>
      <ul class="navbar-nav " >
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-user-circle-o"></i> Profile
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="../index.php" target="_blank"><i class="fa fa-globe"></i>  <?php echo lang('VISITSHOP'); ?></a></li>
            <li><a class="dropdown-item" href="members.php?do=Edit&userID=<?php echo $_SESSION['UserID']; ?>"><i class="fa fa-wrench"></i>  <?php echo lang('Edit_Profile'); ?></a></li>
            <li><a class="dropdown-item" href="#"><i class="fa fa-cogs"></i>  <?php echo lang('Settings'); ?></a></li>
            <li><a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out"></i>  <?php echo lang('LogOut'); ?></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>