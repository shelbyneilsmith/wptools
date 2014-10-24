<?php
$this->sections[] = array(
	'title'     => __('Social Media', 'yb'),
	// 'desc'      => __('Redux Framework was created with the developer in mind. It allows for any theme developer to have an advanced theme panel with most of the features a developer would need. For more information check out the Github repo at: <a href="https://github.com/ReduxFramework/Redux-Framework">https://github.com/ReduxFramework/Redux-Framework</a>', 'yb'),
	'icon'      => 'el-icon-bullhorn',
	// 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields'    => array(
		array(
			'id'        => 'opt-checkbox-facebookwidget',
			'type'      => 'checkbox',
			'title'     => __('Enable Facebook Widget', 'yb'),
			'subtitle'  => __('Check to enable facebook widget.', 'yb'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'opt-media-fbimg',
			'type'      => 'media',
			'url'       => true,
			'title'     => __('Facebook Share Image Upload', 'yb'),
			'subtitle'  => __('Upload the default image that you want Facebook to use when someone shares a page from your site.', 'yb'),
		),
		// array(
		// 	'id'        => 'opt-checkbox-twitterwidget',
		// 	'type'      => 'checkbox',
		// 	'title'     => __('Enable Twitter Widget', 'yb'),
		// 	'subtitle'  => __('Check to enable twitter widget.', 'yb'),
		// 	'default'   => '0'// 1 = on | 0 = off
		// ),
		// array(
		// 	'id'    => 'opt-info-twitterwarning',
		// 	'type'  => 'info',
		// 	'style' => 'warning',
		// 	'title' => __('Twitter Configuration API (1.1)', 'yb'),
		// 	'desc'  => __('You need to have a twitter App for your usage of the new Twitter API 1.1, login & create at https://dev.twitter.com/apps', 'yb')
		// ),
		array(
			'id'        => 'opt-text-social-twitter',
			'type'      => 'text',
			'title'     => __('Twitter Username', 'yb'),
			'subtitle'  => __('Enter your Twitter username', 'yb'),
			'default'   => '',
		),
		// array(
		// 	'id'        => 'opt-text-social-twitter-consumerkey',
		// 	'type'      => 'text',
		// 	'title'     => __('Twitter App Consumer Key', 'yb'),
		// 	'subtitle'  => __('Enter your Twitter App Consumer Key.', 'yb'),
		// 	'default'   => '',
		// ),
		// array(
		// 	'id'        => 'opt-text-social-twitter-consumersecret',
		// 	'type'      => 'text',
		// 	'title'     => __('Twitter App Consumer Secret', 'yb'),
		// 	'subtitle'  => __('Enter your Twitter App Consumer Secret.', 'yb'),
		// 	'default'   => '',
		// ),
		// array(
		// 	'id'        => 'opt-text-social-twitter-accesstoken',
		// 	'type'      => 'text',
		// 	'title'     => __('Twitter App Access Token', 'yb'),
		// 	'subtitle'  => __('Enter your Twitter App Access Token.', 'yb'),
		// 	'default'   => '',
		// ),
		// array(
		// 	'id'        => 'opt-text-social-twitter-tokensecret',
		// 	'type'      => 'text',
		// 	'title'     => __('Twitter App Access Token Secret', 'yb'),
		// 	'subtitle'  => __('Enter your Twitter App Access Token Secret.', 'yb'),
		// 	'default'   => '',
		// ),
		// array(
		// 	'id'        => 'section-twitterconfig-end',
		// 	'type'      => 'section',
		// 	'indent'    => false // Indent all options below until the next 'section' option is set.
		// ),
		array(
			'id'        => 'section-socialurls-start',
			'type'      => 'section',
			'title'     => __('Enter your username / URL to show or leave blank to hide Social Media Icons', 'yb'),
			'indent'    => false // Indent all options below until the next 'section' option is set.
		),
		array(
			'id'        => 'opt-text-social-facebook',
			'type'      => 'text',
			'title'     => __('Facebook URL', 'yb'),
			'subtitle'  => __('Enter URL to your Facebook Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-instagram',
			'type'      => 'text',
			'title'     => __('Instagram URL', 'yb'),
			'subtitle'  => __('Enter URL to your Instagram Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-youtube',
			'type'      => 'text',
			'title'     => __('YouTube URL', 'yb'),
			'subtitle'  => __('Enter URL to your YouTube Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-googleplus',
			'type'      => 'text',
			'title'     => __('Google+ URL', 'yb'),
			'subtitle'  => __('Enter URL to your Google+ Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-forrst',
			'type'      => 'text',
			'title'     => __('Forrst URL', 'yb'),
			'subtitle'  => __('Enter URL to your Forrst Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-dribbble',
			'type'      => 'text',
			'title'     => __('Dribbble URL', 'yb'),
			'subtitle'  => __('Enter URL to your Dribbble Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-flickr',
			'type'      => 'text',
			'title'     => __('Flickr URL', 'yb'),
			'subtitle'  => __('Enter URL to your Flickr Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-skype',
			'type'      => 'text',
			'title'     => __('Skype URL', 'yb'),
			'subtitle'  => __('Enter URL to your Skype Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-digg',
			'type'      => 'text',
			'title'     => __('Digg URL', 'yb'),
			'subtitle'  => __('Enter URL to your Digg Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-linkedin',
			'type'      => 'text',
			'title'     => __('LinkedIn URL', 'yb'),
			'subtitle'  => __('Enter URL to your LinkedIn Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-vimeo',
			'type'      => 'text',
			'title'     => __('Vimeo URL', 'yb'),
			'subtitle'  => __('Enter URL to your Vimeo Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-yahoo',
			'type'      => 'text',
			'title'     => __('Yahoo URL', 'yb'),
			'subtitle'  => __('Enter URL to your Yahoo Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-tumblr',
			'type'      => 'text',
			'title'     => __('Tumblr URL', 'yb'),
			'subtitle'  => __('Enter URL to your Tumblr Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-deviantart',
			'type'      => 'text',
			'title'     => __('DeviantArt URL', 'yb'),
			'subtitle'  => __('Enter URL to your DeviantArt Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-behance',
			'type'      => 'text',
			'title'     => __('Behance URL', 'yb'),
			'subtitle'  => __('Enter URL to your Behance Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-pinterest',
			'type'      => 'text',
			'title'     => __('Pinterest URL', 'yb'),
			'subtitle'  => __('Enter URL to your Pinterest Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-text-social-delicious',
			'type'      => 'text',
			'title'     => __('Delicious URL', 'yb'),
			'subtitle'  => __('Enter URL to your Delicious Account', 'yb'),
			'default'   => '',
		),
		array(
			'id'        => 'opt-checkbox-social-rss',
			'type'      => 'checkbox',
			'title'     => __('Show RSS', 'yb'),
			'subtitle'  => __('Check to Show RSS Icon', 'yb'),
			'default'   => '0'// 1 = on | 0 = off
		),
		array(
			'id'        => 'section-socialurls-end',
			'type'      => 'section',
			'indent'    => false // Indent all options below until the next 'section' option is set.
		),
	),
);

?>