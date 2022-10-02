<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UploadFcmToken extends CI_Controller
{
    //Loading the upload_fcm_token model
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id')) {
            echo 'Invalid Session';
            redirect('login');
        }
        $this->load->model('upload_fcm_token_model');
    }

    function index()
    {
        $data = array(
            'fcm_token' => $this->input->post('fcm_token'),
        );
        $result = $this->upload_fcm_token_model->upload_fcm_token($this->input->post('user_name'), $data);
        if ($result == true) {
            $response = array("status" => 1, "message" => "Data successfully uploaded");
        } else {
            $response = array("status" => 0, "message" => "Error uploading data");
        }
        echo json_encode($response);
    }
}