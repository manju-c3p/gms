<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Demo extends CI_Controller
{

public function update_receipt_trans_id()
{
    $this->db->where('voucher_id', 2638);

    $update = $this->db->update('voucher_transaction', [
        'trans_id' => 163
    ]);

    if ($update) {
        echo "Trans ID updated successfully";
    } else {
        echo "Update failed";
    }
}


}
