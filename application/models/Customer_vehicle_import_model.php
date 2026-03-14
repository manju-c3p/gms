<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer_vehicle_import_model extends CI_Model
{
	// 	public function import_customer_vehicle($row)
	// {
	//     /* ================= NORMALIZE ================= */
	//     $phone = preg_replace('/[^0-9]/', '', $row['mobile'] ?? '');
	//     $plate = strtoupper(trim($row['plate_no'] ?? ''));
	//     $vin   = strtoupper(trim($row['vin_no'] ?? ''));

	//     if (in_array($plate, ['NOPLATE', '-', 'SOLD', ''])) {
	//         $plate = '';
	//     }

	//     /* ================= CUSTOMER ================= */
	//     // 🚨 RESET QUERY BUILDER
	//     $this->db->reset_query();

	//     // phone is mandatory
	//     if (empty($phone)) {
	//         return; // skip row safely
	//     }

	//     $customer = $this->db
	//         ->where('phone', $phone)
	//         ->get('customers')
	//         ->row();

	//     if ($customer) {
	//         $customer_id = $customer->customer_id;
	//     } else {

	//         $this->db->reset_query();

	//         $this->db->insert('customers', [
	//             'name'         => $row['customer'] ?? '',
	//             'phone'        => $phone,
	//             'billnumber'   => $row['bill_number'] ?? null,
	//             'date'         => $row['date'] ?? null,
	//             'opening_date' => $row['opening_date'] ?? null,
	//             'created_at'   => date('Y-m-d H:i:s')
	//         ]);

	//         $customer_id = $this->db->insert_id();
	//     }

	//     /* ================= VEHICLE ================= */
	//     // 🚨 RESET QUERY BUILDER
	//     $this->db->reset_query();

	//     $vehicle = null;

	//     // only search if at least one identifier exists
	//     if (!empty($plate) || !empty($vin)) {

	//         if (!empty($vin)) {
	//             $this->db->where('chassis_no', $vin);
	//         }

	//         if (!empty($plate)) {
	//             $this->db->or_where('registration_no', $plate);
	//         }

	//         $vehicle = $this->db->get('vehicles')->row();
	//     }

	//     // 🚫 DO NOT INSERT VEHICLE IF PLATE IS EMPTY
	//     if (!$vehicle && !empty($plate)) {

	//         $this->db->reset_query();

	//         $this->db->insert('vehicles', [
	//             'customer_id'     => $customer_id,
	//             'registration_no' => $plate,
	//             'brand'           => $row['brand'] ?? null,
	//             'model'           => $row['model'] ?? null,
	//             'year'            => $row['year'] ?? null,
	//             'chassis_no'      => $vin ?: null,
	//             'created_at'      => date('Y-m-d H:i:s')
	//         ]);
	//     }
	// }

	// public function import_customer_vehicle($row)
	// {
	//     /* ================= NORMALIZE ================= */
	//     $phone = preg_replace('/[^0-9]/', '', $row['mobile'] ?? '');
	//     $plate = strtoupper(trim($row['plate_no'] ?? ''));
	//     $vin   = strtoupper(trim($row['vin_no'] ?? ''));

	//     // Invalid plates only check
	//     $invalid_plates = ['NOPLATE', '-', 'SOLD', '000', ''];

	//     /* ================= CUSTOMER ================= */
	//     $this->db->reset_query();

	//     // Always create customer (NO CHECKS)
	//     $this->db->insert('customers', [
	//         'name'         => $row['customer'] ?? '',
	//         'phone'        => $phone,
	//         'billnumber'   => $row['bill_number'] ?? null,
	//         'date'         => $row['date'] ?? null,
	//         'opening_date' => $row['opening_date'] ?? null,
	//         'created_at'   => date('Y-m-d H:i:s')
	//     ]);

	//     $customer_id = $this->db->insert_id();

	//     /* ================= VEHICLE ================= */
	//     $this->db->reset_query();

	//     // Insert vehicle ONLY if plate is valid
	//     if (!in_array($plate, $invalid_plates)) {

	//         $this->db->insert('vehicles', [
	//             'customer_id'     => $customer_id,
	//             'registration_no' => $plate,
	//             'brand'           => $row['brand'] ?? null,
	//             'model'           => $row['model'] ?? null,
	//             'year'            => $row['year'] ?? null,
	//             'chassis_no'      => $vin ?: null,
	//             'created_at'      => date('Y-m-d H:i:s')
	//         ]);
	//     }
	// }
	public function import_customer_vehicle($row)
	{
		/* ================= NORMALIZE ================= */
		$customer_name = trim($row['customer'] ?? '');

		if ($customer_name === '') {
			return; // safety
		}
		$phone = strtoupper(trim($row['mobile'] ?? ''));
		$plate = strtoupper(trim($row['plate_no'] ?? ''));
		$vin   = strtoupper(trim($row['vin_no'] ?? ''));
		$brand = trim($row['brand'] ?? '');
		$model = trim($row['model'] ?? '');

		$invalid_plates = ['NOPLATE', '-', 'SOLD', '000', ''];

		/* ================= CUSTOMER CHECK ================= */
		$this->db->reset_query();

		$customer = $this->db
			->where('name', $customer_name)
			->limit(1)
			->get('customers')
			->row();

		if ($customer) {
			// ✅ Customer exists
			$customer_id = $customer->customer_id;
		} else {
			// 🆕 Create new customer
			$this->db->reset_query();

			$this->db->insert('customers', [
				'name'         => $customer_name,
				'phone'   => $row['mobile'] ?? null,
				'billnumber'   => $row['bill_number'] ?? null,
				'date'         => $row['date'] ?? null,
				'opening_date' => $row['opening_date'] ?? null,
				'created_at'   => date('Y-m-d H:i:s')
			]);

			$customer_id = $this->db->insert_id();
			// ====================ledger entry================
		}

		/* ================= VEHICLE CHECK ================= */
		// Do nothing if plate invalid
		if (in_array($plate, $invalid_plates)) {
			return;
		}

		$this->db->reset_query();

		$vehicle_exists = $this->db
			->where('customer_id', $customer_id)
			->where('registration_no', $plate)
			->where('brand', $brand)
			->where('model', $model)
			->where('chassis_no', $vin)
			->limit(1)
			->get('vehicles')
			->row();

		// 🚫 Same vehicle already exists
		if ($vehicle_exists) {
			return;
		}

		/* ================= INSERT VEHICLE ================= */
		$this->db->reset_query();

		$this->db->insert('vehicles', [
			'customer_id'     => $customer_id,
			'registration_no' => $plate,
			'brand'           => $brand ?: null,
			'model'           => $model ?: null,
			'year'            => $row['year'] ?? null,
			'chassis_no'      => $vin ?: null,
			'created_at'      => date('Y-m-d H:i:s')
		]);
	}


	public function import_customer_vehicle_from_invoice_row_old($row)
	{
		$result = [
			'customer_added'  => false,
			'customer_used'   => false,
			'vehicle_added'   => false,
			'vehicle_skipped' => false,
			'customer_name'   => null,
			'plate'           => null,
			'reason'          => null
		];

		/* ================= NORMALIZE ================= */
		$customer_name = trim($row['customer_name'] ?? '');

		// Skip service / total rows
		if ($customer_name === '' || strtoupper($customer_name) === 'TOTAL') {
			$result['reason'] = 'Service/Total row';

			log_message(
				'error',
				'IMPORT | Skipped row | Reason: Service/Total row'
			);

			return $result;
		}

		$plate = strtoupper(trim($row['plate no'] ?? ''));
		$vin   = strtoupper(trim($row['vin no'] ?? ''));
		$brand = trim($row['brand'] ?? '');
		$model = trim($row['model'] ?? '');


		$result['customer_name'] = $customer_name;
		$result['plate'] = $plate;

		$invalid_plates = ['NOPLATE', '-', 'SOLD', '000', ''];

		/* ================= CUSTOMER ================= */
		$this->db->reset_query();

		$customer = $this->db
			->where('name', $customer_name)
			->get('customers')
			->row();

		if ($customer) {

			$customer_id = $customer->customer_id;
			$result['customer_used'] = true;

			log_message(
				'error',
				"IMPORT | Customer exists | Name: {$customer_name} | ID: {$customer_id}"
			);
		} else {

			$this->db->insert('customers', [
				'name'       => $customer_name,
				'created_at' => date('Y-m-d H:i:s')
			]);

			$customer_id = $this->db->insert_id();
			$result['customer_added'] = true;

			log_message(
				'error',
				"IMPORT | Customer added | Name: {$customer_name} | ID: {$customer_id}"
			);
		}

		/* ================= VEHICLE ================= */
		if (in_array($plate, $invalid_plates)) {

			$result['vehicle_skipped'] = true;
			$result['reason'] = 'Invalid plate';

			log_message(
				'error',
				"IMPORT | Vehicle skipped | Invalid plate | Customer: {$customer_name}"
			);

			return $result;
		}

		$this->db->reset_query();

		$vehicle_exists = $this->db
			->where('customer_id', $customer_id)
			->where('registration_no', $plate)
			->where('chassis_no', $vin)
			->limit(1)
			->get('vehicles')
			->row();

		if ($vehicle_exists) {

			$result['vehicle_skipped'] = true;
			$result['reason'] = 'Vehicle already exists';

			log_message(
				'error',
				"IMPORT | Vehicle exists | Plate: {$plate} | Customer: {$customer_name}"
			);

			return $result;
		}

		/* ================= INSERT VEHICLE ================= */
		$this->db->insert('vehicles', [
			'customer_id'     => $customer_id,
			'registration_no' => $plate,
			'brand'           => $brand ?: null,
			'model'           => $model ?: null,
			'chassis_no'      => $vin ?: null,
			'created_at'      => date('Y-m-d H:i:s')
		]);

		$result['vehicle_added'] = true;

		log_message(
			'error',
			"IMPORT | Vehicle added | Plate: {$plate} | Customer: {$customer_name}"
		);

		return $result;
	}

	public function import_customer_vehicle_from_invoice_row($row)
	{
		$result = [
			'customer_added'  => false,
			'customer_used'   => false,
			'vehicle_added'   => false,
			'vehicle_skipped' => false,
			'customer_name'   => null,
			'plate'           => null,
			'reason'          => null
		];

		/* ================= NORMALIZE ================= */

		$customer_name = trim($row['Customer Name'] ?? '');

		if ($customer_name === '' || strtoupper($customer_name) === 'TOTAL') {
			$result['reason'] = 'Service/Total row';
			return $result;
		}

		$plate = strtoupper(trim($row['Plate No'] ?? ''));
		$vin   = strtoupper(trim($row['Vin No'] ?? ''));
		$brand = trim($row['Brand'] ?? '');
		$model = trim($row['Model'] ?? '');

		$result['customer_name'] = $customer_name;

		$result['plate'] = $plate;

		$invalid_plates = ['NOPLATE', '-', 'SOLD', '000', ''];

		/* ================= CUSTOMER ================= */

		$this->db->reset_query();

		$customer = $this->db
			->where('name', $customer_name)
			->limit(1)
			->get('customers')
			->row();

		if ($customer) {

			$customer_id = $customer->customer_id;
			$result['customer_used'] = true;
		} else {

			$this->db->insert('customers', [
				'name'       => $customer_name,
				'created_at' => date('Y-m-d H:i:s')
			]);

			$customer_id = $this->db->insert_id();
			$result['customer_added'] = true;
		}


		/* ================= VEHICLE ================= */

		if (in_array($plate, $invalid_plates)) {

			$result['vehicle_skipped'] = true;
			$result['reason'] = 'Invalid plate';
			return $result;
		}


		/* ================= CHECK VEHICLE EXISTS ================= */

		$this->db->reset_query();

		// Check using plate AND customer_id (VIN optional)
		$this->db->where('customer_id', $customer_id);
		$this->db->where('registration_no', $plate);

		if (!empty($vin)) {
			$this->db->group_start();
			$this->db->where('chassis_no', $vin);
			$this->db->or_where('chassis_no IS NULL', null, false);
			$this->db->group_end();
		}

		$vehicle_exists = $this->db
			->limit(1)
			->get('vehicles')
			->row();


		if ($vehicle_exists) {

			$result['vehicle_skipped'] = true;
			$result['reason'] = 'Vehicle already exists';

			return $result;
		}


		/* ================= INSERT VEHICLE ================= */

		$vehicle_data = [
			'customer_id'     => $customer_id,
			'registration_no' => $plate,
			'brand'           => !empty($brand) ? $brand : null,
			'model'           => !empty($model) ? $model : null,
			'chassis_no'      => !empty($vin) ? $vin : null,
			'created_at'      => date('Y-m-d H:i:s')
		];

		$this->db->insert('vehicles', $vehicle_data);

		$result['vehicle_added'] = true;

		return $result;
	}

	public function import_customers_and_vehicles_from_csvold($file_path)
	{
		if (!file_exists($file_path)) {
			return "File not found.";
		}

		$handle = fopen($file_path, "r");

		if (!$handle) {
			return "Unable to open file.";
		}

		// Read header row
		$header = fgetcsv($handle);

		// Normalize header keys to lowercase
		$header = array_map('strtolower', $header);

		$added_customers = 0;
		$added_vehicles  = 0;

		while (($row = fgetcsv($handle)) !== FALSE) {

			$row = array_combine($header, $row);

			$customer_name = trim($row['customer name']);
			$plate         = strtoupper(trim($row['plate no']));
			$brand         = trim($row['brand']);
			$model         = trim($row['model']);
			$vin           = strtoupper(trim($row['vin no']));

			// Skip invalid rows
			if ($customer_name == '' || strtoupper($customer_name) == 'TOTAL') {
				continue;
			}

			/* ================= CUSTOMER CHECK ================= */

			$customer = $this->db
				->where('name', $customer_name)
				->get('customers')
				->row();

			if ($customer) {

				$customer_id = $customer->customer_id;
			} else {

				$this->db->insert('customers', [
					'name' => $customer_name,
					'created_at' => date('Y-m-d H:i:s')
				]);

				$customer_id = $this->db->insert_id();
				$added_customers++;
			}


			/* ================= VEHICLE CHECK ================= */

			if ($plate == '') {
				continue;
			}

			$vehicle = $this->db
				->where('customer_id', $customer_id)
				->where('registration_no', $plate)
				->get('vehicles')
				->row();

			if (!$vehicle) {

				$this->db->insert('vehicles', [
					'customer_id'     => $customer_id,
					'registration_no' => $plate,
					'brand'           => $brand ?: null,
					'model'           => $model ?: null,
					'chassis_no'      => $vin ?: null,
					'created_at'      => date('Y-m-d H:i:s')
				]);

				$added_vehicles++;
			}
		}

		fclose($handle);

		return [
			'customers_added' => $added_customers,
			'vehicles_added'  => $added_vehicles
		];
	}

	public function import_customers_and_vehicles_from_csv($file_path)
{
    if (!file_exists($file_path)) {
        return [
            'customers_added' => 0,
            'vehicles_added' => 0,
            'error' => 'File not found.'
        ];
    }

    $handle = fopen($file_path, "r");

    if (!$handle) {
        return [
            'customers_added' => 0,
            'vehicles_added' => 0,
            'error' => 'Unable to open file.'
        ];
    }

    /* ========= READ HEADER SAFELY (REMOVE BOM) ========= */

    $first_line = fgets($handle);

    // Remove BOM if exists
    $first_line = preg_replace('/^\xEF\xBB\xBF/', '', $first_line);

    $header = str_getcsv($first_line);

    // Normalize header (lowercase + trim)
    $header = array_map(function ($h) {
        return strtolower(trim($h));
    }, $header);


    $added_customers = 0;
    $added_vehicles  = 0;


    /* ========= PROCESS ROWS ========= */

    while (($csv_row = fgetcsv($handle)) !== FALSE) {

        // Skip empty rows
        if (!$csv_row || count(array_filter($csv_row)) == 0) {
            continue;
        }

        // Combine header and row safely
        if (count($header) != count($csv_row)) {
            continue;
        }

        $row = array_combine($header, $csv_row);

        // Safe access
        $customer_name = isset($row['customer name']) ? trim($row['customer name']) : '';
		$customer_mob = isset($row['cust mobile']) ? trim($row['cust mobile']) : '';
        $plate         = isset($row['plate no']) ? strtoupper(trim($row['plate no'])) : '';
        $brand         = isset($row['brand']) ? trim($row['brand']) : '';
        $model         = isset($row['model']) ? trim($row['model']) : '';
        $vin           = isset($row['vin no']) ? strtoupper(trim($row['vin no'])) : '';

        // Skip invalid rows
        if ($customer_name == '' || strtoupper($customer_name) == 'TOTAL') {
            continue;
        }


        /* ========= CUSTOMER CHECK ========= */

        $customer = $this->db
            ->where('name', $customer_name)
            ->get('customers')
            ->row();

        if ($customer) {

            $customer_id = $customer->customer_id;

        } else {

            $this->db->insert('customers', [
                'name'       => $customer_name,
				'phone'=> $customer_mob,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $customer_id = $this->db->insert_id();

            $added_customers++;
        }


        /* ========= VEHICLE CHECK ========= */

        if ($plate == '') {
            continue;
        }

        $vehicle = $this->db
            ->where('customer_id', $customer_id)
            ->where('registration_no', $plate)
            ->get('vehicles')
            ->row();

        if (!$vehicle) {

            $this->db->insert('vehicles', [
                'customer_id'     => $customer_id,
                'registration_no' => $plate,
                'brand'           => $brand ?: null,
                'model'           => $model ?: null,
                'chassis_no'      => $vin ?: null,
                'created_at'      => date('Y-m-d H:i:s')
            ]);

            $added_vehicles++;
        }
    }

    fclose($handle);

    return [
        'customers_added' => $added_customers,
        'vehicles_added'  => $added_vehicles
    ];
}
}
