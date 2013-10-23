<?php include('settings.php'); ?>
<?php include('libs/library.php'); ?>

<!doctype html>
	<html>
		<head>
			<title><?php echo $company_name ?> Project Links</title>
			<link rel="stylesheet" href="library/css/screen.css">

			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0" />
		</head>

		<div class="logo">
			<img src="library/images/yb-logo.png" alt="">
		</div>

		<div id="design-directory">

			<div class="banner">
				<h1 class="page-title"><?php echo $company_name ?> Project Links</h1>
			</div>

			<div class="links">
				<div id="wireframe-links">
					<h3>Wireframes</h3>
					<?php createNav($wireframes, true, false); ?>
				</div>

				<div id="styletile-links">
					<h3>Style Tiles</h3>
					<a class="style-viewer-link" href="/design/styletiles/">View All</a>
					<br><br>
					<?php echo styleTileLinks($styleTiles, $alphas); ?>
				</div>
			</div>

			<div id="process-info">
				<?php include('copy.php'); ?>
			</div>

			<div class="contact">
				<h2>Questions?</h2>
				<p>If you have any questions and would like further advice and clarifaction please feel free to drop us a line.</p>
			</div>

		</div>

		<body>

		</body>
	</html>