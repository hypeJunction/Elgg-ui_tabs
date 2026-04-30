<?php
$entity = elgg_extract('entity', $vars);
?>

<div>
	<label><?php echo elgg_echo('ui:tabs:settings:ajax_page_tabs') ?></label>
	<?php
	echo elgg_view('input/select', [
		'name' => 'params[ajax_page_tabs]',
		'value' => $entity->ajax_page_tabs,
		'options_values' => [
			0 => elgg_echo('option:no'),
			1 => elgg_echo('option:yes'),
		]
	]);
	?>
</div>


