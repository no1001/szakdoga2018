<?php
$host='localhost';
$user='root';
$password='';
$db="kghsz_vasvari";
global $salt1,$salt2,$domain,$restaurantID;
$restaurantID=1;
$salt1='alpha';
$salt2='omega';

$domain="http://localhost/webhely/";

//az esetleges hibák miatt főként
error_reporting(0);

//adatbázis specifikus dolgok
$ok1=mysql_connect($host,$user,$password);
$ok2=mysql_select_db($db);
if ((!$ok1)||(!$ok2)){echo "Nem sikerült kapcsolódni az adatbázishoz";}
//Magyar-local+utf-8-as kódolás
mb_internal_encoding("UTF-8");
mysql_query("SET NAMES 'utf8'");
date_default_timezone_set('Europe/Budapest');

function query($sql){return mysql_query($sql);}
function results($res,$line,$column){return mysql_result($res,$line,$column);}
function numberofrows($res){return mysql_num_rows($res);}	
function fetch($result){return mysql_fetch_array($result);}
function insert($sql){query($sql);return mysql_insert_id();}

//tranzakciók
function begin(){query("START TRANSACTION");}
function commit(){query("COMMIT");}
function rollback(){query("ROLLBACK");}

//felhasználó visszairányítása a kezdőlapra
function toindex($append){
	global $domain;
	$link=$domain.$append;
	header("Location: $link");exit;
}

//felhasználó azonosítójának kinyerése sütiből
function getUserId()
	{
		global $salt1,$salt2;
		if (isset($_COOKIE['faust']))
		{
			$cookie=$_COOKIE['faust'];
			$sql="Select userID from users where md5(CONCAT('$salt1','_','$salt2',userID,'$salt2','_','$salt1'))='$cookie'";
			$result=query($sql);
			if (numberofrows($result)==1) return results($result,0,'userID');
			else return ('-1');
		} else return ('-1');	
	}
//felhasználó rankjának kiolvasása
function getUserRank($userId){
	if ($userId<1){return (0);}
	else {
	$getRankSql='select `FKranksID` from users where userID='.$userId;
	$sor=query($getRankSql);
	$thisrank=results($sor,0,0);
	return $thisrank;}
}
//felhasználónév
function getUserName($userId){
	if ($userId<1){return (0);}
	else{
	$getNameSql="select userRName from users where userID=$userId";
	$name=results(query($getNameSql),0,0);
	return $name;}
}
//átlagos id sózása/kinyerése
function saltId($id){
		global $salt1,$salt2;
		$saltedID=md5($salt2.'_'.$id.'_'.$salt1);
		return $saltedID;
	}

	function getId($saltedID,$table,$azon)
	{
		global $salt1,$salt2;
			$sql="Select $azon from $table where md5(CONCAT('$salt2','_',$azon,'_','$salt1'))='$saltedID';";
			$eredmeny=query($sql);
			if (numberofrows($eredmeny)==1) return results($eredmeny,0,0);
			else return -1;
	}

//naplózás
//event/műveletkódok jelentése:log.php	
function genlog($usersql, $eventcode)
{
	$safesql=str_replace("'","\\'", $usersql);
	$ip=$_SERVER['REMOTE_ADDR'];
	$user=getUserId();
	$sql = "INSERT INTO log (`whereip`, `whatcode`, `howsql`, `who_userID`) VALUES ('$ip',$eventcode,'$safesql','$user');";	
	$ok=query($sql);	
}


?>