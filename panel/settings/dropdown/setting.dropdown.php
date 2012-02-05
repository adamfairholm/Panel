<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Entry Setting
 *
 * Retrieves the id of a setting for use in the channel entries tag
 *
 * @author		Parse19
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @link		http://parse19.com/panel
 * @license		http://parse19.com/panel/license
 */
class Setting_dropdown
{
	var $setting_type_name			= 'dropdown';

	var $setting_data				= array('content');

	// --------------------------------------------------------------------------

	/**
	 * Constructor
	 */
	function Setting_dropdown()
	{
		$this->EE =& get_instance();
	}

	// --------------------------------------------------------------------------

	/**
	 * Extra field to define content
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function content_input( $value = '' )
	{
		$params['name']		= 'content';
		$params['id']		= 'content';
		$params['value']	= $value;

		return form_textarea( $params );
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	string
	 */
	function form_output( $name, $value = '', $data = array() )
	{
		$items = array();
		
		$items[''] = $this->EE->lang->line('panel_choose_value');
	
		if( isset($data['content']) ):
		
			$lines = explode("\n", $data['content']);
			
			foreach( $lines as $line ):
			
				$pieces = explode(":", $line);
				
				$items[trim($pieces[0])] = trim($pieces[1]);
			
			endforeach;
		
			return form_dropdown( $name, $items, $value);
		
		else:
			
			return "No drop down data set";
		
		endif;
	}
	
}

/* End of file setting.text.php */
/* Location: ./expressionengine/third_party/panel/settings/setting.text.php */