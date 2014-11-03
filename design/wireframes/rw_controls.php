<style>

	/* yb-black: #231d1e */

	html {
		background-color: #000;
	}

	body {
		width: 100%;
		height: 100%;
		/*background-color: #000 !important;*/
	}

	.back-to-project {
		display:block;
		margin-top:1em;
		font-size: 14px;
		line-height: 2em;
		text-align: center;
		transition:border-bottom 200ms linear;
		color: #231d1e !important;
		border-bottom: 3px solid transparent;
		text-decoration: none;
	}

	.back-to-project:hover {
		border-bottom:3px solid #ffce07;
	}

	.wf-controls {
		position: fixed;
		bottom: 30px;
		width:190px;
		border: 10px solid #231d1e;
		background-color: white;
		padding: 20px;
		line-height: 3em;
		font-family: sans-serif;
		font-size: 1em;
		margin: 0;
		font-family: Trebuchet MS, sans-serif;
	}

	.wf-controls.open {
		left:0;
		transition:left 400ms ease;
	}

	.wf-controls.closed {
		left:-250px;
		transition:left 600ms cubic-bezier(.75,.95,.07,.81);
	}

	.wf-controls-tab {
		position:absolute;
		bottom:30px;
		right:-50px;
		width:50px;
		height:50px;
		background-color: #231d1e;
		border-radius: 3px;

		background-repeat: no-repeat;
		background-position: center center;
	}

	.wf-controls.open .wf-controls-tab {
		background-image: url(library/images/icon-close.png);
	}

	.wf-controls.closed .wf-controls-tab {
		background-image: url(library/images/icon-open.png);
	}

	.wf-controls h2 {
		font-size: 16px;
		margin-bottom:.3em;
	}

	.wf-logo {
		margin: .3em 0 2em 0;
	}

	.wf-logo img {
		display:block;
		width:80px;
		height:auto;
		margin:0 auto;
	}

	.wf-controls ul {
		margin:0;
		list-style: none;
	}

	.wf-links {
		margin-bottom:1.2em;
	}

	.wf-links a {
		font-size: 14px;
		text-decoration: none;
	}

	.wf-links a:hover {
		text-decoration: underline;
	}

	.wf-links .dropMenu ul {
		position:static;
		margin-left:1em;
	}

	.rw-controls li {
		display: inline-block;
		display:block;
		position: relative;
		height: 3em;
		padding: 0;
		margin: 0 auto;
		border: 0;
		line-height: 50px;
		font-size: 14px;
		opacity: 0.4;
		cursor: pointer;
		-webkit-transition: opacity 0.2s;
		-moz-transition: opacity 0.2s;
		transition: opacity 0.2s;
	}

	.rw-controls li:hover {
		opacity: 1;
	}

	.rw-controls li.active {
		opacity: 1;
	}

	.rw-controls li span {
		display:inline-block;
		font-size: 12px;
		vertical-align: top;
		line-height: 50px;
	}

	.rw-icon {
		display:inline-block;
		height:50px;
		background-image: url('library/images/state-icons-black.png');
		background-color: transparent;
		background-repeat: no-repeat;
		font-size: 16px;
	}

	#auto .rw-icon {
		width: 1.9em;
		margin-right: .6em;
		background-position: -8.2em 0.7em;

	}

	#desktop .rw-icon {
		width: 1.9em;
		margin-right: .6em;
		background-position: -5.9em 0.7em;
	}

	#tablet-portrait .rw-icon {
		width: 1.2em;
		margin-right: 1.3em;
		background-position: -2.6em 0.7em;
	}

	#tablet-landscape .rw-icon {
		width: 1.5em;
		margin-right: 1em;
		background-position: -4em 0.7em;
	}

	#smartphone-portrait .rw-icon {
		width: 0.6em;
		margin-right: 1.9em;
		background-position: 0em 0.7em;
	}

	#smartphone-landscape .rw-icon {
		width: 1.1em;
		margin-right:1.4em;
		background-position: -1em 0.7em;
	}

	iframe#self {
		width: 100%;
		height: 100%;
		margin:0 auto;
		background-color: #fff;
		display: block;
		border: none;
		-webkit-transition: all 1s;
		-moz-transition: all 1s;
		transition: all 1s;
	}

	iframe#self.desktop {
		width: 1440px;
		height: 100%;
	}

	iframe#self.tablet-portrait {
		width: 768px;
		height: 1024px;
	}

	iframe#self.tablet-landscape {
		width: 1024px;
		height: 768px;
	}

	iframe#self.smartphone-portrait {
		width: 320px;
		height: 568px;
	}

	iframe#self.smartphone-landscape {
		width: 568px;
		height: 320px;
	}

	@media (max-height:730px) {
		.rw-controls {
			display:none;
		}
	}
</style>

<div class="wf-controls closed">
	<div class="wf-controls-tab"></div>
	<div class="wf-logo">
		<img src="../library/images/yb-logo.png" alt="Wooohooo! Congrats on working with Yellowberri! ;-P">
	</div>

	<div class="wf-links">
		<h2>Wireframes</h2>
		<?php createNav($wireframes, true, false); ?>
	</div>

	<ul class="rw-controls">
		<h2>Responsive Controls</h2>
		<li class="active" id="auto"><div class="rw-icon"></div><span>Auto</span></li>
		<li id="desktop" title="Desktop"><div class="rw-icon"></div><span>Desktop</span></li>
		<li id="tablet-portrait" title="Tablet Portrait"><div class="rw-icon"></div><span>Tablet Portrait</span></li>
		<li id="tablet-landscape" title="Tablet Landscape"><div class="rw-icon"></div><span>Tablet Landscape</span></li>
		<li id="smartphone-portrait" title="Smartphone Portrait"><div class="rw-icon"></div><span>Smartphone Portrait</span></li>
		<li id="smartphone-landscape" title="Smartphone Landscape"><div class="rw-icon"></div><span>Smartphone Landscape</span></li>
	</ul>

	<a href="../" class="back-to-project">Back to Project Links</a>
</div>

<script>
	$(function(){
		var rw_url = "";

		if (rw_url.length > 0) {
			rw_url = rw_url;
		} else {
			rw_url = window.location;
		}

		var origBodyBG = $('body').css('backgroundColor');
		var wfControls = $('.wf-controls');

		if( self == top ) {
			$('body').css('backgroundColor', '#231d1e');
			$('body').children().not('.wf-controls, style, script').remove();
		} else {
			$('head').prepend('<base target="_parent" />');
			$('body').css('backgroundColor', origBodyBG);
			$('.wf-controls').remove();
		}

		$('body').prepend('<iframe id="self" class="full-width" src="'+rw_url+'"></iframe>');

		$( '.wf-controls li' ).click( function() {
			$('iframe#self').attr('class', $(this).attr('id'));
			$('.wf-controls li.active').removeClass('active');
			$(this).addClass('active');
		});

		$('.wf-controls-tab').click(function() {
			if ( wfControls.hasClass('open') ) {
				wfControls.removeClass('open');
				wfControls.addClass('closed');
			}

			else if ( wfControls.hasClass('closed') ) {
				wfControls.removeClass('closed');
				wfControls.addClass('open');
			}
		});
	});
</script>