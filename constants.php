<?php
	define('COLOR_DRINK_ADMIN', 0xAA0000);
	define('COLOR_RTP',         0x00AA00);
	define('COLOR_EBOARD',      0x0000AA);
	
	define('OVERLAY_OPACITY', .8);


	$COLOR_YEAR = array(0xBBBBFF, 0xBBFFFF, 0xBBFFBB, 0xFFFFBB, 0xFFBBBB);

	define('BASE_DN',   'dc=csh,dc=rit,dc=edu');
	define('USERS_DN',  'ou=Users,' .BASE_DN);
	define('GROUPS_DN', 'ou=Groups,'.BASE_DN);
	define('EBOARD_DN', 'cn=eboard,'.GROUPS_DN);
	define('RTP_DN',    'cn=rtp,'   .GROUPS_DN);

	$ROOM_NUMBERS = array(3009, 3013, 3016, 3020, 3024, 3038, 3050, 
	                      3051, 3054, 3055, 3059, 3063, 3066, 3067, 3070,
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
	                        'url'  => 'https://wiki.csh.rit.edu/wiki/Little_Drink'));


	define('ROOM_OVERLAY_FILE',    'roomoverlay.html');
	define('PROJECT_OVERLAY_FILE', 'projectoverlay.html');

	define('MEMBERS_URL', 'https://members.csh.rit.edu/profiles/members/');
	define('LDAP_URL',    'ldaps://ldap.csh.rit.edu');
	define('LDAP_PORT',   636);
?>
