<?php
include "functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if ($userRank<1)toindex();
$token=$_POST['token'];
$bookingsID=getId($token,'bookings','bookingsID');

/*
0- készenlét
1- késés
2- nem jelzett késés
3- jelen
4- távozott
5- lemondva/törölve
6- elmúlt/archiv
*/

$sql="update bookings set progress=5 where bookingsID=$bookingsID";
if ($userRank<2) $sql.=" and 	guests_userID=$userID";
$ok=query($sql);

if ($ok){genlog($sql,48);toindex('foglalas&msg=27');}
  else {genlog($sql,49);toindex('foglalas&hiba=37');}

?>