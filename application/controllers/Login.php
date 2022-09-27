<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    //Loading the encypt library, form validation and login model
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_type')) {
            redirect('superuserhome');
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
            $userAgent = implode(";", $this->input->request_headers());
            if ($result == '') {
                if (str_contains($userAgent, 'Dart')) {
                    $this->db->where('user_email', $this->input->post('user_email'));
                    $query = $this->db->get('users');
                    if ($query->num_rows() > 0) {
                        foreach ($query->result() as $row) {
                            $user_name = $row->user_name;
                        }
                    } else {
                        $user_name = 'Username not found';
                    }
                    $response = array("status" => 1, "user_name" => $user_name);
                    echo json_encode($response);
                } else {
                    if ($this->input->post('user_email') == 'super_user.warx@gmail.com') {
                        $this->session->set_userdata('user_type','super_user');
                        redirect('superuserhome');
                    } else {
                        echo '<h3 align="center">Web access is not allowed as of now.<br>Kindly login from the Call Logs Monitor mobile app</br></h3>';
                        //redirect('home');
                    }
                }
            } else {
                if (str_contains($userAgent, 'Dart')) {
                    $response = array("status" => 0, "error" => $result);
                    echo json_encode($response);
                } else {
                    $this->session->set_flashdata('message', $result);
                    redirect('login');
                }
            }
        } else {
            $this->index();
        }
    }
}