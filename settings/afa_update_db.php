<?php 
include "../functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if (($userID<0)||($userRank<3))toindex();

$leiras=$_POST['leiras'];
$ertek=$_POST['ertek'];
$kezd=$_POST['kezd'];
$vege=$_POST['vege'];
$token=$_POST['token'];

if ($token=='0'){
  $sql="INSERT INTO `afa`(`leiras`, `value`, `ervenyesFrom`, `ervenyesTo`) VALUES ('$leiras','$ertek','$kezd','$vege')";
}
else{
  $afaID=getId($token,'afa','afaID');
  $sql="UPDATE afa set `leiras`='$leiras', `value`='$ertek', `ervenyesFrom`='$kezd', `ervenyesTo`='$vege' where afaID=$afaID";
}
$ok=query($sql);
 if ($ok){genlog($sql,34);toindex("settings/afa&msg=20");}
 else  {genlog($sql,35);toindex("settings/afa&hiba=29");}
?>