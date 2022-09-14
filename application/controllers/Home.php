<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    //Validating the used login
    public function __construct()
    {
        parent::__construct();
        $this->load->model('home_model');
        if (!$this->session->userdata('id')) {
            redirect('login');
        }
    }

    //Loading the Home view in the browser
    function index()
    {
        echo '<br/><br/><br/><h3 align="center">Welcome User</h3>';
        echo '<p align="center"><a href="' . base_url() . 'home/logout">Logout</a></p>';
        $data['result'] = $this->home_model->retreive_call_logs();
        $this->load->view('home', $data);
    }

    //Log out the user
    function logout()
    {
        $data = $this->session->all_userdata();
        foreach ($data as $row => $rows_value) {
            $this->session->unset_userdata($row);
        }
        $this->session->sess_destroy();
        redirect('login');
    }
}
