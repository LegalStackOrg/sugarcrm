<?php
require_once 'modules/Tasks/Task.php';
class DPTask extends Task
{
    function create_new_list_query($order_by, $where, $filter = array(), $params = array(), $show_deleted = 0, $join_type = '', $return_array = false, $parentbean = null, $singleSelect = false, $ifListForExport = false)
    {
        global $odeqScheduleDashlet;
        $query = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, $return_array, $parentbean, $singleSelect, $ifListForExport);

        if(!empty($odeqScheduleDashlet))
        {
            $qq = $query;
            $query = array();
            $query['select'] = $odeqScheduleDashlet->getQuery($qq, "");
            $query['where'] = "";
            $query['from'] = "";
            $query['from_min'] = "";
            $query['order_by'] = "";
            $odeqScheduleDashlet->lvs->lvd->count_query = $odeqScheduleDashlet->getCountQuery();
        }
        return $query;
    }

}
