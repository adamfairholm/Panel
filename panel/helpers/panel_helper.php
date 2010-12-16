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

/* End of file panel_helper.php */
/* Location: ./expressionengine/third_party/Panel/panel/helpers/panel_helper.php */