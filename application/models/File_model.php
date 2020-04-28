<?php
class File_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($file)
	{
		// if file exists already, i.e. hash matches
		$file2 = $this->get_file_by_hash($file['file_hash']);
		if ($file2) {
			return $file2['id'];
		}
		
		// get next id
		$query = $this->db->get_where('cdm_latest_number', array('table_name' => 'cdm_file'));
		$result = $query->row_array();
		$id = intval($result['next_number']);
		
		$data = array(
			'id'			=> $id,
			'file_hash' 	=> $file['file_hash'],
			'file_name' 	=> $file['file_name'],
			'file_loc' 		=> $file['file_loc'],
			'file_size' 	=> $file['file_size'],
			'file_ext' 		=> $file['file_ext'],
			'created_by' 	=> $file['user']
		);
		$this->db->insert('cdm_file', $data);
		
		// update latest number table
		$this->db->where('table_name', 'cdm_file');
		$this->db->update('cdm_latest_number', array('next_number' => $id + 1));
		
		return $id;
	}
	
	public function read()
	{
		$query = $this->db->get('cdm_file');
		return $query->result_array();
	}
	
	public function get_file_by_hash($file_hash)
	{
		$query = $this->db->get_where('cdm_file', array('file_hash' => $file_hash));
		return $query->row_array();
	}
	
	public function get_file_by_id($id)
	{
		$query = $this->db->get_where('cdm_file', array('id' => $id));
		return $query->row_array();
	}
	
	public function get_active_files()
	{
		$query = $this->db->get_where('cdm_file', 'deleted_by IS NULL');
		return $query->result_array();
	}
	
	public function hide($file)
	{
		$data = array(
			'deleted_at'	=> date('Y-m-d H:i:s'),
			'deleted_by' 	=> $file['user']
		);
		
		$this->db->where('id', $file['id']);
		$this->db->update('cdm_file', $data);
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('cdm_file');
	}
}