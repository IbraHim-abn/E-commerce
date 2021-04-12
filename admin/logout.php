<?php 
session_start();//start session
session_unset();
session_destroy();
header('Location:index.php');
exit();
?>