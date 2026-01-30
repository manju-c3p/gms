<?php 

function get_total_for_balance_sheet_with_date($id,$from)
{
    $CI =& get_instance();
    
    $from=date('Y-m-d',strtotime($from));
     $query=$CI->db->query("select sum(if(drcr_type='Dr',amount,-amount)) as amount from general_ledger gl, voucher_transaction lt,account_group ag where ag.group_no=gl.group_no and gl.account_id=lt.account_id and ag.sno='$id' and date(voucher_date) <'$from'  and cancel=0");
    return $query->row('amount');
}
function get_total_for_balance_sheet($id)
{
    $CI =& get_instance();
    
     $query=$CI->db->query("select sum(if(drcr_type='Dr',amount,-amount)) as amount from general_ledger gl, voucher_transaction lt,account_group ag where ag.group_no=gl.group_no and gl.account_id=lt.account_id and ag.sno='$id'  and cancel=0 group by sno");
    return $query->row('amount');
}
function get_group_details($pandl, $parent)
{
    $CI =& get_instance();
    
     $query=$CI->db->query("select ag.group_name,ag.group_no,sno from account_group ag where pandl=$pandl and ag.parent_group = '$parent' order by sequenceintb");
     return $query->result();
}
function get_group_details1($curgno,$from,$to)
{
    $CI =& get_instance();
    $from=date('Y-m-d',strtotime($from));
    $to=date('Y-m-d',strtotime($to));
     $query=$CI->db->query("select gl.group_no,lt.account_id, gl.account_name, sum(if(drcr_type='DR',amount,-amount)) as ltamount from general_ledger gl, voucher_transaction lt where gl.account_id=lt.account_id and gl.group_no='$curgno' and date(voucher_date) between '$from' and '$to' and cancel=0 group by lt.account_id");
     return $query->result();
}

function get_group_nos($group_no)
{
    $CI =& get_instance();
    
     $query=$CI->db->query("select group_concat(group_no)as gno  from account_group where parent_group in ($group_no)");
     return $query->row('gno');
}
function get_subgroup_details($group_no)
{
    $CI =& get_instance();
    
     $query=$CI->db->query("select *  from general_ledger where group_no in($group_no)");
     return $query->result();
}

function get_group_total($pandl,$group_no,$from,$to)
{
    $CI =& get_instance();
    
    $from=date('Y-m-d',strtotime($from));
    $to=date('Y-m-d',strtotime($to));
    $query=$CI->db->query("select ag.group_no,sum(if(drcr_type='DR',amount,-amount)) as amount from account_group ag,voucher_transaction lt, general_ledger gl  where ag.group_no=gl.group_no and lt.account_id=gl.account_id and pandl=$pandl and ag.parent_group in($group_no) and date(voucher_date) between '$from' and '$to' and cancel=0");
     return $query->row('amount');
}
function get_group_total1($group_no,$from,$to)
{
    $CI =& get_instance();
    
    $from=date('Y-m-d',strtotime($from));
    $to=date('Y-m-d',strtotime($to));
     $query=$CI->db->query("select coalesce(sum(if(drcr_type='Dr',amount,-amount)),0) as ltamount from general_ledger gl, voucher_transaction lt where gl.account_id=lt.account_id and gl.group_no in($group_no) and date(voucher_date) between '$from' and '$to' and cancel=0 ");
     return $query->row('ltamount');
}

function get_voucher_by_trans_id($trans_id, $vtype, $crdr, $accId)
{
    $CI =& get_instance();
    
     $query=$CI->db->query("select amount from voucher_transaction where trans_id=$trans_id and voucher_type='$vtype' and drcr_type='$crdr' and account_id='$accId' and cancel=0");
     return $query->row('amount');
}
function get_ledger_total1($account_id,$from,$to)
{
    $CI =& get_instance();
    
    $from=date('Y-m-d',strtotime($from));
    $to=date('Y-m-d',strtotime($to));
     $query=$CI->db->query("select coalesce(sum(if(drcr_type='Dr',amount,-amount)),0) as ltamount from general_ledger gl, voucher_transaction lt
    where gl.account_id=lt.account_id and gl.account_id in($account_id) and date(voucher_date) between '$from' and '$to' and cancel=0 ");
     return $query->row('ltamount');
}

 function get_pnl_opening_stock_amt($from)
 {
	$CI =& get_instance();
	$from=date('Y-m-d',strtotime($from));

	$query=$CI->db->query("select coalesce(sum(price*quantity),0)as totamt from stock_details where stock_date <'$from' and stock_type='IN' and status=0");
	return $query->row('totamt');
 }
 function get_pnl_closing_stock_amt($from, $to)
 {
	$CI =& get_instance();
	$from=date('Y-m-d',strtotime($from));
    	$to=date('Y-m-d',strtotime($to));

	$query=$CI->db->query(" select coalesce(sum(price*quantity),0) as totamt from stock_details where stock_date between '$from' and '$to' and stock_type='IN' and status=0");
	return $query->row('totamt');
 }
?>
