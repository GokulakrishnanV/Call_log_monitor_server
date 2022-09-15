<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SuperUserhome extends CI_Controller
{

    //Validating the used login
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('login');
        }
        $this->load->model('superuserhome_model');
    }

    //Loading the Home view in the browser
    function index()
    {
        $data['query']=$this->superuserhome_model->retreive_call_logs();
        $this->load->view('super_user_home',$data);
        echo '<br/><br/><br/><h3 align="center">Welcome Super User</h3>';
        echo '<p align="center"><a href="' . base_url() . 'superuserhome/logout">Logout</a></p>';
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
