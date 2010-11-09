<?php
	$starttime = microtime(true);


	$username = 'uid=<username>,';
	$password = '<password>';

	$colorRTPEboard = '#00FFFF';
	$colorRTP = '#00FF00';
	$colorEboard = '#0000FF';

	$baseDN = 'dc=csh,dc=rit,dc=edu';
	$usersDN = 'ou=Users,'.$baseDN;
	$groupsDN = 'ou=Groups,'.$baseDN;
	$eboardDN = 'cn=eboard,'.$groupsDN;
	$rtpDN = 'cn=rtp,'.$groupsDN;
	$members = null;

	# Connect to LDAP
	$ldap = ldap_connect('ldaps://ldap.csh.rit.edu', 636) or die('Could not connect to LDAP');
	# Bind to LDAP
	ldap_bind($ldap, $username.$usersDN, $password) or die('Could not bind to LDAP');


	# Find all On-Floor members
	$results = ldap_search($ldap, $usersDN, '(&(onfloor=1)(objectClass=houseMember))', array('nickname', 'roomNumber', 'cn'));
	$onfloors = ldap_get_entries($ldap, $results);

	# Insert them into the members array
	$room = 3009;
	foreach ($onfloors as $person) {
		if (!isset($person['dn']))
			continue;

		$members[$person['dn']] = array('name' => $person['cn'][0], 
		                                'room' => $person['roomNumber'][0],
										'year' => 0,
		                                'rtp' => false,
		                                'eboard' => false);
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
		$name = 'n'.$member['room'];
		if ($member['rtp'] and $member['eboard']) {
			$$name = '<font color="'.$colorRTPEboard.'">';
		} else if ($member['rtp']) {
			$$name = '<font color="'.$colorRTP.'">';
		} else if ($member['eboard']) {
			$$name = '<font color="'.$colorEboard.'">';
		} else {
			$$name = '<font>';
		}
		$$name += $member['name'].'</font>';
		
		$color = 'b'.$person['room'];
		$$color = '#FFAAAA';
	}

	require('map.html');

	$endtime = microtime(true);

	$total = round($endtime - $starttime, 4);
	echo '<br /><br />Request took ', $total, ' seconds to complete.';

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
