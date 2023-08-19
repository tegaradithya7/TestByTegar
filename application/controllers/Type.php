<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Type extends Base_controller
{
    public function getType()
    {
        $this->db->select('id, name');
        $type = $this->db->get('ms_type')->result();

        if ($type) {
            $response = [
                'status' => 'success',
                'message' => 'Type retrieved successfully',
                'data' => $type
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'No Type found'
            ];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}
