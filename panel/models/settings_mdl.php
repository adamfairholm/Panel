<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Settings Model
 *
 * @author		Addict Add-ons Dev Team
 * @copyright	Copyright (c) 2011, Addict Add-ons
 * @link		http://addictaddons.com/panel
 * @license		http://addictaddons.com/panel/license
 */
class Settings_mdl extends CI_Model {

	function __construct()
	{
		parent::__construct();
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
		
		$setting = $obj->row();
		
		// Get extra params if they exist
		if( $setting->data ) $setting->data = unserialize($setting->data);
		
		return $setting;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Get all settings
	 *
	 * @access	public
	 * @return	obj
	 */
	function get_all_settings()
	{
		$obj = $this->db->get('panel_settings');
		
		$settings_raw = $obj->result();
		
		$settings = new stdClass;
		
		foreach( $settings_raw as $setting ):
		
			$node = $setting->setting_name;
		
			$settings->$node = $setting;
		
			// Get extra params if they exist
			if( $settings->$node->data ) $settings->$node->data = unserialize($settings->$node->data);

		endforeach;
		
		return $settings;
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

		if( $obj->num_rows() == 0 ):
		
			return FALSE;
		
		endif;

		$settings_raw = $obj->result();
		
		$settings = new stdClass();
				
		foreach( $settings_raw as $setting ):
		
			$node = $setting->setting_name;
		
			$settings->$node = $setting;
		
			// Get extra params if they exist
			if( $settings->$node->data ) $settings->$node->data = unserialize($settings->$node->data);

		endforeach;
		
		return $settings;
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
		
			$setting_path = APPPATH.'third_party/panel/settings/'.$folder.'/';
		
			if( file_exists($setting_path.'setting.'.$folder.EXT) ):
			
				require_once($setting_path.'setting.'.$folder.EXT);

				$class_name = 'Setting_'.$folder;
	
				$types->$folder = new $class_name();
		
			endif;
			
			// Add language files
			
			if( file_exists($setting_path.'language/'.$this->config->item('deft_lang').'/lang.'.$folder.EXT) ):
			
				require_once($setting_path.'language/'.$this->config->item('deft_lang').'/lang.'.$folder.EXT);
			
				$types->$folder->lang = $lang[$folder];
			
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
		
			if( $count > 0 ):
			
				return FALSE;
			
			endif;
		
		else:
		
			if( $count != 1 ):
			
				return FALSE;
			
			endif;
		
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
	 * @param	obj
	 * @return	bool
	 */	
	function add_setting( $data, $panel_id, $type )
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

		// Find the +1 of the order
		$this->db->limit(1);
		$this->db->select("MAX(sort_order) as last_number");
		$this->db->where('panel_id', $panel_id);
		$obj = $this->db->get('panel_settings');
		
		if( $obj->num_rows() == 0 ):
		
			$sort = 1;
		
		else:
		
			$row = $obj->row();
			
			$sort = $row->last_number + 1;
		
		endif;
		
		$insert_data['sort_order']		= $sort;
		
		// See if there are custom params & add them into a serialized array
		
		if( isset( $type->setting_data ) && is_array( $type->setting_data ) ):
		
			$params = array();
		
			foreach( $type->setting_data as $setting ):
			
				if( isset($data[$setting]) ):
			
					$params[$setting] = $data[$setting];
				
				endif;
			
			endforeach;
		
			if( count($params) > 0 ):
			
				$insert_data['data'] = serialize($params);
			
			endif;
		
		endif;
	
		return $this->db->insert( 'panel_settings', $insert_data );
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Updates a setting
	 *
	 * @access	public
	 * @param	array
	 * @param	int
	 * @param	obj
	 * @return	bool
	 */	
	function update_setting( $data, $setting_id, $type )
	{
		$update_data = array(
			'setting_type'		=> $data['setting_type'],
			'setting_label'		=> $data['setting_label'],
			'setting_name'		=> $data['setting_name'],
			'instructions'		=> $data['instructions'],
			'default_value'		=> $data['default_value'],
		);

		// See if there are custom params & add them into a serialized array
		
		if( isset( $type->setting_data ) && is_array( $type->setting_data ) ):
		
			$params = array();
		
			foreach( $type->setting_data as $setting ):
			
				if( isset($data[$setting]) ):
			
					$params[$setting] = $data[$setting];
				
				endif;
			
			endforeach;
		
			if( count($params) > 0 ):
			
				$update_data['data'] = serialize($params);
				
			else:
			
				$update_data['data'] = null;
			
			endif;
		
		endif;
		
		// Update the setting
		
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
	
	// --------------------------------------------------------------------------

	/**
	 * Resets all settings to their default values
	 *
	 * @access	public
	 * @return	bool
	 */
	function reset_settings()
	{
		$settings = $this->get_all_settings();
		
		$outcome = TRUE;
	
		foreach( $settings as $setting ):
		
			$update_data['value'] = $setting->default_value;
			
			$this->db->where('id', $setting->id);
			$outcome = $this->db->update('panel_settings', $update_data);
			
			$update_data = array();
		
		endforeach;
		
		return $outcome;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Checks to see if a variable name will conflict with anything else
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function is_global_name( $name )
	{
		$global_vars = array('app_build', 'app_version', 'charset', 'cp_url', 'current_time', 'debug_mode', 'doc_url', 'elapsed_time', 'email', 'group_id', 'group_title', 'gzip_mode', 'hits', 'homepage', 'ip_address', 'lang', 'location', 'member_group', 'member_id', 'member_profile_link', 'redirect', 'screen_name', 'site_name', 'site_url', 'template_edit_date', 'total_comments', 'total_entries', 'total_queries', 'username', 'webmaster_email');
		
		if( in_array(trim($name), $global_vars) ):
		
			return FALSE;
		
		else:

			return TRUE;
		
		endif;
	}

}

/* End of file settings_mdl.php */
/* Location: ./expressionengine/third_party/panel/models/settings_mdl.php */