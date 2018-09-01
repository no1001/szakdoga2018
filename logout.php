<?php 
include "functions.php";
setcookie("faust", "", time() - 60);
genlog('',2);
toindex('index&msg=2');
?>