<?php
class MaterialIssue_model extends CI_Model
{

public function get_jobcard_parts_with_issued_qty($jobcard_id)
{
    return $this->db
        ->select('
            jp.part_id,
            jp.part_name,
            jp.qty,
            IFNULL(SUM(mii.issued_qty), 0) AS issued_qty
        ')
        ->from('jobcard_parts jp')
        ->join(
            'material_issue_items mii',
            'mii.part_id = jp.part_id AND mii.jobcard_id = jp.jobcard_id',
            'left'
        )
        ->where('jp.jobcard_id', $jobcard_id)
        ->group_by('jp.part_id')
        ->get()
        ->result();
}

}
