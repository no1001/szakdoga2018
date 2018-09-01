<?php 
include "../functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if (($userID<0)||($userRank<3))toindex();

$leiras=$_POST['leiras'];
$kezd=$_POST['kezd'];
$vege=$_POST['vege'];
$token=$_POST['token'];

if ($token=='0'){
  $sql="INSERT INTO `category`(`leiras`, `ervenyesFrom`, `ervenyesTo`) VALUES ('$leiras','$kezd','$vege')";
}
else{
  $categoryID=getId($token,'category','categoryID');
  $sql="UPDATE category set `leiras`='$leiras', `ervenyesFrom`='$kezd', `ervenyesTo`='$vege' where categoryID=$categoryID";
}

$ok=query($sql);
 if ($ok){genlog($sql,38);toindex("settings/category&msg=22");}
 else  {genlog($sql,39);toindex("settings/category&hiba=31");}
?>