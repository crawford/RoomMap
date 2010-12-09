<?php
	require_once('credentials.php');
	require_once('constants.php');

	$connection = mysql_connect(SUDS_DB_URL, SUDS_USERNAME, SUDS_PASSWORD) or die ("Unable to connect!");
	mysql_select_db(SUDS_DB_NAME) or die("Unable to select database!");
	$query = "SELECT * FROM status";
	$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
	mysql_close($connection);
	
	echo "[";
	for($i = 0; $i < mysql_num_rows($result); $i++) {
		$row = mysql_fetch_row($result);
		echo $row[3];
		if($i + 1 < mysql_num_rows($result)) {
			echo ", ";
		}
	}
	echo "]";
?>
