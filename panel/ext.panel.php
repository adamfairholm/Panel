<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Panel Extension
 *
 * @author		Parse19
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @link		http://parse19.com/panel
 * @license		http://parse19.com/panel/license
 */
class Panel_ext {

    var $name 				= 'Panel Extenson';
    var $version 			= '1.0.2';
    var $description 		= 'Adds panel settings into global variables';
    var $settings_exist 	= 'n';
    var $docs_url 			= '';

	// --------------------------------------------------------------------------

	/**
	 * Constructor
 	 *
 	 * @access	public
 	 * @return 	void
     */
	function Panel_ext()
	{
		$this->EE =& get_instance();
	}

	// --------------------------------------------------------------------------

    /**
     * Set the panel vars.
 	 *
 	 * @access	public
 	 * @return 	void
     */
    function set_panel_vars()
    {    
    	$settings = $this->EE->db->select('setting_name, value')->get('panel_settings')->result();
    	
    	foreach ($settings as $setting)
    	{
			// Get the value from the config and replace
			// the value if it exists.
			if($this->EE->config->item($setting->setting_name) !== FALSE)
			{
				$this->EE->config->_global_vars[$setting->setting_name] = $this->EE->config->item($setting->setting_name);
			}
			else
			{
				$this->EE->config->_global_vars[$setting->setting_name] = $setting->value;
			}
		}
    }

	// --------------------------------------------------------------------------
	  
	/**
	 * Activate Extension
	 *
 	 * @access	public
 	 * @return 	void
     */
	function activate_extension()
	{
		$data = array(
			'class'		=> __CLASS__,
			'method'	=> 'set_panel_vars',
			'hook'		=> 'sessions_start',
			'settings'	=> '',
			'priority'	=> 8,
			'version'	=> $this->version,
			'enabled'	=> 'y'
		);
		
		$this->EE->db->insert('extensions', $data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Disable Extension
	 *
 	 * @access	public
 	 * @return 	void
     */
	function disable_extension()
	{
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->delete('extensions');
	}

}

/* End of file ext.panel.php */
/* Location: ./expressionengine/third_party/Panel/panel/ext.panel.php */