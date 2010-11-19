<?php
	$starttime = microtime(true);

	require_once('credentials.php');
	require_once('constants.php');
	require_once('ldap.class.php');	
	
	$members = null;
	$ldap = new LdapHelper();

	$ldap->connect(LDAP_USERNAME, LDAP_PASSWORD, LDAP_URL, LDAP_PORT);
	$ldap->fetch_on_floors(USERS_DN, $members);
	$ldap->fetch_eboard(EBOARD_DN, $members);
	$ldap->fetch_rtps(RTP_DN, $members);
	$ldap->disconnect();

	# Fill the variables with info
	foreach($members as $member) {
		$nameColor = 0;
		if ($member['rtp']) {
			$nameColor += COLOR_RTP;
		}
		if ($member['eboard']) {
			$nameColor += COLOR_EBOARD;
		}
		if ($member['drinkadmin']) {
			$nameColor += COLOR_DRINK_ADMIN;
		}

		if (isset($rooms[$member['room']])) {
			$rooms[$member['room']]['occupantTwoName'] = $member['name'];
			$rooms[$member['room']]['occupantTwoColor'] = $nameColor;
			$rooms[$member['room']]['occupantTwoUsername'] = $member['username'];
			$rooms[$member['room']]['fillColor'] = (int)round(($rooms[$member['room']]['fillColor'] + get_year_color($member['year'])) / 2);	
		} else {
			$rooms[$member['room']] = array('occupantOneName' => $member['name'],
			                                'occupantOneColor' => $nameColor,
											'occupantOneUsername' => $member['username'],
			                                'fillColor' => get_year_color($member['year']));
		}
	}

	# Generate the HTML for each of the rooms
	foreach($ROOM_NUMBERS as $roomNumber) {

		$background = rgbahex($rooms[$roomNumber]['fillColor'], OVERLAY_OPACITY);

		$nameOne = $rooms[$roomNumber]['occupantOneName'];
		$nameTwo = $rooms[$roomNumber]['occupantTwoName'];

		$colorOne = rgbahex($rooms[$roomNumber]['occupantOneColor']);
		$colorTwo = rgbahex($rooms[$roomNumber]['occupantTwoColor']);

		$linkOne = MEMBERS_URL . $rooms[$roomNumber]['occupantOneUsername'];
		$linkTwo = MEMBERS_URL . $rooms[$roomNumber]['occupantTwoUsername'];

		ob_start();
		require(OVERLAY_FILE);
		$body .= ob_get_contents();
		ob_end_clean();
	}

	$endtime = microtime(true);
	$total = round($endtime - $starttime, 4);


	
	$body .= '<br /><br />Request took '.$total.' seconds to complete.';

	require('map.html');



	function rgbahex($rgb, $opacity = 1) {
		return 'rgba(' . (string)(($rgb&0xFF0000) >> 16) . ',' . (string)(($rgb&0x00FF00) >> 8) . ',' . (string)($rgb&0x0000FF) . ',' . $opacity . ')';
	}
	
	function get_year_color($year) {
		global $COLOR_YEAR;

		if ($year < 6) {
			return $COLOR_YEAR[$year - 1];
		}
		return $COLOR_YEAR[4];
	}

	function printnames($members) {
		# Print them out
		foreach($members as $member) {
			if ($member['rtp'] and $member['eboard']) {
				echo '<font color="#00aaaa">';
			} else if ($member['rtp']) {
				echo '<font color="#00aa00">';
			} else if ($member['eboard']) {
				echo '<font color="#0000aa">';
			} else {
				echo '<font>';
			}
			echo $member['name'], '</font><br />';
		}
	}
?>
