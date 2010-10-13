<div class="banner {$type}">
{if $block.name}
<div class="heading">{$heading|wash}</div>
{/if}
<script type='text/javascript'>
<!--// <![CDATA[

{if $zone_override}
OA_show('{$zone_override}');
{else}
OA_show('{$type}');
{/if}
	
// ]]> --></script>
</div>

<script type="text/javascript" language="javascript">{$content}</script>