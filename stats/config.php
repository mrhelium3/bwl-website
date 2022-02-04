<?php
/*
-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-*-*-**-*-*-*
	MBedwars - Webstats by Niekold (Niekold#9410)

	- You are not allowed to resell the plugin/website
	- You are not allowed to reupload the plugin/website anywhere else
    - Refunds are not accepted
    - any error/bug should be posted in the resource's thread, not in the review section otherwise I will not give a support for reported bugs in     review section
	- You are not allowed to share this resource with others
    - You are not allowed to claim ownership of this resource

	Copyrighted by Niekold © 2018
	

	|-----------|
	|0 = false	|
	|1 = true	|
	|-----------|
	
	
-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-**-*-*-**-*-*-*
*/


/* Configurations */

$domain = "https://bw-league.com/stats";
$maindomain = "https://bw-league.com/";

$topplayeramount = "10";

$servername = "Bedwars League";
$richname = "BWL - StatsPage";
$richtext = "Check your stats!";

/* MYSQL */

$ip = "panel.bw-league.com:3306";
$user = "u2_9UIYdHumdS";
$password = "K=xwLDvWc@QWldX5@8STCm5Q";
$table = "MBedwars_stats";
$database = "s2_bedwars";

$debug = "false";
/* Dont Change! */
$version = "1.1.4";
$versioncheck = "https://spigot.nevercold.eu/mbedwars/webstats/version.json";
$true = "true";
$false = "false";
include("mysqlclass.php");
/* Dont Change! */

?>