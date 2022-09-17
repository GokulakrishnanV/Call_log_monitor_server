<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ResetPassword extends CI_Controller
{

    //Loading the form validation and reset password model
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_type')) {
            redirect('superuserhome');
        }
        $this->load->library('form_validation');
        $this->load->model('passwordreset_model');
    }

    //Loading the reset password form in the browser
    function index()
    {
        $this->load->view('password_reset');
    }

    function validation()
    {
        $this->form_validation->set_rules('user_email', 'Email Address', 'required|trim|valid_email');
        if ($this->form_validation->run()) {
            $password_reset_key = md5(rand());
            $user_email = $this->input->post('user_email');

            $data = array(
                'password_reset_key' => $password_reset_key,
            );
            $status = $this->passwordreset_model->update($data, $user_email);
            $userAgent = implode(";", $this->input->request_headers());

            if ($status == true) {
                $username = $this->passwordreset_model->retreive_username($user_email);
                $subject = "Password reset email for Flutter Call Log App";
                $message = "
                <p>Hi there " . $username . ",<p>
                <p>This is a password reset email from Flutter call log app.<p>
                <p>Click this <a href='" . base_url() . "resetpassword/reset_password/" . $password_reset_key . "'>link</a> to reset your account password.<p>
                <br>If this email is not requested by you, you can safely discard this email. Your password will not be changed.</br>
                <p>Regards,<p>
                <p>Flutter Call Log Team.<p>
                ";
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'smtp.gmail.com',
                    'smtp_port' => 465,
                    'smtp_user'  => 'flutterdev.warx@gmail.com',
                    'smtp_pass'  => 'kndtprxxizraojne',
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
                        $response = array("status" => 1, "message" => "Password reset email has been sent.\nIf not received, check your spam folder");
                        echo json_encode($response);
                    } else {
                        $this->session->set_flashdata('message', 'Check your email inbox for password reset email. If not received, check your spam folder');
                        redirect('login');
                    }
                }
            } else {
                if (str_contains($userAgent, 'Dart')) {
                    $response = array("status" => 0, "error" => "Email not found.");
                    echo json_encode($response);
                } else {
                    $this->session->set_flashdata('message', 'Email not found.');
                    redirect('resetpassword');
                }
            }
        }
    }

    //Resetting the password
    function reset_password()
    {
        if ($this->uri->segment(3)) {
            $password_reset_key = $this->uri->segment(3);
            if ($this->passwordreset_model->reset_password($password_reset_key)) {
                $this->load->view('new_password');
            } else {
                $data['message'] = '<h3 align="center">Invalid Link</h3>';
                echo $data['message'];
            }
        }
    }

    //Updating the new password
    function update_password()
    {
        $this->form_validation->set_rules('user_password', 'Password', 'required|trim|min_length[8]|max_length[20]');
        if ($this->form_validation->run()) {
            $encrypted_new_password = password_hash($this->input->post('user_password'), PASSWORD_DEFAULT);
            $data = array(
                'user_password' => $encrypted_new_password,
                'password_reset_key' =>null,
            );
            $result = $this->passwordreset_model->update_password($data);
            if($result == true){
                $data['message'] = '<h4 align="center">Your password has been updated successfully.<br>You can login with your new password from <a href="'.base_url().'/login"</a>here</h4>';
            }else{
                $data['message'] = '<h4 align="center">Ah snap! Something happened on our end. We cannot reset your password. Kindly try again from <a href="'.base_url().'/resetpassword"</a>here</h4>';
            }
            $this->load->view('update_password', $data);
        }
    }
}
