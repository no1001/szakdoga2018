<?php 
include "../functions.php";
$userID=getUserID();
$userRank=getUserRank($userID);
if (($userID<0)||($userRank<3)||(empty($_POST['token']))) toindex();

$rank=getId($_POST['rank'],'ranks','ranksID');
$workerID=getId($_POST['token'],'users','userID');
$checkrank_sql="select FKranksID from users where userID=$workerID";
$oldrank=results(query($checkrank_sql),0,0);
if ($oldrank==3){genlog($sql,37);toindex("settings/dolgozo&hiba=30");}
$sql="update users set FKranksID=$rank where userID=$workerID";
$ok=query($sql);

 if ($ok){genlog($sql,36);toindex("settings/dolgozo&msg=21");}
 else  {genlog($sql,37);toindex("settings/dolgozo&hiba=30");}
?>