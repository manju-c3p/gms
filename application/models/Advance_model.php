<?php
class Advance_model extends CI_Model
{

	public function create_advance($data)
	{
		$data['balance_amount'] = $data['amount'];

		// ✅ Save advance
		$this->db->insert('advance_receipts', $data);
		$advance_id = $this->db->insert_id();

		/* =========================================
       ACCOUNTING ENTRY (DOUBLE ENTRY)
    ========================================= */

		$amount = floatval($data['amount']);

		if ($amount > 0) {

			$code_prefix = "ADV/" . date('y') . "/";
			$this->load->model('Accounts_model');
			$num = $this->Accounts_model->get_account_code_count_for_advance($code_prefix, 'ADV') + 1;
			$voucher_code = $code_prefix . sprintf("%05d", $num);

			$voucher_date = date('Y-m-d H:i:s', strtotime($data['receipt_date']));

			// ✅ LEDGER IDs (CHANGE if needed)
			$cash_account = 23; // Cash/Bank
			$advance_ledger = 2873; // Customer Advance (Liability)

			/* -----------------------------
           DR: Cash / Bank
        ----------------------------- */
			$dr = [
				'voucher_code' => $voucher_code,
				'voucher_date' => $voucher_date,
				'voucher_type' => 'R',
				'customer_id' => $data['customer_id'],
				'account_id' => $cash_account,
				'amount' => $amount,
				'drcr_type' => 'Dr',
				'trans_id' => $advance_id, // ✅ link to advance
				'trans_type' => 'ADV_RECEIPT',
				'recordCreatedBy' => $this->session->userdata('user_id'),
				'invoice_code' => NULL,
				'invoice_amount' => 0,
			];
			$this->db->insert('voucher_transaction', $dr);

			/* -----------------------------
           CR: Customer Advance
        ----------------------------- */
			$cr = [
				'voucher_code' => $voucher_code,
				'voucher_date' => $voucher_date,
				'voucher_type' => 'R',
				'customer_id' => $data['customer_id'],
				'account_id' => $advance_ledger,
				'amount' => $amount,
				'drcr_type' => 'Cr',
				'trans_id' => $advance_id,
				'trans_type' => 'ADV_RECEIPT',
				'recordCreatedBy' => $this->session->userdata('user_id'),
				'invoice_code' => NULL,
				'invoice_amount' => 0,
			];
			$this->db->insert('voucher_transaction', $cr);
		}

		return $advance_id;
	}


	public function get_available_advance($jobcard_id)
	{
		return $this->db
			->where('jobcard_id', $jobcard_id)
			->where('balance_amount >', 0)
			->get('advance_receipts')
			->result();
	}

	public function apply_advance($advance_id, $use_amount)
	{
		$advance = $this->db->where('advance_id', $advance_id)->get('advance_receipts')->row();

		$new_used = $advance->used_amount + $use_amount;
		$new_balance = $advance->amount - $new_used;

		$status = 'partial';
		if ($new_balance <= 0) {
			$status = 'fully_used';
			$new_balance = 0;
		}

		$this->db->where('advance_id', $advance_id)->update('advance_receipts', [
			'used_amount' => $new_used,
			'balance_amount' => $new_balance,
			'status' => $status
		]);

		// ACCOUNTING ENTRY (convert to income)
		$this->accounting_entry([
			'type' => 'advance_adjustment',
			'ref_id' => $advance_id,
			'debit' => 'Customer Advance',
			'credit' => 'Sales',
			'amount' => $use_amount
		]);
	}


	private function accounting_entry($data)
	{
		$this->db->insert('transactions', [
			'date' => date('Y-m-d'),
			'type' => $data['type'],
			'ref_id' => $data['ref_id'],
			'debit_account' => $data['debit'],
			'credit_account' => $data['credit'],
			'amount' => $data['amount']
		]);
	}

	public function get_available_advance_custid($customer_id)
	{
		$data = $this->db
			->where('customer_id', $customer_id)
			->where('balance_amount >', 0)
			->get('advance_receipts')
			->result();

		echo json_encode($data);
	}
}
