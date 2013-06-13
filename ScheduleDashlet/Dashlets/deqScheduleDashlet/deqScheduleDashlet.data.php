<?php
if(!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

global $current_user;
$dashletData['deqScheduleDashlet']['searchFields'] = array(
    'name' => array('default' => ''),
);

$dashletData['deqScheduleDashlet']['columns'] = array(
    'data_type' => array(
        'width' => '2',
        'label' => ' ',
        'sortable' => false,				
        'source' => 'non-db',
        'default' => true,
    ),
    'date_start' => array(
        'width' => '6',
        'label' => 'LBL_DASHLET_DATE',
        'default' => true,
    ),
    'time' => array(
        'width' => '5',
        'label' => 'LBL_DASHLET_TIME',
        'sortable' => false,
        'default' => true,
    ),
    'name' => array(
        'width' => '30',
        'label' => 'LBL_SUBJECT',
        'link' => true,
        'default' => true,
        'dynamic_module' => 'MODULE',
    ),
    'parent_name' => array(
        'width' => '20',
        'label' => 'LBL_LIST_RELATED_TO',
        'sortable' => false,
        'dynamic_module' => 'PARENT_TYPE',
        'link' => true,
        'id' => 'PARENT_ID',
        'ACLTag' => 'PARENT',
        'related_fields' => array(
            'parent_id',
            'parent_type'
        ),
        'default' => true,
    ),
);
?>
