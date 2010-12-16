<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_mdl extends CI_Model {

	function Settings_mdl()
	{
		parent::CI_Model();
    }

	// --------------------------------------------------------------------------
	
	/**
	 * Get a setting
	 *
	 * @access	public
	 * @param	int
	 * @return	obj
	 */
	function get_setting( $setting_id )
	{
		$this->db->limit(1);
	
		$this->db->where('id', $setting_id);
		
		$obj = $this->db->get('panel_settings');
		
		return $obj->row();
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Get the settings for a panel
	 *
	 * @access	public
	 * @param	int
	 * @return	obj
	 */
	function get_settings_for_panel( $panel_id )
	{
		$this->db->where('panel_id', $panel_id);
		
		$obj = $this->db->get('panel_settings');
		
		return $obj->result();
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Get a master obj of settings
	 *
	 * Settings are classes in the settings folder with a standard format.
	 *
	 * @access	public
	 * @return	obj
	 */
	function get_setting_types()
	{
		$this->load->helper('directory');
	
		$types = new stdClass;

		// Get the folders

		$folders = directory_map(APPPATH.'third_party/panel/settings/');

		// Run through them
		
		foreach( $folders as $folder => $node ):
		
			$setting_file = APPPATH.'third_party/panel/settings/'.$folder.'/setting.'.$folder.EXT;
		
			if( file_exists($setting_file) ):
			
				require_once($setting_file);

				$class_name = 'Setting_'.$folder;
	
				$types->$folder= new $class_name();
		
			endif;
	
		endforeach;
		
		return $types;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * See if a name is unique in the db
	 *
	 * @access	public
	 * @param	string
	 * @param	string ('new' or 'edit')
	 * @return	bool
	 */	
	function is_name_unique( $name, $method )
	{
		$this->db->where('setting_name', $name);
		
		$obj = $this->db->get('panel_settings');
		
		$count = $obj->num_rows();
		
		if( $method == 'new' ):
		
			$threshold = 0;
		
		else:
		
			$threshold = 1;
		
		endif;

		if( $count > $threshold ):
		
			return FALSE;
		
		endif;

		return TRUE;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Add a setting to a panel
	 *
	 * @access	public
	 * @param	array
	 * @param	int
	 * @return	bool
	 */	
	function add_setting_to_panel( $data, $panel_id )
	{
		$insert_data = array(
			'panel_id'			=> $panel_id,
			'setting_type'		=> $data['setting_type'],
			'setting_label'		=> $data['setting_label'],
			'setting_name'		=> $data['setting_name'],
			'instructions'		=> $data['instructions'],
			'default_value'		=> $data['default_value'],
			'value'				=> $data['default_value']
		);
	
		return $this->db->insert( 'panel_settings', $insert_data );
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Updates a setting
	 *
	 * @access	public
	 * @param	array
	 * @param	int
	 * @return	bool
	 */	
	function update_setting( $data, $setting_id )
	{
		$update_data = array(
			'setting_type'		=> $data['setting_type'],
			'setting_label'		=> $data['setting_label'],
			'setting_name'		=> $data['setting_name'],
			'instructions'		=> $data['instructions'],
			'default_value'		=> $data['default_value'],
		);
		
		$this->db->where('id', $setting_id);
	
		return $this->db->update( 'panel_settings', $update_data );
	}

	// --------------------------------------------------------------------------

	/**
	 * Counts the number of settings for a given panel
	 *
	 * @access	public
	 * @param	int
	 * @return	int
	 */
	function count_panel_settings( $panel_id )
	{
		$this->db->where('panel_id', $panel_id);
	
		$obj = $this->db->get('panel_settings');
	
		return $obj->num_rows();
	}

	// --------------------------------------------------------------------------

	/**
	 * Deletes a setting
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_setting( $setting_id )
	{
		$this->db->where('id', $setting_id);
	
		return $this->db->delete('panel_settings');
	}

}

/* End of file settings_mdl.php */
/* Location: ./expressionengine/third_party/panel/models/settings_mdl.php */