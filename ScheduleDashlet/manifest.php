<?php

$manifest = array(
    'acceptable_sugar_versions' => array('regex_matches' => array("6\\.*", ), ),
    'acceptable_sugar_flavors' => array(
        'CE',
        'PRO',
        'ENT',
        'CORP',
        'ULT'
    ),
    'readme' => '',
    'key' => 'dllc',
    'author' => 'Data Equity LLC',
    'description' => 'Data Equity LLC Schedule Dashlet',
    'icon' => '',
    'is_uninstallable' => true,
    'name' => 'deqScheduleDashlet',
    'published_date' => '2013-05-27 21:12:30',
    'type' => 'module',
    'version' => '1.2',
    'remove_tables' => '',
);

$installdefs = array(
    'id' => 'deqScheduleDashlet',
    /*'copy' => array( array(
     'from' => '<basepath>/Dashlets/deqScheduleDashlet/',
     'to' => 'custom/modules/Tasks/Dashlets/deqScheduleDashlet/',
     ), ),*/
    'dashlets' => array( array(
            'from' => '<basepath>/Dashlets/deqScheduleDashlet/',
            'name' => 'deqScheduleDashlet',
        )),
    'language' => array( array(
            'from' => '<basepath>/Language/Home/en_us.deqScheduleDashlet.php',
            'to_module' => 'Home',
            'language' => 'en_us',
        ),
        /*array(
         'from' => '<basepath>/Language/Tasks/en_us.deqScheduleDashlet.php',
         'to_module' => 'Tasks',
         'language' => 'en_us',
         ),*/
    ),
);
