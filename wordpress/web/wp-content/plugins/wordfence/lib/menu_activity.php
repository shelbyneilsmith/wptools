<div class="wordfenceModeElem" id="wordfenceMode_activity"></div>
<div class="wrap wordfence">
	<div class="wordfence-lock-icon wordfence-icon32"><br /></div><h2 id="wfHeading">Live Site Activity</h2>
	<div class="wordfenceLive">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr><td><h2>Wordfence Live Activity:</h2></td><td id="wfLiveStatus"></td></tr>
		</table>
	</div>
	<div class="wordfenceWrap">
		<div>
			<div id="wfTabs">
				<a href="#" class="wfTab1 wfTabSwitch selected" onclick="wordfenceAdmin.switchTab(this, 'wfTab1', 'wfDataPanel', 'wfActivity_hit', function(){ WFAD.activityTabChanged(); }); return false;">All Hits</a>
				<a href="#" class="wfTab1 wfTabSwitch" onclick="wordfenceAdmin.switchTab(this, 'wfTab1', 'wfDataPanel', 'wfActivity_human', function(){ WFAD.activityTabChanged(); }); return false;">Humans</a>
				<a href="#" class="wfTab1 wfTabSwitch" onclick="wordfenceAdmin.switchTab(this, 'wfTab1', 'wfDataPanel', 'wfActivity_ruser', function(){ WFAD.activityTabChanged(); }); return false;">Registered Users</a>
				<a href="#" class="wfTab1 wfTabSwitch" onclick="wordfenceAdmin.switchTab(this, 'wfTab1', 'wfDataPanel', 'wfActivity_crawler', function(){ WFAD.activityTabChanged(); }); return false;">Crawlers</a>
				<a href="#" class="wfTab1 wfTabSwitch" onclick="wordfenceAdmin.switchTab(this, 'wfTab1', 'wfDataPanel', 'wfActivity_gCrawler', function(){ WFAD.activityTabChanged(); }); return false;">Google Crawlers</a>
				<a href="#" class="wfTab1 wfTabSwitch" onclick="wordfenceAdmin.switchTab(this, 'wfTab1', 'wfDataPanel', 'wfActivity_404', function(){ WFAD.activityTabChanged(); }); return false;">Pages Not Found</a>
				<a href="#" class="wfTab1 wfTabSwitch" onclick="wordfenceAdmin.switchTab(this, 'wfTab1', 'wfDataPanel', 'wfActivity_loginLogout', function(){ WFAD.activityTabChanged(); }); return false;">Logins and Logouts</a>
				<a href="#" class="wfTab1 wfTabSwitch" onclick="wordfenceAdmin.switchTab(this, 'wfTab1', 'wfDataPanel', 'wfActivity_topLeechers', function(){ WFAD.staticTabChanged(); }); return false;">Top Consumers</a>
				<a href="#" class="wfTab1 wfTabSwitch" onclick="wordfenceAdmin.switchTab(this, 'wfTab1', 'wfDataPanel', 'wfActivity_topScanners', function(){ WFAD.staticTabChanged(); }); return false;">Top 404s</a>
			</div>
			<div class="wfTabsContainer">
				<div id="wfActivity_hit" class="wfDataPanel"><div class="wfLoadingWhite32"></div></div>
				<div id="wfActivity_human" class="wfDataPanel" style="display: none;"><div class="wfLoadingWhite32"></div></div>
				<div id="wfActivity_ruser" class="wfDataPanel" style="display: none;"><div class="wfLoadingWhite32"></div></div>
				<div id="wfActivity_crawler" class="wfDataPanel" style="display: none;"><div class="wfLoadingWhite32"></div></div>
				<div id="wfActivity_gCrawler" class="wfDataPanel" style="display: none;"><div class="wfLoadingWhite32"></div></div>
				<div id="wfActivity_404" class="wfDataPanel" style="display: none;"><div class="wfLoadingWhite32"></div></div>
				<div id="wfActivity_loginLogout" class="wfDataPanel" style="display: none;"><div class="wfLoadingWhite32"></div></div>
				<div id="wfActivity_topScanners" class="wfDataPanel" style="display: none;"><div class="wfLoadingWhite32"></div></div>
				<div id="wfActivity_topLeechers" class="wfDataPanel" style="display: none;"><div class="wfLoadingWhite32"></div></div>
				<div id="wfActivity_blockedIPs" class="wfDataPanel" style="display: none;"><div class="wfLoadingWhite32"></div></div>
			</div>
		</div>
	</div>
</div>

<script type="text/x-jquery-template" id="wfLeechersTmpl">
<div>
<div style="border-bottom: 1px solid #CCC; padding-bottom: 10px; margin-bottom: 10px;">
<table border="0" style="width: 100%">
{{each(idx, elem) results}}
<tr><td>
	<div>
		{{if loc}}
			<img src="http://www.wordfence.com/images/flags/${loc.countryCode.toLowerCase()}.png" width="16" height="11" alt="${loc.countryName}" title="${loc.countryName}" class="wfFlag" />
			<a href="http://maps.google.com/maps?q=${loc.lat},${loc.lon}&z=6" target="_blank">{{if loc.city}}${loc.city}, {{/if}}${loc.countryName}</a>
		{{else}}
			An unknown location at IP <a href="${WFAD.makeIPTrafLink(IP)}" target="_blank">${IP}</a>
		{{/if}}
	</div>
	<div>
		<strong>IP:</strong>&nbsp;<a href="${WFAD.makeIPTrafLink(IP)}" target="_blank">${IP}</a>
		{{if elem.blocked}}
			[<a href="#" onclick="WFAD.unblockIP('${IP}'); return false;">unblock</a>]
		{{else}}
			[<a href="#" onclick="WFAD.blockIP('${IP}', 'Manual block by administrator'); return false;">block</a>]
		{{/if}}
	</div>
	<div>
		<span class="wfReverseLookup"><span style="display:none;">${elem.IP}</span></span>
	</div>
	<div>
		<span class="wfTimeAgo">Last hit was ${elem.timeAgo} ago.</span>
	</div>
</td>
<td style="font-size: 28px; color: #999;">
	${elem.totalHits} hits
</td>
</tr>
{{/each}}
</table>
</div>
</div>
</script>
<script type="text/x-jquery-template" id="wfLoginLogoutEventTmpl">
<div style="display: none;">
<div class="wfActEvent" id="wfActEvent_${id}">
	<div>
		{{if loc}}
			<img src="http://www.wordfence.com/images/flags/${loc.countryCode.toLowerCase()}.png" width="16" height="11" alt="${loc.countryName}" title="${loc.countryName}" class="wfFlag" />
			<a href="http://maps.google.com/maps?q=${loc.lat},${loc.lon}&z=6" target="_blank">{{if loc.city}}${loc.city}, {{/if}}${loc.countryName}</a>
		{{else}}
			An unknown location at IP ${IP}
		{{/if}}
		{{if action == 'loginOK'}}
			logged in successfully as <strong>"${username}"</strong>
		{{else action == 'logout'}}
			logged out as <strong>"${username}"</strong>
		{{else action == 'loginFailValidUsername'}}
			attempted a failed login as <strong>"${username}"</strong>.
		{{else action == 'loginFailInvalidUsername'}}
			attempted a failed login using an invalid username <strong>"${username}"</strong>.
		{{/if}}
	</div>
	<div>
		<strong>IP:</strong> <a href="${WFAD.makeIPTrafLink(IP)}" target="_blank">${IP}</a>&nbsp;
		{{if blocked}}
			[<a href="#" onclick="WFAD.unblockIP('${IP}'); return false;">unblock</a>]
		{{else}}
			[<a href="#" onclick="WFAD.blockIP('${IP}', 'Manual block by administrator'); return false;">block</a>]
		{{/if}}
	</div>
	<div>
		<span class="wfReverseLookup"><span style="display:none;">${IP}</span></span>
	</div>
	<div>
		<span class="wfTimeAgo">${timeAgo} ago</span>
	</div>
</div>
</div>
</script>
<script type="text/x-jquery-template" id="wfHitsEventTmpl">
<div style="display: none;">
<div class="wfActEvent" id="wfActEvent_${id}">
<table border="0" cellpadding="1" cellspacing="0">
<tr>
<td>
	{{if user}}
		<span class="wfAvatar">{{html user.avatar}}</span>
		<a href="${user.editLink}" target="_blank">${user.display_name}</a>
	{{/if}}
	{{if loc}}
		{{if user}}in {{/if}}
		<img src="http://www.wordfence.com/images/flags/${loc.countryCode.toLowerCase()}.png" width="16" height="11" alt="${loc.countryName}" title="${loc.countryName}" class="wfFlag" />
		<a href="http://maps.google.com/maps?q=${loc.lat},${loc.lon}&z=6" target="_blank">{{if loc.city}}${loc.city}, {{/if}}${loc.countryName}</a>
	{{else}}
		An unknown location at IP <a href="${WFAD.makeIPTrafLink(IP)}" target="_blank">${IP}</a>
	{{/if}}
	{{if referer}}
		{{if extReferer}}
			arrived from <a href="${referer}" target="_blank" style="color: #A00; font-weight: bold;">${referer}</a> and
		{{else}}
			left <a href="${referer}" target="_blank" style="color: #999; font-weight: normal;">${referer}</a> and
		{{/if}}
	{{/if}}
	{{if activityMode == 'hit'}}
		landed on 
	{{else activityMode == 'human' || activityMode == 'ruser'}}
		visited
	{{else activityMode == '404'}}
		tried to access
	{{else activityMode == 'gCrawler'}}
		crawled
	{{else activityMode == 'crawler'}}
		crawled
	{{/if}}
<a href="${URL}" target="_blank">${URL}</a>
</td></tr>
<tr><td><span class="wfTimeAgo">${timeAgo} ago</span>&nbsp;&nbsp; <strong>IP:</strong> <a href="${WFAD.makeIPTrafLink(IP)}" target="_blank">${IP}</a>
	{{if blocked}}
		[<a href="#" onclick="WFAD.unblockIP('${IP}'); return false;">unblock</a>]
	{{else}}
		[<a href="#" onclick="WFAD.blockIP('${IP}', 'Manual block by administrator'); return false;">block</a>]
	{{/if}}
	&nbsp;<span class="wfReverseLookup"><span style="display:none;">${IP}</span></span>
</td></tr>
{{if browser && browser.browser != 'Default Browser'}}<tr><td><strong>Browser:</strong> ${browser.browser}{{if browser.version}} version ${browser.version}{{/if}}{{if browser.platform && browser.platform != 'unknown'}} running on ${browser.platform}{{/if}}</td></tr>{{/if}}
<tr><td style="color: #AAA;">${UA}</td></tr>
<tr><td></td></tr>
</table>
</div>
</div>
</script>
<script type="text/x-jquery-template" id="wfWelcomeContent3">
<div>
<h3>Welcome to ALL Your Site Visits, Live!</h3>
<strong><p>Traffic you've never seen before</p></strong>
<p>
	Google Analytics and other Javascript analytics packages can't show you crawlers, RSS feed readers, hack attempts and other non-human traffic that hits your site.
	Wordfence runs on your server and shows you, in real-time, all the traffic that is hitting your server right now, including those non-human crawlers, feed readers and hackers that Analytics can't track.
</p>
<strong><p>Separated into the important categories</p></strong>
<p>
	You'll notice we have divided your traffic into tabs. These include an "All Hits" tab to simply view everything that is hitting your server right now.
	We then sub-divide that into Human traffic, your site members, crawlers - which we further break down into Google crawlers.
</p>
<p>
	<strong>How to use this page when your site is being attacked</strong>
</p>
<p>
	Start by looking at "All Hits" because you may notice that a single IP address is generating most of your traffic.
	This could be a denial of service attack, someone stealing your content or a hacker probing for weaknesses.
	If you see a suspicious pattern, simply block that IP address.
</p>
<p>
	If you don't see any clear patterns of attack, take a look at "Top 404s" which will show you IP addresses that are generating excessive page not found errors. 
	It's common for an attacker probing for weaknesses to generate a lot of page not found errors. If you see one IP
	address that is generating many of these requests, and it's not Google or another trusted crawler, then you should consider
	blocking them.
</p>
<p>
	Next look at "Logins and Logouts". If you see a large number of failed logins from an IP address, block them if you don't recognize who they are.
</p>
<p>
	Finally, take a look at "Top Consumers". These are the top IP addresses who are "consuming" or accessing most of your content.
	If you're trying to protect yourself against a content thief, this is the first place to look.
</p>

</div>
</script>
