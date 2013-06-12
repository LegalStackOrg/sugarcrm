<?php
if(!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once ('custom/modules/Home/Dashlets/deqScheduleDashlet/Tasks.php');
require_once ('include/Dashlets/DashletGeneric.php');
class deqScheduleDashlet extends DashletGeneric
{
    var $myItemsOnly = false;
    var $showMyItemsOnly = false;
    var $filters = array();
    var $displayTpl = 'custom/modules/Home/Dashlets/deqScheduleDashlet/DashletGenericDisplay.tpl';
    var $configureTpl = 'custom/modules/Home/Dashlets/deqScheduleDashlet/DashletGenericConfigure.tpl';

    function deqScheduleDashlet($id, $def = null)
    {
        global $current_user, $app_strings, $odeqScheduleDashlet;
        require ('custom/modules/Home/Dashlets/deqScheduleDashlet/deqScheduleDashlet.data.php');

        $this->scheduled_meetings = (isset($def['scheduled_meetings'])) ? $def['scheduled_meetings'] : true;
        $this->tasks_to_start = (isset($def['tasks_to_start'])) ? $def['tasks_to_start'] : true;
        $this->project_tasks_to_start = (isset($def['project_tasks_to_start'])) ? $def['project_tasks_to_start'] : true;
        parent::DashletGeneric($id, $def);

        if(empty($def['title']))
            $this->title = translate('LBL_DEQ_SCHEDULE', 'Home');

        $this->searchFields = $dashletData['deqScheduleDashlet']['searchFields'];
        $this->columns = $dashletData['deqScheduleDashlet']['columns'];
        $this->seedBean = new DPTask();
        $odeqScheduleDashlet = $this;
    }

    function process($lvsParams = array())
    {
        global $timedate;
        parent::process($lvsParams);
        foreach ($this->lvs->data['data'] as $row => $data)
        {
            // If name begins with MEETING, then type is meeting
            if(strpos($this->lvs->data['data'][$row]['NAME'], 'MEETING: ') === 0)
            {
                $this->lvs->data['data'][$row]['NAME'] = substr($this->lvs->data['data'][$row]['NAME'], 9);
                $this->lvs->data['data'][$row]['MODULE'] = 'Meetings';
                $this->lvs->data['data'][$row]['DATA_TYPE'] = '<img alt="Meeting" src="custom/modules/Home/Dashlets/deqScheduleDashlet/meeting_24.png" />';
            }
            // If name begins with PROJECT, then type is meeting
            elseif(strpos($this->lvs->data['data'][$row]['NAME'], 'PROJECT: ') === 0)
            {
                $this->lvs->data['data'][$row]['NAME'] = substr($this->lvs->data['data'][$row]['NAME'], 9);
                $this->lvs->data['data'][$row]['MODULE'] = 'ProjectTask';
                $this->lvs->data['data'][$row]['DATA_TYPE'] = '<img alt="" src="custom/modules/Home/Dashlets/deqScheduleDashlet/project_task_24.png" />';
            }
            // then type is task
            else
            {
                $this->lvs->data['data'][$row]['MODULE'] = 'Tasks';
                $this->lvs->data['data'][$row]['DATA_TYPE'] = '<img alt="" src="custom/modules/Home/Dashlets/deqScheduleDashlet/task_24.png" />';
            }

            $this->lvs->data['data'][$row]['TIME'] = substr($this->lvs->data['data'][$row]['DATE_START'], 10);
            $date_db = $timedate->to_db_date($this->lvs->data['data'][$row]['DATE_START']);
            $this->lvs->data['data'][$row]['DATE_START'] = substr($this->lvs->data['data'][$row]['DATE_START'], 0, 10);

            $this->lvs->data['data'][$row]['DATE_START'] = $this->getDateString($date_db, $this->lvs->data['data'][$row]['DATE_START']);

        }
    }

    function buildWhere()
    {
        $returnArray = array();
        $returnArray = parent::buildWhere();
        return $returnArray;
    }

    function getWhereQuery()
    {
        static $where_sql = '';
        if(!empty($where_sql))
        {
            return $where_sql;
        }

        $whereArray = $this->buildWhere();
        foreach ($whereArray as $where)
        {
            $where_sql .= " AND {$where} ";
        }

        return $where_sql;
    }

    function getQuery($ret_array, $params)
    {
        $today = gmdate('Y-m-d') . ' 00:00:00';
        $order_by_sql = str_replace(array('tasks.', ), '', $ret_array['order_by']);

        //$where_sql = "";
        $where_sql = $this->getWhereQuery();

        $sql = "";
        if($this->tasks_to_start)
        {
            $sql .= "(SELECT tasks.id , tasks.date_start , tasks.name , tasks.parent_id , tasks.parent_type , tasks.assigned_user_id, tasks.date_entered, 'task' AS data_type FROM tasks where tasks.deleted=0 AND tasks.assigned_user_id = '{$GLOBALS['current_user']->id}' AND tasks.date_start >= '{$today}' {$where_sql})";
        }
        if($this->scheduled_meetings)
        {
            if($this->tasks_to_start)
                $sql .= " UNION ";
            $sql .= "(SELECT M.id, M.date_start, CONCAT('MEETING: ', M.name) AS name, M.parent_id, M.parent_type, M.assigned_user_id, M.date_entered, 'meeting' AS data_type FROM meetings M WHERE M.deleted = 0 AND M.assigned_user_id = '{$GLOBALS['current_user']->id}' AND M.date_start >= '{$today}' " . str_replace('tasks.', 'M.', $where_sql) . ") ";
        }
        if($this->project_tasks_to_start)
        {
            if($this->tasks_to_start || $this->scheduled_meetings)
                $sql .= " UNION ";
            $sql .= "(SELECT PT.id, CONCAT(PT.date_start, ' 00:00:00') AS date_start, CONCAT('PROJECT: ', PT.name) AS name, PT.project_id AS parent_id, 'Project' AS parent_type, PT.assigned_user_id, PT.date_entered, 'project' AS data_type FROM project_task PT, project P WHERE PT.deleted = 0 AND PT.assigned_user_id = '{$GLOBALS['current_user']->id}' AND PT.date_start >= '{$today}' AND P.id = PT.project_id AND P.deleted = 0 " . str_replace('tasks.', 'PT.', $where_sql) . ") ";
        }

        $sql .= $order_by_sql;
        return $sql;
    }

    function getCountQuery()
    {
        $today = gmdate('Y-m-d') . ' 00:00:00';
        // $where_sql = "";
        $where_sql = $this->getWhereQuery();

        $sql = "SELECT (";
        if($this->tasks_to_start)
        {
            $sql .= "(SELECT COUNT(id) AS count FROM tasks where tasks.deleted=0 AND tasks.assigned_user_id = '{$GLOBALS['current_user']->id}' AND tasks.date_start >= '{$today}' {$where_sql} )";
        }
        if($this->scheduled_meetings)
        {
            if($this->tasks_to_start)
                $sql .= " + ";
            $sql .= "(SELECT COUNT(M.id) AS count FROM meetings M WHERE M.deleted = 0 AND M.assigned_user_id = '{$GLOBALS['current_user']->id}' AND M.date_start >= '{$today}' " . str_replace('tasks.', 'M.', $where_sql) . ")";
        }
        if($this->project_tasks_to_start)
        {
            if($this->tasks_to_start || $this->scheduled_meetings)
                $sql .= " + ";
            $sql .= "(SELECT COUNT(PT.id) AS count FROM project P, project_task PT WHERE P.deleted = 0 AND P.assigned_user_id = '{$GLOBALS['current_user']->id}' AND PT.deleted = 0 AND P.id = PT.project_id AND PT.date_start >= '{$today}' " . str_replace('tasks.', 'PT.', $where_sql) . ")";
        }
        $sql .= ") AS c ";
        return $sql;
    }

    function getDateString($date_db, $date)
    {
        global $mod_strings;
        static $dates = null;
        static $weekdays = array(
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        );
        if(empty($dates))
        {
            $weekday_num = date('N');
            $i = $weekday_num;
            while ($i < 7)
            {
                $i++;
                $date_diff = $i - $weekday_num;
                $dte = date('Y-m-d', strtotime("+{$date_diff} DAY"));
                $dates[$dte] = $weekdays[$i];
            }
            $dates[date('Y-m-d', time() - 86400)] = $mod_strings['LBL_YESTERDAY'];
            $dates[date('Y-m-d')] = $mod_strings['LBL_TODAY'];
            $dates[date('Y-m-d', time() + 86400)] = $mod_strings['LBL_TOMORROW'];
        }

        if(isset($dates[$date_db]))
        {
            $date = $dates[$date_db];
        }
        return $date;
    }

    function processDisplayOptions()
    {
        $this->seedBean->module_dir = "Home";
        parent::processDisplayOptions();
        $this->seedBean->module_dir = "Tasks";
        $this->configureSS->assign('scheduled_meetings', $this->scheduled_meetings);
        $this->configureSS->assign('tasks_to_start', $this->tasks_to_start);
        $this->configureSS->assign('project_tasks_to_start', $this->project_tasks_to_start);
        $this->configureSS->assign('mod_strings', $GLOBALS['mod_strings']);
    }

    function saveOptions($req)
    {
        $options = parent::saveOptions($req);

        $options['scheduled_meetings'] = (!empty($req['scheduled_meetings'])) ? $req['scheduled_meetings'] : false;
        $options['tasks_to_start'] = (!empty($req['tasks_to_start'])) ? $req['tasks_to_start'] : false;
        $options['project_tasks_to_start'] = (!empty($req['project_tasks_to_start'])) ? $req['project_tasks_to_start'] : false;

        return $options;
    }

}
