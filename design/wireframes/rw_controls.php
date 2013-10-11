<style>
	body {
		width: 100%;
		height: 100%;
	}
	.rw-controls {
		position: absolute;
		bottom: 0;
		left: 0;
		background: #000;
		padding: 20px;
		line-height: 3em;
		font-family: sans-serif;
		font-size: 1em;
		margin: 0;
	}

	.rw-controls li {
		position: relative;
		height: 3em;
		border: 0;
		margin: 0;
		margin-right: 20px;
		background-color: transparent;
		background-image: url('library/images/state-icons.png');
		background-repeat: no-repeat;
		color: #fff;
		text-indent: -9999px;
		opacity: 0.3;
		display: inline-block;
		padding: 0;
		cursor: pointer;
		-webkit-transition: opacity 0.2s;
		-moz-transition: opacity 0.2s;
		transition: opacity 0.2s;
	}
	.rw-controls li:hover {
		opacity: 1;
	}
	.rw-controls li:last-of-type {
		margin-right: 0;
	}
	#auto {
		background: none;
		text-indent: 0;
		font-size: 0.681em;
		text-transform: uppercase;
		font-weight: bold;
		letter-spacing: 0.11em;
		top: -0.2em;
	}
	#desktop {
		width: 1.9em;
		background-position: -5.9em 0.7em;
	}
	#tablet-portrait {
		width: 1.2em;
		background-position: -2.6em 0.7em;
	}
	#tablet-landscape {
		width: 1.5em;
		background-position: -4em 0.7em;
	}
	#smartphone-portrait {
		width: 0.6em;
		background-position: 0em 0.7em;
	}
	#smartphone-landscape {
		width: 1.1em;
		background-position: -1em 0.7em;
	}

	iframe#self {
		width: 100%;
		height: 100%;
		margin: 0 auto;
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

</style>
<script>
	$(function(){
		var rw_url = "";

		if (rw_url.length > 0) {
			rw_url = rw_url;
		} else {
			rw_url = window.location;
		}

		var origBodyBG = $('body').css('backgroundColor');

		if(self==top) {
			$('body').css('backgroundColor', '#231d1e');
			$('body').children().not('.rw-controls, style, script').remove();
		} else {
			$('body').css('backgroundColor', origBodyBG);
			$('.rw-controls').remove();
		}

		$('body').prepend('<iframe id="self" class="full-width" src="'+rw_url+'"></iframe>');

		$( '.rw-controls li' ).click( function() {
			$('iframe#self').attr('class', $(this).attr('id'));
			$('.rw-controls li.active').removeClass('active');
			$(this).addClass('active');
		});
	});
</script>
<ul class="rw-controls">
	<li class="active"  id="auto">Auto</li>
	<li id="desktop" title="Desktop">Desktop</li>
	<li id="tablet-portrait" title="Tablet Portrait">Tablet Portrait</li>
	<li id="tablet-landscape" title="Tablet Landscape">Tablet Landscape</li>
	<li id="smartphone-portrait" title="Smartphone Portrait">Smartphone Portrait</li>
	<li id="smartphone-landscape" title="Smartphone Landscape">Smartphone Landscape</li>
</ul>
