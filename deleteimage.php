<?php 
include "functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if ($userRank<2){
  toindex();  
}
$siker=true;
if(!empty($_POST['going_to_be_deleted'])) {
    begin();
    foreach($_POST['going_to_be_deleted'] as $image) {
            $image_id=getId($image,"gallery","image_id");
            $getFileNamesql="select name from gallery where image_id=$image_id";
            $FileName="images/gallery/".results(query($getFileNamesql),0,0);
            $MinFileName="images/gallery/thumb_".results(query($getFileNamesql),0,0);
            $sikerDel1=unlink($FileName);
            $sikerDel2=unlink($MinFileName);
      if ($sikerDel1 && $sikerDel2){
        $DeletefromDbSql="delete from gallery where image_id=$image_id";
        $ok=query($DeletefromDbSql);
        if ($ok) genlog($DeletefromDbSql,26); else {genlog($DeletefromDbSql,27);$siker=false;}
      }
      else $siker=false;
    }
}else $siker=false;
if ($siker){commit();toindex('galeria&msg=16');}
else {rollback();toindex('galeria&hiba=25');}
?>