<?php
require_once('variableBDD.php');

function connexionBDD(){
	try{
		$bdd = new PDO(driver.":host=".host.";dbname=".dbname.";charset=utf8",user,pwd, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
		return $bdd;
	}catch(Exception $e){
		die('Erreur : ' . $e->getMessage());
	}
}
?>
