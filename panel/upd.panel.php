<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Panel Update File
 *
 * @author		Parse19
 * @copyright	Copyright (c) 2011-2012, Parse19
 * @link		http://parse19.com/panel
 * @license		http://parse19.com/panel/license
 */
class Panel_upd { 

    /**
     * Panel Version
     *
     * @access	public
     * @var		array
     */
    public $version        = '1.1'; 
 
 	// --------------------------------------------------------------------------
   
    /**
     * Our Panel Fields
     *
     * @access	private
     * @var		array
     */
    private $panel_fields = array(
		'sort_order' 	=> array('type' => 'INT', 'constraint' => 4 ),
		'panel_name' 	=> array('type' =>'VARCHAR', 'constraint' => 80),
		'panel_desc' 	=> array('type' =>'VARCHAR', 'constraint' => 200, 'null' => TRUE),
		'panel_menu' 	=> array('type' =>'VARCHAR', 'constraint' => 50, 'null' => TRUE)
	);

 	// --------------------------------------------------------------------------

    /**
     * Our Panel Settings Fields
     *
     * @access	private
     * @var		array
     */
	private $setting_fields = array(
		'panel_id' 		=> array('type' => 'INT', 'constraint' => 11),
		'sort_order' 	=> array('type' => 'INT', 'constraint' => 4),
		'setting_type' 	=> array('type' => 'VARCHAR', 'constraint' => 40),
		'setting_label' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE),
		'setting_name' 	=> array('type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE),
		'instructions' 	=> array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
		'data' 			=> array('type' => 'TEXT'),
		'default_value' => array('type' => 'TEXT', 'null' => TRUE),
		'value' 		=> array('type' => 'TEXT', 'null' => TRUE)
	);
	
	// --------------------------------------------------------------------------
     
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

		$this->EE->dbforge->add_field('id');
        $this->EE->dbforge->add_field($this->panel_fields);
            		
		$outcome = $this->EE->dbforge->create_table('panels');

		// -------------------------------------
		// Create the Panel Settings Table
		// -------------------------------------

		$this->EE->dbforge->add_field('id');
        $this->EE->dbforge->add_field($this->setting_fields);
		
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
	 * We're basically just going to run the schema
	 * so it stays up to date.
	 */
	function update()
	{
		$this->EE->load->dbforge();
		
		$tables = array(
			'panels'			=> $this->panel_fields,
			'panel_settings'	=> $this->setting_fields
		);
		
		foreach($tables as $table_name => $table_data)
		{		
			foreach ($table_data as $field_name => $field_data)
			{
				// If a field does not exist, then create it.
				if ( ! $this->EE->db->field_exists($field_name, $table_name))
				{
					$this->EE->dbforge->add_column($table_name, array($field_name => $field_data));	
				}
				else
				{
					// Okay, it exists, we are just going to modify it.
					// If the schema is the same it won't hurt it.
					$field_data['name'] = $field_name;
					$this->EE->dbforge->modify_column($table_name, array($field_name => $field_data));
				}
			}
		}
		
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