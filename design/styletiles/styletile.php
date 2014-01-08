<?php
require_once("../settings.php");
?>

<link rel="stylesheet" href="library/css/screen.css">
<script type="text/javascript" src="//use.typekit.net/krx7gup.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

<?php
$option = $_GET[ 'option' ];
?>

<div class="wrapper option-<?php echo $option; ?>">
	<div class="style-tile">

		<div class="masthead">
			<div class="masthead-inner">
				<div class="logo"></div>

				<div class="color-palette">
					<div class="color color-one"></div>
					<div class="color color-two"></div>
					<div class="color color-three"></div>
					<div class="color color-four"></div>
					<div class="color color-five"></div>
				</div>

				<ul class="navigation">
					<li>Home</li>
					<li>Nav One</li>
					<li>Nav Two</li>
					<li>Nav Three</li>
					<li>Nav Four</li>
				</ul>
			</div>
		</div>

		<div class="main">
			<div class="main-inner">
				<div class="mini-moodboard"></div>
				<div class="typography">
					<h1>Headline Example <?php echo strtoupper($option); ?></h1>
					<?php
						$optionFonts = $fonts[$option];
						$displayFont = $optionFonts[0];
						$bodyFont = $optionFonts[1];
					?>
					<span class="font-info">Display Type: <?php echo $displayFont; ?> / Body Type: <?php echo $bodyFont; ?></span>

					<p>Body copy example. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ultrices ultricies turpis a hendrerit. <b>Pellentesque sed augue</b> pelentesque, consequat enim non, fermentum nulla. Donec fringilla mattis dolor, in malesuada justo tincidunt id. <i>Donec vitae ultricies</i> ante. Etiam sit amet ullamcorper nisl, at egestas metus.</p>

					<h2>An Example of a Subheading.</h2>

					<p>Cras nibh libero, posuere eu nunc at, elementum dictum arcu. Cras eleifend, lacus sed ornare feugiat, <a href="#">Example Link</a>. Massa ligula facilisis sem. Pellen feugiat varius tincidunt. Nullam non convallis justo.</p>
				</div>

				<div class="buttons">
					<a class="btn btn-1" href="#">Read More</a>
					<a class="btn btn-2" href="#">Submit</a>
				</div>
			</div>
		</div>

	</div>
	<div class="footer">
		<div class="footer-inner">
			<div class="pull-out">
				<p>Yellowberri is a full-service creative agency specializing in web development, video production, branding, motion graphics, social media, print design, audio production and photography.</p>
			</div>
			<div class="brand-attributes">
				<ul>
					<?php
						$brandAttr = $brandAttr[$option];

						foreach($brandAttr as $brandWord) {
							echo "<li>".$brandWord."</li>";
						}
					?>
	 			</ul>
			</div>
		</div>
	</div>
</div>