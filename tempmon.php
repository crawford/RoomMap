<?php
	require_once('credentials.php');
	require_once('constants.php');

	$db = pg_connect('host='.TEMPMON_DB_URL.
	                 ' dbname='.TEMPMON_DB_NAME.
	                 ' user='.TEMPMON_USERNAME.
	                 ' password='.TEMPMON_PASSWORD);
	
	for ($i = 0; $i < 11; $i++) {
		$result = pg_query($db, "SELECT temperature FROM tempmon WHERE sensorid=$i ORDER BY time DESC LIMIT 1;");
		$row = pg_fetch_assoc($result);
		echo $row['temperature'], '<br />';
	
	}
	pg_close($db);
?>
