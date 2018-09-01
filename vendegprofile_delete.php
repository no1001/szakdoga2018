<?php 
include "functions.php";
$userID=getUserID();
if ($userID<1)toindex();
if (!isset($_POST['token'])){genlog('',33);toindex('profil&hiba=28');}
$token=$_POST['token'];
$guestID=getId($token,'guests','guestID');
$sql="delete from guests where userID=$userID and guestID=$guestID";
$ok=query($sql);
if ($ok){
  genlog($sql,18);
	toindex('profil&msg=19');
}
else{
  genlog($sql,33);toindex('profil&hiba=28');
}
?>