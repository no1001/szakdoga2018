<?php
include "../functions.php";
if(isset($_POST['userName'] )){
$userName=htmlspecialchars($_POST['userName'],ENT_QUOTES);
$sql="SELECT userID from users where userName collate utf8_bin like '$userName' limit 1";
$darab=numberofrows(query($sql));
echo $darab;}

?>