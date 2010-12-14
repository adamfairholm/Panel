<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel_mcp {
	
	function Panel_mcp()
	{
		$this->EE =& get_instance();
	}

	// --------------------------------------------------------------------------
	
	/**
	 * List out the panels
	 */
	function index()
	{	
		/*$this->EE->cp->set_right_nav( 
			array(
				'panel_edit_panels' => BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=panel'.AMP.'method=',
			)
		 );*/
	
		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('panel_module_name'));

		// -------------------------------------
		// Load trigger edit window
		// -------------------------------------

		return $this->EE->load->view('list_panels', '', TRUE); 
	}

}

/* End of file mcp.panel.php */
/* Location: ./system/expressionengine/third_party/panel/mcp.panel.php */
