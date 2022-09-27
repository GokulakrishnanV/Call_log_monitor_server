<?php

class Passwordreset_model extends CI_Model
{  
    //Updates the password_reset_key in the database
    function update($data,$user_email)
    {
        $this->db->where('user_email', $user_email);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
                $this->db->where('user_email', $user_email);
                $this->db->update('users', $data);
                return true;
        } else {
            return false;
        }
    }

    //Retreive username of the given email from the database for the purpose of sending email
    function retreive_username($user_email)
    {
        $this->db->where('user_email', $user_email);
        $query = $this->db->get('users');
        foreach ($query->result() as $row) {
            $username = $row->user_name;
        }
        return $username;
    }

    //Checks if the reset password link is valid
    function reset_password($password_reset_key)
    {
        $this->db->where('password_reset_key', $password_reset_key);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $this->session->set_userdata('password_reset_key', $password_reset_key);
            return true;
        } else {
            return false;
        }
    } 

    //Updates the user password in the database
    function update_password($data)
    {
        $password_reset_key = $this->session->userdata('password_reset_key');
        $this->db->where('password_reset_key', $password_reset_key);
        $query = $this->db->get('users');
        if($query->num_rows()>0){
            $this->db->where('password_reset_key', $password_reset_key);
            $this->db->update('users', $data);
            return true;
        }else{
            return false;
        }
 
    }
}
?>