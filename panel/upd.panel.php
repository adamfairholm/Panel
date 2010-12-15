<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Panel_upd { 

    var $version        = '0.1 Alpha'; 
     
    function Panel_upd() 
    { 
		$this->EE =& get_instance();
    }

	// --------------------------------------------------------------------------
	   
    function install()
    {
		$outcome = TRUE;
		
		$this->EE->load->dbforge();

		// -------------------------------------
		// Create the Panels Table
		// -------------------------------------

		$this->EE->dbforge->add_field( 'id' );
			
		$panel_fields = array(
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
            'setting_type' 	=> array( 'type' => 'VARCHAR', 'constraint' => 40 ),
            'setting_label' => array( 'type' => 'VARCHAR', 'constraint' => 100 ),
            'setting_name' 	=> array( 'type' => 'VARCHAR', 'constraint' => 100 ),
            'instructions' 	=> array( 'type' => 'VARCHAR', 'constraint' => 255 ),
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

	function update($current = '')
	{
	
		return FALSE;
	}

	// --------------------------------------------------------------------------
	
	function uninstall()
	{
		$this->EE->load->dbforge();

		$outcome = TRUE;
		
		// Drop log table
	
		$outcome = $this->EE->dbforge->drop_table('panels');

		// Drop scratch table

		$outcome = $this->EE->dbforge->drop_table('panel_settings');
	
		return $outcome;
	}
	
}

/* End of file upd.trigger.php */
/* Location: ./expressionengine/third_party/trigger/upd.trigger.php */