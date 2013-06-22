<?php

$manifest = array (
	'acceptable_sugar_versions' => array('regex_matches' => array("6\\.*", ), ),
    'acceptable_sugar_flavors' => array(
        'DEV',
		'CE',
        'PRO',
        'ENT',
        'CORP',
        'ULT'
    ),
	'readme'=>'',
	'key'=>'deq',
	'author' => 'Data Equity LLC',
	'description' => 'My Communications Dashlet by Data Equity LLC ',
	'icon' => '',
	'is_uninstallable' => true,
	'name' => 'deqCommunicationsDashlet',
	'published_date' => '2012-05-31 00:19:38',
	'type' => 'module',
	'version' => '1.3',
	'remove_tables' => 'prompt',
);

$installdefs = array (
	'id' => 'deqCommunicationsDashlet',
	 'copy' => array( array(
     'from' => '<basepath>/custom/',
     'to' => 'custom/',
     ), ),
	'dashlets' => 
	array (
	   array(
	     'from' => '<basepath>/Dashlets/deqCommunicationsDashlet/',
	     'name' => 'deqCommunicationsDashlet',
	   )
	),
	'language' => 
	array (
	  array (
	    'from' => '<basepath>/Language/Home/en_us.deqCommunicationsDashlet.php',
	    'to_module' => 'Home',
	    'language' => 'en_us',
	  ),
	),
);

