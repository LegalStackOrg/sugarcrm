<?php
if(!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

$dashletMeta['deqScheduleDashlet'] = array(
    'module' => 'Home',
    'title' => translate('LBL_DEQ_SCHEDULE', 'Home'),
    'description' => 'A customizable Schedule view.',
    'category' => 'Module Views',
    //'icon' => 'custom/modules/Home/Dashlets/deqScheduleDashlet/task_24.png',
    // need to put icon in theme
    // see 94th line @include/MySugar/DashletsDialog/DashletsDialog.php
);
