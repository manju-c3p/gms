<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admintools extends CI_Controller
{
	public function index()
	{
		$this->load->view('Accounts/admin_tools_view');
	}

	// 🔍 Fetch table data
	public function get_table_data11()
	{
		$table = $this->input->post('table');

		if (empty($table)) {
			echo json_encode([]);
			return;
		}

		// $data = $this->db->limit(50)->get($table)->result();
		$data = $this->db->get($table)->result();
		echo json_encode($data);
	}

	public function get_table_dataold()
	{
		$table = $this->input->post('table');

		if (empty($table)) {
			echo json_encode([]);
			return;
		}

		// Get table fields
		$fields = $this->db->list_fields($table);

		// Assume first column is primary key
		$pk = $fields[0];

		// Fetch in DESC order
		$data = $this->db
			->order_by($pk, 'DESC')
			->get($table)
			->result();

		echo json_encode($data);
	}

	public function get_table_data()
	{
		$table  = $this->input->post('table');
		$search = $this->input->post('search'); // ✅ NEW

		if (empty($table)) {
			echo json_encode([]);
			return;
		}

		$fields = $this->db->list_fields($table);
		$pk = $fields[0];

		// ✅ Apply search on all columns
		if (!empty($search)) {
			foreach ($fields as $field) {
				$this->db->or_like($field, $search);
			}
		}

		$data = $this->db
			->order_by($pk, 'DESC')
			->get($table)
			->result();

		echo json_encode($data);
	}

	public function delete_multiple()
	{
		$table = $this->input->post('table');
		$ids   = $this->input->post('ids'); // comma separated
		$ids   = explode(',', $ids);

		// ⚠️ Protect critical tables
		$restricted_tables = ['general_ledger'];

		if (in_array($table, $restricted_tables)) {
			echo json_encode(['status' => 'error', 'msg' => 'Deletion not allowed']);
			return;
		}

		// detect PK
		$fields = $this->db->list_fields($table);
		$pk = in_array('id', $fields) ? 'id' : $fields[0];

		$this->db->where_in($pk, $ids);
		$this->db->delete($table);

		echo json_encode(['status' => 'success', 'msg' => 'Selected records deleted']);
	}

	// ❌ Delete record (controlled)
	public function delete_record()
	{
		$table = $this->input->post('table');
		$id    = $this->input->post('id');
		$pk    = $this->input->post('pk'); // primary key column

		// ⚠️ Protect critical tables
		$restricted_tables = ['general_ledger'];

		if (in_array($table, $restricted_tables)) {
			echo json_encode(['status' => 'error', 'msg' => 'Deletion not allowed on this table']);
			return;
		}

		$this->db->where($pk, $id);
		$this->db->delete($table);

		echo json_encode(['status' => 'success']);
	}


	public function fix_po_status_once()
{
	$po_id = 73; // 👈 change if needed

	$this->db->where('po_id', $po_id);
	$this->db->update('purchase_order_master', [
		'grn_status' => 0,
		'po_status'  => 0
	]);

	echo "PO status updated for ID: " . $po_id;
	exit;
}

function update_grn_dates_from_po()
{
    // Step 1: Get GRNs between 97 and 105
    $grns = $this->db->query("
        SELECT grn_id, po_id 
        FROM purchase_grn_master
        WHERE grn_id BETWEEN 97 AND 105
    ")->result();

    if (empty($grns)) {
        log_message('error', 'No GRNs found');
        return false;
    }

    foreach ($grns as $g) {

        // Step 2: Get PO date using po_id
        $po = $this->db->query("
            SELECT po_date 
            FROM purchase_order_master
            WHERE po_id = ?
        ", [$g->po_id])->row();

        if (!empty($po) && !empty($po->po_date)) {

            // Step 3: Update GRN with PO date
            $this->db->query("
                UPDATE purchase_grn_master
                SET grn_date = ?
                WHERE grn_id = ?
            ", [$po->po_date, $g->grn_id]);

            log_message('error', 'Updated GRN ID: ' . $g->grn_id . ' with date ' . $po->po_date);

        } else {
            log_message('error', 'PO not found for GRN ID: ' . $g->grn_id);
        }
    }

    return true;
}

function update_voucher_dates_from_grn()
{
    // 🔹 Get all matching records
    $rows = $this->db->query("
        SELECT 
            vt.voucher_id,
            g.grn_date
        FROM voucher_transaction vt
        JOIN purchase_grn_master g 
            ON vt.trans_id = g.grn_id
        WHERE g.grn_date IS NOT NULL
    ")->result();

    if (empty($rows)) {
        log_message('error', 'No matching records found for update');
        return false;
    }

    foreach ($rows as $r) {

        // 🔹 Format date with fixed time
        $new_date = date('Y-m-d 05:06:16', strtotime($r->grn_date));

        // 🔹 Update voucher_date
        $this->db->query("
            UPDATE voucher_transaction
            SET voucher_date = ?
            WHERE voucher_id = ?
        ", [$new_date, $r->voucher_id]);

        log_message('error', 'Updated Voucher ID: ' . $r->voucher_id . ' → ' . $new_date);
    }

    return true;
}

function fix_specific_vouchers()
{
    $this->db->query("
        UPDATE voucher_transaction
        SET 
            trans_id = 78,
            voucher_date = '2026-03-30 00:00:00'
        WHERE voucher_id IN (1576, 1575)
    ");

    return true;
}

public function update_pod_voucher_date()
{
    $voucher_code = 'POD/26/0057';
    $new_date = '2026-03-30 00:00:00'; // match DB format

    $this->db->where('voucher_code', $voucher_code);
    $updated = $this->db->update('voucher_transaction', [
        'voucher_date' => $new_date
    ]);

    if ($this->db->affected_rows() > 0) {
        echo "Voucher date updated successfully";
    } else {
        echo "No rows updated or already same date";
    }
}

public function reset_po_status()
{
    $po_code = 'POD/26/0001';

    $this->db->where('po_code', $po_code);
    $updated = $this->db->update('purchase_order_master', [
        'po_status'  => 0,
        'srn_status' => 0
    ]);

    if ($this->db->affected_rows() > 0) {
        echo "PO status and SRN status updated successfully";
    } else {
        echo "No changes made or record not found";
    }
}

public function fix_ti_voucher_dates()
{
    $ids = [1661, 1662, 1663];
    $new_date = '2026-03-28 00:00:00'; // DB format

    $this->db->where_in('voucher_id', $ids);
    $this->db->update('voucher_transaction', [
        'voucher_date' => $new_date
    ]);

    if ($this->db->affected_rows() > 0) {
        echo "Voucher dates updated successfully";
    } else {
        echo "No changes made";
    }
}

public function fix_mixed_voucher_dates()
{
    // First update: last 3 records
    $this->db->where_in('voucher_id', [1546, 1547, 1548]);
    $this->db->update('voucher_transaction', [
        'voucher_date' => '2026-03-10 00:00:00'
    ]);

    // Second update: voucher_id 1848
    $this->db->where('voucher_id', 1848);
    $this->db->update('voucher_transaction', [
        'voucher_date' => '2026-03-11 00:00:00'
    ]);

    echo "Voucher dates updated";
}
// =================================================

public function fix_voucher_dates()
{
    $this->load->database();

    $updates = [
        'PV/26/00003' => '2026-03-05',
        'PV/26/00006' => '2026-03-07',
        'PV/26/00010' => '2026-03-09',
        'PV/26/00014' => '2026-03-12',
        'PV/26/00015' => '2026-03-12',
        'PV/26/00016' => '2026-03-12',
    ];

    foreach ($updates as $voucher_code => $date) {
        $this->db->where('voucher_code', $voucher_code);
        $this->db->update('voucher_transaction', [
            'voucher_date' => $date
        ]);
    }

    echo "Voucher dates updated successfully.";
}

public function fix_pr_2026_0001()
{
    $this->load->database();

    // 1. Update all 3 rows (common changes)
    $this->db->where('voucher_code', 'PR-2026-0001');
    $this->db->update('voucher_transaction', [
        'voucher_type' => 'PR',
        'customer_id'  => 71,
        'trans_id'     => 3
    ]);

    // 2. First 2 rows → CR
    $this->db->where_in('voucher_id', [1380, 1379]);
    $this->db->update('voucher_transaction', [
        'drcr_type' => 'Cr'
    ]);

    // 3. Last row → DR + account_id fix
    $this->db->where('voucher_id', 1378);
    $this->db->update('voucher_transaction', [
        'drcr_type' => 'Dr',
        'account_id' => 2815
    ]);

    echo "PR-2026-0001 corrected successfully.";
}
public function update_grn_voucher_dates()
{
	$updates = [

		'GRN/26/0003' => '2026-03-06',
		'GRN/26/0002' => '2026-03-04',
		'GRN/26/0001' => '2026-03-03',

	];

	foreach ($updates as $voucher_code => $voucher_date) {

		$this->db->where('voucher_code', $voucher_code);

		$this->db->update('voucher_transaction', [
			'voucher_date' => $voucher_date
		]);

		echo $voucher_code . ' updated to ' . $voucher_date . '<br>';
	}

	exit;
}

public function update_purchase_return_account()
{
    $this->db->where('voucher_id', 2260);
    
    $update = $this->db->update('voucher_transaction', [
        'account_id' => 2815
    ]);

    if ($update) {
        echo "Account ID updated successfully";
    } else {
        echo "Update failed";
    }
}

public function add_second_receipt_entry()
{
    // Get existing entry
    $row = $this->db
        ->where('voucher_id', 2633)
        ->get('voucher_transaction')
        ->row();

    if ($row) {

        $data = [
            'voucher_code'      => $row->voucher_code,
            'voucher_date'      => $row->voucher_date,
            'voucher_type'      => $row->voucher_type,
            'customer_id'       => $row->customer_id,
            'amount'            => $row->amount,

            // Changed fields
            'drcr_type'         => 'Cr',
            'account_id'        => 2803,
            'invoice_code'      => 'TI-2026-0020',
            'invoice_amount'    => 5000,

            // Same fields
            'discount'          => $row->discount,
            'payment_type'      => $row->payment_type,
            'cancel'            => $row->cancel,
            'narration'         => $row->narration,
            'trans_id'          => $row->trans_id,
            'timestamp'         => $row->timestamp,
            'trans_type'        => $row->trans_type,
            'recordCreatedBy'   => $row->recordCreatedBy,
            'transaction_type'  => $row->transaction_type,
            'transaction_no'    => $row->transaction_no,
            'reco'              => $row->reco,
            'bank_date'         => $row->bank_date,
        ];

        $this->db->insert('voucher_transaction', $data);
    }
}

public function add_second_receipt_entry_2628()
{
    // Get existing entry
    $row = $this->db
        ->where('voucher_id', 2628)
        ->get('voucher_transaction')
        ->row();

    if ($row) {

        $data = [
            'voucher_code'      => $row->voucher_code,
            'voucher_date'      => $row->voucher_date,
            'voucher_type'      => $row->voucher_type,
            'customer_id'       => $row->customer_id,
            'amount'            => $row->amount,

            // Changed fields
            'drcr_type'         => 'Cr',
            'account_id'        => 2457,
            'invoice_code'      => 'TI-2026-0016',
            'invoice_amount'    => 3166,

            // Same fields
            'discount'          => $row->discount,
            'payment_type'      => $row->payment_type,
            'cancel'            => $row->cancel,
            'narration'         => $row->narration,
            'trans_id'          => $row->trans_id,
            'timestamp'         => $row->timestamp,
            'trans_type'        => $row->trans_type,
            'recordCreatedBy'   => $row->recordCreatedBy,
            'transaction_type'  => $row->transaction_type,
            'transaction_no'    => $row->transaction_no,
            'reco'              => $row->reco,
            'bank_date'         => $row->bank_date,
        ];

        $this->db->insert('voucher_transaction', $data);
    }
}



public function update_receipt_trans_id()
{
    $this->db->where_in('voucher_id', [2641, 2628]);

    $update = $this->db->update('voucher_transaction', [
        'trans_id' => 186
    ]);

    if ($update) {
        echo "Trans ID updated successfully";
    } else {
        echo "Update failed";
    }
}

public function update_qty_columns()
{
    $queries = [

        "ALTER TABLE estimation_parts 
        CHANGE qty qty DECIMAL(10,2) NOT NULL",

        "ALTER TABLE jobcard_parts 
        CHANGE qty qty DECIMAL(10,2) NOT NULL DEFAULT '1'",

        "ALTER TABLE quotation_parts 
        CHANGE qty qty DECIMAL(10,2) NOT NULL",

        "ALTER TABLE invoice_items 
        CHANGE quantity quantity DECIMAL(10,2) NULL DEFAULT NULL"

    ];

    foreach ($queries as $sql) {
        $this->db->query($sql);
    }

    echo "All quantity columns updated successfully";
}

// =============================================
}
