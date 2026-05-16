<?php


function calculate_opening_bal($from_date1, $account_id)
{
	$CI = &get_instance();

	$from_date = date('Y-m-d', strtotime($from_date1));
	$query = $CI->db->query("select coalesce(two1.opening_sum,0)+coalesce(two.opening,0)as opening_bal from (select r.account_id, Case when opening_bal_type ='Dr' THEN opening_balance ELSE -opening_balance END as opening from general_ledger r where r.account_id='$account_id') as two LEFT JOIN (select account_id,SUM(CASE WHEN drcr_type= 'Dr' THEN amount ELSE (-amount) end) AS opening_sum from voucher_transaction v where cancel=0 and date(v.voucher_date) < '$from_date' and v.account_id='$account_id' group by account_id) as two1 on (two.account_id=two1.account_id);");
	return $query->row('opening_bal');
}

function calculate_todays_order_wise_opening_bal($from_date1, $account_id, $order_id)
{
	$CI = &get_instance();

	$from_date = date('Y-m-d', strtotime($from_date1));
	$query = $CI->db->query("select coalesce(two1.opening_sum,0)+coalesce(two.opening,0) as opening_bal from (select r.account_id,r.customer_id, Case when opening_bal_type ='DR' THEN opening_balance ELSE -opening_balance END as opening from general_ledger r where r.account_id='$account_id') as two LEFT JOIN (select account_id,customer_id,SUM(CASE WHEN drcr_type= 'DR' THEN amount ELSE (-amount) end) AS opening_sum from voucher_transaction v where cancel=0 and date(v.voucher_date) <= '$from_date' and v.account_id='$account_id' and v.order_id=$order_id group by account_id) as two1 on (two.account_id=two1.account_id);");
	return $query->row('opening_bal');
}

function get_accountname_by_id($account_id)
{

	$CI = &get_instance();
	$query = $CI->db->query(" select account_name from general_ledger where account_id='$account_id' ");
	return $query->row('account_name');
}
if (!function_exists('convert_number_to_words')) {

	function convert_number_to_words11($number)
	{
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'negative ';
		$decimal     = ' point ';
		$dictionary  = array(
			0                   => 'zero',
			1                   => 'one',
			2                   => 'two',
			3                   => 'three',
			4                   => 'four',
			5                   => 'five',
			6                   => 'six',
			7                   => 'seven',
			8                   => 'eight',
			9                   => 'nine',
			10                  => 'ten',
			11                  => 'eleven',
			12                  => 'twelve',
			13                  => 'thirteen',
			14                  => 'fourteen',
			15                  => 'fifteen',
			16                  => 'sixteen',
			17                  => 'seventeen',
			18                  => 'eighteen',
			19                  => 'nineteen',
			20                  => 'twenty',
			30                  => 'thirty',
			40                  => 'forty',
			50                  => 'fifty',
			60                  => 'sixty',
			70                  => 'seventy',
			80                  => 'eighty',
			90                  => 'ninety',
			100                 => 'hundred',
			1000                => 'thousand',
			1000000             => 'million',
			1000000000          => 'billion',
			1000000000000       => 'trillion',
			1000000000000000    => 'quadrillion'
		);

		if (!is_numeric($number)) {
			return false;
		}

		if ($number < 0) {
			return $negative . convert_number_to_words(abs($number));
		}

		$string = $fraction = null;

		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}

		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int)($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = (int)($number / 100);
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . convert_number_to_words($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int)($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= convert_number_to_words($remainder);
				}
				break;
		}

		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = [];
			foreach (str_split((string)$fraction) as $digit) {
				$words[] = $dictionary[$digit];
			}
			$string .= implode(' ', $words);
		}

		return $string;
	}

	function convert_number_to_words($number)
	{
		$dictionary  = array(
			0 => 'Zero',
			1 => 'One',
			2 => 'Two',
			3 => 'Three',
			4 => 'Four',
			5 => 'Five',
			6 => 'Six',
			7 => 'Seven',
			8 => 'Eight',
			9 => 'Nine',
			10 => 'Ten',
			11 => 'Eleven',
			12 => 'Twelve',
			13 => 'Thirteen',
			14 => 'Fourteen',
			15 => 'Fifteen',
			16 => 'Sixteen',
			17 => 'Seventeen',
			18 => 'Eighteen',
			19 => 'Nineteen',
			20 => 'Twenty',
			30 => 'Thirty',
			40 => 'Forty',
			50 => 'Fifty',
			60 => 'Sixty',
			70 => 'Seventy',
			80 => 'Eighty',
			90 => 'Ninety',
			100 => 'Hundred',
			1000 => 'Thousand',
			1000000 => 'Million',
			1000000000 => 'Billion'
		);

		if (!is_numeric($number)) return false;

		$number = round($number, 2);

		$integer = floor($number);
		$fraction = round(($number - $integer) * 100);

		// 🔹 Convert number to words (recursive)
		$convert = function ($num) use (&$convert, $dictionary) {

			if ($num < 21) return $dictionary[$num];

			if ($num < 100) {
				$tens = ((int)($num / 10)) * 10;
				$units = $num % 10;
				return $dictionary[$tens] . ($units ? '-' . $dictionary[$units] : '');
			}

			if ($num < 1000) {
				$hundreds = (int)($num / 100);
				$remainder = $num % 100;
				return $dictionary[$hundreds] . ' Hundred' .
					($remainder ? ' and ' . $convert($remainder) : '');
			}

			$baseUnit = pow(1000, floor(log($num, 1000)));
			$numBaseUnits = (int)($num / $baseUnit);
			$remainder = $num % $baseUnit;

			return $convert($numBaseUnits) . ' ' . $dictionary[$baseUnit] .
				($remainder ? ($remainder < 100 ? ' and ' : ', ') . $convert($remainder) : '');
		};

		$dirhams = $convert($integer);

		// ✅ Final Output
		if ($fraction > 0) {
			$fils = $convert($fraction);
			return "AED {$dirhams} Dirhams and {$fils} Fils";
		} else {
			return "AED {$dirhams} Dirhams Only";
		}
	}



	///account receipt related entry
function get_paid_invoice_amount1($type, $id, $account_id)
{
	$CI = & get_instance();
	if($type=='customer')
	{
		$query=$CI->db->query("select two.amount as paid_amt from (select grand_total from invoice_master where invoice_id='$id')as one left join(select coalesce(sum(amount),0)as amount from voucher_transaction  where trans_id=$id and account_id=$account_id and drcr_type='Cr')as two on(1=1) ");
		return $query->row('paid_amt');
	}
	else
	{
		$query=$CI->db->query("select two.amount as paid_amt from (select grand_total from purchase_grn_master where grn_id='$id')as one left join(select coalesce(sum(amount),0)as amount from voucher_transaction  where trans_id=$id and account_id=$account_id and drcr_type='Dr')as two on(1=1) ");
		
		return $query->row('paid_amt');
	}
}

function get_paid_invoice_amount($type, $id, $account_id)
{
    $CI = &get_instance();

    if($type == 'customer') {
        $sql = "SELECT COALESCE(SUM(amount),0) as paid_amt 
                FROM voucher_transaction 
                WHERE trans_id = ? AND account_id = ? AND drcr_type = 'Cr'";
    } else {
        $sql = "SELECT COALESCE(SUM(amount),0) as paid_amt 
                FROM voucher_transaction 
                WHERE trans_id = ? AND account_id = ? AND drcr_type = 'Dr'";
    }

    $query = $CI->db->query($sql, [$id, $account_id]);

    return (float) $query->row('paid_amt');
}

function get_supplier_advance_balance($supplier_id)
{
    $CI = &get_instance();

    $query = $CI->db->query("
        SELECT 
            COALESCE(SUM(amount - adjusted_amount), 0) AS advance_balance
        FROM supplier_advances
        WHERE supplier_id = ?
    ", [$supplier_id]);

    return (float) $query->row('advance_balance');
}
}
