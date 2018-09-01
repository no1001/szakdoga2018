<?php
include "../functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if (($userID<0)||($userRank<3))toindex();
if (empty($_POST['newcontent'])){toindex("settings/newnews&hiba=12");}
$newcontent=addslashes(htmlentities(($_POST['newcontent'])));
$title=htmlentities(($_POST['title']));
$token=$_POST['token'];
$newsID=getId($token,'news','newsID');
$sql="update news set submitted=now(),title='$title', content='$newcontent', author=$userID where newsID=$newsID";
$ok=query($sql);

//a log általában tartalmazza az sql-t de ebben az esetben a content miatt túl hosszú lenne az sql
if ($ok){genlog("",8);toindex("settings/newnews&msg=6&nwsid=".$token);}
  else  {genlog("",9);toindex("settings/newnews&hiba=14");}
?>