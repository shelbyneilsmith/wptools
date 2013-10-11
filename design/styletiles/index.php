<?php include('header.php'); ?>
	<div id="wrapper" class="hfeed clearfix">
		<header>
			<div id="header-inner" class="clearfix">
				<!-- be sure to change the img src to actual path of logo image -->
				<h1 id="site-title"><a href="/" title="<?php echo $company_name; ?>" rel="home"><img src="images/mainLogo.png" alt="<?php echo $company_name; ?>" /></a></h1>
				<!--<nav class="main">
				</nav>-->
			</div>
		</header><!-- #header-->

		<div id="content" class="content-box">
			<h2>Page Header</h2>
			<h3>Subheader</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin eu mi sapien. Nunc nec enim eu odio ornare volutpat consequat ut arcu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut vulputate euismod justo, sagittis blandit urna gravida quis. In hac habitasse platea dictumst. Proin pharetra condimentum ipsum vel luctus. Quisque eget mauris nec odio bibendum fermentum sed ut nunc.</p>
			<p><a href="#">Sample link text &raquo;</a></p>
		</div>

		<ul id="color-palette">
			<h3>Color Palette</h3>
			<li class="color-1"><span>#ffffff</span></li>
			<li class="color-2"><span>#eeeeee</span></li>
			<li class="color-3"><span>#dddddd</span></li>
			<li class="color-4"><span>#cccccc</span></li>
			<li class="color-5"><span>#bbbbbb</span></li>
		</ul>

		<form id="modular-form" class="modular-box">
			<h3>Modular/Form Box</h3>
			<ul class="form-fields">
				<li>
					<label for="name">Name:</label>
					<input type="text" name="name" />
				</li>
				<li>
					<label for="email">Email:</label>
					<input type="text" name="email" />
				</li>
				<li>
					<label for="message">Message:</label>
					<textarea type="text" name="messsage"></textarea>
				</li>
				<li>
					<input type="submit" class="submit-btn" value="Submit" />
				</li>
			</ul>
		</form>

		<div id="other-styles">
			<div class="texture-box">
			</div>
			<div class="texture-box">
			</div>
			<div class="texture-box">
			</div>
		</div>
	</div> <!-- end #wrapper -->
<?php include('footer.php'); ?>