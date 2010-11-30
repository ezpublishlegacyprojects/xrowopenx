<div class="openxad banner {$banner}">
{if $heading}
<div class="heading">{$heading|wash}</div>
{/if}
<script type='text/javascript'>
<!--// <![CDATA[

{if $zone_override}
OA_show('{$zone_override}');
{else}
OA_show('{$banner}');
{/if}
	
// ]]> --></script>
</div>