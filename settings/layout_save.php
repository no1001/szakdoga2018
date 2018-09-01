<?php
include "../functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if (($userID<0)||($userRank<3))toindex();
$layoutID=getId($_POST['token'],'layouts','layoutsID');
$sw=$_POST['sw'];
$sh=$_POST['sh'];
$oke=true;
begin();
$deleteOldSql="delete from tables_in_layouts where layoutID=$layoutID";
$ok=query($deleteOldSql); if(!$ok) $oke=false;
foreach ($_POST['asztal'] as $egyasztal){
  
  $tableID=getId($egyasztal['name'],'tables','tablesID');
  $positionX=$egyasztal['xpoz']/$sw;
  $positionY=$egyasztal['ypoz']/$sh;
  $insertTableSql="INSERT INTO `tables_in_layouts`(`tableID`, `layoutID`, `positionX`, `positionY`) VALUES ($tableID,$layoutID,$positionX,$positionY)";;
  $ok=query($insertTableSql); if (!$ok) $oke=false;
}
 if ($oke){commit();genlog('',42);toindex("settings/layout&msg=24");}
 else  {rollback();genlog('',43);toindex("settings/layout&hiba=33");}
?>