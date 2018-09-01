<?php
include "../functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if (($userID<0)||($userRank<3))toindex();
if (!(isset($_GET['a']))){
     index("?p=settings/nyitva&hiba=18");
    }

$action=$_GET['a'];
//1-új 2-szerkeszt 3-töröl
switch ($action){
    case md5('1'): 
    $date=$_POST['spec_day'];
    $open=$_POST['spec_open'];
    $close=$_POST['spec_close'];

    if (empty($date) || empty($open) || empty($close)){
      
     toindex("settings/nyitva&hiba=18");
    }
      $newspecdatesql="INSERT INTO `specialdates`(`date`, `open`, `close`) VALUES ('$date','$open','$close')";
      $inserted=query($newspecdatesql);
        if ($inserted){
          genlog($newspecdatesql,14);
          toindex("settings/nyitva&msg=10");
        }
      else {
        genlog($newspecdatesql,15);
        toindex("settings/nyitva&hiba=19");
      }
    break;
  case md5('2'):    
    $date=$_POST['spec_day'];
    $open=$_POST['spec_open'];
    $close=$_POST['spec_close'];

    if (empty($date) || empty($open) || empty($close)){
     index("?p=settings/nyitva&hiba=18");
    }
      $id=getId($_POST['token'],'specialdates','id');
      $updateSql="update specialdates set date='$date',open='$open',close='$close' where id=$id";
    
      $updated=query($updateSql);
      if ($updated){
         genlog($updateSql,20);
         toindex("settings/nyitva&msg=13");
      }
      else{
        genlog($updateSql,21);
        toindex("settings/nyitva&hiba=22");
      }
      break;    
  case md5('3'):
    $id=getId($_POST['token'],'specialdates','id');
    $deleteSql="delete from specialdates where id=$id";
    $deleted=query($deleteSql);
     if ($deleted){
         genlog($deleteSql,22);
         toindex("settings/nyitva&msg=14");
      }
      else{
        genlog($deleteSql,23);
         toindex("settings/nyitva&hiba=23");
      }
      break; 
  default: toindex();break;
    
}
?>