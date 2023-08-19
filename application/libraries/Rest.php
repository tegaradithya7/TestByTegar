<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rest
{

    var $main;
    var $error;
    var $data;
    var $request_param;
    var $next;

    function set_error($error_message = '')
    {
        $this->error = $error_message;
    }

    function set_data($params)
    {
        $this->data = $params;
    }


    function set_requestparam($params)
    {
        $this->request_param = $params;
    }

    function set_next($params)
    {
        $this->next = $params;
    }

    function render()
    {
        $this->request_param = (empty($this->request_param) ? "" : $this->request_param);
        $this->next = (empty($this->next) ? "" : $this->next);

        if (is_null($this->data)) {
            $data = array(
                'request_param' => $this->request_param,
                'status' => 'error',
                'error_message' => $this->error,
                'data' => null,
                'next' => $this->next
            );
        } else {
            $data = array(
                'request_param' => $this->request_param,
                'status' => 'success',
                'error_message' => null,
                'data' => $this->data,
                'next' => $this->next
            );
        }

        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function render_empty()
    {
        $this->request_param = (empty($this->request_param) ? "" : $this->request_param);
        $this->next = (empty($this->next) ? "" : $this->next);

        $data = array(
            'request_param' => $this->request_param,
            'status' => 'success',
            'error_message' => $this->error,
            'data' => $this->data,
            'next' => $this->next
        );

        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function nafiis()
    {
        $this->request_param = (empty($this->request_param) ? "" : $this->request_param);
        $this->next = (empty($this->next) ? "" : $this->next);

        $data = array(
            'request_param' => $this->request_param,
            'status' => 'success',
            'error_message' => $this->error,
            'message_data' => $this->data->message_data,
            'next' => $this->next
        );

        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function fm()
    {
        $this->request_param = (empty($this->request_param) ? "" : $this->request_param);
        $this->next = (empty($this->next) ? "" : $this->next);

        $data = array(
            'request_param' => $this->request_param,
            'status' => 'success',
            'error_message' => $this->error,
            'data' => $this->data->data,
            'next' => $this->next
        );

        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function send_error($code, $data)
    {
        $ci = &get_instance();
        $this->set_error($data);
        $ci->output->set_status_header($code);
        $this->render();
    }

    function send_empty($code, $data)
    {
        $ci = &get_instance();
        $this->set_error($data);
        $ci->output->set_status_header($code);
        $this->set_data([]);
        $this->render_empty();
    }

    function send($data)
    {
        $this->set_data($data);
        $this->render();
    }
    function send_nafiis($data)
    {
        $this->set_data($data);
        $this->nafiis();
    }
    function send_fm($data)
    {
        $this->set_data($data);
        $this->fm();
    }
}
