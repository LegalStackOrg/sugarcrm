<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
    <tr class="pagination">
        <td colspan='{$colCount+1}' align='right'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                <tr>
                    <td align='left'>&nbsp;</td>
                    <td align='right' nowrap='nowrap'>
                        {if $pageData.urls.startPage}
                            <!--<a href='#' onclick='return SUGAR.mySugar.retrieveDashlet("{$dashletId}", "{$pageData.urls.startPage}")' ><img src='{sugar_getimagepath file="start.png"}' alt='{$navStrings.start}' align='absmiddle' border='0' width='14' height='13'>&nbsp;{$navStrings.start}</a>&nbsp;-->
                            <button title='{$navStrings.start}' class='button' onclick='return SUGAR.mySugar.retrieveDashlet("{$dashletId}", "{$pageData.urls.startPage}")'>
                                <img src='{sugar_getimagepath file='start.png'}' alt='{$navStrings.start}' align='absmiddle' border='0'>
                            </button>

                        {else}
                            <!--<img src='{sugar_getimagepath file="start_off.png"}' alt='{$navStrings.start}' align='absmiddle' border='0'>&nbsp;{$navStrings.start}&nbsp;&nbsp;-->
                            <button title='{$navStrings.start}' class='button' disabled>
                                <img src='{sugar_getimagepath file='start_off.png'}' alt='{$navStrings.start}' align='absmiddle' border='0'>
                            </button>

                        {/if}
                        {if $pageData.urls.prevPage}
                            <!--<a href='#' onclick='return SUGAR.mySugar.retrieveDashlet("{$dashletId}", "{$pageData.urls.prevPage}")' ><img src='{sugar_getimagepath file="previous.png"}' alt='{$navStrings.previous}' align='absmiddle' border='0' width='8' height='13'>&nbsp;{$navStrings.previous}</a>&nbsp;-->
                            <button title='{$navStrings.previous}' class='button' onclick='return SUGAR.mySugar.retrieveDashlet("{$dashletId}", "{$pageData.urls.prevPage}")'>
                                <img src='{sugar_getimagepath file='previous.png'}' alt='{$navStrings.previous}' align='absmiddle' border='0'>
                            </button>

                        {else}
                            <!--<img src='{sugar_getimagepath file="previous_off.png"}' alt='{$navStrings.previous}' align='absmiddle' border='0' width='8' height='13'>&nbsp;{$navStrings.previous}&nbsp;-->
                            <button class='button' disabled title='{$navStrings.previous}'>
                                <img src='{sugar_getimagepath file='previous_off.png'}' alt='{$navStrings.previous}' align='absmiddle' border='0'>
                            </button>
                        {/if}
                            <span class='pageNumbers'>({if $pageData.offsets.lastOffsetOnPage == 0}0{else}{$pageData.offsets.current+1}{/if} - {$pageData.offsets.lastOffsetOnPage} {$navStrings.of} {if $pageData.offsets.totalCounted}{$pageData.offsets.total}{else}{$pageData.offsets.total}{if $pageData.offsets.lastOffsetOnPage != $pageData.offsets.total}+{/if}{/if})</span>
                        {if $pageData.urls.nextPage}
                            <!--&nbsp;<a href='#' onclick='return SUGAR.mySugar.retrieveDashlet("{$dashletId}", "{$pageData.urls.nextPage}")' >{$navStrings.next}&nbsp;<img src='{sugar_getimagepath file="next.png"}' alt='{$navStrings.next}' align='absmiddle' border='0' width='8' height='13'></a>&nbsp;-->
                            <button title='{$navStrings.next}' class='button' onclick='return SUGAR.mySugar.retrieveDashlet("{$dashletId}", "{$pageData.urls.nextPage}")'>
                                <img src='{sugar_getimagepath file='next.png'}' alt='{$navStrings.next}' align='absmiddle' border='0'>
                            </button>

                        {else}
                           <!-- &nbsp;{$navStrings.next}&nbsp;<img src='{sugar_getimagepath file="next_off.png"}' alt='{$navStrings.next}' align='absmiddle' border='0' width='8' height='13'>-->
                            <button class='button' title='{$navStrings.next}' disabled>
                                <img src='{sugar_getimagepath file='next_off.png'}' alt='{$navStrings.next}' align='absmiddle' border='0'>
                            </button>

                        {/if}
                        {if $pageData.urls.endPage  && $pageData.offsets.total != $pageData.offsets.lastOffsetOnPage}
                            <!--<a href='#' onclick='return SUGAR.mySugar.retrieveDashlet("{$dashletId}", "{$pageData.urls.endPage}")' >{$navStrings.end}&nbsp;<img src='{sugar_getimagepath file="end.png"}' alt='{$navStrings.end}' align='absmiddle' border='0' width='14' height='13'></a></td>-->
                            <button title='{$navStrings.end}' class='button' onclick='return SUGAR.mySugar.retrieveDashlet("{$dashletId}", "{$pageData.urls.endPage}")'>
                                <img src='{sugar_getimagepath file='end.png'}' alt='{$navStrings.end}' align='absmiddle' border='0'>
                            </button>

                        {elseif !$pageData.offsets.totalCounted || $pageData.offsets.total == $pageData.offsets.lastOffsetOnPage}
                            <!--&nbsp;{$navStrings.end}&nbsp;<img src='{sugar_getimagepath file="end_off.png"}' alt='{$navStrings.end}' align='absmiddle' border='0' width='14' height='13'>-->
                            <button class='button' disabled title='{$navStrings.end}'>
                                <img src='{sugar_getimagepath file='end_off.png'}' alt='{$navStrings.end}' align='absmiddle' border='0'>
                            </button>

                        {/if}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr height='20'>
        {foreach from=$displayColumns key=colHeader item=params}
            <th scope='col' width='{$params.width}%' nowrap="nowrap">
                <div style='white-space: nowrap;'width='100%' align='{$params.align|default:'left'}'>
                {if $params.sortable|default:true}
                    <a href='#' onclick='return SUGAR.mySugar.retrieveDashlet("{$dashletId}", "{$pageData.urls.orderBy}{$params.orderBy|default:$colHeader|lower}&sugar_body_only=1&id={$dashletId}")' class='listViewThLinkS1'>{sugar_translate label=$params.label module=Home}</a>&nbsp;&nbsp;
                    {if $params.orderBy|default:$colHeader|lower == $pageData.ordering.orderBy}
                        {if $pageData.ordering.sortOrder == 'ASC'}
                            {capture assign="imageName"}arrow_down.{$arrowExt}{/capture}
                            <img border='0' src='{sugar_getimagepath file=$imageName}' width='{$arrowWidth}' height='{$arrowHeight}' align='absmiddle' alt='{$arrowAlt}'>
                        {else}
                            {capture assign="imageName"}arrow_up.{$arrowExt}{/capture}
                            <img border='0' src='{sugar_getimagepath file=$imageName}' width='{$arrowWidth}' height='{$arrowHeight}' align='absmiddle' alt='{$arrowAlt}'>
                        {/if}
                    {else}
                        {capture assign="imageName"}arrow.{$arrowExt}{/capture}
                        <img border='0' src='{sugar_getimagepath file=$imageName}' width='{$arrowWidth}' height='{$arrowHeight}' align='absmiddle' alt='{$arrowAlt}'>
                    {/if}
               {else}
                    {if !isset($params.noHeader) || $params.noHeader == false}
                      {sugar_translate label=$params.label module=Home}
                    {/if}
               {/if}
               </div>
            </th>
        {/foreach}
        {if !empty($quickViewLinks)}
        <th scope='col' nowrap="nowrap" width='1%'>&nbsp;</th>
        {/if}
    </tr>

    {foreach name=rowIteration from=$data key=id item=rowData}
        {if $smarty.foreach.rowIteration.iteration is odd}
            {assign var='_rowColor' value=$rowColor[0]}
        {else}
            {assign var='_rowColor' value=$rowColor[1]}
        {/if}
        <tr height='20' class='{$_rowColor}S1'>
            {if $prerow}
            <td width='1%' nowrap='nowrap'>
                    <input onclick='sListView.check_item(this, document.MassUpdate)' type='checkbox' class='checkbox' name='mass[]' value='{$rowData[$params.id]|default:$rowData.ID}'>
            </td>
            {/if}
            {counter start=0 name="colCounter" print=false assign="colCounter"}
            {foreach from=$displayColumns key=col item=params}
                {strip}
                <td scope='row' align='{$params.align|default:'left'}' valign="top" {if ($params.type == 'teamset')}class="nowrap"{/if}>
                    {if $col == 'NAME' || $params.bold}<b>{/if}
                    {if $params.link && !$params.customCode}
                        <{$pageData.tag.$id[$params.ACLTag]|default:$pageData.tag.$id.MAIN} href='index.php?action={$params.action|default:'DetailView'}&module={if $params.dynamic_module}{$rowData[$params.dynamic_module]}{else}{$params.module|default:$pageData.bean.moduleDir}{/if}&record={$rowData[$params.id]|default:$rowData.ID}&offset={$pageData.offsets.current+$smarty.foreach.rowIteration.iteration}&stamp={$pageData.stamp}'>
                    {/if}
                    {if $params.customCode}
                        {sugar_evalcolumn_old var=$params.customCode rowData=$rowData}
                    {else}
                       {sugar_field parentFieldArray=$rowData vardef=$params displayType=ListView field=$col}
                    {/if}
                    {if empty($rowData.$col) && empty($params.customCode)}&nbsp;{/if}
                    {if $params.link && !$params.customCode}
                        </{$pageData.tag.$id[$params.ACLTag]|default:$pageData.tag.$id.MAIN}>
                    {/if}
                    {if $col == 'NAME' || $params.bold}</b>{/if}
                </td>
                {/strip}
                {counter name="colCounter"}
            {/foreach}
            {if !empty($quickViewLinks)}
            <td width='1%' class='{$_rowColor}S1' bgcolor='{$_bgColor}' nowrap>
                {if $pageData.access.edit}
                    <a title='{$editLinkString}' href='index.php?action=EditView&module={$rowData.MODULE}&record={$rowData.ID}'><img border="0" src="{sugar_getimagepath file="edit_inline.png"}"></a>
                {/if}
                {if $pageData.access.view}
                    <a title='{$viewLinkString}' href='index.php?action=DetailView&module={$rowData.MODULE}&record={$rowData.ID}'><img border="0" src="{sugar_getimagepath file="view_inline.png"}"></a>
                {/if}
            </td>
            {/if}
            </tr>
    {foreachelse}
    <tr height='20' class='{$rowColor[0]}S1'>
        <td colspan="{$colCount}">
            <em>{$APP.LBL_NO_DATA}</em>
        </td>
    </tr>
    {/foreach}
</table>
