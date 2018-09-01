<?php
include "../functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if (($userID<0)||($userRank<3))toindex();
if (empty($_POST['newaboutus'])){toindex("settings/editaboutus&hiba=16");}
$newaboutus=addslashes(htmlentities(($_POST['newaboutus'])));

$sql="update restaurant set aboutus='$newaboutus' where restaurantID=$restaurantID";
$ok=query($sql);

//a log általában tartalmazza az sql-t de ebben az esetben felesleges,túl hosszú lenne,vagy lemaradna az sql lényege
 if ($ok){genlog("",10);toindex("settings/editaboutus&msg=8");}
 else  {genlog("",11);toindex("settings/editaboutus&hiba=17");}
?>