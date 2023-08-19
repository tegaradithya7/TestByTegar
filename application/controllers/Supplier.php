<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Supplier extends Base_controller
{
    public function insertSupplier()
    {
        $rawData = $this->input->raw_input_stream;
        $data = json_decode($rawData, true);

        $response = [
            'status' => 'success',
            'message' => 'Insert operation completed'
        ];

        $shouldInsertAll = true;
        $insertedData = [];

        foreach ($data as $supplier) {
            if (!empty($supplier['supplier_name'])) {
                $existingSupplier = $this->db->get_where('ms_supplier', ['supplier_name' => $supplier['supplier_name']])->row();

                if ($existingSupplier) {
                    $shouldInsertAll = false;
                    $insertedData[] = [
                        'status' => 'error',
                        'message' => 'Supplier with the same name already exists: ' . $supplier['supplier_name']
                    ];
                } else {
                    $this->db->insert('ms_supplier', $supplier);
                    $insertedData[] = [
                        'status' => 'success',
                        'message' => 'Data inserted successfully for supplier: ' . $supplier['supplier_name']
                    ];
                }
            } else {
                $shouldInsertAll = false;
                $insertedData[] = [
                    'status' => 'error',
                    'message' => 'Required fields are missing for supplier: ' . $supplier['supplier_name']
                ];
            }
        }

        if (!$shouldInsertAll) {
            $response['status'] = 'error';
            $response['message'] = 'One or more suppliers already exist or have missing fields';
        }

        $response['data'] = $insertedData;

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    public function getSuppliers()
    {
        $this->db->select('id, supplier_name');
        $suppliers = $this->db->get_where('ms_supplier', ['del' => 0])->result();

        if ($suppliers) {
            $response = [
                'status' => 'success',
                'message' => 'Suppliers retrieved successfully',
                'data' => $suppliers
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'No suppliers found'
            ];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    public function deleteSupplier($supplier_id)
    {
        $existingSupplier = $this->db->get_where('ms_supplier', ['id' => $supplier_id])->row();

        if ($existingSupplier) {
            $this->db->where('id', $supplier_id);
            $this->db->update('ms_supplier', ['del' => 1]);

            $response = [
                'status' => 'success',
                'message' => 'Supplier soft deleted successfully'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Supplier not found'
            ];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function updateSupplier($supplier_id)
    {
        $rawData = $this->input->raw_input_stream;
        $data = json_decode($rawData, true);

        if (!empty($data['supplier_name'])) {
            $existingSupplier = $this->db->get_where('ms_supplier', ['id' => $supplier_id])->row();

            if ($existingSupplier) {
                $this->db->where('id', $supplier_id);
                $this->db->update('ms_supplier', $data);

                $response = [
                    'status' => 'success',
                    'message' => 'Supplier updated successfully'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Supplier not found'
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
