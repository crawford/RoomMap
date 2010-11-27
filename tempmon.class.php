<?php
	require_once('credentials.php');
	require_once('constants.php');

	class TempmonHelper {
		private $pg_conn = null;

		function connect($username, $password, $pg_url, $pg_name) {
			# Connect to postgres database
			$this->pg_conn = pg_connect("host=$pg_url dbname=$pg_name user=$username password=$password");
		}

		function disconnect() {
			# Disconnect from database
			pg_close($this->pg_conn);
		}

		function fetch_temps(&$temps) {
			for ($i = 0; $i < 11; $i++) {
				$result = pg_query($this->pg_conn, "SELECT temperature FROM tempmon WHERE sensorid=$i ORDER BY time DESC LIMIT 1;");
				$row = pg_fetch_assoc($result);
				$temps[$i] = $row['temperature'];
			}
		}
	};
?>
