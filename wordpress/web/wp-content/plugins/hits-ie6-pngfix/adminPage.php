<?php
if($_POST['hits_ie6_pngfix_save'])
{
	if (! wp_verify_nonce($_POST['_wpnonce'], 'hits_ie6_pngfix-update-options') ) die(_e('Whoops! There was a problem with the data you posted. Please go back and try again.', $this->localizationDomain)); 
	$this->options['hits_ie6_pngfix_method'] = $_POST['hits_ie6_pngfix_method'];   
	$this->options['hits_ie6_pngfix_THM_CSSSelector'] = $_POST['hits_ie6_pngfix_THM_CSSSelector'];
	$this->options['hits_ie6_debug']= $_POST['hits_ie6_debug'];
	$this->options['hits_ie6_pngfix_pagesAreCached'] = $_POST['hits_ie6_pngfix_pagesAreCached'];
	$this->saveAdminOptions();
                
	echo '<div class="updated"><p>'. __('Success! Your changes were sucessfully saved!', $this->localizationDomain) .'</p></div>';
}
?>                                   
<div class="wrap">
	<h2>HITS- IE6 PNG Fix</h2>
	<form method="post" id="hits_ie6_pngfix_options">
		<?php wp_nonce_field('hits_ie6_pngfix-update-options');?>
		<p><?php _e('This plugin brought to you for free by ', $this->localizationDomain);?><a href="http://www.itegritysolutions.ca/community/wordpress/ie6-png-fix" target="_blank" >ITegrity Solutions</a>.</p>
		<p><?php _e('I take no credit for the great effort authors have gone into making each method of getting IE6 PNG compatability to work. I just did the work to merge them all into a single wordpress plugin.', $this->localizationDomain);?></p>
		<table width="100%" cellspacing="2" cellpadding="5" class="form-table"> 
			<tr valign="top"> 
				<th width="33%" scope="row"><?php _e('PNG Fix Method:', $this->localizationDomain); ?></th> 
				<td>
					<select name="hits_ie6_pngfix_method" id="hits_ie6_pngfix_method" style="width:200px;">
						<option value="THM1"<?php if (strcmp($this->options['hits_ie6_pngfix_method'],'THM1')==0) { echo ' selected="selected"';} ?>><?php _e('Twin Helix v1.0', $this->localizationDomain);?></option>
						<option value="THM2"<?php if (strcmp($this->options['hits_ie6_pngfix_method'],'THM2')==0) { echo ' selected="selected"';} ?>><?php _e('Twin Helix v2.0', $this->localizationDomain);?></option>
						<option value="UPNGFIX"<?php if (strcmp($this->options['hits_ie6_pngfix_method'],'UPNGFIX')==0) { echo ' selected="selected"';} ?>><?php _e('Unit PNG Fix', $this->localizationDomain);?></option>
						<option value="SUPERSLEIGHT"<?php if (strcmp($this->options['hits_ie6_pngfix_method'],'SUPERSLEIGHT')==0) { echo ' selected="selected"';} ?>><?php _e('SuperSleight', $this->localizationDomain);?></option>
						<option value="DD_BELATED"<?php if (strcmp($this->options['hits_ie6_pngfix_method'],'DD_BELATED')==0) { echo ' selected="selected"';} ?>><?php _e('DD_belatedPNG', $this->localizationDomain);?></option>
					</select>
				</td> 
			</tr>
			<tr>
				<th width="33%" scope="row"><?php _e('CSS Selector:', $this->localizationDomain); ?></th>
				<td><input type="text" name="hits_ie6_pngfix_THM_CSSSelector" value="<?php echo $this->options['hits_ie6_pngfix_THM_CSSSelector'] ?>" size="100" /><br /><?php _e('Note: CSS Selector is not used for Unit PNG Fix and SuperSleight.', $this->localizationDomain);?></td>
			</tr>
			<tr valign="top"> 
				<th width="33%" scope="row"><?php _e('Where detection should occur:', $this->localizationDomain); ?></th> 
				<td>
					<select name="hits_ie6_pngfix_pagesAreCached" id="hits_ie6_pngfix_pagesAreCached" style="width:200px;">
						<option value="false"<?php if (strcmp($this->options['hits_ie6_pngfix_pagesAreCached'],'false')==0) { echo ' selected="selected"';} ?>><?php _e('Pages are not cached (default)', $this->localizationDomain);?></option>
						<option value="true"<?php if (strcmp($this->options['hits_ie6_pngfix_pagesAreCached'],'true')==0) { echo ' selected="selected"';} ?>><?php _e('Pages are cached', $this->localizationDomain);?></option>
					</select>
					<br />
					<?php _e('Note: Pages being cached rely on browser conditional comments, and can interfere with your theme.', $this->localizationDomain);?>
				</td> 
			</tr>
			<tr>
				<th width="33%" scope="row"><?php _e('Plugin Debug Mode:', $this->localizationDomain); ?></th>
				<td>
					<select name="hits_ie6_debug" id="hits_ie6_debug" style="width:100px;">
						<option value="false" <?php if (strcmp($this->options['hits_ie6_debug'],'false')==0) { echo ' selected="selected"';} ?>><?php _e('False',$this->localizationDomain);?></option>
						<option value="true" <?php if (strcmp($this->options['hits_ie6_debug'],'true')==0) { echo ' selected="selected"';} ?>><?php _e('True',$this->localizationDomain);?></option>
					</select>
					<br />
					<?php _e('Note: Please set this to true if you are having difficulties with this plugin.', $this->localizationDomain);?>
				</td>
			</tr>
			<tr>
				<th colspan=2><input type="submit" name="hits_ie6_pngfix_save" value="<?php _e('Save',$this->localizationDomain);?>" /></th>
			</tr>
		</table>
                    
		<p><?php _e('Feedback and requests are always welcome. ', $this->localizationDomain);?><a href="http://www.homeitsolutions.ca/websites/wordpress-plugins/ie6-png-fix"> <?php _e('Visit the plugin website', $this->localizationDomain);?></a> <?php _e('to leave any feedback, translations, comments or donations. All donations will go towards micro loans through', $this->localizationDomain);?> <a href="http://www.kiva.org">Kiva</a>.</p>
		<h3><?php _e('PNG Fix Credits', $this->localizationDomain);?></h3>
		<p><?php _e('The Twin Helix approaches were taken from', $this->localizationDomain);?> <a href="http://www.twinhelix.com/css/iepngfix/">Twin Helix</a></p>
		<p><?php _e('The UnitInteractive approach was taken from', $this->localizationDomain);?> <a href="http://labs.unitinteractive.com/unitpngfix.php"> Unit Interactive Labs</a>.</p>
		<p><?php _e('The SuperSleight apprach was taken from', $this->localizationDomain);?> <a href="http://allinthehead.com/retro/338/supersleight-jquery-plugin">Drew McLellan</a></p>
		<p><?php _e('The DD_belatedPNG approach was taken from', $this->localizationDomain);?> <a href="http://dillerdesign.com/experiment/DD_belatedPNG/">DillerDesign</a></p>
	</form>
</div>