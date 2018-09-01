<?php
include 'functions.php';
$ip=$_SERVER['REMOTE_ADDR'];
	$checkBF="SELECT count(*) as db from log where date(happen)=date(NOW()) and  MINUTE(timediff(happen,now()))<60 and whatcode=0 and whereip='$ip'";
	$er=query($checkBF);
	$db=results($er,0,'db');
	if ($db>=5) 
	{
		header( $_SERVER['SERVER_PROTOCOL']." 404 Not Found", true );
		exit;
	}

$userName=htmlspecialchars($_POST['userName'],ENT_QUOTES);

$userPassword=$_POST['userPassword'];
	$sql="SELECT userID FROM users WHERE userName collate utf8_bin like '$userName' AND userPassword=MD5('$userPassword')";
	$result=query($sql);
	$rows=numberofrows($result);
	if ($rows==1) 
	{
		$kod=md5($salt1."_".$salt2.results($result,0,'userID').$salt2."_".$salt1);
		setcookie("faust",$kod,time()+43200);//12 óra
		$userID=results($result,0,0);
		//utolsó bejelentkezés frissítése
		$userIP=$_SERVER['REMOTE_ADDR'];
		$update="UPDATE users SET LastLoginTime=NOW(), LastLoginIP='$userIP' WHERE userID=$userID";
		query($update);
		//naplózás
		$ip=$_SERVER['REMOTE_ADDR'];
		$logsql = "INSERT INTO log (`whereip`, `whatcode`, `howsql`, `who_userID`) VALUES ('$ip',1,'','$userID');";	
		query($logsql);	
		toindex('index&msg=1');
	}
	else 
	{
		genlog($sql,0);
		toindex('login&hiba=1');
	}
?>