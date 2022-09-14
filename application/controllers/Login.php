<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    //Loading the encypt library, form validation and login model
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('id')) {
            redirect('home');
        }
        $this->load->library('form_validation');
        $this->load->model('login_model');
    }

    //Loading the login form in the browser
    function index()
    {
        $this->load->view('login');
    }

    //Validating the form
    function validation()
    {
        $this->form_validation->set_rules('user_email', 'Email Address', 'required|trim|valid_email');
        $this->form_validation->set_rules('user_password', 'Password', 'required');
        if ($this->form_validation->run()) {
            $result = $this->login_model->can_login($this->input->post('user_email'), $this->input->post('user_password'));
            if ($result == '') {
                if ($this->input->post('user_email') == 'super_user.warx@gmail.com') {
                    redirect('superuserhome');
                } else {
                    redirect('home');
                }
            } else {
                $this->session->set_flashdata('message', $result);
                redirect('login');
            }
        } else {
            $this->index();
        }
    }
}
