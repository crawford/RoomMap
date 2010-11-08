<?php
	$starttime = microtime(true);

	echo '<h2>im the map, im the map, im the map, im the map, IM THE MAP!!!</h2>';

	$username = 'uid=<username>,';
	$password = '<password>';

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
	$results = ldap_search($ldap, $usersDN, '(&(onfloor=1)(objectClass=houseMember))', array('cn'));
	$onfloors = ldap_get_entries($ldap, $results);

	# Insert them into the members array
	foreach ($onfloors as $person) {
		if (!isset($person['dn']))
			continue;

		$members[$person['dn']] = array('name' => $person['cn'][0], 
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
	

	# Unbind from LDAP
	ldap_unbind($ldap);

	$endtime = microtime(true);

	$total = round($endtime - $starttime, 4);
	echo 'Request took ', $total, ' seconds to complete. To bad LDAP is soooo fucking slow.';
?>
