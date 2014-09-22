<?php
$this->sections[] = array(
	'title'     => __('Blog', 'yb'),
	'icon'      => 'el-icon-pencil',
	'fields'    => array(
		array(
			'id'        => 'opt-checkbox-blog',
			'type'      => 'checkbox',
			'title'     => __('Enable Blog', 'yb'),
			'subtitle'  => __('Check to use the Blog features for this site.', 'yb'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-bloglayout',
			'type'      => 'image_select',
			'title'     => __('Blog Layout', 'yb'),
			'subtitle'  => __('Select blog content and sidebar alignment.', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'options'   => array(
				'default' => array('alt' => 'Global Default',       'img' => '/wp-content/themes/yb/library/_images/layout-default.png'),
				'Centered No Sidebar' => array('alt' => 'Centered No Sidebar', 'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
				'Centered Left Sidebar' => array('alt' => 'Centered Left Sidebar',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
				'Centered Right Sidebar' => array('alt' => 'Centered Right Sidebar', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
			),
			'default'   => 'Centered Right Sidebar'
		),
		array(
			'id'        => 'opt-select-blogpostlayout',
			'type'      => 'select',
			'title'     => __('Blog Post Layout', 'yb'),
			'subtitle'  => __('Choose your Default Blog Layout', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'options'   => array(
				'blog-fullwidth' => 'Blog Fullwidth',
				'blog-medium' => 'Blog Medium',
			),
			'default'   => 'blog-fullwidth'
		),
		array(
			'id'        => 'opt-checkbox-sharebox',
			'type'      => 'checkbox',
			'title'     => __('Enable Share-Box on Post Detail', 'yb'),
			'subtitle'  => __('Check to enable Share-Box', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => '1'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-checkbox-authorinfo',
			'type'      => 'checkbox',
			'title'     => __('Enable Author Info on Post Detail', 'yb'),
			'subtitle'  => __('Check to enable Author Info', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => '1'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-checkbox-relatedposts',
			'type'      => 'checkbox',
			'title'     => __('Enable Related Posts on Post Detail', 'yb'),
			'subtitle'  => __('Check to enable Related Posts', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-text-excerptlength',
			'type'      => 'text',
			'title'     => __('Blog Excerpt Length', 'yb'),
			'subtitle'  => __('Default: 30. Used for blog page, archives & search results.', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => '30',
		),
		array(
			'id'        => 'opt-checkbox-readmore',
			'type'      => 'checkbox',
			'title'     => __('Enable \'Read More\' Button', 'yb'),
			'subtitle'  => __('Check to enable \'Read More\' button on blog entries.', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => '1'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-checkbox-blogcomments',
			'type'      => 'checkbox',
			'title'     => __('Disable Blog Comments', 'yb'),
			'subtitle'  => __('Check to disable comments on Blog posts.', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'section-blogtitle-start',
			'type'      => 'section',
			'title'     => __('Blog Title Settings', 'yb'),
			'indent'    => false // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'opt-text-blogtitle',
			'type'      => 'text',
			'title'     => __('Blog Title', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => 'Blog',
		),
		array(
			'id'        => 'opt-text-blogbreadcrumb',
			'type'      => 'text',
			'title'     => __('Blog Breadcrumb Name', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => 'Blog',
		),
		array(
			'id'        => 'opt-select-blogtitlebar',
			'type'      => 'select',
			'title'     => __('Blog Titlebar', 'yb'),
			'subtitle'  => __('Choose your Blog Titlebar Layout', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'options'   => array(
				'default' => 'default',
				'Background-Image Style 1' => 'Background-Image Style 1',
				'Background-Image Style 2' => 'Background-Image Style 2',
			),
			'default'   => 'default'
		),
		array(
			'id'        => 'opt-media-blogtitlebar',
			'type'      => 'media',
			'url'       => true,
			'title'     => __('Blog Titlebar Image (If Blog Titlebar Layout is set to Image)', 'yb'),
			'required' => array('opt-select-blogtitlebar','!=','default'),
			// 'compiler'  => 'true',
			//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			// 'desc'      => __('Upload your site\'s low-res logo here.', 'yb'),
			'subtitle'  => __('Upload a Blog Titlebar Image.', 'yb'),
			// 'default'   => array('url' => 'http://s.wordpress.org/style/images/codeispoetry.png'),
			//'hint'      => array(
			//    'title'     => 'Hint Title',
			//    'content'   => 'This is a <b>hint</b> for the media field with a Title.',
			//)
		),
		array(
			'id'        => 'opt-checkbox-blogbreadcrumbs',
			'type'      => 'checkbox',
			'title'     => __('Disable Breadcrumbs for Blog', 'yb'),
			'subtitle'  => __('Check to disable Breadcrumbs for Blog & Blog Posts.', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'section-blogtitle-end',
			'type'      => 'section',
			'indent'    => false // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'section-blogsocial-start',
			'type'      => 'section',
			'title'     => __('Social Sharing Box Icons', 'yb'),
			'indent'    => false // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'opt-checkbox-sharingboxfacebook',
			'type'      => 'checkbox',
			'title'     => __('Enable Facebook in Social Sharing Box', 'yb'),
			'subtitle'  => __('Check to enable Facebook in Social Sharing Box', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => '1'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-checkbox-sharingboxtwitter',
			'type'      => 'checkbox',
			'title'     => __('Enable Twitter in Social Sharing Box', 'yb'),
			'subtitle'  => __('Check to enable Twitter in Social Sharing Box', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => '1'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-checkbox-sharingboxlinkedin',
			'type'      => 'checkbox',
			'title'     => __('Enable LinkedIn in Social Sharing Box', 'yb'),
			'subtitle'  => __('Check to enable LinkedIn in Social Sharing Box', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-checkbox-sharingboxreddit',
			'type'      => 'checkbox',
			'title'     => __('Enable Reddit in Social Sharing Box', 'yb'),
			'subtitle'  => __('Check to enable Reddit in Social Sharing Box', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-checkbox-sharingboxdigg',
			'type'      => 'checkbox',
			'title'     => __('Enable Digg in Social Sharing Box', 'yb'),
			'subtitle'  => __('Check to enable Digg in Social Sharing Box', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-checkbox-sharingboxdelicious',
			'type'      => 'checkbox',
			'title'     => __('Enable Delicious in Social Sharing Box', 'yb'),
			'subtitle'  => __('Check to enable Delicious in Social Sharing Box', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-checkbox-sharingboxgoogle',
			'type'      => 'checkbox',
			'title'     => __('Enable Google in Social Sharing Box', 'yb'),
			'subtitle'  => __('Check to enable Google in Social Sharing Box', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-checkbox-sharingboxemail',
			'type'      => 'checkbox',
			'title'     => __('Enable Email in Social Sharing Box', 'yb'),
			'subtitle'  => __('Check to enable Email in Social Sharing Box', 'yb'),
			'required' => array('opt-checkbox-blog','=','1'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'section-blogsocial-end',
			'type'      => 'section',
			'indent'    => false // Indent all options below until the next 'section' option is set.
		),
	),
);

?>