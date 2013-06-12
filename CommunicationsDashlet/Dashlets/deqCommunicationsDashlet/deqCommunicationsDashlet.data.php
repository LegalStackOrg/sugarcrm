<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


global $current_user;
$dashletData['deqCommunicationsDashlet']['searchFields'] = array(
  'name' => array('default' => ''),
);
 
$dashletData['deqCommunicationsDashlet']['columns'] = array(
	'data_type' => array(
    'width' => '3',
    'label' => 'LBL_DEQ_COMMUNICATIONS_MODULE',
    'default' => true,
    'source' => 'non-db',
	),
  'name' => array(
    'width'          => '30', 
    'label'          => 'LBL_SUBJECT',
    'link'           => true,
    'default'        => true,
    'dynamic_module' => 'MODULE',
  ),
  'date_start' => array(
    'width' => '5',
    'default' => true,
    'label' => 'LBL_DASHLET_DATE'
  ),
  'time' => array(
    'width' => '5',
    'label' => 'LBL_DASHLET_TIME',
    'sortable' => false,
  ),
);