<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * On/Off Setting
 *
 * @package		Panel
 * @author		Adam Fairholm (Green Egg Media)
 */
class Setting_onoff
{
	var $setting_type_name			= 'onoff';
	
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
		$params['name']		= $name;
		$params['id']		= $name;
		
		// Yes
		
		$params['value']	= 'on';
		
		if( $value == 'on' ):
		
			$params['checked'] = TRUE;
		
		endif;
		
		$html = form_radio( $params ) . " On&nbsp;&nbsp;";
		
		// No
		
		$params['value']	= 'off';
		
		if( $value == 'off' ):
		
			$params['checked'] = TRUE;
		
		endif;

		$html .= form_radio( $params ) . " Off";
		
		return $html;
	}
	
}

/* End of file setting.text.php */
/* Location: ./expressionengine/third_party/panel/settings/setting.text.php */