<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once ('custom/modules/Home/Dashlets/deqCommunicationsDashlet/Emails.php');
require_once ('include/Dashlets/DashletGeneric.php');

class deqCommunicationsDashlet extends DashletGeneric {
	
	var $myItemsOnly = false;
    var $showMyItemsOnly = false;
    var $filters = array();
    var $displayTpl = 'custom/modules/Home/Dashlets/deqCommunicationsDashlet/DashletGenericDisplay.tpl';
    var $configureTpl = 'custom/modules/Home/Dashlets/deqCommunicationsDashlet/DashletGenericConfigure.tpl'; 
    
    function deqCommunicationsDashlet($id, $def = null) {
        global $current_user, $app_strings,$odeqCommunicationDashlet,$mod_strings;
		require ('custom/modules/Home/Dashlets/deqCommunicationsDashlet/deqCommunicationsDashlet.data.php');
		
		$this->logged_calls = (isset($def['logged_calls'])) ? $def['logged_calls'] : false;
        $this->archived_emails = (isset($def['archived_emails'])) ? $def['archived_emails'] : false;
        parent::DashletGeneric($id, $def);
         
        if(empty($def['title'])) $this->title = translate('LBL_DEQ_COMMUNICATIONS', 'Home');
        
        $this->searchFields = $dashletData['deqCommunicationsDashlet']['searchFields'];
        $this->columns = $dashletData['deqCommunicationsDashlet']['columns'];
        $this->seedBean = new DPEmail();
		$odeqCommunicationDashlet = $this;
    }
    
	function process($lvsParams = array())
    {
        global $timedate;
        parent::process($lvsParams);
        foreach($this->lvs->data['data'] as $row => $data) {
          // If name begins with CALLS, then type is call
          if (strpos($this->lvs->data['data'][$row]['NAME'], 'CALLS: ') === 0) {
            $this->lvs->data['data'][$row]['NAME'] = substr($this->lvs->data['data'][$row]['NAME'], 7);
            $this->lvs->data['data'][$row]['MODULE'] = 'Calls';
            $this->lvs->data['data'][$row]['DATA_TYPE'] = '<img alt="" src="custom/modules/Home/Dashlets/deqCommunicationsDashlet/phone_24.png" />';
            if (empty($this->lvs->data['data'][$row]['DATE_START'])) {
              $this->lvs->data['data'][$row]['DATE_START'] = $this->lvs->data['data'][$row]['DATE_SENT'];
            }                
          } 
          // If name begins with EMAILS, then type is email
            elseif (strpos($this->lvs->data['data'][$row]['NAME'], 'EMAILS: ') === 0) {
            $this->lvs->data['data'][$row]['NAME'] = substr($this->lvs->data['data'][$row]['NAME'], 8);
            $this->lvs->data['data'][$row]['MODULE'] = 'Emails';
            $this->lvs->data['data'][$row]['DATA_TYPE'] = '<img alt="" src="custom/modules/Home/Dashlets/deqCommunicationsDashlet/email_24.png" />';
            $this->lvs->data['data'][$row]['DATE_START'] = $this->lvs->data['data'][$row]['DATE_SENT'];
          } 
            // then type is email
            else {
            $this->lvs->data['data'][$row]['MODULE'] = 'Emails';
            $this->lvs->data['data'][$row]['DATA_TYPE'] = '<img alt="" src="custom/modules/Home/Dashlets/deqCommunicationsDashlet/email_24.png" />';
            $this->lvs->data['data'][$row]['DATE_START'] = $this->lvs->data['data'][$row]['DATE_SENT'];
          }
          
          $this->lvs->data['data'][$row]['TIME'] = substr($this->lvs->data['data'][$row]['DATE_START'], 10);
          $date_db = $timedate->to_db_date($this->lvs->data['data'][$row]['DATE_START']);
          $this->lvs->data['data'][$row]['DATE_START'] = substr($this->lvs->data['data'][$row]['DATE_START'], 0, 10);
          
          $this->lvs->data['data'][$row]['DATE_START']  = $this->getDateString($date_db, $this->lvs->data['data'][$row]['DATE_START']);
        }
    }
	
   function buildWhere() {
    $returnArray = array();
    $returnArray = parent::buildWhere();

    return $returnArray;
  }
  
  function getWhereQuery() {
    static $where_sql =  '';
    if (!empty($where_sql)) {
      return $where_sql;
    }
    
    $whereArray = $this->buildWhere();
    foreach ($whereArray as $where) {
      $where_sql  .= " AND {$where} ";
    }
    
    return $where_sql;
  }
  
  function getQuery($ret_array, $params) {
    $today = gmdate('Y-m-d') . ' 00:00:00';
    $c_assigned_where_sql = $e_assigned_where_sql = '';
    $order_by_sql = str_replace(array('emails.', ), '', $ret_array['order_by']);
    
    $where_sql  = $this->getWhereQuery();
    
    $sql = "";
    if ($this->logged_calls) {
      $sql .= "(SELECT C.id , C.date_start AS date_sent, C.date_start , CONCAT('CALLS: ', C.name) AS name, 
      C.assigned_user_id, C.date_entered, C.parent_id , C.parent_type , 'calls' AS data_type FROM calls C 
      WHERE C.deleted=0 AND C.assigned_user_id = '{$GLOBALS['current_user']->id}'
      AND C.date_start >= '{$today}' ".str_replace('emails.', 'C.', $where_sql)." )
      ";
    }
	
    if ($this->archived_emails) {
      if ($this->logged_calls) $sql .= " UNION ";
      $sql .= "(SELECT E.id, E.date_sent, E.date_sent AS date_start, E.name, 
      E.assigned_user_id, E.date_entered,E.parent_id , E.parent_type , 'emails' AS data_type FROM emails E 
      WHERE E.deleted = 0 AND E.assigned_user_id = '{$GLOBALS['current_user']->id}'
      AND E.type = 'inbound' 
      AND E.date_sent >= '{$today}' {$where_sql} ) 
      ";
    }
    
	$sql .= $order_by_sql;
    return $sql;
  }
  
  function getCountQuery() {
    $today  = date('Y-m-d', strtotime('-2 MONTH'));

    $c_assigned_where_sql = $e_assigned_where_sql = '';
    $where_sql  = $this->getWhereQuery();
    
    $sql = "SELECT (";
    if ($this->logged_calls) {
      $sql  .= "(SELECT COUNT(id) AS count FROM calls C 
      where C.deleted=0 {$c_assigned_where_sql} 
      AND C.date_start >= '{$today}' ".str_replace('emails.', 'C.', $where_sql).")
      "; 
    }
    if ($this->archived_emails) {
      if ($this->logged_calls) $sql .= " + ";
      $sql  .= "(SELECT COUNT(E.id) AS count FROM emails E 
      WHERE E.deleted = 0 {$e_assigned_where_sql} 
      AND E.type = 'inbound' 
      AND E.date_sent >= '{$today}' {$where_sql} )
      "; 
    }
		
		$sql  .= ") AS c ";

    return $sql;
  }
  
  function getDateString($date_db, $date) {
    global $mod_strings;
    static $dates = null;
    static $weekdays    = array (
      1 => 'Monday', 
      2 => 'Tuesday', 
      3 => 'Wednesday', 
      4 => 'Thursday', 
      5 => 'Friday', 
      6 => 'Saturday', 
      7 => 'Sunday', 
    );
    if (empty($dates)) {
      $weekday_num = date('N');
      $i = $weekday_num;
      while ($i < 7) {
        $i++;
        $date_diff  = $i - $weekday_num;
        $dte = date('Y-m-d', strtotime("+{$date_diff} DAY"));
        $dates[$dte]  = $weekdays[$i];
      }
      $dates[date('Y-m-d', time()-86400)]  = translate('LBL_YESTERDAY', 'Home');
      $dates[date('Y-m-d')]  = translate('LBL_TODAY', 'Home');
      $dates[date('Y-m-d', time()+86400)]  = translate('LBL_TOMORROW', 'Home');
    }
    if (isset($dates[$date_db])) {
      $date  = $dates[$date_db];
    }
    
    return $date;
  }

	function processDisplayOptions() {
		  $this->seedBean->module_dir = "Home";
	      parent::processDisplayOptions();
		  $this->seedBean->module_dir = "Emails";
	      $this->configureSS->assign('logged_calls', $this->logged_calls);
	      $this->configureSS->assign('archived_emails', $this->archived_emails);
	      
	      $this->configureSS->assign('mod_strings', $GLOBALS['mod_strings']);
	    }
    function saveOptions($req) {
      $options  = parent::saveOptions($req);

      $options['logged_calls'] 		= (!empty($req['logged_calls'])) ? $req['logged_calls'] : false;
      $options['archived_emails'] = (!empty($req['archived_emails'])) ? $req['archived_emails'] : false;

      return $options;
    }
}