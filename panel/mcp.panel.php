<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel_mcp {
	
	// --------------------------------------------------------------------------
	
	function Panel_mcp()
	{
		$this->EE =& get_instance();
		
		$this->EE->load->model('panel_mdl');
		
		$this->module_base = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=panel';
	}

	// --------------------------------------------------------------------------
	
	/**
	 * List out the panels
	 */
	function index()
	{	
		$this->EE->cp->set_right_nav( 
			array(
				'panel_new_panel' 		=> $this->module_base.AMP.'method=new_panel',
				'panel_manage_panels' 	=> $this->module_base.AMP.'method=manage_panels'
			)
		 );
	
		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('panel_module_name'));

		// -------------------------------------
		// Get Panels
		// -------------------------------------

		// -------------------------------------
		// Load Page
		// -------------------------------------

		return $this->EE->load->view('panels', '', TRUE); 
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Manage Panels
	 *
	 * List panels in an admin-like way to edit and delete them
	 */
	function manage_panels()
	{
		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('panel_manage_panels'));
		
		$vars['module_base'] = $this->module_base;

		// -------------------------------------
		// Get Panels
		// -------------------------------------
		
		$vars['panels'] = $this->EE->panel_mdl->get_panels();
		
		// -------------------------------------
		// Load Table Library for layout
		// -------------------------------------
	
		$this->EE->load->library('Table');
		
		// -------------------------------------
		// Load trigger edit window
		// -------------------------------------

		return $this->EE->load->view('list_panels', $vars, TRUE); 
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Create a new panel
	 */
	function new_panel()
	{
		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('panel_new_panel'));

		$vars = array(
			'id'			=> '',
			'panel_name'	=> '',
			'method'		=> 'new'
		);

		// -------------------------------------
		// Process Data
		// -------------------------------------

		if( $this->EE->input->get_post('submit') ):
		
			// Check that we have a panel name
		
			if( $this->EE->input->get_post('panel_name') == '' ):
			
				show_error("You must provide a panel name");
			
			endif;
			
			if( $this->EE->panel_mdl->add_panel( $this->EE->input->get_post('panel_name') ) ):
			
				$this->EE->session->set_flashdata('message_success', "Panel added successfully");
				
				$this->EE->functions->redirect( $this->module_base );
			
			else:
			
				show_error("There was a problem with adding your panel");
			
			endif;
		
		endif;

		return $this->_panel_form( $vars );
	}
	
	// --------------------------------------------------------------------------

	/**
	 * The panel form
	 *
	 * @access	private
	 * @param	array
	 */
	function _panel_form( $vars )
	{
		$this->EE->load->helper('form');
		
		// -------------------------------------
		// Load Page
		// -------------------------------------

		return $this->EE->load->view('panel_form', $vars, TRUE); 
	}	

}

/* End of file mcp.panel.php */
/* Location: ./system/expressionengine/third_party/panel/mcp.panel.php */
