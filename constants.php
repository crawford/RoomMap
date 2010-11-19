<?php
	$colorDrinkAdmin = 0xAA0000;
	$colorRTP = 0x00AA00;
	$colorEboard = 0x0000AA;

	$colorYear = array(0xDDDDFF, 0xDDFFFF, 0xDDFFDD, 0xFFFFDD, 0xFFDDDD);

	$BASE_DN = 'dc=csh,dc=rit,dc=edu';
	$USERS_DN = 'ou=Users,'.$BASE_DN;
	$GROUPS_DN = 'ou=Groups,'.$BASE_DN;
	$EBOARD_DN = 'cn=eboard,'.$GROUPS_DN;
	$RTP_DN = 'cn=rtp,'.$GROUPS_DN;

	$roomNumbers = array(3009, 3012, 3013, 3016, 3020, 3024, 3038, 3050, 
	                3051, 3054, 3055, 3059, 3063, 3066, 3067, 3070,
	                3070, 3074, 3086, 3090, 3091, 3094, 3095, 3099,
	                3103, 3106, 3107, 3110, 3111, 3125, 3126);

	$overlayFile = 'overlay.html';
	define('LDAP_URL', 'ldaps://ldap.csh.rit.edu');
	define('LDAP_PORT', 636);
?>
