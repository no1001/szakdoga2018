<?php
include "../functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if ($userRank<3)toindex();
if (empty($_POST['token']))
{toindex("settings/nyitva&hiba=18");}
$mon_open=$_POST['mon_open'];
$tue_open=$_POST['tue_open'];
$wed_open=$_POST['wed_open'];
$thu_open=$_POST['thu_open'];
$fri_open=$_POST['fri_open'];
$sat_open=$_POST['sat_open'];
$sun_open=$_POST['sun_open'];

$mon_close=$_POST['mon_close'];
$tue_close=$_POST['tue_close'];
$wed_close=$_POST['wed_close'];
$thu_close=$_POST['thu_close'];
$fri_close=$_POST['fri_close'];
$sat_close=$_POST['sat_close'];
$sun_close=$_POST['sun_close'];
 function updateday($nap,$opening,$closing)
 {
   return "update nyitvatartas set open='$opening', close='$closing' where nap=$nap";
 }
begin();
$hetfo=query(updateday(1,$mon_open,$mon_close));
$kedd=query(updateday(2,$tue_open,$tue_close));
$szerda=query(updateday(3,$wed_open,$wed_close));
$csutortok=query(updateday(4,$thu_open,$thu_close));
$pentek=query(updateday(5,$fri_open,$fri_close));
$szombat=query(updateday(6,$sat_open,$sat_close));
$vasarnap=query(updateday(0,$sun_open,$sun_close));
if ($hetfo && $kedd && $szerda && $csutortok && $pentek && $szombat && $vasarnap){
  commit();
  genlog("",12);
  toindex("settings/nyitva&msg=9");
}
else {
  rollback();
  genlog("",13);
  subtoindex("settings/nyitva&hiba=18");
}
?>