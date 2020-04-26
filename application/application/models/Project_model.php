<?php
class Project_model extends CI_Model 
{	
	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($project)
	{
		// get next id
		$query = $this->db->get_where('cdm_latest_number', array('table_name' => 'cdm_project'));
		$result = $query->row_array();
		$id = intval($result['next_number']);
		
		// set data to be entered into the table
		$data = array(
			'id'			=> $id,
			'project_name' 	=> $project['pname'],
			'project_code' 	=> strtolower($project['pcode']),
			'description' 	=> $project['desc'],
			'owner_com_id' 	=> $project['company_id'],
			'created_by' 	=> $project['user']
		);
		$this->db->insert('cdm_project', $data);

		// update latest number table
		$this->db->where('table_name', 'cdm_project');
		$this->db->update('cdm_latest_number', array('next_number' => $id + 1));
		
		return $id;
	}
	
	public function read()
	{
		$query = $this->db->get('cdmv_project');
		return $query->result_array();
	}
	
	public function get_active_projects()
	{
		$query = $this->db->get_where('cdmv_project', 'deleted_by IS NULL');
		return $query->result_array();
	}
	
	public function get_project_by_id($id)
	{
		$query = $this->db->get_where('cdmv_project', array('id' => $id));
		return $query->row_array();
	}
	
	public function get_project_by_project_code($project_code)
	{
		$query = $this->db->get_where('cdmv_project', array('project_code' => $project_code));
		return $query->row_array();
	}
	
	public function update($project)
	{
		$data = array(
			'project_name' 	=> $project['pname'],
			'project_code' 	=> strtolower($project['pcode']),
			'owner_com_id' 	=> $project['owner_com_id'],
			'description' 	=> $project['desc'],
			'updated_by'	=> $project['user'],
			'updated_at' 	=> date('Y-m-d H:i:s')
		);
		
		$this->db->where('id', $project['id']);
		$this->db->update('cdm_project', $data);
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('cdm_project');
	}
	
	public function hide($project)
	{
		$data = array(
			'deleted_at' 		=> date('Y-m-d H:i:s'),
			'deleted_by' 	=> $project['user']
		);
		
		$this->db->where('id', $project['id']);
		$this->db->update('cdm_project', $data);
	}
	
	public function trans_start()
	{
		$this->db->trans_start();
	}
	
	public function trans_complete()
	{
		$this->db->trans_complete();
	}
}