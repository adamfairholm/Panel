<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Yes/No Setting
 *
 * @author		Parse19
 * @copyright	Copyright (c) 2011, Parse19
 * @link		http://parse19.com/panel
 * @license		http://parse19.com/panel/license
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
		
		// Yes

		$params['value']	= 'y';
		$params['label']	= 'yes';
		$params['id']		= $name.'_y';
				
		if( $value == 'y' ):
		
			$params['checked'] = TRUE;
		
		endif;
		
		$html = form_radio( $params ) . ' <label for="'.$params['id'].'">' . $this->lang['setting_yes'] . "</label>&nbsp;&nbsp;&nbsp;&nbsp;";
		
		// No

		$params['value']	= 'n';
		$params['label']	= 'no';
		$params['id']		= $name.'_n';

		if( $value == 'n' ):
		
			$params['checked'] = TRUE;
			
		else:
		
			$params['checked'] = FALSE;
		
		endif;

		$html .= form_radio( $params ) . ' <label for="'.$params['id'].'">' . $this->lang['setting_no'];
		
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
			'y' 	=> 'Yes',
			'n'		=> 'No'
		);
		
		return form_dropdown( 'default_value', $options, $value);
	}
	
}

/* End of file setting.yesno.php */
/* Location: ./expressionengine/third_party/panel/settings/yesno/setting.yesno.php */