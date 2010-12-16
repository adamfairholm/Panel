<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Text Setting
 *
 * @package		Panel
 * @author		Adam Fairholm (Green Egg Media)
 */
class Setting_text
{
	var $setting_type_name			= 'text';

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
		
		return form_input( $params );
	}
	
}

/* End of file setting.text.php */
/* Location: ./expressionengine/third_party/panel/settings/setting.text.php */