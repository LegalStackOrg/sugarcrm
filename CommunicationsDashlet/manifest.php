<?php

$manifest = array (
	'acceptable_sugar_versions' => array('regex_matches' => array("6\\.*", ), ),
    'acceptable_sugar_flavors' => array(
        'CE',
        'PRO',
        'ENT',
        'CORP',
        'ULT'
    ),
	'readme'=>'',
	'key'=>'dllc',
	'author' => 'Data Equity LLC',
	'description' => 'Data Equity LLC Communications Dashlet',
	'icon' => '',
	'is_uninstallable' => true,
	'name' => 'deqCommunicationsDashlet',
	'published_date' => '2012-05-31 00:19:38',
	'type' => 'module',
	'version' => '1.2',
	'remove_tables' => 'prompt',
);

$installdefs = array (
	'id' => 'deqCommunicationsDashlet',
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

