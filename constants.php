<?php
	define('COLOR_DRINK_ADMIN', 0xAA0000);
	define('COLOR_RTP',         0x00AA00);
	define('COLOR_EBOARD',      0x0000AA);
	
	define('OVERLAY_OPACITY',       .8);
	define('EMPTY_ROOM_BACKGROUND', 0xFFFFFF);


	$COLOR_YEAR = array(0xBBBBFF, 0xBBFFFF, 0xBBFFBB, 0xFFFFBB, 0xFFBBBB);

	define('BASE_DN',   'dc=csh,dc=rit,dc=edu');
	define('USERS_DN',  'ou=Users,' .BASE_DN);
	define('GROUPS_DN', 'ou=Groups,'.BASE_DN);
	define('EBOARD_DN', 'cn=eboard,'.GROUPS_DN);
	define('RTP_DN',    'cn=rtp,'   .GROUPS_DN);

	$ROOM_NUMBERS = array(3009, 3013, 3016, 3020, 3024, 3050, 3051, 
	                      3054, 3055, 3059, 3063, 3066, 3067, 3070,
	                      3071, 3074, 3086, 3090, 3091, 3094, 3095, 3099,
	                      3103, 3106, 3107, 3110, 3111, 3125, 3126);

	$PROJECTS = array(array('id'   => 'bigdrink',
	                        'name' => 'Big Drink',
	                        'url'  => 'https://wiki.csh.rit.edu/wiki/Big_Drink'),
	                  array('id'   => 'snack',
	                        'name' => 'Snack',
	                        'url'  => 'https://wiki.csh.rit.edu/wiki/Snack'),
	                  array('id'   => 'littledrink',
	                        'name' => 'Little Drink',
	                        'url'  => 'https://wiki.csh.rit.edu/wiki/Little_Drink'),
	                  array('id'   => 'infosys',
	                        'name' => 'Little Infosys',
	                        'url'  => 'https://wiki.csh.rit.edu/wiki/Infosys'));

	$SHOWERS = array(array('id'     => 'sudsLeast',
	                       'status' => 0),
	                 array('id'     => 'sudsLwest',
	                       'status' => 0),
	                 array('id'     => 'sudsNNeast',
	                       'status' => 0),
	                 array('id'     => 'sudsNNwest',
	                       'status' => 0),
	                 array('id'     => 'sudsNSeast',
	                       'status' => 0),
	                 array('id'     => 'sudsNSwest',
	                       'status' => 0),
	                 array('id'     => 'sudsSNeast',
	                       'status' => 0),
	                 array('id'     => 'sudsSNwest',
	                       'status' => 0),
	                 array('id'     => 'sudsSSeast',
	                       'status' => 0),
	                 array('id'     => 'sudsSSwest',
	                       'status' => 0));


	define('ROOM_OVERLAY_FILE',    'roomoverlay.html');
	define('PROJECT_OVERLAY_FILE', 'projectoverlay.html');
	define('SUDS_OVERLAY_FILE', 'sudsoverlay.html');
	define('TEMPMON_OVERLAY_FILE', 'tempmonoverlay.html');

	define('MEMBERS_URL', 'https://profiles.csh.rit.edu/user/');
	define('LDAP_URL',    'ldaps://ldap.csh.rit.edu');
	define('LDAP_PORT',   636);

	define('SUDS_DB_URL',  'db.csh.rit.edu');
	define('SUDS_DB_NAME', 'suds');
	
	define('TEMPMON_DB_URL',  'tempmon.csh.rit.edu');
	define('TEMPMON_DB_NAME', 'tempmon');
	define('TEMPMON_MAX_TEMP', 30);
	define('TEMPMON_MIN_TEMP', 10);
?>
