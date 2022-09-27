<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    //Validating the used login
    public function __construct()
    {
        parent::__construct();
        $this->load->model('home_model');
        $userAgent = implode(";", $this->input->request_headers());
        if (!$this->session->userdata('id')) {
            if (str_contains($userAgent, 'Dart')) {
                $response = array("status" => 0, "error" => "Invalid session,\nKindly login again");
                echo json_encode($response);
            }
            redirect('login');
        }
    }

    //Loading the Home view in the browser
    function index()
    {
        $userAgent = implode(";", $this->input->request_headers());
        $data['result'] = $this->home_model->retreive_call_logs();
        if (str_contains($userAgent, 'Dart')) {
            foreach ($data as $responseData) {
                $response = array("status" => 1, "message" => $responseData->result());
            }
            log_message('debug', json_encode($response));
            echo json_encode($response);
        } else {
            echo '<br/><br/><br/><h3 align="center">Welcome User</h3>';
            echo '<p align="center"><a href="' . base_url() . 'home/logout">Logout</a></p>';
            $this->load->view('home', $data);
        }
    }

    //Log out the user
    function logout()
    {
        $userAgent = implode(";", $this->input->request_headers());
        $data = $this->session->all_userdata();
        foreach ($data as $row => $rows_value) {
            $this->session->unset_userdata($row);
        }
        $this->session->sess_destroy();
        if (str_contains($userAgent, 'Dart')) {
            $response = array("status" => 1, "message" => "Logged out successfully");
            echo json_encode($response);
        } else {
            redirect('login');
        }
    }
}