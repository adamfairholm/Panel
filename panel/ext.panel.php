<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Panel Extension
 *
 * @author		Addict Add-ons Dev Team
 * @copyright	Copyright (c) 2011, Addict Add-ons
 * @link		http://addictaddons.com/panel
 * @license		http://addictaddons.com/panel/license
 */
class Panel_ext {

    var $name 				= 'Panel Extenson';
    var $version 			= '1.0';
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
    	$obj = $this->EE->db->get('panel_settings');
    
    	$settings = $obj->result();
    	
    	foreach( $settings as $setting ):
    
			$this->EE->config->_global_vars[$setting->setting_name] = $setting->value;
		
		endforeach;
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