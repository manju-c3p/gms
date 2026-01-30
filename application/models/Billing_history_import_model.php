<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing_history_import_model extends CI_Model
{
    public function create_or_get_invoice($data)
    {
        $existing = $this->db
            ->where('billing_no', $data['billing_no'])
            ->get('billing_invoices')
            ->row();

        if ($existing) {
            return $existing->invoice_id;
        }

        $this->db->insert('billing_invoices', $data);
        return $this->db->insert_id();
    }

    public function insert_invoice_item($invoice_id, $data)
    {
        $data['invoice_id'] = $invoice_id;
        $this->db->insert('billing_invoice_items', $data);
    }

    public function update_invoice_totals($invoice_id, $totals)
    {
        $this->db->where('invoice_id', $invoice_id)
                 ->update('billing_invoices', $totals);
    }
}
