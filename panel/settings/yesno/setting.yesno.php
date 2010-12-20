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

	// --------------------------------------------------------------------------

	/**
	 * Custom default value
	 *
	 * @access	public
	 * @param	[string]
	 * @return	string
	 */
	function default_value( $value = '' )
	{
		$options = array(
			'yes' 	=> 'Yes',
			'no'	=> 'No'
		);
		
		return form_dropdown( 'default_value', $options, $value);
	}
	
}

/* End of file setting.yesno.php */
/* Location: ./expressionengine/third_party/panel/settings/yesno/setting.yesno.php */