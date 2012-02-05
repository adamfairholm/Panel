<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Textarea Setting
 *
 * @author		Parse19
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @link		http://parse19.com/panel
 * @license		http://parse19.com/panel/license
 */
class Setting_textarea
{
	var $setting_type_name			= 'textarea';
	
	var $use_label					= TRUE;

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	function form_output( $name, $value = '' )
	{
		$params['name']		= $name;
		$params['id']		= $name;
		$params['value']	= $value;
		
		return form_textarea( $params );
	}
	
}

/* End of file setting.textarea.php */
/* Location: ./expressionengine/third_party/panel/settings/textarea/setting.textarea.php */