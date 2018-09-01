<?php
if (!(defined('included'))){header("Location: /");}
if ($userRank<3){{ 
    include_once 'inc/errors.php';
		hiba(0);
    exit;
	}
								}
	if (isset($_GET['sp'])){
				if (file_exists("settings/".$_GET['sp'].".php")) include "settings/".$_GET['sp'].".php";
				else {include 'inc/errors.php'; hiba(0);}
			}
			else {
				include "settings/index.php";
			}

?>