<?php
class MaterialIssue_model extends CI_Model
{

	public function get_jobcard_parts_with_issued_qty($jobcard_id)
	{
		return $this->db
			->select('
            jp.part_id,
            sp.part_name,
            jp.qty,
            IFNULL(SUM(mii.issued_qty), 0) AS issued_qty
        ')
			->from('jobcard_parts jp')

			// Join spare parts master to get part name
			->join(
				'spare_parts sp',
				'sp.part_id = jp.part_id',
				'left'
			)

			// Join material issue items to calculate issued qty
			->join(
				'material_issue_items mii',
				'mii.part_id = jp.part_id 
             AND mii.jobcard_id = jp.jobcard_id',
				'left'
			)

			->where('jp.jobcard_id', $jobcard_id)
			->group_by('jp.part_id, sp.part_name, jp.qty')
			->get()
			->result();
	}


	/* ===============================
       CREATE MATERIAL ISSUE (MASTER)
    ================================ */
	public function create_issue($data)
	{
		$this->db->insert('material_issues', $data);
		return $this->db->insert_id();
	}

	/* ===============================
       UPDATE MATERIAL ISSUE
    ================================ */
	public function update_issue($issue_id, $data)
	{
		return $this->db
			->where('issue_id', $issue_id)
			->update('material_issues', $data);
	}

	/* ===============================
       CREATE MATERIAL ISSUE ITEM
    ================================ */
	public function create_issue_item($data)
	{
		return $this->db->insert('material_issue_items', $data);
	}

	/* ===============================
       GET REMAINING JOB CARD PART QTY
    ================================ */
	public function get_remaining_jobcard_part_qty($jobcard_id, $part_id)
	{
		// Planned qty
		$planned = $this->db
			->select('qty')
			->from('jobcard_parts')
			->where('jobcard_id', $jobcard_id)
			->where('part_id', $part_id)
			->get()
			->row();

		if (!$planned) {
			return 0;
		}

		// Already issued qty
		$issued = $this->db
			->select('IFNULL(SUM(issued_qty),0) AS issued_qty', false)
			->from('material_issue_items')
			->where('jobcard_id', $jobcard_id)
			->where('part_id', $part_id)
			->get()
			->row();

		return $planned->qty - ($issued->issued_qty ?? 0);
	}
}
