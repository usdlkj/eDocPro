<?php
class Document_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($document)
	{
		// get highest doc record version
		$this->db->select_max('version');
		$this->db->from('cdm_document');
		$this->db->where('doc_code', $document['doc_code']);
		$this->db->where('project_id', $document['project_id']);
		$query = $this->db->get();
		
		if ($query->num_rows() == 0)  {
			$version = 1;
		}
		else
		{
			// set all previous versions to false
			$this->db->set('is_latest', 0);
			$this->db->where('doc_code', $document['doc_code']);
			$this->db->where('project_id', $document['project_id']);
			$this->db->update('cdm_document');
			
			// increment current version
			$row = $query->row();
			$version = $row->version + 1;
		}
		
		// get next id
		$query = $this->db->get_where('cdm_latest_number', array('table_name' => 'cdm_document'));
		$result = $query->row_array();
		$id = intval($result['next_number']);
		
		// set data to be entered into the table
		$data = array(
			'id'			=> $id,
			'doc_code'		=> $document['doc_code'],
			'project_id' 	=> $document['project_id'],
			'file_id' 		=> $document['file_id'],
			'version' 		=> $version,
			'created_by' 	=> $document['user'],
		);
		$this->db->insert('cdm_document', $data);
		
		// update latest number table
		$this->db->where('table_name', 'cdm_document');
		$this->db->update('cdm_latest_number', array('next_number' => $id + 1));
		
		return $id;
	}
	
	public function read()
	{
		$query = $this->db->get('cdm_document');
		return $query->result_array();
	}
	
	public function get_documents($project_id, $all = null)
	{
		$this->db->where('project_id', $project_id);
		if (!$all) {
			$this->db->where('is_latest', 1);
		}
		$this->db->order_by('doc_code', 'asc');
		$query = $this->db->get('cdm_document');
		return $query->result_array();
	}
	
	public function get_documents_by_code($project_id, $doc_code)
	{
		$query = $this->db->get_where('cdm_document', array('project_id' => $project_id, 'doc_code' => $doc_code));
		return $query->result_array();
	}
	
	public function get_document_by_id($id)
	{
		$query = $this->db->get_where('cdm_document', array('id' => $id));
		return $query->row_array();
	}
	
	public function get_documents_by_com_id($project_id, $company_id, $all = null)
	{
		$this->db->where('project_id', $project_id);
		$this->db->where('company_id', $company_id);
		if (!$all) {
			$this->db->where('is_latest', 1);
		}
		$this->db->order_by('doc_code', 'asc');
		$query = $this->db->get('cdmv_document');
		return $query->result_array();
	}
}