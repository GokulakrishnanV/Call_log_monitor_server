<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{

    //Loading the form validation and register model
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_type')) {
            redirect('superuserhome');
        }
        $this->load->library('form_validation');
        $this->load->model('register_model');
    }

    //Loading the register form in the browser
    function index()
    {
        $this->load->view('register');
    }

    //Validating the form, inserting the user in the database, and sending user verification email
    function validation()
    {
        $this->form_validation->set_rules('user_name', 'Name', 'required|trim');
        $this->form_validation->set_rules('user_email', 'Email Address', 'required|trim|valid_email');
        $this->form_validation->set_rules('user_password', 'Password', 'required|trim|min_length[8]|max_length[20]');

        if ($this->form_validation->run()) {
            $verification_key = md5(rand());
            $encrypted_password = password_hash($this->input->post('user_password'), PASSWORD_DEFAULT);
            $data = array(
                'user_name' => $this->input->post('user_name'),
                'user_email' => $this->input->post('user_email'),
                'user_password' => $encrypted_password,
                'verification_key' => $verification_key,
            );
            $id = $this->register_model->insert($data);
            $userAgent = implode(";", $this->input->request_headers());
            
            if ($id > 1) {
                $subject = "Email verification for Flutter Call Log App";
                $message = "
                <p>Hi there " . $this->input->post('user_name') . ",<p>
                <p>Kindly verify your email to complete your registration for Flutter call log app.<p>
                <p>Click this <a href='" . base_url() . "register/verify_email/" . $verification_key . "'>link</a> to verify your email address.<p>
                <p>Regards,<p>
                <p>Flutter Call Log Team.<p>
                ";
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'smtp.gmail.com',
                    'smtp_port' => 465,
                    'smtp_user'  => 'flutterdev.warx@gmail.com',
                    'smtp_pass'  => 'syubelukmiooihrk',
                    'mailtype'  => 'html',
                    'charset'    => 'iso-8859-1',
                    'wordwrap'   => TRUE,
                    'smtp_crypto' => 'ssl'
                );
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from('flutterdev.warx@gmail.com', 'Warx Support');
                $this->email->to($this->input->post('user_email'));
                $this->email->subject($subject);
                $this->email->message($message);

                if ($this->email->send()) {
                    if (str_contains($userAgent, 'Dart')) {
                        $response = array("status" => 1, "message" => "Verification email has been sent.\nIf not received, check your spam folder");
                        echo json_encode($response);
                    } else {
                        $this->session->set_flashdata('message', 'Check your email inbox for verification email. If not received, check your spam folder');
                        redirect('login');
                    }
                }
            } elseif ($id == 1) {
                if (str_contains($userAgent, 'Dart')) {
                    $response = array("status" => 2, "error" => "Username already exists.\nKindly use another username.");
                    echo json_encode($response);
                } else {
                    $this->session->set_flashdata('message', 'Username already exists');
                    redirect('register');
                }
            } else {
                if (str_contains($userAgent, 'Dart')) {
                    $response = array("status" => 0, "error" => "Email already exists.");
                    echo json_encode($response);
                } else {
                    $this->session->set_flashdata('message', 'Email already exists');
                    redirect('register');
                }
            }
        } else {
            $this->index();
        }
    }

    //Verifying the email
    function verify_email()
    {
        if ($this->uri->segment(3)) {
            $verification_key = $this->uri->segment(3);

            if ($this->register_model->verify_email($verification_key)) {
                $data['message'] = '<h3 align="center">Your email has been successfully verified.<br>You can login from <a href="' . base_url() . 'login">here</a></h3>';
            } else {
                $data['message'] = '<h3 align="center">Invalid Link</h3>';
            }
            $this->load->view('email_verification', $data);
        }
    }
}
