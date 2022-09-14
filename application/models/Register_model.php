<?php

class Register_model extends CI_Model
{

    //Insert the user data into the database
    function insert($data)
    {
        $this->db->where('user_email', $data['user_email']);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return 0;
        } else {
            $this->db->where('user_name', $data['user_name']);
            $query = $this->db->get('users');
            if ($query->num_rows() > 0) {
                return 1;
            } else {
                $this->db->insert('users', $data);
                return $this->db->insert_id();
            }
        }
    }

    //Verifying the email
    function verify_email($key)
    {
        $this->db->where('verification_key', $key);
        $this->db->where('is_email_verified', 'no');
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $data = array(
                'is_email_verified' => 'yes'
            );
            $this->db->where('verification_key', $key);
            $this->db->update('users', $data);
            return true;
        } else {
            return false;
        }
    }
}
