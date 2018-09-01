<?php
include "functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if ($userRank<1)toindex();

$name=htmlspecialchars($_POST['name'],ENT_QUOTES);
$email=$_POST['email'];
$tel=htmlspecialchars($_POST['tel'],ENT_QUOTES);
$address=htmlspecialchars($_POST['address'],ENT_QUOTES);
$token=$_POST['token'];

if (!($token=='')){
  $guestID=getId($token,'guests','guestID');
  $sql="UPDATE `guests` SET name='$name', email='$email', tel='$tel', address='$address' where userID=$userID and guestID=$guestID";
  $ok=query($sql);
  
  if ($ok){genlog($sql,30);toindex('profil&msg=18');}
  else {genlog('',31);toindex('profil&hiba=27');}
  }
else {
  $sql="INSERT INTO `guests`( `name`, `email`, `tel`, `address`, `userID`) VALUES ('$name','$email','$tel','$address',$userID)";
  $ok=query($sql);
  if ($ok){genlog($sql,28);toindex('profil&msg=17');}
  else {genlog($sql,29);toindex('profil&hiba=26');}
}

?>