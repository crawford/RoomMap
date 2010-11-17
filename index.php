<?php
	$starttime = microtime(true);

	$username = 'cn=map,';
	$password = 'lamp33$firefighter';

	$colorDrinkAdmin = 0xAA0000;
	$colorRTP = 0x00AA00;
	$colorEboard = 0x0000AA;

	$colorYear = array(0xDDDDFF, 0xDDFFFF, 0xDDFFDD, 0xFFFFDD, 0xFFDDDD);

	$baseDN = 'dc=csh,dc=rit,dc=edu';
	$usersDN = 'ou=Users,'.$baseDN;
	$appsDN = 'ou=Apps,'.$baseDN;
	$groupsDN = 'ou=Groups,'.$baseDN;
	$eboardDN = 'cn=eboard,'.$groupsDN;
	$rtpDN = 'cn=rtp,'.$groupsDN;
	$members = null;

	$roomNumbers = array(3009, 3012, 3013, 3016, 3020, 3024, 3038, 3050, 
	                3051, 3054, 3055, 3059, 3063, 3066, 3067, 3070,
	                3070, 3074, 3086, 3090, 3091, 3094, 3095, 3099,
	                3103, 3106, 3107, 3110, 3111, 3125, 3126);
	$overlayFile = 'overlay.html';

	# Connect to LDAP
	$ldap = ldap_connect('ldaps://ldap.csh.rit.edu', 636) or die('Could not connect to LDAP');
	# Bind to LDAP
	ldap_bind($ldap, $username.$appsDN, $password) or die('Could not bind to LDAP');


	# Find all On-Floor members
	$results = ldap_search($ldap, $usersDN, '(&(onfloor=1)(objectClass=houseMember))', array('nickname', 'roomNumber', 'cn', 'homeDirectory', 'drinkAdmin', 'givenName'));
	$onfloors = ldap_get_entries($ldap, $results);

	# Calculate the current directory year
	$curyear = date('Y');
	if (date('W') < 26) {
		# Adjust for school years
		$curyear--;
	}
	$curyear -= 1991;


	# Insert them into the members array
	foreach ($onfloors as $person) {
		if (!isset($person['dn']))
			continue;

		# Get the year level from the home directory
		$matches = null;
		preg_match('/^.*\/u(.*)\/.*$/', $person['homedirectory'][0], $matches);
		

		$matches = $curyear - $matches[1];


		$members[$person['dn']] = array('name' => (!empty($person['nickname'][0]))?$person['nickname'][0]:$person['givenname'][0], 
		                                'room' => $person['roomnumber'][0],
										'year' => $matches,
		                                'rtp' => false,
		                                'eboard' => false,
										'drinkadmin' => $person['drinkadmin'][0]);
	}


	# Find all eboard members
	$results = ldap_search($ldap, $eboardDN, 'objectClass=groupOfNames', array('member'));
	$entries = ldap_get_entries($ldap, $results);

	$eboard = $entries[0]['member'];

	# Set the member to be on eboard
	foreach ($eboard as $person) {
		$members[$person]['eboard'] = true;
	}


	# Find all RTPs
	$results = ldap_search($ldap, $rtpDN, 'objectClass=groupOfNames', array('member'));
	$entries = ldap_get_entries($ldap, $results);

	$rtps = $entries[0]['member'];
	
	# Set the member to be an rtp
	foreach ($rtps as $person) {
		$members[$person]['rtp'] = true;
	}

	# Unbind from LDAP
	ldap_unbind($ldap);


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
