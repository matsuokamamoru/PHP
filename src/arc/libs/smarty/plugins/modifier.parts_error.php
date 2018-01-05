<?php
function smarty_modifier_parts_error($paramas, array $html = array('<p class="error">', '</p>'))
{
	array_walk_recursive($paramas, function($val) use($html) {
		echo $html[0] . $val . $html[1];
	});
	return;
}
