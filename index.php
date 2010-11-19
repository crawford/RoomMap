<?php
	$starttime = microtime(true);

	require_once('credentials.php');
	require_once('constants.php');
	require_once('ldap.class.php');	
	
	$members = null;
	$ldap = new LdapHelper();

	$ldap->connect(LDAP_USERNAME, LDAP_PASSWORD, LDAP_URL, LDAP_PORT);
	$ldap->fetch_on_floors($USERS_DN, $members);
	$ldap->fetch_eboard($EBOARD_DN, $members);
	$ldap->fetch_rtps($RTP_DN, $members);
	$ldap->disconnect();

	# Fill the variables with info
	foreach($members as $member) {
		$nameColor = 0;
		if ($member['rtp']) {
			$nameColor += $colorRTP;
		}
		if ($member['eboard']) {
			$nameColor += $colorEboard;
		}
		if ($member['drinkadmin']) {
			$nameColor += $colorDrinkAdmin;
		}
		$nameColor = rgbhex($nameColor);

		$name = 'n'.$member['room'];
		$$name .= '<font color="'.$nameColor.'">'.htmlentities($member['name']).'</font><br />';
		
		$color = 'b'.$member['room'];
		if ($member['year'] < 6) {
			$nextColor = $colorYear[$member['year'] - 1];
		} else {
			$nextColor = $colorYear[4];
		}
		if (isset($$color)) {
			$$color = (int)round(($$color + $nextColor)/2);
		} else {
			$$color = $nextColor;
		}
	}
	
	# Format the colors
	foreach($members as $member) {
		$color = 'b'.$member['room'];
		if (is_int($$color)) {	
			$$color = rgbhex($$color);
		}
	}

	# Generate the HTML for each of the rooms
	foreach($roomNumbers as $roomnumber) {

		$background = 'rgba(255, 0, 0, .2)';

		ob_start();
		require($overlayFile);
		$body .= ob_get_contents();
		ob_end_clean();
	}

	$endtime = microtime(true);
	$total = round($endtime - $starttime, 4);


	
	$body .= '<br /><br />Request took '.$total.' seconds to complete.';

	require('map.html');


	function rgbhex($rgb) {
		return '#'.str_pad(dechex($rgb), 6, '0', STR_PAD_LEFT);
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
