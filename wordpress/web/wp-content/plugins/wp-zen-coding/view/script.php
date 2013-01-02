<?php if (count(debug_backtrace()) === 0) exit(); ?>
<script type="text/javascript" src="<?php echo $baseUrl; ?>zen_textarea<?php echo $min; ?>.js"></script>
<script type="text/javascript">
(function(zen) {

	// Set options
	zen.setup(<?php echo json_encode($this->option['options']); ?>);

	// Set variables
	var ResourceManager = zen.getResourceManager();
	ResourceManager.setVocabulary({
		'variables': <?php echo json_encode($option['variables']); ?>
	}, 'user');

	// Unbind shortcuts
	var shortcuts = zen.getShortcuts(), length = shortcuts.length, i = 0;
	for (; i < length; ++i) {
		zen.unbindShortcut(shortcuts[i].keystroke);
	}

	// Add shortcuts
<?php
	foreach ($option['shortcut'] as $type => $keys) {
		foreach ($keys as $key) {
			echo "\tzen.addShortcut('$key', '$type');" . PHP_EOL;
		}
	}
?>

})(zen_textarea);
</script>