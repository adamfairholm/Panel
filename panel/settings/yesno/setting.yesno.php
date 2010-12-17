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
		
		$params['value']	= 'yes';
		
		if( $value == 'yes' ):
		
			$params['checked'] = TRUE;
		
		endif;
		
		$html = form_radio( $params ) . " Yes&nbsp;&nbsp;";
		
		// No
		
		$params['value']	= 'no';
		
		if( $value == 'no' ):
		
			$params['checked'] = TRUE;
		
		endif;

		$html .= form_radio( $params ) . " No";
		
		return $html;
	}
	
}

/* End of file setting.text.php */
/* Location: ./expressionengine/third_party/panel/settings/setting.text.php */