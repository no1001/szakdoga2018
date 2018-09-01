<?php 
include "../functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if (($userID<0)||($userRank<3))toindex();
$ok=true;
$leiras=$_POST['leiras'];
$price=$_POST['price'];
$afaID=getId($_POST['afa'],'afa','afaID');
$kezd=$_POST['kezd'];
$vege=$_POST['vege'];
$token=$_POST['token'];
begin();

if ($token=='0'){
  //új étel beszúrása majd a kaja kategóriáinak rögzítése
  $sql="INSERT INTO `foods`(`leiras`, `price`, `ervenyesFrom`, `ervenyesTo`, `afa_afaID`) VALUES ('$leiras','$price','$kezd','$vege','$afaID')";
  $newID=insert($sql);
  $kategoriak = isset($_POST['kategoriak']) ? $_POST['kategoriak'] : array();
    foreach($kategoriak as $kategoria) {
    $categoryID=getId($kategoria,'category','categoryID');
    $insertToCatSql="INSERT INTO `foods_has_category`(`foods_foodsID`, `category_categoryID`) VALUES ($newID,$categoryID)";
    $siker=query($insertToCatSql);
    if (!$siker) $ok=false;
    }
}
//meglévő étel frissítése/régi kategóriák törlés->újra rögzítése
else{
  $foodsID=getId($token,'foods','foodsID');
  $sql="UPDATE foods set `leiras`='$leiras', `price`='$price', `ervenyesFrom`='$kezd', `ervenyesTo`='$vege', `afa_afaID`='$afaID' where foodsID=$foodsID";
  $siker1=query($sql); if (!$siker1) $ok=false;
  
  //régi kategóriák törlése
  $sql2="DELETE FROM `foods_has_category` WHERE `foods_foodsID`='$foodsID'";

  $siker2=query($sql2);if (!$siker2) $ok=false;
  
  //új kategóriák felvétele
  $kategoriak = isset($_POST['kategoriak']) ? $_POST['kategoriak'] : array();
    foreach($kategoriak as $kategoria) {
    $categoryID=getId($kategoria,'category','categoryID');
    $insertToCatSql="INSERT INTO `foods_has_category`(`foods_foodsID`, `category_categoryID`) VALUES ($foodsID,$categoryID)";
    $siker=query($insertToCatSql);
    if (!$siker) $ok=false;
    }
}


 if ($ok){commit();genlog($sql,40);toindex("settings/food&msg=23");}
 else  {rollback();genlog($sql,41);toindex("settings/food&hiba=32");}
?>