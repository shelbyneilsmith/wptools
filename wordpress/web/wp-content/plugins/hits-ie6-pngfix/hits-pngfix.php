<?php
/*
	Plugin Name: HITS- IE6 PNGFix
	Version: 3.5.3
	Author: Adam Erstelle
	Author URI: http://www.itegritysolutions.ca/
	Plugin URI: http://www.itegritysolutions.ca/community/wordpress/ie6-png-fix
	Description: Adds IE6 Compatability for PNG transparency, using 1 of 5 configured approaches either server side or client side
	Text Domain: hits-ie6-pngfix
	
	PLEASE NOTE: If you make any modifications to this plugin file directly, please contact me so that
	             the plugin can be updated for others to enjoy the same freedom and functionality you
				 are trying to add. Thank you!
	
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if (!class_exists('hits_ie6_pngfix')) {
    class hits_ie6_pngfix {
        /**
        * @var string The options string name for this plugin
        */
        var $optionsName = 'hits_ie6_pngfix_options';
		var $overrideIE6Check=false;//for debug purposes only
        
        /**
        * @var string $localizationDomain Domain used for localization
        */
        var $localizationDomain = "hits-ie6-pngfix";
        
        /**
        * @var string $pluginurl The path to this plugin
        */ 
        var $thispluginurl = '';
        
        /**
         * @var string $pluginProtocolRelativeUrl The protocol relative path to this plugin
         */
        var $thisProtocolRelativeUrl='';
        
        /**
        * @var string $pluginurlpath The path to this plugin
        */
        var $thispluginpath = '';
            
        /**
        * @var array $options Stores the options for this plugin
        */
        var $options = array();
        
        /**
        * PHP 4 Compatible Constructor
        */
        function hits_ie6_pngfix(){$this->__construct();}
        
        /**
        * PHP 5 Constructor
        */        
        function __construct(){
            //Language Setup
            $locale = get_locale();
            $mo = dirname(__FILE__) . "/languages/" . strtolower($this->localizationDomain) . "-".strtolower($locale).".mo";
            load_textdomain($this->localizationDomain, $mo);

            //"Constants" setup
            $this->thispluginurl = WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)).'/';
            $this->thispluginpath = WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)).'/';
            $relativeUrl = str_replace('http://','//', $this->thispluginurl);
            $this->thisProtocolRelativeUrl = $relativeUrl;
			
			global $wp_version;
            $this->wp_version = substr(str_replace('.', '', $wp_version), 0, 2);
            
            //Initialize the options
            //This is REQUIRED to initialize the options when the plugin is loaded!
            $this->getOptions();
            $this->actions_filters();
        }
		
		/**
		 * Centralized place for adding all actions and filters for the plugin into wordpress
		*/
		function actions_filters()
		{
			if(is_admin()){
				add_action('admin_menu', array(&$this,'admin_menu_link'));
				add_action('admin_head', array(&$this, 'admin_head'));
			}
			else
				add_action('wp_head', array(&$this,'wp_head'));
		}
		
		/**
		 * Adds administrative stylesheet
		 */
		function admin_head()
		{
			$cssUrl = $this->thisProtocolRelativeUrl;
            echo('<link rel="stylesheet" href="'.$cssUrl.'css/admin.css" type="text/css" media="screen" />');			
		}
		
        /**
		 * Writes the IE6 fix code if IE6 has been detected as the user's browser
		*/
        function wp_head()
		{
			$fixMethod = $this->options['hits_ie6_pngfix_method'];
			$pagesAreCached = $this->options['hits_ie6_pngfix_pagesAreCached'];
			
			global $wp_version;
			echo "\n";
			echo "\n<!-- Begin - HITS-IE6 PNGFix -->";
			if($this->options['hits_ie6_debug']=='true')
			{
				echo "\n<!-- DEBUG: Plugin Version=$this->version\n     DEBUG: Fix Method=$fixMethod\n     DEBUG: PagesAreCached=$pagesAreCached -->";
			}
			if($pagesAreCached=='false')
			{
				if($this->isIE6() || $this->overrideIE6Check)
				{
					echo "\n<!-- IE6 has been detected as the users browser version by the server -->";
					$this->write_ie6_fix_nodes($fixMethod);
				}
				else
					echo "\n<!-- IE6 has not been detected as the users browser version by the server -->";
			}
			else
			{
				echo "\n<!-- The browser itself will determine if IE6 code will be used -->";
				echo "\n<!--[if lte IE 6]>";
				$this->write_ie6_fix_nodes($fixMethod);
				echo "\n<![endif]-->";
			}
			
			echo "\n<!--  End  - HITS-IE6 PNGFix -->\n";
			echo "\n";
		}
		
		/**
		 * Outputs the fix to the browser's head for implementing the IE6 PNG Fix
		 * @param String $fixMethod
		 */
		function write_ie6_fix_nodes($fixMethod)
		{
			$pluginUrl = $this->thisProtocolRelativeUrl;
			if (strcmp($fixMethod,'THM1')==0)
			{
				echo "\n<style type='text/css'>".$this->options['hits_ie6_pngfix_THM_CSSSelector']." { behavior: url(". $pluginUrl."THM1/iepngfix.php) }</style>";
			}
			else if (strcmp($fixMethod,'THM2')==0)
			{
				echo "\n<style type='text/css'>".$this->options['hits_ie6_pngfix_THM_CSSSelector']." { behavior: url(". $pluginUrl."THM2/iepngfix.php) }</style>";
				echo "\n<script type='text/javascript' src='". $pluginUrl."THM2/iepngfix_tilebg.js'></script>";
			}
			else if (strcmp($fixMethod,'UPNGFIX')==0)
			{
				echo "\n<script type='text/javascript' src='". $pluginUrl."UPNGFIX/unitpngfix.js.php'></script>";
			}
			else if (strcmp($fixMethod,'SUPERSLEIGHT')==0)
			{
				echo "\n<script type='text/javascript' src='". $pluginUrl."supersleight/supersleight-min.js.php'></script>";
			}
			else if (strcmp($fixMethod,'DD_BELATED')==0)
			{
				echo "\n<script type='text/javascript' src='". $pluginUrl."DD_belatedPNG/DD_belatedPNG_0.0.8a-min.js'></script>";
				echo "\n<script type='text/javascript'>DD_belatedPNG.fix('".$this->options['hits_ie6_pngfix_THM_CSSSelector']."');</script>";
			}
		}
        
		/**
		 * PHP IE6 detection code.
		 * @return boolean Whether or not PHP has detected the browser is IE6
		 */
		function isIE6()
		{
			$browser = 'mozilla';
			$majorVersion = 5;
		
			if(get_cfg_var('browscap')) 
			{
				$browserTab = get_browser();
				$browser = strtolower($browserTab->browser);
				$majorVersion = intval($browserTab->majorver);
			}
			else 
			{
				$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
				if (preg_match('|msie ([0-9]).[0-9]{1,2}|',$userAgent,$matched)) 
				{
					$browser = 'ie';
					$majorVersion = intval($matched[1]);
				}
			}
		
			if($this->options['hits_ie6_debug']=="true") {
				echo "\n<!-- DEBUG: HTTP_USER_AGENT='$userAgent' -->";
				echo "\n<!-- DEBUG: DETECT BROWSER='$browser' -->";
				echo "\n<!-- DEBUG: DETECT M VERSION='$majorVersion' -->";
			}
		
			if($browser == 'ie' && $majorVersion <= 6) { // if IE<=6
				return true;
			}
			else { //if IE>6
				return false;
			}
		}
        
        /**
        * Retrieves the plugin options from the database.
        * @return array
        */
        function getOptions() {
            if (!$theOptions = get_option($this->optionsName)) 
			{//default options
                $theOptions = array('hits_ie6_pngfix_method'=>'THM1', //Added V2.0
									'hits_ie6_pngfix_THM_CSSSelector'=>'img, div', //Added V2.1
									//'hits_ie6_pngfix_THM_image_path'=>'Initiated',//Added V2.2  Removed in V3.2
									'hits_ie6_pngfix_version'=>$this->version, //Added V2.3
									'hits_ie6_debug'=>"false", //Added V3.0
									'hits_ie6_pngfix_pagesAreCached'=>'false' //Added V3.1
									//'hits_ie6_pngfix_image_path'=>'Initiated'//Added V3.2 Removed in V3.3
									);
                update_option($this->optionsName, $theOptions);
				$this->persist_optionsFile();
            }
            $this->options = $theOptions;
            
			//check for missing fields on an upgrade
			$missingOptions=false;
			if(!$this->options['hits_ie6_pngfix_version'] || (strcmp($this->options['hits_ie6_pngfix_version'],$this->version)!=0))
			{
				$missingOptions=true;
				//an upgrade, run upgrade specific tasks.
				
				//upgrading from pre-version 2.2
				if(!$this->options['hits_ie6_pngfix_THM_CSSSelector'])
				{
					if(strcmp($this->options['hits_ie6_pngfix_method'],'THM1')==0)
						$this->options['hits_ie6_pngfix_THM_CSSSelector'] = 'img,div';
					else if(strcmp($this->options['hits_ie6_pngfix_method'],'THM2')==0)
						$this->options['hits_ie6_pngfix_THM_CSSSelector'] = 'img, div, a, input';
				}				
				//upgrading from version 2.2
				
				//set the version and update the database.
				$this->options['hits_ie6_pngfix_version']=$this->version;
				
				//added in 3.0
				if(!$this->options['hits_ie6_debug'])
				{
					$this->options['hits_ie6_debug']="false";
				}
				
				//added in 3.1
				if(!$this->options['hits_ie6_pngfix_pagesAreCached'])
				{
					$this->options['hits_ie6_pngfix_pagesAreCached']='false';	
				}
				
				//upgrading to V3.2
				if($this->options['hits_ie6_pngfix_THM_image_path'])
				{
					//remove the old options	
					unset($this->options['hits_ie6_pngfix_THM_image_path']);
				}
				if($this->options['hits_ie6_pngfix_image_path'])
				{
					//remove old option
					unset($this->options['hits_ie6_pngfix_image_path']);
				}
				$this->persist_optionsFile();
			}
			
			//if missing options found, update them.
			if($missingOptions==true)
				$this->saveAdminOptions();
        }
        
        /**
        * @desc Saves the admin options to the database.
        */
        function saveAdminOptions(){
			//save options to database
			return update_option($this->optionsName, $this->options);
        }
		
		/**
		 * Saves the path to the location of clear.gif to a properties file for use inside the fixes.
		 */
		function persist_optionsFile()
		{
			$propFile = $this->thispluginpath.'hits-pngfix2.properties';
			if($this->is__writable($propFile))
			{
				$propFileHandle = @fopen($propFile, 'w') or die("can't open file");
				fwrite($propFileHandle,$this->thisProtocolRelativeUrl."clear.gif");
				fclose($propFileHandle);
			}
			else
			{
				if($this->options['hits_ie6_debug']=='true')
					echo "<!-- DEBUG: Options file is not writeable -->";
			}
		}
		
		/**
		 * Determines if a file is writeable by the web server
		 * following code taken from http://us.php.net/manual/en/function.is-writable.php
		 * @param unknown_type $path
		 * @return boolean
		 */
		function is__writable($path) {
		//will work in despite of Windows ACLs bug
		//NOTE: use a trailing slash for folders!!!
		//see http://bugs.php.net/bug.php?id=27609
		//see http://bugs.php.net/bug.php?id=30931
		
			if ($path{strlen($path)-1}=='/') // recursively return a temporary file path
				return is__writable($path.uniqid(mt_rand()).'.tmp');
			else if (is_dir($path))
				return is__writable($path.'/'.uniqid(mt_rand()).'.tmp');
			// check tmp file for read/write capabilities
			$rm = file_exists($path);
			$f = @fopen($path, 'a');
			if ($f===false)
				return false;
			fclose($f);
			if (!$rm)
				unlink($path);
			return true;
		}

        /**
        * Adds the options subpanel
        */
        function admin_menu_link() {
            //If you change this from add_options_page, MAKE SURE you change the filter_plugin_actions function (below) to
            //reflect the page filename (ie - options-general.php) of the page your plugin is under!
            add_options_page('HITS- IE6 PNG Fix', 'HITS- IE6 PNG Fix', 'edit_pages', basename(__FILE__), array(&$this,'admin_options_page'));
            add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'filter_plugin_actions'), 10, 2 );
        }
        
        /**
        * Adds the Settings link to the plugin activate/deactivate page
        */
        function filter_plugin_actions($links, $file) {
           //If your plugin is under a different top-level menu than Settiongs (IE - you changed the function above to something other than add_options_page)
           //Then you're going to want to change options-general.php below to the name of your top-level page
           $settings_link = '<a href="options-general.php?page=' . basename(__FILE__) . '">' . __('Settings') . '</a>';
           array_unshift( $links, $settings_link ); // before other links

           return $links;
        }
        
        /**
        * Adds settings/options page
        */
        function admin_options_page() { 
            require_once($this->pluginDIR .'adminPage.php');
        }
  } //End Class
} //End if class exists statement

//instantiate the class
if (class_exists('hits_ie6_pngfix')) {
    $hits_ie6_pngfix_var = new hits_ie6_pngfix();
}
?>
