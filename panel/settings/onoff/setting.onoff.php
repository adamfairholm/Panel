<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * On/Off Setting
 *
 * @author		Parse19
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @link		http://parse19.com/panel
 * @license		http://parse19.com/panel/license
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
		
		// Yes
		
		$params['value']	= 'on';
		$params['label']	= 'on';
		$params['id']		= $name.'_on';
		
		if( $value == 'on' ):
		
			$params['checked'] = TRUE;
		
		endif;
		
		$html = form_radio( $params ) . ' <label for="'.$params['id'].'">' . $this->lang['setting_on'] . "</label>&nbsp;&nbsp;&nbsp;&nbsp;";
		
		// No
		
		$params['value']	= 'off';
		$params['label']	= 'off';
		$params['id']		= $name.'_off';
		
		if( $value == 'off' ):
		
			$params['checked'] = TRUE;
			
		else:
		
			$params['checked'] = FALSE;
		
		endif;

		$html .= form_radio( $params ) . ' <label for="'.$params['id'].'">' . $this->lang['setting_off'] . '</label>';
		
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
			'on' 	=> 'On',
			'off'	=> 'Off'
		);
		
		return form_dropdown( 'default_value', $options, $value);
	}
}

/* End of file setting.onoff.php */
/* Location: ./expressionengine/third_party/panel/settings/onoff/setting.onoff.php */