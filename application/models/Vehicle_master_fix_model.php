<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_master_fix_model extends CI_Model
{
    public function update_vehicle_brand_model_ids()
    {
        $vehicles = $this->db
            ->where('(brand_id IS NULL OR brand_id = 0)', null, false)
            ->get('vehicles')
            ->result();

        $updatedCount = 0;

        foreach ($vehicles as $v) {

            $brandName = trim($v->brand);
            $modelName = trim($v->model);

            if ($brandName === '' || $modelName === '') {
                continue;
            }

            /* ================= BRAND ================= */
            $brand = $this->db
                ->where('LOWER(brand_name)', strtolower($brandName))
                ->get('vehicle_brands')
                ->row();

            if (!$brand) {
                $this->db->insert('vehicle_brands', [
                    'brand_name' => $brandName
                ]);
                $brand_id = $this->db->insert_id();
            } else {
                $brand_id = $brand->brand_id;
            }

            /* ================= MODEL ================= */
            $model = $this->db
                ->where('brand_id', $brand_id)
                ->where('LOWER(model_name)', strtolower($modelName))
                ->get('vehicle_models')
                ->row();

            if (!$model) {
                $this->db->insert('vehicle_models', [
                    'brand_id'   => $brand_id,
                    'model_name' => $modelName
                ]);
                $model_id = $this->db->insert_id();
            } else {
                $model_id = $model->model_id;
            }

            /* ================= UPDATE VEHICLE ================= */
            $this->db
                ->where('vehicle_id', $v->vehicle_id)
                ->update('vehicles', [
                    'brand_id' => $brand_id,
                    'model_id' => $model_id
                ]);

            $updatedCount++;
        }

        return $updatedCount;
    }
}
