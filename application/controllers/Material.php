<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Material extends Base_controller
{
    public function insertMaterial()
    {
        $rawData = $this->input->raw_input_stream;
        $data = json_decode($rawData, true);

        $response = [
            'status' => 'success',
            'message' => 'Insert operation completed'
        ];

        $shouldInsertAll = true;
        $insertedData = [];

        foreach ($data as $material) {
            if (
                !empty($material['material_name']) &&
                !empty($material['material_code']) &&
                is_numeric($material['material_buy_price']) &&
                !empty($material['supplier_id']) &&
                !empty($material['type_id'])
            ) {
                if ($material['material_buy_price'] >= 100) {
                    $existingMaterial = $this->db->get_where('ms_material', ['material_code' => $material['material_code']])->row();
                    if ($existingMaterial) {
                        $shouldInsertAll = false;
                        $insertedData[] = [
                            'status' => 'error',
                            'message' => 'Material with the same name already exists: ' . $material['material_name']
                        ];
                    } else {
                        $this->db->insert('ms_material', $material);
                        $insertedData[] = [
                            'status' => 'success',
                            'message' => 'Data inserted successfully for material: ' . $material['material_name']
                        ];
                    }
                } else {
                    $shouldInsertAll = false;
                    $insertedData[] = [
                        'status' => 'error',
                        'message' => 'material_buy_price should be greater than or equal to 100 for material: ' . $material['material_name']
                    ];
                }
            } else {
                $shouldInsertAll = false;
                $insertedData[] = [
                    'status' => 'error',
                    'message' => 'Required fields are missing for material: ' . $material['material_name']
                ];
            }
        }

        if (!$shouldInsertAll) {
            $response['status'] = 'error';
            $response['message'] = 'One or more materials already exist or have missing fields';
        }

        $response['data'] = $insertedData;

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function getMaterials()
    {
        $type_id = $this->input->get('type_id');

        $this->db->select('ms_material.id, ms_supplier.supplier_name, ms_type.name as type_name, ms_material.material_name, ms_material.material_code, ms_material.material_buy_price');
        $this->db->from('ms_material');
        $this->db->join('ms_supplier', 'ms_supplier.id = ms_material.supplier_id', 'left');
        $this->db->join('ms_type', 'ms_type.id = ms_material.type_id', 'left');
        $this->db->where('ms_material.deleted', 0);

        if (!empty($type_id)) {
            $this->db->where('ms_material.type_id', $type_id);
        }

        $materials = $this->db->get()->result();

        if ($materials) {
            $response = [
                'status' => 'success',
                'message' => 'Materials retrieved successfully',
                'data' => $materials
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'No materials found'
            ];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function deleteMaterial($material_id)
    {
        $existingMaterial = $this->db->get_where('ms_material', ['id' => $material_id])->row();

        if ($existingMaterial) {
            $this->db->where('id', $material_id);
            $this->db->update('ms_material', ['deleted' => 1]);

            $response = [
                'status' => 'success',
                'message' => 'Material soft deleted successfully'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Material not found'
            ];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function updateMaterial($material_id)
    {
        $rawData = $this->input->raw_input_stream;
        $data = json_decode($rawData, true);

        if (!empty($material_id)) {
            $existingMaterial = $this->db->get_where('ms_material', ['id' => $material_id])->row();

            if ($existingMaterial) {
                $this->db->where('id', $material_id);
                $this->db->update('ms_material', $data);

                $response = [
                    'status' => 'success',
                    'message' => 'Material updated successfully'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Material not found'
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Required fields are missing'
            ];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}
