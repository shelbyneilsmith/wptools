<div class="wordfenceModeElem" id="wordfenceMode_scan"></div>
<div class="wrap wordfence">
	<div class="wordfence-lock-icon wordfence-icon32"><br /></div><h2 id="wfHeading">Wordfence Scan</h2>
	<div class="wordfenceWrap">
		<div class="wordfenceScanButton">
			<table border="0" cellpadding="0" cellspacing="0" style="width: 800px;">
			<tr>
				<td style="width: 250px; padding-top: 10px;">
					<input type="button" value="Start a Wordfence Scan" id="wfStartScanButton1" class="wfStartScanButton button-primary" onclick="wordfenceAdmin.startScan();" /><br />
					&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="WFAD.killScan(); return false;" style="font-size: 10px; color: #AAA;">Click here to kill a running scan.</a>
				</td>
				<td>
					<div style="border: 1px solid #CCC; padding: 4px;">
						You can <a href="#" onclick="WFAD.startTourAgain(); return false;">start the tour again</a> or <a target="_blank" href="http://www.wordfence.com/forums/">visit our support forums for help.</a> Love Wordfence? You can help by doing two simple things: <a href="http://wordpress.org/extend/plugins/wordfence/" target="_blank">Go to WordPress.org now and give this plugin a 5&#9733; rating</a>. Blog about Wordfence and link to the <a href="http://wordpress.org/extend/plugins/wordfence/" target="_blank">plugin page</a>. Spreading the word helps us keep the best features free.
					</div>
				</td>
			</tr>
			</table>
		</div>
		<div>
			<div class="consoleHead">
				<span class="consoleHeadText">Scan Summary</span>
			</div>
			<?php 
				$events = wordfence::getLog()->getStatusEvents(0);
			?>
			<div class="bevelDiv1 consoleOuter"><div class="bevelDiv2"><div class="bevelDiv3 consoleInner" id="consoleSummary">
			<?php if(sizeof($events) < 1){ ?>
				<div style="width: 500px;">
					Welcome to Wordfence!<br /><br />
					To get started, simply click the blue button at the top of this page to start your first scan.
				</div>
			<?php } ?>
			</div></div></div>
			<?php if(wfConfig::get('isPaid')){ ?>
			<div style="margin: 0 0 20px 5px; width: 795px; font-weight: bold; color: #0A0;">
				Premium scanning enabled.	
			</div>
			<?php } else { ?>
			<div style="margin: 0 0 20px 5px; width: 795px;">
				<strong>How to upgrade:</strong> If you would like to control how often your site is checked for security vulnerabilities and infections, and you would like to be able to block countries, <a href="https://www.wordfence.com/choose-a-wordfence-membership-type/?s2-ssl=yes" target="_blank">visit www.wordfence.com</a> and sign up for our paid option. Then go to the Wordfence options page on this site and replace your free API key with your new premium key. You will then be able to activate the premium scanning options on the Wordfence options page.
			</div>

			<?php } ?>
			<div class="consoleHead" style="margin-top: 20px;">
				<span class="consoleHeadText">Scan Detailed Activity</span>
				<a href="#" class="wfALogMailLink" onclick="WFAD.emailActivityLog(); return false;">Email activity log</a>
			</div>
			<div class="bevelDiv1 consoleOuter"><div class="bevelDiv2"><div class="bevelDiv3 consoleInner" id="consoleActivity">
				<?php 
					if(sizeof($events) > 0){
						$debugOn = wfConfig::get('debugOn', false);
						$newestItem = 0;
						$sumEvents = array();
						$timeOffset = 3600 * get_option('gmt_offset');
						foreach($events as $e){
							if(strpos($e['msg'], 'SUM_') !== 0){
								if( $debugOn || $e['level'] < 4){
									$typeClass = '';
									if($debugOn){
										$typeClass = ' wf' . $e['type'];
									}
									echo '<div class="wfActivityLine' . $typeClass . '">[' . date('M d H:i:s', $e['ctime'] + $timeOffset) . ']&nbsp;' . $e['msg'] . '</div>';
								}
							}
							$newestItem = $e['ctime'];
						}

						echo '<script type="text/javascript">WFAD.lastALogCtime = ' . $newestItem . '; WFAD.processActArray(' . json_encode(wordfence::getLog()->getSummaryEvents()) . ');</script>';
					} else { ?>
						A live stream of what Wordfence is busy with right now will appear in this box.

					<?php
					}
				?>
			</div></div></div>
			<div style="position: relative; width: 803px;">
				&nbsp;
				<a href="#" target="_blank" class="wfALogViewLink" id="wfALogViewLink">View activity log</a>
			</div>
			<div style="margin: 0 0 20px 5px; width: 795px;">
				<strong>Docs:</strong> Our <a href="http://www.wordfence.com/docs/" target="_blank">Wordfence Documentation</a> has tips on <a href="http://www.wordfence.com/docs/using-wordfence-to-analyze-changes-in-wordpress-files/" target="_blank">dealing with changed files</a>, <a href="http://www.wordfence.com/docs/how-to-clean-a-hacked-wordpress-site-using-wordfence/" target="_blank">how to clean a hacked site</a> and our <a href="http://www.wordfence.com/docs/frequently-asked-questions/" target="_blank">FAQ</a>.
				<?php $unknownFilesLink = wfUtils::siteURLRelative() . '?_wfsf=unknownFiles&nonce=' . wp_create_nonce('wp-ajax'); ?>
				<br /><strong>Tools:</strong> Cleaning a hacked system? See a <a href="<?php echo $unknownFilesLink ?>&sort=3&dir=rev" target="_blank">list of files that are not in the WordPress core, plugin or theme repositories</a> after your first scan.
			</div>

		</div>
		<div style="margin-top: 20px;">
			<div id="wfTabs">
				<a href="#" id="wfNewIssuesTab" class="wfTab2 wfTabSwitch selected" onclick="wordfenceAdmin.switchIssuesTab(this, 'new'); return false;">New Issues</a>
				<a href="#" class="wfTab2 wfTabSwitch"          onclick="wordfenceAdmin.switchIssuesTab(this, 'ignored'); return false;">Ignored Issues</a>
			</div>
			<div class="wfTabsContainer">
				<div id="wfIssues_new" class="wfIssuesContainer">
					<h2>New Issues</h2>
					<p>
						The list below shows new problems or warnings that Wordfence found with your site.
						If you have fixed all the issues below, you can <a href="#" onclick="WFAD.updateAllIssues('deleteNew'); return false;">click here to mark all new issues as fixed</a>.
						You can also <a href="#" onclick="WFAD.updateAllIssues('ignoreAllNew'); return false;">ignore all new issues</a> which will exclude all issues listed below from future scans.
					</p>
					 <div id="wfIssues_dataTable_new">
					 </div>
				</div>
				<div id="wfIssues_ignored" class="wfIssuesContainer">
					<h2>Ignored Issues</h2>
					<p>
						The list below shows issues that you know about and have chosen to ignore.
						You can <a href="#" onclick="WFAD.updateAllIssues('deleteIgnored'); return false;">click here to clear all ignored issues</a>
						which will cause all issues below to be re-scanned by Wordfence in the next scan.
					</p>
					 <div id="wfIssues_dataTable_ignored"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/x-jquery-template" id="issueTmpl_wfThemeUpgrade">
<div>
<div class="wfIssue">
	<h2>${shortMsg}</h2>
	<p>
		<table border="0" class="wfIssue" cellspacing="0" cellpadding="0">
		<tr><th>Theme Name:</th><td>${data.name}</td></tr>
		<tr><th>Current Theme Version:</th><td>${data.version}</td></tr>
		<tr><th>New Theme Version:</th><td>${data.newVersion}</td></tr>
		<tr><th>Theme URL:</th><td><a href="${data.URL}" target="_blank">${data.URL}</a></td></tr>
		<tr><th>Severity:</th><td>{{if severity == '1'}}Critical{{else}}Warning{{/if}}</td></tr>
		<tr><th>Status</th><td>
			{{if status == 'new' }}New{{/if}}
			{{if status == 'ignoreP' || status == 'ignoreC' }}Ignored{{/if}}
		</td></tr>
		</table>
	</p>
	<p>
		{{html longMsg}}
		<a href="<?php echo get_admin_url() . 'update-core.php'; ?>">Click here to update now</a>.
	</p>
	<div class="wfIssueOptions">
		{{if (status == 'new')}}
			<strong>Resolve:</strong>
			<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">I have fixed this issue</a>
			<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreC'); return false;">Ignore this issue</a>
		{{/if}}
		{{if status == 'ignoreC' || status == 'ignoreP'}}
			<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreC'); return false;">Stop ignoring this issue</a>
		{{/if}}
	</div>
</div>
</div>
</script>

<script type="text/x-jquery-template" id="issueTmpl_wfPluginUpgrade">
<div>
<div class="wfIssue">
	<h2>${shortMsg}</h2>
	<p>
		<table border="0" class="wfIssue" cellspacing="0" cellpadding="0">
		<tr><th>Plugin Name:</th><td>${data.Name}</td></tr>
		{{if data.PluginURI}}<tr><th>Plugin Website:</th><td><a href="${data.PluginURI}" target="_blank">${data.PluginURI}</a></td></tr>{{/if}}
		<tr><th>Current Plugin Version:</th><td>${data.Version}</td></tr>
		<tr><th>New Plugin Version:</th><td>${data.newVersion}</td></tr>
		<tr><th>Severity:</th><td>{{if severity == '1'}}Critical{{else}}Warning{{/if}}</td></tr>
		<tr><th>Status</th><td>
			{{if status == 'new' }}New{{/if}}
			{{if status == 'ignoreP' || status == 'ignoreC' }}Ignored{{/if}}
		</td></tr>
		</table>
	</p>
	<p>
		{{html longMsg}}
		<a href="<?php echo get_admin_url() . 'update-core.php'; ?>">Click here to update now</a>.
	</p>
	<div class="wfIssueOptions">
	{{if status == 'new'}}
		<strong>Resolve:</strong>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">I have fixed this issue</a>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreC'); return false;">Ignore this issue</a>
	{{/if}}
	{{if status == 'ignoreC' || status == 'ignoreP'}}
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">Stop ignoring this issue</a>
	{{/if}}
	</div>
</div>
</div>
</script>

<script type="text/x-jquery-template" id="issueTmpl_wfUpgrade">
<div>
<div class="wfIssue">
	<h2>${shortMsg}</h2>
	<p>
		<table border="0" class="wfIssue" cellspacing="0" cellpadding="0">
		<tr><th>Current WordPress Version:</th><td>${data.currentVersion}</td></tr>
		<tr><th>New WordPress Version:</th><td>${data.newVersion}</td></tr>
		<tr><th>Severity:</th><td>{{if severity == '1'}}Critical{{else}}Warning{{/if}}</td></tr>
		<tr><th>Status</th><td>
			{{if status == 'new' }}New{{/if}}
			{{if status == 'ignoreP' || status == 'ignoreC' }}Ignored{{/if}}
		</td></tr>
		</table>
	</p>
	<p>
		{{html longMsg}}
		<a href="<?php echo get_admin_url() . 'update-core.php'; ?>">Click here to update now</a>.
	</p>
	<div class="wfIssueOptions">
	{{if (status == 'new')}}
		<strong>Resolve:</strong>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">I have fixed this issue</a>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreC'); return false;">Ignore this issue</a>
	{{/if}}
	{{if status == 'ignoreC' || status == 'ignoreP'}}
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">Stop ignoring this issue</a>
	{{/if}}
</div>
</div>
</script>

<script type="text/x-jquery-template" id="issueTmpl_dnsChange">
<div>
<div class="wfIssue">
	<h2>${shortMsg}</h2>
	<p>
		<table border="0" class="wfIssue" cellspacing="0" cellpadding="0">
		<tr><th>Old DNS records:</th><td>${data.oldDNS}</td></tr>
		<tr><th>New DNS records:</th><td>${data.newDNS}</td></tr>
		<tr><th>Severity:</th><td>{{if severity == '1'}}Critical{{else}}Warning{{/if}}</td></tr>
		<tr><th>Status</th><td>
			{{if status == 'new' }}New{{/if}}
			{{if status == 'ignoreP' || status == 'ignoreC' }}Ignored{{/if}}
		</td></tr>
		</table>
	</p>
	<p>
		{{html longMsg}}
	</p>
	<div class="wfIssueOptions">
	{{if (status == 'new')}}
		<strong>Resolve:</strong> 
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">I know about this change</a>
	{{/if}}
	</div>
</div>
</div>
</script>

<script type="text/x-jquery-template" id="issueTmpl_diskSpace">
<div>
<div class="wfIssue">
	<h2>${shortMsg}</h2>
	<p>
		<table border="0" class="wfIssue" cellspacing="0" cellpadding="0">
		<tr><th>Space remaining:</th><td>${data.spaceLeft}</td></tr>
		<tr><th>Severity:</th><td>{{if severity == '1'}}Critical{{else}}Warning{{/if}}</td></tr>
		<tr><th>Status</th><td>
			{{if status == 'new' }}New{{/if}}
			{{if status == 'ignoreP' || status == 'ignoreC' }}Ignoring all disk space alerts{{/if}}
		</td></tr>
		</table>
	</p>
	<p>
		{{html longMsg}}
	</p>
	<div class="wfIssueOptions">
	{{if (status == 'new')}}
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">I have fixed this issue</span>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreP'); return false;">Ignore disk space alerts</span>
	{{/if}}
	{{if status == 'ignoreP' || status == 'ignoreC'}}
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">Stop ignoring disk space alerts</a>
	{{/if}}
	</div>
</div>
</div>
</script>

<script type="text/x-jquery-template" id="issueTmpl_easyPassword">
<div>
<div class="wfIssue">
	<h2>${shortMsg}</h2>
	<p>
		<table border="0" class="wfIssue" cellspacing="0" cellpadding="0">
		<tr><th>Issue first detected:</th><td>${timeAgo} ago.</td></tr>
		<tr><th>Login name:</th><td>${data.user_login}</td></tr>
		<tr><th>User email:</th><td>${data.user_email}</td></tr>
		<tr><th>Full name:</th><td>${data.first_name} ${data.last_name}</td></tr>
		<tr><th>Severity:</th><td>{{if severity == '1'}}Critical{{else}}Warning{{/if}}</td></tr>
		<tr><th>Status</th><td>
			{{if status == 'new' }}New{{/if}}
			{{if status == 'ignoreC' }}Ignored until user changes password{{/if}}
			{{if status == 'ignoreP' }}Ignoring this user's weak passwords{{/if}}
		</td></tr>
		</table>
	</p>
	<p>
		{{html longMsg}}
	</p>
	<div class="wfIssueOptions">
		<strong>Tools:</strong>
		<a target="_blank" href="${data.editUserLink}">Edit this user</a>
	</div>
	<div class="wfIssueOptions">
	{{if status == 'new'}}
		<strong>Resolve:</strong> 
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">I have fixed this issue</a>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreC'); return false;">Ignore this weak password</a>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreP'); return false;">Ignore all this user's weak passwords</a>
	{{/if}}
	{{if status == 'ignoreC' || status == 'ignoreP'}}
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">Stop ignoring this issue</a>
	{{/if}}
	</div>
</div>
</div>
</script>

<script type="text/x-jquery-template" id="issueTmpl_commentBadURL">
<div>
<div class="wfIssue">
	<h2>${shortMsg}</h2>
	<p>
		<table border="0" class="wfIssue" cellspacing="0" cellpadding="0">
		<tr><th>Author</th><td>${data.author}</td></tr>
		<tr><th>Bad URL:</th><td><strong class="wfWarn">${data.badURL}</strong></td></tr>
		<tr><th>Posted on:</th><td>${data.commentDate}</td></tr>
		{{if data.isMultisite}}
		<tr><th>Multisite Blog ID:</th><td>${data.blog_id}</td></tr>
		<tr><th>Multisite Blog Domain:</th><td>${data.domain}</td></tr>
		<tr><th>Multisite Blog Path:</th><td>${data.path}</td></tr>
		{{/if}}
		<tr><th>Severity:</th><td>Critical</td></tr>
		<tr><th>Status</th><td>
			{{if status == 'new' }}New{{/if}}
			{{if status == 'ignoreP' || status == 'ignoreC' }}Ignored{{/if}}
		</td></tr>
		</table>
	</p>
	<p>
		{{html longMsg}}
	</p>
	<div class="WfIssueOptions">
		<strong>Tools:</strong>
		<a target="_blank" href="${data.editCommentLink}">Edit this ${data.type}</a>
	</div>
	<div class="wfIssueOptions">
	{{if status == 'new'}}
		<strong>Resolve:</strong> 
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">I have fixed this issue</a>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreC'); return false;">Ignore this ${data.type}</a>
	{{/if}}
	{{if status == 'ignoreC' || status == 'ignoreP'}}
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">Stop ignoring this ${data.type}</a>
	{{/if}}
</div>
</div>
</script>
<script type="text/x-jquery-template" id="issueTmpl_postBadTitle">
<div>
<div class="wfIssue">
	<h2>${shortMsg}</h2>
	<p>
		<table border="0" class="wfIssue" cellspacing="0" cellpadding="0">
		<tr><th>Title:</th><td><strong class="wfWarn">${data.postTitle}</strong></td></tr>
		<tr><th>Posted on:</th><td>${data.postDate}</td></tr>
		{{if data.isMultisite}}
		<tr><th>Multisite Blog ID:</th><td>${data.blog_id}</td></tr>
		<tr><th>Multisite Blog Domain:</th><td>${data.domain}</td></tr>
		<tr><th>Multisite Blog Path:</th><td>${data.path}</td></tr>
		{{/if}}
		<tr><th>Severity:</th><td>Critical</td></tr>
		<tr><th>Status</th><td>
			{{if status == 'new' }}New{{/if}}
			{{if status == 'ignoreC' }}This bad title will be ignored in this ${data.type}.{{/if}}
			{{if status == 'ignoreP' }}This post won't be scanned for bad titles.{{/if}}
		</td></tr>
		</table>
	</p>
	<p>
		{{html longMsg}}
	</p>
	<div class="wfIssueOptions">
		<strong>Tools:</strong> 
		<a target="_blank" href="${data.editPostLink}">Edit this ${data.type}</a>
	</div>
	<div class="wfIssueOptions">
	{{if status == 'new'}}
		<strong>Resolve:</strong> 
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">I have fixed this issue</a>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreC'); return false;">Ignore this title in this ${data.type}</a>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreP'); return false;">Ignore all dangerous titles in this ${data.type}</a>
	{{/if}}
	{{if status == 'ignoreP' || status == 'ignoreC'}}
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">Stop ignoring this issue</a>
	{{/if}}
	</div>
</div>
</div>
</script>

<script type="text/x-jquery-template" id="issueTmpl_postBadURL">
<div>
<div class="wfIssue">
	<h2>${shortMsg}</h2>
	<p>
		<table border="0" class="wfIssue" cellspacing="0" cellpadding="0">
		{{if data.isMultisite}}
		<tr><th>Title:</th><td><a href="${data.permalink}" target="_blank">${data.postTitle}</a></td></tr>
		{{else}}
		<tr><th>Title:</th><td><a href="${data.permalink}" target="_blank">${data.postTitle}</a></td></tr>
		{{/if}}
		<tr><th>Bad URL:</th><td><strong class="wfWarn">${data.badURL}</strong></td></tr>
		<tr><th>Posted on:</th><td>${data.postDate}</td></tr>
		{{if data.isMultisite}}
		<tr><th>Multisite Blog ID:</th><td>${data.blog_id}</td></tr>
		<tr><th>Multisite Blog Domain:</th><td>${data.domain}</td></tr>
		<tr><th>Multisite Blog Path:</th><td>${data.path}</td></tr>
		{{/if}}
		<tr><th>Severity:</th><td>Critical</td></tr>
		<tr><th>Status</th><td>
			{{if status == 'new' }}New{{/if}}
			{{if status == 'ignoreC' }}This bad URL will be ignored in this ${data.type}.{{/if}}
			{{if status == 'ignoreP' }}This post won't be scanned for bad URL's.{{/if}}
		</td></tr>
		</table>
	</p>
	<p>
		{{html longMsg}}
	</p>
	<div class="wfIssueOptions">
		<strong>Tools:</strong> 
		<a target="_blank" href="${data.editPostLink}">Edit this ${data.type}</a>
	</div>
	<div class="wfIssueOptions">
	{{if status == 'new'}}
		<strong>Resolve:</strong> 
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">I have fixed this issue</a>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreC'); return false;">Ignore this bad URL in this ${data.type}</a>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreP'); return false;">Ignore all bad URL's in this ${data.type}</a>
	{{/if}}
	{{if status == 'ignoreP' || status == 'ignoreC'}}
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">Stop ignoring this issue</a>
	{{/if}}
	</div>
</div>
</div>
</script>



<script type="text/x-jquery-template" id="issueTmpl_file">
<div>
<div class="wfIssue">
	<h2>${shortMsg}</h2>
	<p>
		<table border="0" class="wfIssue" cellspacing="0" cellpadding="0">
		<tr><th>Filename:</th><td>${data.file}</td></tr>
		{{if ((typeof data.badURL !== 'undefined') && data.badURL)}}
		<tr><th>Bad URL:</th><td><strong class="wfWarn">${data.badURL}</strong></td></tr>
		{{/if}}
		<tr><th>File type:</th><td>{{if data.cType}}${WFAD.ucfirst(data.cType)}{{else}}Not a core, theme or plugin file.{{/if}}</td></tr>
		<tr><th>Issue first detected:</th><td>${timeAgo} ago.</td></tr>
		<tr><th>Severity:</th><td>{{if severity == '1'}}Critical{{else}}Warning{{/if}}</td></tr>
		<tr><th>Status</th><td>
			{{if status == 'new' }}New{{/if}}
			{{if status == 'ignoreP' }}Permanently ignoring this file{{/if}}
			{{if status == 'ignoreC' }}Ignoring this file until it changes{{/if}}
		</td></tr>
		</table>
	</p>
	<p>
		{{html longMsg}}
	</p>
	<div class="wfIssueOptions">
		<strong>Tools:</strong> 
		{{if data.fileExists}}
		<a target="_blank" href="${WFAD.makeViewFileLink(data.file)}">View the file.</a>
		{{/if}}
		{{if data.canFix}}
		<a href="#" onclick="WFAD.restoreFile('${id}'); return false;">Restore the original version of this file.</a>
		{{/if}}
		{{if data.canDelete}}
		<a href="#" onclick="WFAD.deleteFile('${id}'); return false;">Delete this file (can't be undone).</a>
		{{/if}}
		{{if data.canDiff}}
		<a href="${WFAD.makeDiffLink(data)}" target="_blank">See how the file has changed.</a>
		{{/if}}
	</div>
	<div class="wfIssueOptions">
		{{if status == 'new'}}
			<strong>Resolve:</strong>
			<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">I have fixed this issue</a>
			{{if data.fileExists}}
				<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreC'); return false;">Ignore until the file changes.</a>
				<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreP'); return false;">Always ignore this file.</a>
			{{else}}
				<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreC'); return false;">Ignore missing file</a>
			{{/if}}
				
		{{/if}}
		{{if status == 'ignoreC' || status == 'ignoreP'}}
			<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">Stop ignoring this issue.</a>
		{{/if}}
	</div>
</div>
</div>
</script>
<script type="text/x-jquery-template" id="issueTmpl_pubBadURLs">
<div>
<div class="wfIssue">
	<h2>${shortMsg}</h2>
	<p>
		<table border="0" class="wfIssue" cellspacing="0" cellpadding="0">
		<tr><th>Severity:</th><td>{{if severity == '1'}}Critical{{else}}Warning{{/if}}</td></tr>
		<tr><th>Status</th><td>
			{{if status == 'new' }}New{{/if}}
			{{if status == 'ignoreC' }}These bad URLs will be ignored until they change.{{/if}}
			{{if status == 'ignoreP' }}These bad URLs will be permanently ignored.{{/if}}
		</td></tr>
		</table>
	</p>
	<p>
		{{html longMsg}}
	</p>
	<div class="wfIssueOptions">
	{{if status == 'new'}}
		<strong>Resolve:</strong> 
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">I have fixed this issue</a>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreC'); return false;">Ignore these URLs until they change.</a>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreP'); return false;">Ignore these URLs permanently</a>
	{{/if}}
	{{if status == 'ignoreP' || status == 'ignoreC'}}
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">Stop ignoring this issue</a>
	{{/if}}
	</div>
</div>
</div>
</script>


<script type="text/x-jquery-template" id="issueTmpl_pubDomainRedir">
<div>
<div class="wfIssue">
	<h2>${shortMsg}</h2>
	<p>
		<table border="0" class="wfIssue" cellspacing="0" cellpadding="0">
		<tr><th>Severity:</th><td>{{if severity == '1'}}Critical{{else}}Warning{{/if}}</td></tr>
		<tr><th>Status</th><td>
			{{if status == 'new' }}New{{/if}}
			{{if status == 'ignoreC' }}This redirect will be ignored until it changes.{{/if}}
			{{if status == 'ignoreP' }}This redirect is permanently ignored.{{/if}}
		</td></tr>
		</table>
	</p>
	<p>
		{{html longMsg}}
	</p>
	<div class="wfIssueOptions">
	{{if status == 'new'}}
		<strong>Resolve:</strong> 
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">I have fixed this issue</a>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreC'); return false;">Ignore this redirect until it changes</a>
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'ignoreP'); return false;">Ignore any redirect like this permanently</a>
	{{/if}}
	{{if status == 'ignoreP' || status == 'ignoreC'}}
		<a href="#" onclick="WFAD.updateIssueStatus('${id}', 'delete'); return false;">Stop ignoring this issue</a>
	{{/if}}
	</div>
</div>
</div>
</script>




<script type="text/x-jquery-template" id="wfNoScanYetTmpl">
<div>
	<table class="wfSummaryParent" cellpadding="0" cellspacing="0">
	<tr><th class="wfHead">Your first scan is starting now</th></tr>
	<tr><td>
		<table class="wfSC1"  cellpadding="0" cellspacing="0">
		<tr><td>
			Your first Wordfence scan should be automatically starting now
			and you will see the scan details in the "Activity Log" above in a few seconds.
			While you're waiting, why not visit the <a href="http://www.wordfence.com/forums/" target="_blank">Wordfence Forums</a>
			where you can post your comments or questions. We would love to hear from you.
		</td></tr>
		<tr><td>
			<div class="wordfenceScanButton"><input type="button" value="Start a Wordfence Scan" id="wfStartScanButton2" class="wfStartScanButton button-primary" /></div>
		</td></tr>
		</table>
	</td>
	</tr></table>
</div>
</script>


<script type="text/x-jquery-template" id="wfWelcomeContent1">
<div>
<h3>Welcome to Wordfence</h3>
<p>
	Wordfence is a robust and complete security system for WordPress. It protects your WordPress site
	from security threats and keeps you off Google's SEO black-list by providing a firewall, brute force protection, continuous scanning and many other security enhancements. 
</p>
<p>
	Wordfence also detects if there are any security problems on 
	your site or if there has been an intrusion and will alert you via email. 
	Wordfence can also help repair hacked sites, even if you don't have a backup of your site.
</p>
</div>
</script>
<script type="text/x-jquery-template" id="wfWelcomeContent2">
<div>
<h3>How Wordfence is different</h3>
<p><strong>Powered by our Cloud Servers</strong></p>
<p>
	Wordfence is not just a standalone plugin for WordPress. It is part of Feedjit Inc. and is powered by our cloud scanning servers based at our
	data center in Seattle, Washington in the USA. On these servers we keep an updated mirror of every version of WordPress ever released
	and every version of every plugin and theme ever released into the WordPress repository. That allows us to
	do an integrity check on your core files, plugins and themes. It also means that when we detect they have changed, we can show you the
	changes and we can give you the option to repair any corrupt files. Even if you don't have a backup of that file.
</p>
<p><strong>Keeping you off Google's SEO Black-List</strong></p>
<p>
	We also maintain a real-time copy of the Google Safe Browsing list (the GSB) and use it to scan all your files, posts, pages and comments for dangerous URL's.
	If you accidentally link to a URL on the GSB, your site is often black-listed by Google and removed from search results. 
	The GSB is constantly changing, so constant scanning of all your content is needed to keep you safe and off Google's SEO black-list.
</p>
<p><strong>Scans for back-doors, malware, viruses and other threats</strong></p>
<p>
	Wordfence also maintains an updated threat and malware signature database which we use to scan your site for intrusions, malware, backdoors and more.
</p>
</div>
</script>
<script type="text/x-jquery-template" id="wfWelcomeContent3">
<div>
<h3>How to use Wordfence</h3>
<strong><p>Start with a Scan</p></strong>
<p>
	Using Wordfence is simple. Start by doing a scan. One is probably already running if you just installed Wordfence.
	Once the scan is complete, a list of issues will appear at the bottom of this page. Work through each issue one at a time. If you know an 
	issue is not a security problem, simply choose to ignore it. When you click "ignore" it will be moved to the list of ignored issues.
</p>
<strong><p>Use the tools we provide</p></strong>
<p>
	You'll notice that with each issue we provide tools to help you repair problems you may find. For example, if a core file has been modified
	you can view how it has been changed, view the whole file or repair the file. If we find a back-door a hacker has left behind, we give
	you the option to delete the file. Using these tools is an essential part of the diagnostic and cleaning process if you have been hacked.
</p>
<p>
	Repair each security problem that you find. You may have to fix a weak password that we detected, upgrade a theme or plugin, delete a comment that
	contains an unsafe URL and so on. Once you're done, start another scan and your site should come back with no security issues.
</p>
<strong><p>Regular scheduled scans keep your site safe</p></strong>
<p>
	Once you've done your initial scan and cleanup, Wordfence will automatically scan your site once a day.
	If you would like to scan your site more frequently or control when Wordfence does a scan, upgrade to the 
	paid version of Wordfence which includes other features like country blocking.
</p>
</div>
</script>
