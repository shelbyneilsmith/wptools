<?php
/*
Plugin Name: WP Zen-Coding
Plugin URI: http://rewish.org/wp/zen_coding
Description: WP Zen-Coding is a awesome 'Zen-Coding' plugin for WP admin page. <a href="http://wordpress.org/extend/plugins/wp-zen-coding/changelog/">[en]ChangeLog</a>, <a href="http://rewish.org/wp/zen_coding#changeLog">[ja]ChangeLog</a>
Author: Hiroshi Hoaki
Version: 0.3.1
Author URI: http://rewish.org/
*/
class WP_ZenCoding
{
	const OPTION_VERSION = 3;

	private $option;
	private $pluginPath;

	public function getInstance()
	{
		static $obj = null;
		return $obj ? $obj : $obj = new self;
	}

	private function __construct()
	{
        $this->pluginPath = implode(DIRECTORY_SEPARATOR, array(
            WP_PLUGIN_DIR,
            basename(dirname(__FILE__)),
            basename(__FILE__)
        ));
	}

	public function add()
	{
		add_action('plugins_loaded',  array($this, 'loadTextdomain'));
		add_action('admin_menu', array($this, 'addAdmin'));
		add_action('admin_print_footer_scripts', array($this, 'addScript'));
	}

	public function loadTextdomain()
	{
		$dir = dirname(__FILE__) .'/lang';
		$mo  = __CLASS__ .'-'. get_locale() .'.mo';
		load_textdomain(__CLASS__, realpath("$dir/$mo"));
	}

	public function addAdmin()
	{
		$basename = 'Zen Coding';
		add_submenu_page(
			'options-general.php', $basename, $basename,
			'manage_options', $this->pluginPath, array($this, 'adminOption')
		);
	}

	public function adminOption()
	{
		$optionName = $this->getOptionName();
		$domain = __CLASS__;
		$option = $this->getOption();
		require dirname(__FILE__)
			. DIRECTORY_SEPARATOR . 'view'
			. DIRECTORY_SEPARATOR . "option.php";
	}

	public function addScript()
	{
		$this->readyOption();
		$min = WP_DEBUG ? '' : '.min';
		$baseUrl = plugin_dir_url($this->pluginPath);
		$option  =& $this->option;
		require dirname(__FILE__)
			. DIRECTORY_SEPARATOR . 'view'
			. DIRECTORY_SEPARATOR . "script.php";
	}

	private function readyOption()
	{
		$this->getOption();
		$this->option['variables']['locale'] = $this->option['variables']['lang'];
		$this->option['shortcut']['Insert Formatted Line Break'][] = 'Enter';
		$this->option['shortcut']['Expand Abbreviation'][] = 'Tab';
		if ($this->option['variables']['indentation'] === '') {
			$this->option['variables']['indentation'] = "\t";
		}
	}

	private function getOptionName()
	{
		return __CLASS__;
	}

	private function getOption()
	{
		$this->option = get_option($this->getOptionName());
		if (empty($this->option)) {
			$this->option = array();
			$this->updateOption();
		}
		if (self::OPTION_VERSION > $this->option['version']) {
			$this->updateOption();
		}
		$this->cleanOption();
		return $this->option;
	}

	private function cleanOption()
	{
		$o = &$this->option;
		$o['options']['use_tab'] = !empty($o['options']['use_tab']);
		$o['options']['pretty_break'] = !empty($o['options']['pretty_break']);
	}

	private function updateOption()
	{
		$default = array(
			'variables' => array(
				'lang' => WPLANG,
				'charset' => 'UTF-8',
				'indentation' => '',
			),
			'options' => array(
				'profile' => 'xhtml',
				'use_tab' => true,
				'pretty_break' => true,
			),
			'shortcut' => array(
				'Expand Abbreviation'    => array('Meta+E'),
				'Balance Tag Outward'    => array('Meta+D'),
				'Balance Tag inward'     => array('Shift+Meta+D'),
				'Wrap with Abbreviation' => array('Shift+Meta+A'),
				'Next Edit Point'        => array('Ctrl+Alt+RIGHT'),
				'Previous Edit Point'    => array('Ctrl+Alt+LEFT'),
				'Select Line'            => array('Meta+L'),

				// Add: Option version 2
				'Merge Lines'    => array('Meta+Shift+M'),
				'Toggle Comment' => array('Meta+/'),
				'Split/Join Tag' => array('Meta+J'),
				'Remove Tag'     => array('Meta+K'),

				// Add: Option version 3
				'Evaluate Math Expression' => array('Meta+Y'),
				'Increment number by 1'    => array('Ctrl+UP'),
				'Decrement number by 1'    => array('Ctrl+DOWN'),
				'Increment number by 0.1'  => array('Alt+UP'),
				'Decrement number by 0.1'  => array('Alt+DOWN'),
				'Increment number by 10'   => array('Ctrl+Alt+UP'),
				'Decrement number by 10'   => array('Ctrl+Alt+DOWN'),
				'Select Next Item'         => array('Meta+.'),
				'Select Previous Item'     => array('Meta+,'),
			)
		);

		foreach ($default as $name => $values) {
			if (empty($this->option[$name]) || !is_array($this->option[$name])) {
				$this->option[$name] = array();
			}
			$this->option[$name] += $values;
		}

		// Delete: Option version 2.1
		unset($this->option['shortcut']['Format Line Break']);

		$this->option['version'] = self::OPTION_VERSION;
		update_option($this->getOptionName(), $this->option);
	}
}

WP_ZenCoding::getInstance()->add();
