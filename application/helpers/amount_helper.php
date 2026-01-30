<?php defined('BASEPATH') or exit('No direct script access allowed');
	function number_to_words123($number)
	{
		if ($number == 0) {
			return 'AED Zero Only';
		}

		$no = floor($number);
		$point = round(($number - $no) * 100);

		$digits_1 = [
			'',
			'One',
			'Two',
			'Three',
			'Four',
			'Five',
			'Six',
			'Seven',
			'Eight',
			'Nine',
			'Ten',
			'Eleven',
			'Twelve',
			'Thirteen',
			'Fourteen',
			'Fifteen',
			'Sixteen',
			'Seventeen',
			'Eighteen',
			'Nineteen'
		];

		$digits_2 = [
			'',
			'',
			'Twenty',
			'Thirty',
			'Forty',
			'Fifty',
			'Sixty',
			'Seventy',
			'Eighty',
			'Ninety'
		];

		// NOTE: still Indian numbering (your existing logic)
		$digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];

		$str = [];
		$i = 0;

		while ($no > 0) {
			$divider = ($i == 2) ? 10 : 100;
			$number_part = $no % $divider;
			$no = floor($no / $divider);

			if ($number_part) {
				$hundred = ($i == 1 && !empty($str)) ? ' and ' : '';

				if ($number_part < 20) {
					$str[] = $digits_1[$number_part] . ' ' . $digits[$i] . $hundred;
				} else {
					$str[] = $digits_2[floor($number_part / 10)] . ' ' .
						$digits_1[$number_part % 10] . ' ' .
						$digits[$i] . $hundred;
				}
			}

			$i += ($divider == 10) ? 1 : 2;
		}

		$result = implode('', array_reverse($str));

		$fils = '';
		if ($point > 0) {
			if ($point < 20) {
				$fils = $digits_1[$point];
			} else {
				$fils = $digits_2[floor($point / 10)] . ' ' . $digits_1[$point % 10];
			}
		}

		if ($fils) {
			return 'AED ' . trim($result) . ' and ' . $fils . ' Fils Only';
		}

		return 'AED ' . trim($result) . ' Only';
	}

	function number_to_words_aed($number)
	{
		if ($number == 0) {
			return 'AED Zero Only';
		}

		$no = floor($number);
		$point = round(($number - $no) * 100);

		$digits_1 = [
			'',
			'One',
			'Two',
			'Three',
			'Four',
			'Five',
			'Six',
			'Seven',
			'Eight',
			'Nine',
			'Ten',
			'Eleven',
			'Twelve',
			'Thirteen',
			'Fourteen',
			'Fifteen',
			'Sixteen',
			'Seventeen',
			'Eighteen',
			'Nineteen'
		];

		$digits_2 = [
			'',
			'',
			'Twenty',
			'Thirty',
			'Forty',
			'Fifty',
			'Sixty',
			'Seventy',
			'Eighty',
			'Ninety'
		];

		// ✅ International system
		$units = ['', 'Thousand', 'Million', 'Billion'];

		$str = [];
		$i = 0;

		while ($no > 0) {
			$chunk = $no % 1000;
			$no = floor($no / 1000);

			if ($chunk) {
				$words = '';

				if ($chunk > 99) {
					$words .= $digits_1[floor($chunk / 100)] . ' Hundred ';
					$chunk %= 100;
				}

				if ($chunk > 0) {
					if ($chunk < 20) {
						$words .= $digits_1[$chunk] . ' ';
					} else {
						$words .= $digits_2[floor($chunk / 10)] . ' ';
						$words .= $digits_1[$chunk % 10] . ' ';
					}
				}

				$str[] = trim($words) . ' ' . $units[$i];
			}

			$i++;
		}

		$result = implode(' ', array_reverse($str));

		// Fils
		$fils = '';
		if ($point > 0) {
			if ($point < 20) {
				$fils = $digits_1[$point];
			} else {
				$fils = $digits_2[floor($point / 10)] . ' ' . $digits_1[$point % 10];
			}
		}

		if ($fils) {
			return 'AED ' . trim($result) . ' and ' . $fils . ' Fils Only';
		}

		return 'AED ' . trim($result) . ' Only';
	}
?>
