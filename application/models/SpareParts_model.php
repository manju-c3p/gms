<?php
class SpareParts_model extends CI_Model
{

	public function add_part($data)
	{
		return $this->db->insert('spare_parts', $data);
	}

	public function update_part($part_id, $data)
	{
		return $this->db->where('part_id', $part_id)->update('spare_parts', $data);
	}

	public function delete_part($part_id)
	{
		return $this->db->delete('spare_parts', ['part_id' => $part_id]);
	}

	public function get_all_parts()
	{
		return $this->db->order_by('part_name', 'ASC')->get('spare_parts')->result();
	}

	// public function get_part($part_id) {
	//     return $this->db->where('part_id', $part_id)->get('spare_parts')->row();
	// }
	public function get_part($part_id)
	{
		return $this->db
			->select('
            p.*,
            m.model_name,
			m.model_id
        ')
			->from('spare_parts p')
			->join('vehicle_models m', 'm.model_id = p.vehicle_model_id', 'left')
			->where('p.part_id', $part_id)
			->get()
			->row();
	}
	public function get_part_rfq($part_id)
	{
		return $this->db
			->select('
            p.*,
            m.model_name,
            m.model_id,

            pu.unit_name AS purchase_unit_name,
            pu.unit_abbr AS purchase_unit_abbr,

            su.unit_name AS stock_unit_name,
            su.unit_abbr AS stock_unit_abbr
        ')
			->from('spare_parts p')

			->join('vehicle_models m', 'm.model_id = p.vehicle_model_id', 'left')

			// Purchase Unit
			->join('unit_master pu', 'pu.unit_id = p.purchase_unit_id', 'left')

			// Stock Unit
			->join('unit_master su', 'su.unit_id = p.stock_unit_id', 'left')

			->where('p.part_id', $part_id)
			->get()
			->row();
	}



	public function get_stock($part_id)
	{
		$in  = $this->db->select_sum('qty')->where('part_id', $part_id)->get('stock_in')->row()->qty;
		$out = $this->db->select_sum('qty')->where('part_id', $part_id)->get('stock_out')->row()->qty;

		return ($in ?? 0) - ($out ?? 0);
	}


	// =========================================

	public function get_all_brands()
	{
		return $this->db->order_by('brand_name', 'ASC')
			->get('vehicle_brands')
			->result();
	}

	public function get_models_by_brand($brand_id)
	{
		return $this->db->where('brand_id', $brand_id)
			->order_by('model_name', 'ASC')
			->get('vehicle_models')
			->result();
	}

	public function save_brand($name)
	{
		$this->db->insert('vehicle_brands', ['brand_name' => $name]);
		return $this->db->insert_id();
	}

	public function save_model($brand_id, $name)
	{
		$this->db->insert('vehicle_models', [
			'brand_id' => $brand_id,
			'model_name' => $name
		]);
		return $this->db->insert_id();
	}

	public function get_brands_by_part_type($part_type)
	{
		return $this->db
			->distinct()
			->select('vb.brand_id, vb.brand_name')
			->from('spare_parts sp')
			->join('vehicle_brands vb', 'vb.brand_id = sp.brand_id')
			->where('sp.part_type', $part_type)
			->order_by('vb.brand_name', 'ASC')
			->get()
			->result();
	}

	public function get_parts_by_part_type($part_type)
	{
		return $this->db
			->distinct()
			->select('sp.part_id , sp.part_name,sp.unit_price')
			->from('spare_parts sp')
			->where('sp.part_type', $part_type)
			->get()
			->result();
	}



	public function insert_part($data, $opening_qty = 0)
	{
		$this->db->trans_start(); // ✅ start transaction

		// 1️⃣ Insert spare part
		$this->db->insert('spare_parts', $data);
		$part_id = $this->db->insert_id();

		// 2️⃣ Insert opening stock (only if qty > 0)
		// if ($opening_qty > 0) {
		$this->db->insert('stock_in', [
			'part_id'   => $part_id,
			'qty'       => $opening_qty,
			'date_in'   => date('Y-m-d'),
			'created_at' => date('Y-m-d H:i:s')
		]);
		// }

		/* stock_ledger */
		$this->db->insert('stock_ledger', [
			'part_id'      => $part_id,
			'txn_type'     => 'OPENING',
			'qty'          => 0,
			'unit_id'      => $stock_unit_id,
			'reference_id' => $stock_in_id,
			'reference_no' => 'OPENING-STOCK',
			'remarks'      => 'Opening stock initialization',
			'txn_date'     => date('Y-m-d H:i:s'),
			'created_at'   => date('Y-m-d H:i:s'),
			'created_by'   => $this->session->userdata('user_id')
		]);


		/* stock_summary */
		$this->db->insert('stock_summary', [
			'part_id'       => $part_id,
			'current_stock' => 0,
			'updated_at'    => date('Y-m-d H:i:s')
		]);

		$this->db->trans_complete(); // ✅ commit / rollback

		return $part_id;
	}
	// =============================================

	public function part_exists($part_name, $part_type, $exclude_id = null)
	{
		$this->db->where('part_name', $part_name);
		$this->db->where('part_type', $part_type);

		if ($exclude_id) {
			$this->db->where('part_id !=', $exclude_id); // for update
		}

		return $this->db->get('spare_parts')->num_rows() > 0;
	}
}
