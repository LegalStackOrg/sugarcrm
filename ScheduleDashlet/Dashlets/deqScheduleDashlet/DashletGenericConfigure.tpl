
<div>
<form action='index.php' id='configure_{$id}' method='post' onSubmit='SUGAR.mySugar.setChooser(); return SUGAR.dashlets.postForm("configure_{$id}", SUGAR.mySugar.uncoverPage);'>
<input type='hidden' name='id' value='{$id}'>
<input type='hidden' name='module' value='Home'>
<input type='hidden' name='action' value='ConfigureDashlet'>
<input type='hidden' name='configure' value='true'>
<input type='hidden' name='to_pdf' value='true'>
<input type='hidden' id='displayColumnsDef' name='displayColumnsDef' value=''>
<input type='hidden' id='hideTabsDef' name='hideTabsDef' value=''>
<input type='hidden' id='dashletType' name='dashletType' value='' />

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="edit view">
	<tr>
        <td scope='row'colspan='4' align='left'>
        	<h2>{$strings.general}</h2>
        </td>
    </tr>
    <tr>
	    <td scope='row'>
		    {$strings.title}
        </td>
        <td colspan='3'>
            <input type='text' name='dashletTitle' value='{$dashletTitle}'>
        </td>
	</tr>
    <tr>
	    <td scope='row'>
		    {$strings.displayRows}
        </td>
        <td{if !$isRefreshable} colspan='3'{/if}>
            <select name='displayRows'>
				{html_options values=$displayRowOptions output=$displayRowOptions selected=$displayRowSelect}
           	</select>
        </td>
        {if $isRefreshable}
        <td scope='row'>
		    {$strings.autoRefresh}
        </td>
        <td>
            <select name='autoRefresh'>
				{html_options options=$autoRefreshOptions selected=$autoRefreshSelect}
           	</select>
        </td>
        {/if}
    </tr>
    
    <tr>
        <td colspan='4' align='center'>
        	<table border='0' cellpadding='0' cellspacing='0'>
        	<tr><td>
			    {$columnChooser}
		    </td>
		    </tr></table>
	    </td>    
	</tr>
	{if $showMyItemsOnly || !empty($searchFields)}
	<tr>
        <td scope='row'colspan='4' align='left'>
	        <br>
        	<h2>{$strings.filters}</h2>
        </td>
    </tr>
    {if $showMyItemsOnly}
    <tr>
	    <td scope='row'>
            {$strings.myItems}
        </td>
        <td>
            <input type='checkbox' {if $myItemsOnly == 'true'}checked{/if} name='myItemsOnly' value='true'>
        </td>
    </tr>
    {/if}
    
    <tr>
	    <td scope='row'>
            <img src='custom/modules/Home/Dashlets/deqScheduleDashlet/meeting_24.png' alt='' align='absmiddle' border='0'> &nbsp; {$mod_strings.LBL_SCHEDULE_MEETINGS} 
        </td>
        <td>
            <input type='checkbox' {if $scheduled_meetings == 'true'}checked{/if} name='scheduled_meetings' value='true'>
        </td>
    </tr>
    <tr>
    <tr>
	    <td scope='row'>
            <img src='custom/modules/Home/Dashlets/deqScheduleDashlet/task_24.png' alt='' align='absmiddle' border='0'> &nbsp; {$mod_strings.LBL_TASKS_TO_START} 
        </td>
        <td>
            <input type='checkbox' {if $tasks_to_start == 'true'}checked{/if} name='tasks_to_start' value='true'>
        </td>
    </tr>
    <tr>
	    <td scope='row'>
            <img src='custom/modules/Home/Dashlets/deqScheduleDashlet/project_task_24.png' alt='' align='absmiddle' border='0'> &nbsp; {$mod_strings.LBL_PROJECT_TASKS_TO_START} 
        </td>
        <td>
            <input type='checkbox' {if $project_tasks_to_start == 'true'}checked{/if} name='project_tasks_to_start' value='true'>
        </td>
    </tr>
    <tr>
    <tr>
    {foreach name=searchIteration from=$searchFields key=name item=params}
        <td scope='row' valign='top'>
            {$params.label}
        </td>
        <td valign='top' style='padding-bottom: 5px'>
            {$params.input}
        </td>
        {if ($smarty.foreach.searchIteration.iteration is even) and $smarty.foreach.searchIteration.iteration != $smarty.foreach.searchIteration.last}
        </tr><tr>
        {/if}
    {/foreach}
    </tr>
    {/if}
    <tr>
	    <td colspan='4' align='right'>
	        <input type='submit' class='button' value='{$strings.save}'>
	        {if $showClearButton}
	        <input type='submit' class='button' value='{$strings.clear}' onclick='SUGAR.searchForm.clear_form(this.form,["dashletTitle","displayRows","autoRefresh"]);return false;'>
	        {/if}
	    </td>    
	</tr>
</table>
</form>
</div>
