<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Panel Module
 *
 * @author		Addict Add-ons Dev Team
 * @copyright	Copyright (c) 2011, Addict Add-ons
 * @link		http://addictaddons.com/panel
 * @license		http://addictaddons.com/panel/license
 */
class Panel_mcp {
	
	// --------------------------------------------------------------------------
	
	/**
	 * Constructor
	 */
	function Panel_mcp()
	{
		$this->EE =& get_instance();
			
		// Load our setting and panel models
		
		$this->EE->load->model( array('panel_mdl', 'settings_mdl') );
		
		// Module base is useful down below
		
		$this->module_base = 	$this->EE->config->item('base_url').
								SYSDIR.'/'.
								BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=panel';

		// Get our setting types
	
		$this->types = $this->EE->settings_mdl->get_setting_types();
	}

	// --------------------------------------------------------------------------
	
	/**
	 * List out the panels
	 */
	function index()
	{
		// -------------------------------------
		// Process Panel Data
		// -------------------------------------
		
		if( $this->EE->input->get_post('submit') ):
		
			$settings = $this->EE->settings_mdl->get_all_settings();
			
			foreach( $settings as $setting ):
			
				if( $this->EE->input->get_post($setting->setting_name) ):
			
					$update_data['value'] = $this->EE->input->get_post($setting->setting_name);
					
					$this->EE->db->where('id', $setting->id);
					
					$this->EE->db->update('panel_settings', $update_data);
					
					$update_data = array();
			
				endif;
			
			endforeach;
		
			$this->EE->session->set_flashdata('message_success', $this->EE->lang->line('panel_settings_updated_s'));
			
			$this->EE->functions->redirect( $this->module_base );
		
		endif;
	
		// -------------------------------------
		// Loads and Setup
		// -------------------------------------
	
		$this->EE->load->library('table');
		$this->EE->load->helper('form');
		
		$this->EE->cp->set_right_nav( 
			array(
				'panel_manage_panels' 	=> $this->module_base.AMP.'method=manage_panels'
			)
		 );
	
		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('panel_module_name'));

		// -------------------------------------
		// Get Panels
		// -------------------------------------
		
		$panels = $this->EE->panel_mdl->get_panels();

		// -------------------------------------
		// Get Panels
		// -------------------------------------
		
		$vars['panels'] = array();
		
		foreach( $panels as $panel ):
		
			$vars['panels'][$panel->id] = array();
		
			$settings = $this->EE->settings_mdl->get_settings_for_panel( $panel->id );
			
			$vars['panel_info'][$panel->id]['name'] = $panel->panel_name;
			
			if( $settings ):
		
			foreach( $settings as $setting ):
			
				$vars['panels'][$panel->id][$setting->id] = $setting;
			
			endforeach;
			
			endif;
		
		endforeach;

		// -------------------------------------
		// Add Accordian Load Page
		// -------------------------------------

		$vars['types'] 			= $this->types;
		$vars['module_base']	= $this->module_base;

		$this->EE->cp->add_js_script('ui', 'accordion');
		$this->EE->javascript->output('
				$("#my_accordion").accordion({autoHeight: false,header: "h3"});
			');
	
		$this->EE->javascript->compile();

		return $this->EE->load->view('panels', $vars, TRUE); 
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Manage Panels
	 *
	 * List panels in an admin-like way to edit and delete them
	 */
	function manage_panels()
	{
		$this->EE->cp->set_right_nav( 
			array(
				'panel_module_name' 	=> $this->module_base,
				'panel_new_panel' 		=> $this->module_base.AMP.'method=new_panel'
			)
		);
		
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
		// Load Page
		// -------------------------------------

		$this->EE->cp->set_breadcrumb($this->module_base, $this->EE->lang->line('panel_module_name'));
		
		return $this->EE->load->view('list_panels', $vars, TRUE); 
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Create a new panel
	 *
	 * @access	public
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
			
				show_error( $this->EE->lang->line('panel_provide_panel_name') );
			
			endif;
			
			if( $this->EE->panel_mdl->add_panel( $this->EE->input->get_post('panel_name') ) ):
			
				$this->EE->session->set_flashdata('message_success', $this->EE->lang->line('panel_add_s'));
				
				$this->EE->functions->redirect( $this->module_base.AMP.'method=manage_panels' );
			
			else:
			
				show_error( $this->EE->lang->line('panel_add_e') );
			
			endif;
		
		endif;

		$this->EE->cp->set_breadcrumb($this->module_base, $this->EE->lang->line('panel_module_name'));
		$this->EE->cp->set_breadcrumb($this->module_base.AMP.'method=manage_panels', $this->EE->lang->line('panel_manage_panels'));

		return $this->_panel_form( $vars );
	}

	// --------------------------------------------------------------------------

	/**
	 * Edit a panel's data
	 *
	 * @access	public
	 */
	function edit_panel()
	{
		$panel_id = $this->EE->input->get_post('panel_id');
	
		// -------------------------------------
		// Process Data
		// -------------------------------------

		if( $this->EE->input->get_post('submit') ):
		
			// Check that we have a panel name
		
			if( $this->EE->input->get_post('panel_name') == '' ):
			
				show_error( $this->EE->input->post('panel_provide_panel_name') );
			
			endif;
			
			if( $this->EE->panel_mdl->update_panel( $this->EE->input->get_post('id'), $this->EE->input->get_post('panel_name') ) ):
			
				$this->EE->session->set_flashdata('message_success', $this->EE->lang->line('panel_upd_s'));
				
				$this->EE->functions->redirect( $this->module_base.AMP.'method=manage_panels' );
			
			else:
			
				show_error($this->EE->lang->line('panel_upd_e'));
			
			endif;
		
		endif;

		// -------------------------------------
		// Get Panel Data
		// -------------------------------------

		$panel = $this->EE->panel_mdl->get_panel( $panel_id );		

		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('panel_edit_panel'));

		$vars = array(
			'id'			=> $panel_id,
			'panel_name'	=> $panel->panel_name,
			'method'		=> 'edit'
		);

		$this->EE->cp->set_breadcrumb($this->module_base, $this->EE->lang->line('panel_module_name'));
		$this->EE->cp->set_breadcrumb($this->module_base.AMP.'method=manage_panels', $this->EE->lang->line('panel_manage_panels'));
		
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

	// --------------------------------------------------------------------------

	/**
	 * Delete a panel
	 *
	 * This deletes the panel in the database and all the 
	 * attached settings
	 *
	 * @access	public
	 */	
	function delete_panel()
	{
		$panel_id = $this->EE->input->get_post('panel_id');

		// -------------------------------------
		// Get Panel Data
		// -------------------------------------

		$panel = $this->EE->panel_mdl->get_panel( $panel_id );	
		
		$vars['panel_id']			= $panel_id;
		$vars['panel_name']			= $panel->panel_name;
		$vars['module_base']		= $this->module_base;

		// -------------------------------------
		// Process Delete
		// -------------------------------------

		if( $this->EE->input->get_post('delete_confirm') == TRUE ):
		
			$this->EE->panel_mdl->delete_panel( $this->EE->input->get_post('panel_id') );
			
			$this->EE->session->set_flashdata('message_success', $this->EE->lang->line('panel_deleted'));
			
			$this->EE->functions->redirect($this->module_base.AMP.'&method=manage_panels');

		else:

			$this->EE->cp->set_breadcrumb($this->module_base, $this->EE->lang->line('panel_module_name'));
			
			$this->EE->cp->set_breadcrumb($this->module_base.AMP.'method=manage_panels', $this->EE->lang->line('panel_manage_panels'));
			
			$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('panel_delete_panel'));				
			
			return $this->EE->load->view('delete_panel', $vars, TRUE);
		
		endif;
	}

	// --------------------------------------------------------------------------

	/**
	 * Manage Settings
	 *
	 * This shows the current settings for a panel
	 *
	 * @access	public
	 */		
	function manage_settings()
	{
		$this->EE->load->model('settings_mdl');
	
		$panel_id = $this->EE->input->get_post('panel_id');

		$this->EE->cp->set_right_nav( 
			array(
				'panel_new_setting' 		=> $this->module_base.AMP.'method=new_setting'.AMP.'panel_id='.$panel_id
			)
		);

		// -------------------------------------
		// Get Panel Data
		// -------------------------------------

		$panel = $this->EE->panel_mdl->get_panel( $panel_id );		

		// -------------------------------------
		// Get Settings for Panel
		// -------------------------------------

		$settings = $this->EE->settings_mdl->get_settings_for_panel( $panel_id );

		// -------------------------------------
		// Load Table Library for layout
		// -------------------------------------
	
		$this->EE->load->library('Table');

		// -------------------------------------
		// Load Page
		// -------------------------------------
		
		$vars['settings']			= $settings;
		$vars['module_base']		= $this->module_base;
		$vars['panel_id']			= $panel->id;
		$vars['types']				= $this->types;

		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('panel_manage_settings').': '.$panel->panel_name);				

		$this->EE->cp->set_breadcrumb($this->module_base, $this->EE->lang->line('panel_module_name'));
		$this->EE->cp->set_breadcrumb($this->module_base.AMP.'method=manage_panels', $this->EE->lang->line('panel_manage_panels'));
			
		return $this->EE->load->view('list_settings', $vars, TRUE);
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Create a new setting
	 *
	 * @access	public
	 */
	function new_setting()
	{	
		$method = 'new';
	
		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('panel_new_setting'));

		// -------------------------------------
		// Get Panel Data
		// -------------------------------------
		
		$panel_id = $this->EE->input->get_post('panel_id');

		$panel = $this->EE->panel_mdl->get_panel( $panel_id );		

		$vars = array(
			'method'		=> $method,
			'panel_id'		=> $panel_id,
			'module_base'	=> $this->module_base,
			'extra_rows'	=> '',
			'setting_id'	=> '',
			'setting_type'	=> '',
			'setting_label'	=> '',
			'setting_name'	=> '',
			'instructions'	=> '',
			'default_value'	=> ''
		);

		// -------------------------------------
		// Process Data
		// -------------------------------------

		if( $this->EE->input->get_post('submit') ):
		
			// -------------------------------------
			// Processing
			// -------------------------------------
			
			$this->_validate_setting( 'new' );
			
			$type = $_POST['setting_type'];
					
			if( $this->EE->settings_mdl->add_setting( $_POST, $panel_id, $this->types->$type ) ):
			
				$this->EE->session->set_flashdata('message_success', $this->EE->lang->line('panel_setting_add_s'));
				
				$this->EE->functions->redirect( $this->module_base.AMP.'method=manage_panels' );
			
			else:
			
				show_error( $this->EE->lang->line('panel_setting_add_e') );
			
			endif;
		
		endif;

		// -------------------------------------
		// Load Page
		// -------------------------------------

		$this->EE->cp->set_breadcrumb($this->module_base, $this->EE->lang->line('panel_module_name'));
		$this->EE->cp->set_breadcrumb($this->module_base.AMP.'method=manage_panels', $this->EE->lang->line('panel_manage_panels'));
		$this->EE->cp->set_breadcrumb($this->module_base.AMP.'method=manage_settings'.AMP.'panel_id='.$panel_id, $this->EE->lang->line('panel_manage_settings').': '.$panel->panel_name);

		return $this->_setting_form( $vars );
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Edit a setting
	 *
	 * @access	public
	 */
	function edit_setting()
	{	
		$method = 'edit';

		$this->EE->load->helper('panel');
	
		// -------------------------------------
		// Get Panel & Setting Data
		// -------------------------------------
		
		$panel_id = $this->EE->input->get_post('panel_id');

		$panel = $this->EE->panel_mdl->get_panel( $panel_id );

		$setting_id = $this->EE->input->get_post('setting_id');
		
		$setting = $this->EE->settings_mdl->get_setting( $setting_id );	

		$vars = array(
			'setting_id'	=> $setting->id,
			'method'		=> $method,
			'panel_id'		=> $panel_id,
			'module_base'	=> $this->module_base,
			'setting_type'	=> $setting->setting_type,
			'setting_label'	=> $setting->setting_label,
			'setting_name'	=> $setting->setting_name,
			'instructions'	=> $setting->instructions,
			'default_value'	=> $setting->default_value
		);

		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('panel_edit_setting').': '.$setting->setting_label);
	
		// Get the extra fields
		
		$vars['extra_rows'] = extra_rows( $setting->setting_type, $this->types, $setting->data );
		
		// Get the right default value format if necessary
		
		$type = $setting->setting_type;
		
		if( method_exists( $this->types->$type, 'default_value') ):
		
			$vars['default_value_input'] = $this->types->$type->default_value( $setting->default_value );
		
		endif;

		// -------------------------------------
		// Process Data
		// -------------------------------------

		if( $this->EE->input->get_post('submit') ):
		
			// -------------------------------------
			// Processing
			// -------------------------------------
			
			$this->_validate_setting( 'edit' );

			$type = $_POST['setting_type'];
					
			if( $this->EE->settings_mdl->update_setting( $_POST, $setting_id, $this->types->$type ) ):
			
				$this->EE->session->set_flashdata('message_success', $this->EE->lang->line('panel_setting_upd_s'));
				
				$this->EE->functions->redirect( $this->module_base.AMP.'method=manage_panels' );
			
			else:
			
				show_error( $this->EE->lang->line('panel_setting_upd_e') );
			
			endif;
		
		endif;

		// -------------------------------------
		// Load Page
		// -------------------------------------

		$this->EE->cp->set_breadcrumb($this->module_base, $this->EE->lang->line('panel_module_name'));
		$this->EE->cp->set_breadcrumb($this->module_base.AMP.'method=manage_panels', $this->EE->lang->line('panel_manage_panels'));
		$this->EE->cp->set_breadcrumb($this->module_base.AMP.'method=manage_settings'.AMP.'panel_id='.$panel_id, $this->EE->lang->line('panel_manage_settings').': '.$panel->panel_name);

		return $this->_setting_form( $vars );
	}

	// --------------------------------------------------------------------------

	/**
	 * Process and save setting data
	 */
	function _validate_setting( $method )
	{
		// -------------------------------------
		// Validation
		// -------------------------------------
	
		$errors = array();

		// Do we have a setting?
	
		if( $this->EE->input->get_post('setting_type') == '-' ):
		
			$errors[] = $this->EE->lang->line('panel_err_setting_type');
		
		endif;
		
		// Do we have a setting label?
	
		if( $this->EE->input->get_post('setting_label') == '' ):
		
			$errors[] = $this->EE->lang->line('panel_err_setting_label');
		
		endif;

		// Do we have a setting name?
		
		if( $this->EE->input->get_post('setting_name') == '' ):
		
			$errors[] = $this->EE->lang->line('panel_err_setting_name');
		
		endif;

		// Is this already a global variable
		
		if( ! $this->EE->settings_mdl->is_global_name( $this->EE->input->get_post('setting_name') ) ):
		
			$errors[] = $this->EE->lang->line('panel_err_global_name');
		
		endif;

		// Is the setting name unique?
		
		if( ! $this->EE->settings_mdl->is_name_unique( $this->EE->input->get_post('setting_name'), $method ) ):
		
			$errors[] = $this->EE->lang->line('panel_err_setting_dupe');
		
		endif;
	
		if(count($errors) > 0)
		{
			$err = null;
	
			foreach ($errors as $error)
			{
				$err .= $error.BR;
			}
	
			show_error($err);
		}
	}

	// --------------------------------------------------------------------------
	
	/**
	 * The form for editing and creating settings
	 *
	 * @access	private
	 */
	function _setting_form( $vars )
	{
		// -------------------------------------
		// Parameters JS
		// -------------------------------------
		
		$this->EE->cp->load_package_js('parameters');

		// -------------------------------------
		// Get the types & create an array
		// -------------------------------------
		
		$vars['setting_types']['-'] = "--".$this->EE->lang->line('panel_pick_setting_type')."--";

		foreach( $this->types as $type ):
		
			$vars['setting_types'][$type->setting_type_name] = $type->lang['setting_label'];
		
		endforeach;

		// -------------------------------------
		// Table Loads and Logic
		// -------------------------------------

		$this->EE->load->library('Table');

		$this->EE->jquery->tablesorter('.mainTable', '{
			headers: {0: {sorter: false}, 1: {sorter: false}},
			widgets: ["zebra"]
		}');

		$this->EE->javascript->compile();	
		
		// -------------------------------------
		// Load Page
		// -------------------------------------
	
		return $this->EE->load->view('setting_form', $vars, TRUE);
	}

	// --------------------------------------------------------------------------

	/**
	 * Deletes a setting
	 *
	 * @access 	public
	 */
	function delete_setting()
	{
		$panel_id = $this->EE->input->get_post('panel_id');

		$panel = $this->EE->panel_mdl->get_panel( $panel_id );

		// -------------------------------------
		// Get Setting Data
		// -------------------------------------

		$setting_id = $this->EE->input->get_post('setting_id');

		$setting = $this->EE->settings_mdl->get_setting( $setting_id );	
		
		$vars['panel_id']			= $panel_id;
		$vars['setting_id']			= $setting->id;
		$vars['setting_label']		= $setting->setting_label;
		$vars['module_base']		= $this->module_base;

		// -------------------------------------
		// Process Delete
		// -------------------------------------

		if( $this->EE->input->get_post('delete_confirm') == TRUE ):
		
			$this->EE->settings_mdl->delete_setting( $setting_id );
			
			$this->EE->session->set_flashdata('message_success', $this->EE->lang->line('panel_setting_del_s'));
			
			$this->EE->functions->redirect( $this->module_base.AMP.'method=manage_settings'.AMP.'panel_id='.$panel_id );

		else:

			$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('panel_delete_setting'));				

			$this->EE->cp->set_breadcrumb($this->module_base, $this->EE->lang->line('panel_module_name'));
			
			$this->EE->cp->set_breadcrumb($this->module_base.AMP.'method=manage_panels', $this->EE->lang->line('panel_manage_panels'));
	
			$this->EE->cp->set_breadcrumb($this->module_base.AMP.'method=manage_settings'.AMP.'panel_id='.$panel_id, $this->EE->lang->line('panel_manage_settings').': '.$panel->panel_name);
			
			return $this->EE->load->view('delete_setting', $vars, TRUE);
		
		endif;
	}

	// --------------------------------------------------------------------------

	/**
	 * Reset all settings back to the defaults
	 *
	 * @access 	public
	 */
	function reset_defaults()
	{
		// -------------------------------------
		// Process Reset
		// -------------------------------------

		if( $this->EE->input->get_post('reset_confirm') == TRUE ):
		
			$this->EE->settings_mdl->reset_settings();
			
			$this->EE->session->set_flashdata('message_success', $this->EE->lang->line('panel_reset_s'));
			
			$this->EE->functions->redirect( $this->module_base );

		else:

			$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('panel_reset'));
					
			$this->EE->cp->set_breadcrumb($this->module_base, $this->EE->lang->line('panel_module_name'));
			
			$this->EE->cp->set_breadcrumb($this->module_base.AMP.'method=manage_panels', $this->EE->lang->line('panel_manage_panels'));
			
			return $this->EE->load->view('reset_defaults', '', TRUE);
		
		endif;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Show parameters for a new setting
	 *
	 * Accessed via AJAX
	 *
	 * @access	public
	 * @return	void
	 */
	function show_parameters()
	{
		$this->EE->load->helper('panel');

		$setting_type = $this->EE->input->get_post('type');
		
		$setting_id = $this->EE->input->get_post('setting_id');
		
		// Get setting if there is one
		
		if( is_numeric($setting_id) ):
		
			$setting = $this->EE->settings_mdl->get_setting($setting_id);
		
			$output = extra_rows( $setting_type, $this->types, $setting->data );
			
		else:
		
			$output = extra_rows( $setting_type, $this->types );
		
		endif;
	
		ajax_output( $output );
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Show the default value for a setting
	 */
	function show_default_value()
	{
		// Check to see if we have a type
		
		if( !$this->EE->input->get_post('type') ):
		
			show_error("Invalid Input");
		
		endif;

		$type = $this->EE->input->get_post('type');
		
		$value = '';
		
		// Get the value if we have the setting ID
		
		if( $this->EE->input->get_post('setting_id') ):
		
			$setting = $this->EE->settings_mdl->get_setting( $this->EE->input->get_post('setting_id') );
	
			$value = $setting->default_value;
			
		endif;
		
		$this->EE->load->helper('panel');

		if( method_exists($this->types->$type, 'default_value') ):
		
			ajax_output( $this->types->$type->default_value( $value ) );
		
		else:
		
			ajax_output( form_input(array('id'=>'default_value','name'=>'default_value','class'=>'fullfield','value'=>$value)) );
		
		endif;
	}
}

/* End of file mcp.panel.php */
/* Location: ./system/expressionengine/third_party/panel/mcp.panel.php */