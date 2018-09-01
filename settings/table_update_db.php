<?php 
include "../functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if (($userID<0)||($userRank<3))toindex();

$leiras=$_POST['leiras'];
$cap=$_POST['cap'];
$kezd=$_POST['kezd'];
$vege=$_POST['vege'];
$token=$_POST['token'];

if ($token=='0'){
  $sql="INSERT INTO `tables`(`leiras`, `cap`, `ervenyesFrom`, `ervenyesTo`) VALUES ('$leiras','$cap','$kezd','$vege')";
}
else{
  $tablesID=getId($token,'tables','tablesID');
  $sql="UPDATE tables set `leiras`='$leiras', `ervenyesFrom`='$kezd', `ervenyesTo`='$vege' where tablesID=$tablesID";
}

$ok=query($sql);
 if ($ok){genlog($sql,44);toindex("settings/layout&msg=25");}
 else  {genlog($sql,45);toindex("settings/layout&hiba=34");}
?>