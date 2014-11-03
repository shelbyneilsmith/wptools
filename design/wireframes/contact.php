<?php
	//page settings

	$page_title = "Contact"; //most of the time, this will stay empty for the front page of the site.
	$front = 0;
	?>

	<?php require_once("header.php"); ?>
		<div id="media-query"></div>

		<div id="content">
			<h2 class="page-title"><?php echo $page_title; ?></h2>

			<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>

			<form id="main-contact" class="contact-form">
				<h3>Send Us a Message</h3>
				<fieldset>
					<label for="name">Name:</label>
					<input type="text" id="name" />

					<label for="email">Email:</label>
					<input type="email" id="email" />

					<label for="message">Message:</label>
					<textarea id="message" rows='3'></textarea>

					<input type="submit" value="Send message" />

				</fieldset>
			</form>

			<div class="contact-info">
				<strong>Main Office</strong>
				<address>
					555 America St.<br />
					Bowling Green, KY 42101
				</address>
				<p class="phone">1-888-555-5555</p>
			</div>
			<div class="map">
				<iframe src="https://www.google.com/maps/embed?pb=!1m5!3m3!1m2!1s0x8865ef361808aa45%3A0x89b2d17988a28cfb!2s814+State+St%2C+Bowling+Green%2C+KY+42101!5e0!3m2!1sen!2sus!4v1387569867643" width="600" height="450" frameborder="0" style="border:0"></iframe>
			</div>

		</div> <!-- end #content -->

	<?php require_once("footer.php"); ?>