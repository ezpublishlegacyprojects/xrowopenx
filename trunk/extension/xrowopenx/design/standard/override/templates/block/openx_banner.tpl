<div class="openxad banner {$block.view}">
{if $block.name}
<div class="heading">{$block.name|wash}</div>
{/if}
<script type='text/javascript'>
<!--// <![CDATA[

{if $block.custom_attributes.zone_override}
OA_show('{$block.custom_attributes.zone_override}');
{else}
OA_show('{$block.view}');
{/if}
	
// ]]> --></script>
</div>