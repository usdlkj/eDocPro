<?php
class Project_field_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($field)
	{
		// insert the field at the end of the sequences
		$fields = $this->get_by_project_id($field['project_id']);
		$count = count($fields);
		$temp = $field['sequence'];
		$field['sequence'] = strval($count + 1);
		$field['field_code'] = strtolower($field['field_code']);
		$this->db->insert('cdm_project_field', $field);
		
		// reorder the field sequences to put the field in the right place
		$field2 = $this->get_by_project_id_code($field['project_id'], $field['field_code']);
		$field2['sequence'] = $temp;
		$this->update_sequence($field2);
	}
	
	public function read()
	{
		$query = $this->db->get('cdm_project_field');
		return $query->result_array();
	}
	
	public function get_by_project_id($project_id)
	{
		$this->db->order_by('sequence','asc');
		$query = $this->db->get_where('cdm_project_field', array('project_id' => $project_id));
		return $query->result_array();
	}
	
	public function get_by_project_id_code($project_id, $code)
	{
		$this->db->order_by('sequence','asc');
		$query = $this->db->get_where('cdm_project_field', array('project_id' => $project_id, 'field_code' => $code));
		return $query->row_array();
	}
	
	public function get_visible_fields_by_project_id($project_id)
	{
		$this->db->order_by('sequence','asc');
		$query = $this->db->get_where('cdm_project_field', array('project_id' => $project_id, 'visible' => 1));
		return $query->result_array();
	}
	
	public function get_by_id($id)
	{
		$query = $this->db->get_where('cdm_project_field', array('id' => $id));
		return $query->row_array();
	}
	
	public function update($field)
	{
		$data = array(
			'field_text' 	=> $field['field_text'],
			'visible' 		=> $field['visible'],
			'mandatory'		=> $field['mandatory']
		);
		
		$this->db->where('id', $field['id']);
		$this->db->update('cdm_project_field', $data);
	}
	
	public function update_sequence($field)
	{
		$fields = $this->get_by_project_id($field['project_id']);
		$count = count($fields);
		
		// loop from the beginning of the sequences
		for ($i = 0; $i < $count; $i++)
		{
			// if ids match, i.e. moving to a bigger sequence
			if ($fields[$i]['id'] == $field['id'])
			{
				// if sequences match, the field is already in the correct place
				if ($fields[$i]['sequence'] == $field['sequence']) break;
				
				// set the field sequence to the desired sequence
				$fields[$i]['sequence'] = $field['sequence'];
				$this->update($fields[$i]);
				
				// loop from the current position plus one
				for ($j = $i + 1; $j < $count; $j++)
				{
					// move the field sequence to one before it (-1)
					$temp = $fields[$j]['sequence'];
					$fields[$j]['sequence'] = strval(intval($fields[$j]['sequence']) - 1);
					$this->update($fields[$j]);
					
					// if the desired sequence is met, reordering complete
					if ($temp == $field['sequence']) break;
				}
				
				break;
			}
			
			// if sequences match, i.e. moving to a smaller sequence
			if ($fields[$i]['sequence'] == $field['sequence'])
			{
				// if ids match, the field is already in the correct place
				if ($fields[$i]['id'] == $field['id']) break;
				
				// loop from the current position
				for ($k = $i; $k < $count; $k++)
				{
					// if the desired sequence is met, set the field's sequence and end the loop
					if ($fields[$k]['id'] == $field['id'])
					{
						$fields[$k]['sequence'] = $field['sequence'];
						$this->update($fields[$k]);
						break;
					}
					
					// move the field sequence to one after it (+1)
					$fields[$k]['sequence'] = strval(intval($fields[$k]['sequence']) + 1);
					$this->update($fields[$k]);
				}
				
				break;
			}
		}
	}
	
	public function delete($field)
	{
		// reorder the sequences to put the deleted field at the end
		$fields = $this->get_by_project_id($field['project_id']);
		$count = count($fields);
		$field['sequence'] = strval($count);
		$this->update_sequence($field);
		
		// delete the field
		$this->db->where('id', $field['id']);
		$this->db->delete('cdm_project_field');
	}
}