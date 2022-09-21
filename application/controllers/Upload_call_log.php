<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Upload_call_log extends CI_Controller
{
    //Loading the upload_call_log model
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id')) {
            echo 'Invalid Session';
            redirect('login');
        }
        $this->load->model('upload_call_log_model');
    }

    //Uploading the call log to the database. (There is no view since it is used only for app)
    function index()
    {
        $data = array(
            'user_name' => $this->input->post('user_name'),
            'caller_name' => $this->input->post('caller_name'),
            'caller_number' => $this->input->post('caller_number'),
            'call_duration' => $this->input->post('call_duration'),
            'call_type' => $this->input->post('call_type'),
            'date_time' => $this->input->post('date_time'),
        );
        $result = $this->upload_call_log_model->upload_call_log($data);
        if ($result == true) {
            $response = array("status" => 1, "message" => "Data successfully uploaded");
        } else {
            $response = array("status" => 0, "message" => "Error uploading data");
        }
        echo json_encode($response);
    }
}
