<?php
include "functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if ($userRank<1)toindex();
$token=$_POST['token'];
$late=$_POST['late'];
$bookingsID=getId($token,'bookings','bookingsID');
$getprev="select bookstart,bookend from bookings where bookingsID=$bookingsID";
$prev=query($getprev);
$bookstart=results($prev,0,0);
$bookend=results($prev,0,1);

$tserkezes=strtotime($bookstart)+$late;
$tstavozas=strtotime($bookend)+$late;

$erkezes=date('H:i',$tserkezes);
$tavozas=date('H:i',$tstavozas);

/*
0- készenlét
1- késés
2- nem jelzett késés
3- jelen
4- távozott
5- lemondva/törölve
6- elmúlt/archiv
*/

$sql="update bookings set erkezes='$erkezes', tavozas='$tavozas', progress=1 where bookingsID=$bookingsID";
if ($userRank<2) $sql.=" and 	guests_userID=$userID";
$ok=query($sql);

if ($ok){genlog($sql,50);toindex('foglalas&msg=28');}
  else {genlog($sql,51);toindex('foglalas&hiba=38');}

?>