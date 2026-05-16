<?php
class Stock_model extends CI_Model
{

	public function stock_in($data)
{
    $this->db->trans_start();

    // 1. Insert stock_in
    $this->db->insert('stock_in', $data);
    $stock_in_id = $this->db->insert_id();

    $part_id = $data['part_id'];
    $qty     = $data['qty'];

    // 2. Get part
    $part = $this->db->where('part_id', $part_id)->get('spare_parts')->row();

    // 3. Insert stock_ledger
    $this->db->insert('stock_ledger', [
        'part_id'      => $part_id,
        'txn_type'     => 'MANUAL_IN',
        'qty'          => $qty,
        'unit_id'      => $part->stock_unit_id ?? 1,
        'reference_id' => $stock_in_id,
        'reference_no' => 'MANUAL-IN',
        'remarks'      => 'Manual Stock In',
        'txn_date'     => date('Y-m-d H:i:s'),
        'created_at'   => date('Y-m-d H:i:s'),
        'created_by'   => $this->session->userdata('user_id')
    ]);

    // 4. Update stock_summary
    $summary = $this->db->where('part_id', $part_id)->get('stock_summary')->row();

    if ($summary) {
        $this->db->where('part_id', $part_id)->update('stock_summary', [
            'current_stock' => $summary->current_stock + $qty,
            'updated_at'    => date('Y-m-d H:i:s')
        ]);
    } else {
        $this->db->insert('stock_summary', [
            'part_id'       => $part_id,
            'current_stock' => $qty,
            'updated_at'    => date('Y-m-d H:i:s')
        ]);
    }

    $this->db->trans_complete();
    return $this->db->trans_status();
}

public function stock_out($data)
{
    $this->db->trans_start();

    $part_id = $data['part_id'];
    $qty     = $data['qty'];

    // 1. Check stock (VERY IMPORTANT)
    $summary = $this->db->where('part_id', $part_id)->get('stock_summary')->row();

    if (!$summary || $summary->current_stock < $qty) {
        $this->db->trans_rollback();
        return false; // prevent negative stock
    }

    // 2. Insert stock_out
    $this->db->insert('stock_out', $data);
    $stock_out_id = $this->db->insert_id();

    // 3. Get part
    $part = $this->db->where('part_id', $part_id)->get('spare_parts')->row();

    // 4. Insert stock_ledger
    $this->db->insert('stock_ledger', [
        'part_id'      => $part_id,
        'txn_type'     => 'ISSUE',
        'qty'          => $qty,
        'unit_id'      => $part->stock_unit_id ?? 1,
        'reference_id' => $stock_out_id,
        'reference_no' => 'STOCK-OUT',
        'remarks'      => 'Stock Issued',
        'txn_date'     => date('Y-m-d H:i:s'),
        'created_at'   => date('Y-m-d H:i:s'),
        'created_by'   => $this->session->userdata('user_id')
    ]);

    // 5. Update stock_summary
    $this->db->where('part_id', $part_id)->update('stock_summary', [
        'current_stock' => $summary->current_stock - $qty,
        'updated_at'    => date('Y-m-d H:i:s')
    ]);

    $this->db->trans_complete();
    return $this->db->trans_status();
}


	public function add_stock_purchase($part_id, $purchase_qty, $reference_no, $txn_date, $price = 0, $created_by = null)
	{

		$this->db->trans_start();

		/* =====================================================
           1. Get part details
        ===================================================== */

		$part = $this->db
			->where('part_id', $part_id)
			->get('spare_parts')
			->row();

		if (!$part) {
			log_message('error', 'Stock add failed. Part not found: ' . $part_id);
			return false;
		}


		/* =====================================================
           2. Convert purchase qty → stock qty
        ===================================================== */

		$conversion = (float)$part->qty_per_purchase_unit;

		if ($conversion <= 0) {
			$conversion = 1;
		}

		$stock_qty = $purchase_qty * $conversion;


		/* =====================================================
           3. Insert into stock_in
        ===================================================== */

		$stock_in = [

			'part_id'    => $part_id,
			'qty'        => $stock_qty,
			'date_in'    => date('Y-m-d', strtotime($txn_date)),
			'created_at' => date('Y-m-d H:i:s')

		];

		$this->db->insert('stock_in', $stock_in);

		$stock_in_id = $this->db->insert_id();


		/* =====================================================
           4. Insert into stock_ledger
        ===================================================== */

		$ledger = [

			'part_id'      => $part_id,
			'txn_type'     => 'PURCHASE',
			'qty'          => $stock_qty,
			'unit_id'      => $part->stock_unit_id,
			'reference_id' => $stock_in_id,
			'reference_no' => $reference_no,
			'remarks'      => 'Purchase GRN',
			'txn_date'     => date('Y-m-d H:i:s', strtotime($txn_date)),
			'created_at'   => date('Y-m-d H:i:s'),
			'created_by'   => $created_by

		];

		$this->db->insert('stock_ledger', $ledger);


		/* =====================================================
           5. Update stock_summary
        ===================================================== */

		$summary = $this->db
			->where('part_id', $part_id)
			->get('stock_summary')
			->row();

		if ($summary) {

			$new_qty = $summary->current_stock + $stock_qty;

			$this->db->where('part_id', $part_id)
				->update('stock_summary', [

					'current_stock' => $new_qty,
					'updated_at'    => date('Y-m-d H:i:s')

				]);
		} else {

			$this->db->insert('stock_summary', [

				'part_id'       => $part_id,
				'current_stock' => $stock_qty,
				'updated_at'    => date('Y-m-d H:i:s')

			]);
		}


		$this->db->trans_complete();

		return $this->db->trans_status();
	}
}
