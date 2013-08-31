<?php

// mysql settings
define( 'DB_HOST', 'localhost' );
define( 'DB_USER', 'MYSQL_USR' );
define( 'DB_PASS', 'MYSQL_PWD' );
define( 'DB_NAME', 'MYSQL_DB' );

//list of servers | ip => label
$servers = array(
	'185.14.184.234' => 'mcfly.bensmann.no'
);

// chart settings
define( 'CHART_TITLE', 'Server Load' );

// data settings
define( 'AUTO_CLEAN_UP', true );	// automatically delete old data?
define( 'STORE_IN_MINUTES', 120 );	// when can we delete the old data?
define( 'DISPLAY_IN_MINUTES', 30 );	// what time period should be displayed in the graph?