<?php
include "../functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if ($userRank<3)toindex();
if (empty($_POST['newwelcome'])){toindex("settings/editwelcome&hiba=10");}
$newwelcome=addslashes(htmlentities(($_POST['newwelcome'])));

$sql="update restaurant set welcome='$newwelcome' where restaurantID=$restaurantID";
$ok=query($sql);

//a log általában tartalmazza az sql-t de ebben az esetben felesleges
 if ($ok){genlog("",4);toindex("settings/editwelcome&msg=4");}
 else  {genlog("",5);toindex("settings/editwelcome&hiba=11");}
?>