
<link href="stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
<!--[if IE]>
   <link href="stylesheets/ie.css" media="screen, projection" rel="stylesheet" type="text/css" />
<![endif]-->
<?php if ($lightbox): ?>
	<link rel="stylesheet" href="stylesheets/jquery.lightbox-0.5.css" />
<?php endif; ?>
<?php if ($slider): ?>
	<link rel="stylesheet" href="stylesheets/flexslider.css" />
<?php endif; ?>

<style type="text/css">
/*--- THE MAGIC ---*/
/*
This is the best bit!
*/
[placeholder]{
	color:#999;
}
[placeholder]:active,
[placeholder]:focus{
	color:#333;

}
/*
If the input has placeholder="" AND value="" darken its appearance to show it is pre-populated and not a form hint.
*/
[placeholder][value]{
	color:#333;
}
</style>
<!--[if IE]>
<style type="text/css">
  .clearfix {
    zoom: 1;     /* triggers hasLayout */
    display: block;     /* resets display for IE/Win */
    }  /* Only IE can see inside the conditional comment
    and read this CSS rule. Don't ever use a normal HTML
    comment inside the CC or it will close prematurely. */
</style>
<![endif]-->