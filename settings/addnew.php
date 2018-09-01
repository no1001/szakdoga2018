<?php
include "../functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if (($userID<0)||($userRank<3))toindex();
if (empty($_POST['newcontent'])){toindex("settings/newnews&hiba=12");}
$newcontent=addslashes(htmlentities(($_POST['newcontent'])));
$title=htmlentities(($_POST['title']));
$sql="INSERT INTO news (submitted,title, content, author) VALUES (now(),'$title','$newcontent',$userID)";
$nwsid=insert($sql);

//a log általában tartalmazza az sql-t de ebben az esetben a content miatt túl hosszú lenne az sql
 if ($nwsid>0){genlog("",6);toindex("settings/newnews&msg=5&nwsid=".saltId($nwsid));}
  else  {genlog("",7);toindex("settings/newnews&hiba=13");}
?>