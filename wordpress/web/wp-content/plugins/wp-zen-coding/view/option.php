<?php if (count(debug_backtrace()) === 0) exit(); ?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>Zen Coding</h2>

<form method="post" action="options.php">
	<div class="hiddens">
		<?php wp_nonce_field('update-options'); ?>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="<?php echo $optionName; ?>" />
	</div>
	<h3><?php _e('Variables', $domain); ?></h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th><?php _e('lang', $domain); ?></th>
				<td><input type="text" name="<?php echo $optionName; ?>[variables][lang]" value="<?php echo $option['variables']['lang']; ?>" /></td>
			</tr>
			<tr>
				<th><?php _e('charset', $domain); ?></th>
				<td><input type="text" name="<?php echo $optionName; ?>[variables][charset]" value="<?php echo $option['variables']['charset']; ?>" /></td>
			</tr>
			<tr>
				<th><?php _e('Indent character', $domain); ?></th>
				<td>
					<input type="text" id="<?php echo $domain; ?>_var_indentation_text" name="<?php echo $optionName; ?>[variables][indentation]" value="<?php echo $option['variables']['indentation']; ?>"<?php if ($option['variables']['indentation'] === '') echo ' disabled="disabled"'; ?> />
					<input type="checkbox" id="<?php echo $domain; ?>_var_indentation" name="<?php echo $optionName; ?>[variables][indentation]" value=""<?php if ($option['variables']['indentation'] === '') echo ' checked="checked"'; ?> />
					<label for="<?php echo $domain; ?>_var_indentation"><?php _e('Use "Horizontal tab"', $domain); ?></label>
					<script type="text/javascript">
						jQuery(function($) {
							var text = $('#<?php echo $domain; ?>_var_indentation_text');
							$('#<?php echo $domain; ?>_var_indentation').click(function() {
								if ($(this).attr('checked')) {
									text.attr('disabled', 'disabled');
								} else {
									text.removeAttr('disabled');
								}
							});
						});
					</script>
				</td>
			</tr>
		</tbody>
	</table>

	<h3><?php _e('Options', $domain); ?></h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th><?php _e('Profile', $domain); ?></th>
				<td>
					<select name="<?php echo $optionName; ?>[options][profile]">
						<option<?php if ($option['options']['profile'] === 'xhtml') echo ' selected="selected"'; ?>>xhtml</option>
						<option<?php if ($option['options']['profile'] === 'html') echo ' selected="selected"'; ?>>html</option>
						<option<?php if ($option['options']['profile'] === 'xml') echo ' selected="selected"'; ?>>xml</option>
						<option<?php if ($option['options']['profile'] === 'plain') echo ' selected="selected"'; ?>>plain</option>
					</select>
			</tr>
			<tr>
				<th><?php _e('Insert horizontal tab by TAB key', $domain); ?></th>
				<td>
					<input type="hidden" name="<?php echo $optionName; ?>[options][use_tab]" value="0" />
					<input id="<?php echo $domain; ?>_op_use_tab" type="checkbox" name="<?php echo $optionName; ?>[options][use_tab]" value="1"<?php if ($option['options']['use_tab']) echo ' checked="checked"'; ?> />
					<label for="<?php echo $domain; ?>_op_use_tab"><?php _e('Use', $domain); ?></label>
				</td>
			</tr>
			<tr>
				<th><?php _e('Auto indent by Line break', $domain); ?></th>
				<td>
					<input type="hidden" name="<?php echo $optionName; ?>[options][pretty_break]" value="0" />
					<input id="<?php echo $domain; ?>_op_pretty_break" type="checkbox" name="<?php echo $optionName; ?>[options][pretty_break]" value="1"<?php if ($option['options']['pretty_break']) echo ' checked="checked"'; ?> />
					<label for="<?php echo $domain; ?>_op_pretty_break"><?php _e('Use', $domain); ?></label>
				</td>
			</tr>
		</tbody>
	</table>

<?php
__('Expand Abbreviation', $domain);
__('Balance Tag Outward', $domain);
__('Balance Tag inward', $domain);
__('Wrap with Abbreviation', $domain);
__('Next Edit Point', $domain);
__('Previous Edit Point', $domain);
__('Select Line', $domain);
__('Merge Lines', $domain);
__('Toggle Comment', $domain);
__('Split/Join Tag', $domain);
__('Remove Tag', $domain);
__('Evaluate Math Expression', $domain);
__('Increment number by 1', $domain);
__('Decrement number by 1', $domain);
__('Increment number by 0.1', $domain);
__('Decrement number by 0.1', $domain);
__('Increment number by 10', $domain);
__('Decrement number by 10', $domain);
__('Select Next Item', $domain);
__('Select Previous Item', $domain);
?>
	<h3><?php _e('Shortcut', $domain); ?></h3>
	<table class="form-table">
		<tbody>
<?php	foreach ($option['shortcut'] as $name => $values): ?>
			<tr>
				<th><?php _e($name, $domain); ?></th>
				<td>
					<ul>
<?php			if (!empty($values)): ?>
<?php				foreach ($values as $value): ?>
						<li><input type="text" name="<?php echo $optionName; ?>[shortcut][<?php echo $name; ?>][]" value="<?php echo $value; ?>" /></li>
<?php				endforeach; ?>
<?php			else: ?>
						<li><input type="text" name="<?php echo $optionName; ?>[shortcut][<?php echo $name; ?>][]" value="" /></li>
<?php			endif; ?>
					</ul>
				</td>
			</tr>
<?php	endforeach; ?>
		</tbody>
	</table>

	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save option', $domain); ?>" />
	</p>

</form>

<h3><?php _e('Test', $domain); ?></h3>
<p><?php _e('You can test &quot;Zen Coding&quot;.', $domain); ?></p>
<div><textarea rows="20" cols="80">html:5>div#page>div#header>ul.navigation>li*4>a</textarea></div>

</div>
