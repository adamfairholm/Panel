<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Yes/No Setting
 *
 * @package		Panel
 * @author		Adam Fairholm (Green Egg Media)
 */
class Setting_yesno
{
	var $setting_type_name			= 'yesno';
	
	// --------------------------------------------------------------------------

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
		
		// Yes
		
		$params['value']	= 'yes';
		
		if( $value == 'yes' ):
		
			$params['checked'] = TRUE;
		
		endif;
		
		$html = form_radio( $params );
		
		// No
		
		$params['value']	= 'no';
		
		if( $value == 'no' ):
		
			$params['checked'] = TRUE;
		
		endif;

		$html .= form_radio( $params );
		
		return $html;
	}
	
}

/* End of file setting.text.php */
/* Location: ./expressionengine/third_party/panel/settings/setting.text.php */