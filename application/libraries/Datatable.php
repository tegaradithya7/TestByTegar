<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datatable {

    var $draw;
    var $records_total;
	var $record_filtered;
	var $data;

    function set($params){
        $this->data = $params;
        $this->records_total = sizeof($params);
        $this->record_filtered = sizeof($params);
    }

    function render(){
        $this->request_param = (empty($this->request_param) ? "" : $this->request_param);
        $this->next = (empty($this->next) ? "" : $this->next);

    	if(is_null($this->data)){
    		$data = array(
                'status' => 'error',
                'draw' => null,
                'recordsTotal' => null,
                'recordsFiltered' => null,
    			'data' => null
    		);
    	}else{
    		$data = array(
                'status' => 'success',
                'draw' => 1,
                'recordsTotal' => $this->records_total,
                'recordsFiltered' => $this->record_filtered,
    			'data' => $this->data
    		);
    	}
    	
    	echo json_encode($data);

    }
}