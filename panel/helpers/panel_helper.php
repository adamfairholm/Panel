<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Bypass everything and output a string.
 *
 * For use with AJAX outputs
 *
 * @access	public
 * @param	string
 * @return	void
 */
function ajax_output( $output )
{
	$EE =& get_instance();

	$EE->output->enable_profiler(FALSE);

	if ($EE->config->item('send_headers') == 'y')
	{
		@header('Content-Type: text/html; charset=UTF-8');	
	}
	
	exit( $output );
}

// --------------------------------------------------------------------------

/**
 * Get extra paramater rows for a type
 *
 * @access	public
 * @param	string
 * @param	obj
 * @return	string
 */
function extra_rows( $setting_type, $types )
{
	$output = '';

	if( isset($types->$setting_type->setting_data) ):
	
		foreach( $types->$setting_type->setting_data as $name ):
	
			if( method_exists( $types->$setting_type, $name.'_input' ) ):
	
				$call = $name.'_input';
	
				$output .= '<tr class="panel_extra_param"><td><strong>'.$types->$setting_type->lang[$name.'_label'].'</strong>';
				
				// Add instructions if they are available
				
				if( isset($types->$setting_type->lang[$name.'_instructions']) ):
				
					$output .= '<br />'.$types->$setting_type->lang[$name.'_instructions'];
				
				endif;
				
				$output .= '</td><td>'.$types->$setting_type->$call().'</td></tr>';
			
			endif;
	
		endforeach;
	
	endif;
	
	return $output;
}

/* End of file panel_helper.php */
/* Location: ./expressionengine/third_party/Panel/panel/helpers/panel_helper.php */