<?php
class Stock_model extends CI_Model
{

	public function stock_in($data)
	{
		return $this->db->insert('stock_in', $data);
	}

	public function stock_out($data)
	{
		return $this->db->insert('stock_out', $data);
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
	
	function update_grn_records($grnid)
        {
	  for ($i = 0; $i < count($_POST["trans_id"]); $i++)
	  {
		$trans_id=$_POST['trans_id'][$i];
		$price=$_POST['price'][$i];
		$total=$_POST['total'][$i];
		$crate=$this->input->post('crate');
		$stockprice=$price*$crate;
		$item_remark=$_POST['item_remark'][$i];
		$storage_location=$_POST['storage_location'][$i];
		

		$query=$this->db->query("update GRN_transaction set price=$price, total=$total, item_remark='$item_remark', storage_location='$storage_location' where trans_id=$trans_id");
		
		$query=$this->db->query("update stock_details set price='$stockprice', storage_location='$storage_location' where remark='GRN' and trans_id=$trans_id and stock_type='IN' and dc_id=$grnid");
	  }	
		$query=$this->db->query("update voucher_transaction set cancel=1 where trans_id=$grnid and voucher_type='G' and cancel=0 ");
		
		/////////////// account entry for po invoice cr to supplier & dr to company /////
		$AccountCode =$this->input->post('GRNcode');  
		$vdate=date('Y-m-d');
		$vtime=date('h:i:s');
		
		/// debit entry 
		for($i=0;$i<count($_POST['inv_debtor']);$i++)
		{
			$debtor=$_POST['inv_debtor'][$i];
			$dr_amount=$_POST['inv_dr_amount'][$i];
			if($dr_amount>0)
			{
			$data = array(
				'voucher_code' =>$AccountCode,
				'voucher_date' => date('Y-m-d h:i:s',strtotime("$vdate $vtime")),
				'voucher_type' => 'G',  /// po invoice  entry
				'customer_id' => $this->input->post('supplier_id'),
				'account_id' => $debtor,
				'amount' => $dr_amount,
				'drcr_type' => 'Dr',
				'trans_id' => $grnid,
				'trans_type'=>'G',
				'recordCreatedBy'=>$this->session->userdata('user_id')
			);
			$this->db->insert('voucher_transaction',$data);
			$vid = $this->db->insert_id();
			}
		}
		// credit entry
		for($i=0;$i<count($_POST['inv_creditor']);$i++)
		{
			$creditor=$_POST['inv_creditor'][$i];
			$cr_amount=$_POST['inv_cr_amount'][$i];
			if($cr_amount>0)
			{
			$data = array(
				'voucher_code' =>$AccountCode,
				'voucher_date' => date('Y-m-d h:i:s',strtotime("$vdate $vtime")),
				'voucher_type' => 'G',  /// po invoice  entry
				'customer_id' => $this->input->post('supplier_id'),
				'account_id' => $creditor,
				'amount' => $cr_amount,
				'drcr_type' => 'Cr',
				'trans_id' => $grnid,
				'trans_type'=>'G',
				'recordCreatedBy'=>$this->session->userdata('user_id')
			);
			$this->db->insert('voucher_transaction',$data);
			$vid = $this->db->insert_id();
			}
		}	
		
		if($grnid)
        	{
		    $user_se_id=$this->session->userdata('user_id');
		    $page_name=explode('index.php/', $_SERVER['PHP_SELF']);
		    $ci = get_instance();
		    $ci->load->helper('log');
		    $log_msg=add_log_entry($user_se_id,2,$page_name[1],'GRN_master','grn_id',$grnid);

        	}
		return $grnid;	
    }
}
