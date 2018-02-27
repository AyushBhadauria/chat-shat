<?php

session_start();
session_destroy();


echo "Logging out... Please Wait";

header("Refresh:2; url=login.php");

?>