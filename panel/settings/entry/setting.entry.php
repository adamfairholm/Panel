<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Entry Setting
 *
 * Retrieves the id of a setting for use in the channel entries tag
 *
 * @author		Parse19
 * @copyright	Copyright (c) 2011, Parse19
 * @link		http://parse19.com/panel
 * @license		http://parse19.com/panel/license
 */
class Setting_entry
{
	var $setting_type_name			= 'entry';

	var $setting_data				= array( 'channel' );

	// --------------------------------------------------------------------------

	/**
	 * Constructor
	 */
	function Setting_entry()
	{
		$this->EE =& get_instance();
	}

	// --------------------------------------------------------------------------

	/**
	 * Extra field to choose a channel
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function channel_input( $value = '' )
	{
		// Get the channels and display in a drop down
		
		$this->EE->db->order_by('channel_title', 'ASC');
		
		$obj = $this->EE->db->get('channels');
	
		$channels = array();
	
		$channels_result = $obj->result();
	
		foreach( $channels_result as $item ):
		
			$channels[$item->channel_id] = $item->channel_title;
		
		endforeach;
	
		return form_dropdown('channel', $channels, $value);
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	string
	 */
	function form_output( $name, $value = '', $data = array() )
	{
		if( isset($data['channel']) ):
		
			// Get entries for a channel
			
			$this->EE->db->where('channel_id', $data['channel']);
			
			$obj = $this->EE->db->get('channel_titles');
		
			$channels_raw = $obj->result();
			
			// Get into drop down
			
			$channels = array();
			
			foreach( $channels_raw as $channel ):
			
				$channels[$channel->entry_id] = $channel->title;
			
			endforeach;
		
			return form_dropdown( $name, $channels, $value);
		
		else:
			
			return "No channel set";
		
		endif;
	}
	
}

/* End of file setting.text.php */
/* Location: ./expressionengine/third_party/panel/settings/setting.text.php */