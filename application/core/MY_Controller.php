<?php

class Base_controller extends MX_Controller
{
    protected $head_token;
    public function __construct()
    {
        parent::__construct();
        $this->head_token = $this->input->get_request_header('x-user-token');

        // if (ENVIRONMENT == 'development') {
        //     $this->output->enable_profiler(TRUE);
        // }
        date_default_timezone_set('Asia/Jakarta');
    }

    public function _compressedImage($source, $path, $quality)
    {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        imagejpeg($image, $path, $quality);
    }

    //DEBUG TOOLS
    public function last_query()
    {
        echo '<br/>';
        echo '<b>Query:</b> ' . $this->db->last_query();
        echo '<br/>';
    }

    public function inspect_variable($var)
    {
        echo '<b>Variable:</b><br/>';
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }

    public function checkAuthority($user_id)
    {
        if (!empty($user_id)) {
            $token = $this->input->get_request_header('x-user-token');
            $var   = $this->jwt->decode($token, $this->config->item('encryption_key'));

            if ($user_id != $var->id) {
                $this->rest->send_error(401, 'user not authorized');
                exit;
            }
        }
    }
}

class Front_Controller extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->template->set_layout('index');
        $this->template->set_theme('default');
    }
}


class Api_Controller extends Base_Controller
{
    protected $head_user_id;
    protected $head_user_role;
    protected $head_token;
    protected $head_device_id;
    protected $head_platform;
    protected $head_lat;
    protected $head_lng;
    protected $user;

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        $this->head_token = $this->input->get_request_header('x-user-token');

        $token = $this->head_token;

        if (empty($this->head_token)) {

            if (!empty($this->input->get('token'))) {
                $token = $this->input->get('token');
            } else {
                $this->rest->send_error(401, "Incomplete header entered.");
                exit;
            }
        }

        // $this->user = $this->jwt->decode($token, $this->config->item('encryption_key'));

        $fix = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImV4cCI6MTU2Njk3MTk5Mn0.eyJpZCI6IjMiLCJmdWxsbmFtZSI6Ik11aGFtYWQgWWFuaSIsInJlZ2lvbl9jb2RlIjoiSktUIiwiZW1haWwiOiJtdWhhbWFkLmRlcmFwQGljb25scG4uY28uaWQiLCJyb2xlX2lkIjoiMTIiLCJyb2xlX25hbWUiOiJTdXBlcl9Vc2VyIn0.8cCUwaYMuNXub_ypI64z-daoCuC897LBfNrpAbMs-80';
        if ($token != $fix) {
            $this->rest->send_error(401, "Token not invalid. please contact pic dev");
            exit;
        }

        // if (empty($this->head_token)) {
        //     $this->rest->send_error(401, "Header yang dimasukan tidak lengkap.");
        //     exit;
        // }


        header('Access-Control-Allow-Origin: *', false);
        //header('Access-Control-Allow-Origin: https://client.site.com', false);
        //header('Access-Control-Allow-Credentials: true', false);
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS', false);
        header('Access-Control-Allow-Headers: DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type', false);
    }
}

class Apis_Controller extends Base_Controller
{
    protected $head_token;
    protected $user;

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        $this->head_token = $this->input->get_request_header('x-user-token');

        $token = $this->head_token;
        // var_dump($token);exit;

        if (empty($this->head_token)) {

            if (!empty($this->input->get('token'))) {
                $token = $this->input->get('token');
            } else {
                $this->rest->send_error(401, "Incomplete header entered.");
                exit;
            }
        }

        // if (empty($this->head_token)) {
        //     $this->rest->send_error(401, "Header yang dimasukan tidak lengkap.");
        //     exit;
        // }


        // $this->user = $this->jwt->decode($this->head_token, $this->config->item('encryption_key'));
        $this->user = $this->jwt->decode($token, $this->config->item('encryption_key'));

        header('Access-Control-Allow-Origin: *', false);
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS', false);
        header('Access-Control-Allow-Headers: DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type', false);
    }

    public function _compressedImage($source, $path, $quality)
    {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        imagejpeg($image, $path, $quality);
    }
}

class Whitelist_Controller extends Base_Controller
{
    protected $head_token;
    protected $user;

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        $this->head_token = $this->input->get_request_header('swabaja-x-partner');

        $token = $this->head_token;

        $x = gethostbyname($_SERVER['HTTP_HOST']);
        // var_dump($x);

        if (!$this->isAllowed($x)) {
            $this->rest->send_error(400, 'IP Not Registered');

            $log = ['modules' => 'API', 'messages' => 'IP Not Registered', 'before' => $x, 'after' => $x];
            $this->db->insert('log_administrator', $log);
            exit;
        }

        if (empty($this->head_token)) {

            if (!empty($this->input->get('token'))) {
                $token = $this->input->get('token');
            } else {
                $this->rest->send_error(401, "Incomplete header entered.");
                exit;
            }
        }

        // $this->user = $this->jwt->decode($this->head_token, $this->config->item('encryption_key'));
        $this->user = $this->jwt->decode($token, $this->config->item('encryption_key'));
        $log = ['modules' => 'API', 'messages' => 'IP Is allowed', 'before' => json_encode($this->user), 'after' => json_encode($this->user)];
        $this->db->insert('log_administrator', $log);

        header('Access-Control-Allow-Origin: *', false);
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS', false);
        header('Access-Control-Allow-Headers: DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type', false);
    }

    // Function to get the client IP address
    function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    function isAllowed($ip)
    {

        $data = $this->db->get_where('setting_api', ['deleted' => 0, 'is_active' => 'yes'])->result();

        if (empty($data)) {
            return false;
        }

        foreach ($data as $key => $value) {

            $whitelist[] = $value->whitelist_ip;
        }

        // If the ip is matched, return true
        if (in_array($ip, $whitelist)) {
            return true;
        }

        foreach ($whitelist as $i) {
            $wildcardPos = strpos($i, "*");

            // Check if the ip has a wildcard
            if ($wildcardPos !== false && substr($ip, 0, $wildcardPos) . "*" == $i) {
                return true;
            }
        }

        return false;
    }
}
