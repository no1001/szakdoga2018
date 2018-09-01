<?php
include "functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if (($userID<0)||($userRank<1)) toindex();
$guestID=getId($_POST['token'],'guests','guestID');
$datum=$_POST['datum'];
$bookstart=$_POST['usertime'];
$bookend=date('H:i',(strtotime($bookstart)+$_POST['useridotartam']));
$erkezes=$bookstart;
$tavozas=$bookend;


$oke=true;
begin();
              
$insertbook="INSERT INTO `bookings`(`datum`, `bookstart`, `bookend`, `erkezes`, `tavozas`, `guests_guestID`, `guests_userID`) VALUES ('$datum','$bookstart','$bookend','$erkezes','$tavozas', $guestID, $userID)";

$bookingsID=insert($insertbook);
if ($bookingsID<1) $oke=false;
else{
  
  $alreadyBooked[]="";
	$getAlreadyBooked="SELECT `tables_tablesID` FROM `bookings_has_tables` join bookings on `bookings_bookingsID`=bookingsID where datum='$datum' and ('$bookstart' between `erkezes` and `tavozas`) and ('$bookend' between `erkezes` and `tavozas`) and progress!=5";

	  $result1=query($getAlreadyBooked);
    while($row1=fetch($result1)){
    $alreadyBooked[] = $row1[0]; 
    }
  if (isset($_POST['asztal'])){
    $asztalok=$_POST['asztal'];  
  $asztalok=$_POST['asztal'];
  foreach($asztalok as $asztal){
    $tablesID=getId($asztal,'tables','tablesID');
    if(in_array($asztal,$alreadyBooked,true)){$oke=false; break;}
    $inserttablessql="INSERT INTO `bookings_has_tables`(`bookings_bookingsID`, `tables_tablesID`) VALUES ($bookingsID,$tablesID)";
    
    $ok=query($inserttablessql);
    if (!$ok) {$oke=false; break;}
  }} else $oke=false;
  
  if (isset($_POST['foglaltkaja'])){
    
    $kajak=$_POST['foglaltkaja'];
  foreach ($kajak as $egykaja){    
    if ($egykaja['2']>0){
      $q=$egykaja['2'];
      
      $foodsID=getId($egykaja['1'],'foods','foodsID');
      $insertfoodsql="INSERT INTO `bookings_has_foods`(`bookings_bookingsID`, `foods_foodsID`, `mennyiseg`) VALUES ($bookingsID,$foodsID,$q)";
      
      $ok=query($insertfoodsql);
    }
  }
  }
  
}
if ($oke){commit();genlog($insertbook,46);toindex("foglalas&msg=26");}
 else  {rollback();genlog($insertbook,47);toindex("foglalas&hiba=36");}
?>