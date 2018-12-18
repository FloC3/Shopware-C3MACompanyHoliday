{block name="frontend_detail_index_c3_holiday"}
    {assign var="holidaystart" value=$C3MACompanyHoliday.start|date_format:"%Y%m%d%H%M%S"}
    {assign var="holidayend" value=$C3MACompanyHoliday.end|date_format:"%Y%m%d%H%M%S"}
    {assign var="holidaydateformat" value="{s namespace="frontend/detail/index/c3/holiday" name="HolidayDateformat"}%d.%m.%Y{/s}"}
    {assign var="holidayinfo" value="{s namespace="frontend/detail/index/c3/holiday" name="Infotext"}Wir befinden uns von %start bis %end in Betriebsurlaub. Natürlich können Sie in dieser Zeit weiterhin bei uns bestellen. Bitte beachten Sie aber, dass es zu Lieferverzögerungen kommen kann. Wir versenden Ihre Ware schnellstmöglich nach dem %end.{/s}"}
    {assign var="holidaystartout" value=$holidaystart|date_format:"$holidaydateformat"}
    {assign var="holidayendout" value=$holidayend|date_format:"$holidaydateformat"}
    {assign var="holidayfindarr" value=array("%start", "%end")}
    {assign var="holidayreplarr" value=array($holidaystartout, $holidayendout)}

    {if $smarty.now|date_format:"%Y%m%d%H%M%S" > $holidaystart && $smarty.now|date_format:"%Y%m%d%H%M%S" < $holidayend}
        {block name="frontend_detail_index_c3_holiday_alert"}
            <div class="alert is--info is--rounded">
                <div class="alert--icon">
                    <i class="icon--element icon--info"></i>
                </div>
                <div class="alert--content">
                    {$holidayinfo|replace:$holidayfindarr:$holidayreplarr}
                </div>
            </div>
        {/block}
    {/if}
{/block}