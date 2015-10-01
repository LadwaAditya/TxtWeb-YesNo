<?php


    define("HOST", "sql212.0fees.net");
    define("USER", "fees0_11733994");
    define("PASS", "mynameisadi");
    define("DB", "fees0_11733994_aditya");
	$pubkey='b3f54555-0f11-4428-99ee-148212237a0b';
	
	
	function db_connect()
{
if (($connection = mysql_connect(HOST, USER, PASS)) === FALSE)
            die("Could not connect to database" . mysql_error());
           
        if (mysql_select_db(DB, $connection) === FALSE)
            die("Could not select database" . mysql_error());
			return $connection;
}

?>
