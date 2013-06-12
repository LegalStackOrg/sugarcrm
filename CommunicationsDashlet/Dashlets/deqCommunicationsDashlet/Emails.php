<?php
require_once 'modules/Emails/Email.php';
class DPEmail extends Email
{
    function create_new_list_query($order_by, $where, $filter = array(), $params = array(), $show_deleted = 0, $join_type = '', $return_array = false, $parentbean = null, $singleSelect = false, $ifListForExport = false)
    {
        global $odeqCommunicationDashlet;
        $query = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, $return_array, $parentbean, $singleSelect, $ifListForExport);

        if(!empty($odeqCommunicationDashlet))
        {
            $qq = $query;
            $query = array();
            $query['select'] = $odeqCommunicationDashlet->getQuery($qq, "");
            $query['where'] = "";
            $query['from'] = "";
            $query['from_min'] = "";
            $query['order_by'] = "";
            $odeqCommunicationDashlet->lvs->lvd->count_query = $odeqCommunicationDashlet->getCountQuery();
        }
        return $query;
    }
}
