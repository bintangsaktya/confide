<?php
session_start(admin);
session_destroy(admin);
header('location:admin_login.php');
?>