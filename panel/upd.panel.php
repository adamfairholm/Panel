<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Panel Update File
 *
 * @author		Addict Add-ons Dev Team
 * @copyright	Copyright (c) 2011, Addict Add-ons
 * @link		http://addictaddons.com/panel
 * @license		http://addictaddons.com/panel/license
 */
class Panel_upd { 

    var $version        = '1.0'; 
     
    function Panel_upd() 
    { 
		$this->EE =& get_instance();
    }

	// --------------------------------------------------------------------------
	   
	/**
	 * Install
	 *
	 * Installs the module
	 *
	 * @access	public
	 * @return	bool
	 */
    function install()
    {
		$outcome = TRUE;
		
		$this->EE->load->dbforge();

		// -------------------------------------
		// Create the Panels Table
		// -------------------------------------

		$this->EE->dbforge->add_field( 'id' );
			
		$panel_fields = array(
            'sort_order' 	=> array( 'type' => 'INT', 'constraint' => 4 ),
            'panel_name' 	=> array( 'type' =>'VARCHAR', 'constraint' => 80 )
        );
                        
        $this->EE->dbforge->add_field( $panel_fields );
            		
		$outcome = $this->EE->dbforge->create_table('panels');

		// -------------------------------------
		// Create the Panel Settings Table
		// -------------------------------------

		$this->EE->dbforge->add_field( 'id' );
	
		$scratch_fields = array(
            'panel_id' 		=> array( 'type' => 'INT', 'constraint' => 11 ),
            'sort_order' 	=> array( 'type' => 'INT', 'constraint' => 4 ),
            'setting_type' 	=> array( 'type' => 'VARCHAR', 'constraint' => 40 ),
            'setting_label' => array( 'type' => 'VARCHAR', 'constraint' => 100 ),
            'setting_name' 	=> array( 'type' => 'VARCHAR', 'constraint' => 100 ),
            'instructions' 	=> array( 'type' => 'VARCHAR', 'constraint' => 255 ),
            'data' 			=> array( 'type' => 'TEXT' ),
           	'default_value' => array( 'type' => 'TEXT' ),
           	'value' 		=> array( 'type' => 'TEXT' )
        );
            
        $this->EE->dbforge->add_field( $scratch_fields );
		
		$outcome = $this->EE->dbforge->create_table('panel_settings');
	
		// -------------------------------------
		// Register the Module
		// -------------------------------------
	
		$data = array(
			'module_name' => 'Panel' ,
			'module_version' => $this->version,
			'has_cp_backend' => 'y',
			'has_publish_fields' => 'n'
		);

		$outcome = $this->EE->db->insert('modules', $data);
		
		return $outcome;
    }

	// --------------------------------------------------------------------------

	/**
	 * Update
	 *
	 * There is currently no update functionality
	 */
	function update($current = '')
	{
		return FALSE;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Uninstall
	 *
	 * Uninstalls the module
	 *
	 * @access	public
	 * @return	bool
	 */
	function uninstall()
	{
		$this->EE->load->dbforge();

		// Drop log table
	
		$this->EE->dbforge->drop_table('panels');

		// Drop scratch table

		$this->EE->dbforge->drop_table('panel_settings');
		
		// Remove from the modules table
		
		$this->EE->db->where('module_name', 'Panel');
		$this->EE->db->delete('modules');
	
		return TRUE;
	}
	
}

/* End of file upd.panel.php */
/* Location: ./system/expressionengine/third_party/panel/upd.panel.php */