<?php
session_start();
session_destroy();
header("Location: ../Templates/home.php");
exit;
?>